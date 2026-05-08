<?php
namespace App\Models;

use App\Core\Model;
use App\Traits\Sluggable;
use PDO;

class Product extends Model {
    use Sluggable;

    protected $table = 'products';

    /**
     * Create a new product and return its ID
     */
    public function createProduct($data) {
        $this->db->beginTransaction();
        try {
            $sql = "INSERT INTO {$this->table} (brand_id, name, custom_url, short_desc, long_desc, base_price, status, tags, seo_title, seo_description, option_names) 
                    VALUES (:brand_id, :name, :custom_url, :short_desc, :long_desc, :base_price, :status, :tags, :seo_title, :seo_description, :option_names)";
            
            $stmt = $this->db->prepare($sql);
            
            // Handle unique slug
            $customUrl = !empty($data['custom_url']) ? $this->generateSlug($data['custom_url']) : $this->generateUniqueSlug($data['name']);

            $stmt->execute([
                'brand_id' => $data['brand_id'] ?? null,
                'name' => $data['name'],
                'custom_url' => $customUrl,
                'short_desc' => $data['short_desc'] ?? null,
                'long_desc' => $data['long_desc'] ?? null,
                'base_price' => $data['base_price'],
                'status' => $data['status'] ?? 'draft',
                'tags' => $data['tags'] ?? null,
                'seo_title' => $data['seo_title'] ?? null,
                'seo_description' => $data['seo_description'] ?? null,
                'option_names' => !empty($data['option_names']) ? json_encode($data['option_names']) : null
            ]);

            $productId = $this->db->lastInsertId();

            // Handle Collections (Many-to-Many)
            if (!empty($data['collection_ids'])) {
                $colSql = "INSERT INTO product_collections (product_id, collection_id) VALUES (?, ?)";
                $colStmt = $this->db->prepare($colSql);
                foreach ($data['collection_ids'] as $colId) {
                    $colStmt->execute([$productId, $colId]);
                }
            }

            // Handle Variants
            if (!empty($data['variants'])) {
                $this->updateVariants($productId, $data['variants']);
            } else {
                // Create default variant for stock management
                $variantSql = "INSERT INTO product_variants (product_id, sku, price, stock_quantity, is_default) 
                               VALUES (?, ?, ?, ?, 1)";
                $this->db->prepare($variantSql)->execute([
                    $productId,
                    $data['sku'] ?? 'SKU-' . $productId,
                    $data['base_price'],
                    $data['stock'] ?? 0
                ]);

                $variantId = $this->db->lastInsertId();

                // Log initial inventory
                if (isset($data['stock']) && $data['stock'] > 0) {
                    $logSql = "INSERT INTO inventory_logs (variant_id, change_amount, reason) VALUES (?, ?, 'initial_stock')";
                    $this->db->prepare($logSql)->execute([$variantId, $data['stock']]);
                }
            }

            $this->db->commit();
            return $productId;
        } catch (\Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("Product operation failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update an existing product (Transactional)
     */
    public function updateProduct($id, $data) {
        $this->db->beginTransaction();
        try {
            $sql = "UPDATE {$this->table} SET 
                    brand_id = :brand_id, 
                    name = :name, 
                    custom_url = :custom_url,
                    short_desc = :short_desc, 
                    long_desc = :long_desc, 
                    base_price = :base_price, 
                    status = :status,
                    tags = :tags,
                    seo_title = :seo_title,
                    seo_description = :seo_description,
                    option_names = :option_names
                    WHERE id = :id";
            
            $stmt = $this->db->prepare($sql);
            
            // Handle unique slug
            $customUrl = !empty($data['custom_url']) ? $this->generateSlug($data['custom_url']) : $this->generateUniqueSlug($data['name'], $id);

            $stmt->execute([
                'id' => $id,
                'brand_id' => $data['brand_id'] ?? null,
                'name' => $data['name'],
                'custom_url' => $customUrl,
                'short_desc' => $data['short_desc'] ?? null,
                'long_desc' => $data['long_desc'] ?? null,
                'base_price' => $data['base_price'],
                'status' => $data['status'] ?? 'draft',
                'tags' => $data['tags'] ?? null,
                'seo_title' => $data['seo_title'] ?? null,
                'seo_description' => $data['seo_description'] ?? null,
                'option_names' => !empty($data['option_names']) ? json_encode($data['option_names']) : null
            ]);

            // Sync collections
            if (isset($data['collection_ids'])) {
                $this->syncCollections($id, $data['collection_ids']);
            }

            // Sync Variants
            if (isset($data['variants'])) {
                $this->updateVariants($id, $data['variants']);
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("Product update failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Sync, Update or Delete Variants for a product
     */
    public function updateVariants($productId, $variants = []) {
        // 1. Get existing variant IDs from database
        $stmt = $this->db->prepare("SELECT id, stock_quantity FROM product_variants WHERE product_id = ?");
        $stmt->execute([$productId]);
        $existingRows = $stmt->fetchAll();
        $existingStock = array_column($existingRows, 'stock_quantity', 'id');
        $existingIds = array_keys($existingStock);
        $receivedIds = [];

        // 2. Prepare statements
        $updateSql = "UPDATE product_variants SET price = ?, stock_quantity = ?, variant_name = ? WHERE id = ? AND product_id = ?";
        $updateStmt = $this->db->prepare($updateSql);

        $insertSql = "INSERT INTO product_variants (product_id, sku, price, stock_quantity, is_default, variant_name) VALUES (?, ?, ?, ?, 0, ?)";
        $insertStmt = $this->db->prepare($insertSql);

        $logSql = "INSERT INTO inventory_logs (variant_id, change_amount, reason) VALUES (?, ?, ?)";
        $logStmt = $this->db->prepare($logSql);

        foreach ($variants as $v) {
            if (!empty($v['id']) && in_array($v['id'], $existingIds)) {
                // Check if stock changed to log it
                $oldStock = $existingStock[$v['id']];
                $newStock = (int)$v['stock'];
                
                // Existing variant - Update it
                $updateStmt->execute([
                    $v['price'],
                    $newStock,
                    $v['name'],
                    $v['id'],
                    $productId
                ]);
                $receivedIds[] = (int)$v['id'];

                if ($oldStock != $newStock) {
                    $logStmt->execute([$v['id'], $newStock - $oldStock, 'manual_update']);
                }
            } else {
                // New variant - Insert it
                $sku = 'SKU-' . $productId . '-' . $this->generateSlug($v['name']);
                $insertStmt->execute([
                    $productId,
                    $sku,
                    $v['price'],
                    $v['stock'],
                    $v['name']
                ]);
                
                $vId = $this->db->lastInsertId();
                if ($v['stock'] > 0) {
                    $logStmt->execute([$vId, $v['stock'], 'initial_stock']);
                }
            }
        }

        // 3. Delete variants that were not in the received list
        $idsToDelete = array_diff($existingIds, $receivedIds);
        if (!empty($idsToDelete)) {
            $deleteSql = "DELETE FROM product_variants WHERE product_id = ? AND id IN (" . implode(',', array_fill(0, count($idsToDelete), '?')) . ")";
            $deleteStmt = $this->db->prepare($deleteSql);
            $deleteStmt->execute(array_merge([$productId], array_values($idsToDelete)));
        }
    }

    /**
     * Get a single product with all related data for the edit page
     */
    public function getProductForEdit($id) {
        $product = $this->find($id);
        if (!$product) return null;

        // Get variants
        $stmt = $this->db->prepare("SELECT * FROM product_variants WHERE product_id = ? ORDER BY id ASC");
        $stmt->execute([$id]);
        $product['variants'] = $stmt->fetchAll();

        // Professional Option Reconstruction
        $optionNames = !empty($product['option_names']) ? json_decode($product['option_names'], true) : [];
        $options = [];

        if (!empty($product['variants'])) {
            // Collect all unique values for each option position
            foreach ($product['variants'] as $v) {
                if ($v['variant_name']) {
                    $vParts = explode(' / ', $v['variant_name']);
                    foreach ($vParts as $i => $val) {
                        if (!isset($options[$i])) {
                            $options[$i] = [
                                'name' => $optionNames[$i] ?? 'Option ' . ($i + 1),
                                'values' => []
                            ];
                        }
                        if (!in_array($val, $options[$i]['values'])) {
                            $options[$i]['values'][] = $val;
                        }
                    }
                }
            }
        }
        $product['options'] = array_values($options);

        // Get images
        $stmt = $this->db->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC");
        $stmt->execute([$id]);
        $product['images'] = $stmt->fetchAll();

        // Get collection IDs
        $stmt = $this->db->prepare("SELECT collection_id FROM product_collections WHERE product_id = ?");
        $stmt->execute([$id]);
        $product['collection_ids'] = array_column($stmt->fetchAll(), 'collection_id');

        return $product;
    }

    /**
     * Update product collections (many-to-many sync)
     */
    public function syncCollections($productId, $collectionIds = []) {
        // Remove old
        $this->db->prepare("DELETE FROM product_collections WHERE product_id = ?")->execute([$productId]);
        // Insert new
        if (!empty($collectionIds)) {
            $stmt = $this->db->prepare("INSERT INTO product_collections (product_id, collection_id) VALUES (?, ?)");
            foreach ($collectionIds as $colId) {
                $stmt->execute([$productId, $colId]);
            }
        }
    }

    // generateSlug() is provided by the Sluggable trait

    /**
     * Get products with brand names for the admin list
     */
    public function getAdminList($page = 1, $perPage = 10, $filters = []) {
        $offset = ($page - 1) * $perPage;
        
        $where = [];
        $params = [];

        if (!empty($filters['search'])) {
            $where[] = "p.name LIKE :search";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['status']) && $filters['status'] !== 'all status') {
            $where[] = "p.status = :status";
            $params[':status'] = $filters['status'];
        }

        $whereClause = !empty($where) ? " WHERE " . implode(" AND ", $where) : "";

        // Get total count for pagination
        $countSql = "SELECT COUNT(*) as total FROM products p" . $whereClause;
        $countStmt = $this->db->prepare($countSql);
        foreach ($params as $key => $val) {
            $countStmt->bindValue($key, $val);
        }
        $countStmt->execute();
        $total = $countStmt->fetch()['total'];

        $sql = "SELECT p.*, b.name as brand_name, 
                       (SELECT image_url FROM product_images WHERE product_id = p.id ORDER BY sort_order ASC LIMIT 1) as featured_image,
                       (SELECT GROUP_CONCAT(c.name SEPARATOR ', ') FROM collections c 
                        JOIN product_collections pc ON pc.collection_id = c.id 
                        WHERE pc.product_id = p.id) as collection_names,
                       (SELECT COUNT(*) FROM product_variants WHERE product_id = p.id) as variants_count
                FROM products p 
                LEFT JOIN brands b ON p.brand_id = b.id 
                $whereClause
                ORDER BY p.id DESC
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->bindValue(':limit', (int)$perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll();

        return [
            'data' => $items,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => (int)$page,
            'last_page' => (int)ceil($total / $perPage)
        ];
    }

    /**
     * Unified method to sync ALL images (existing and new) with correct sort order.
     */
    public function syncAllImages($productId, $allImages = []) {
        // 1. Get existing images from DB
        $stmt = $this->db->prepare("SELECT image_url FROM product_images WHERE product_id = ?");
        $stmt->execute([$productId]);
        $dbImages = array_column($stmt->fetchAll(), 'image_url');

        // 2. Delete images NOT in the new list
        foreach ($dbImages as $url) {
            if (!in_array($url, $allImages)) {
                $this->db->prepare("DELETE FROM product_images WHERE product_id = ? AND image_url = ?")->execute([$productId, $url]);
                // File deletion handled by Media Gallery if needed, but here we just unlink reference
            }
        }

        // 3. Process the list in order
        $insertStmt = $this->db->prepare("INSERT INTO product_images (product_id, image_url, sort_order) VALUES (?, ?, ?)");
        $updateStmt = $this->db->prepare("UPDATE product_images SET sort_order = ? WHERE product_id = ? AND image_url = ?");

        foreach ($allImages as $index => $url) {
            if (empty($url)) continue;

            if (in_array($url, $dbImages)) {
                // Existing - Update order
                $updateStmt->execute([$index, $productId, $url]);
            } else {
                // New - Insert with order
                $insertStmt->execute([$productId, $url, $index]);
            }
        }
    }

    public function getExportData() {
        $sql = "SELECT p.*, b.name as brand_name, 
                (SELECT SUM(stock_quantity) FROM product_variants WHERE product_id = p.id) as total_stock,
                (SELECT GROUP_CONCAT(c.name SEPARATOR ', ') FROM collections c 
                 JOIN product_collections pc ON pc.collection_id = c.id 
                 WHERE pc.product_id = p.id) as collections,
                (SELECT GROUP_CONCAT(CONCAT(v.variant_name, ' ($', v.price, ')') SEPARATOR '; ') 
                 FROM product_variants v WHERE v.product_id = p.id) as variants
                FROM products p 
                LEFT JOIN brands b ON p.brand_id = b.id 
                ORDER BY p.id DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getByCollectionId($collectionId) {
        $sql = "SELECT p.*, 
                (SELECT image_url FROM product_images WHERE product_id = p.id ORDER BY sort_order ASC LIMIT 1) as featured_image 
                FROM products p 
                JOIN product_collections pc ON p.id = pc.product_id 
                WHERE pc.collection_id = ? AND p.status = 'published' 
                ORDER BY p.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$collectionId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function search($query, $limit = 50) {
        $sql = "SELECT p.id, p.name, p.base_price, p.custom_url, pi.image_url as featured_image
                FROM products p 
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.sort_order = 0
                WHERE p.name LIKE ? 
                LIMIT " . (int)$limit;
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['%' . $query . '%']);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get multiple products by their IDs with featured images
     */
    public function getByIds($ids) {
        if (empty($ids)) return [];
        
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT p.*, pi.image_url as featured_image 
                FROM products p 
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.sort_order = 0
                WHERE p.id IN ($placeholders) AND p.status = 'published'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($ids);
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Sort them in the order they were requested
        $idMap = array_flip($ids);
        usort($products, function($a, $b) use ($idMap) {
            return $idMap[$a['id']] <=> $idMap[$b['id']];
        });

        return $products;
    }
}
