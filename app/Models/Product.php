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
            $sql = "INSERT INTO {$this->table} (brand_id, name, custom_url, short_desc, long_desc, base_price, status, tags, seo_title, seo_description) 
                    VALUES (:brand_id, :name, :custom_url, :short_desc, :long_desc, :base_price, :status, :tags, :seo_title, :seo_description)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'brand_id' => $data['brand_id'] ?? null,
                'name' => $data['name'],
                'custom_url' => !empty($data['custom_url']) ? $data['custom_url'] : $this->generateSlug($data['name']),
                'short_desc' => $data['short_desc'] ?? null,
                'long_desc' => $data['long_desc'] ?? null,
                'base_price' => $data['base_price'],
                'status' => $data['status'] ?? 'draft',
                'tags' => $data['tags'] ?? null,
                'seo_title' => $data['seo_title'] ?? null,
                'seo_description' => $data['seo_description'] ?? null
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
                $variantSql = "INSERT INTO product_variants (product_id, sku, price, stock_quantity, is_default, variant_name) 
                               VALUES (?, ?, ?, ?, 0, ?)";
                $variantStmt = $this->db->prepare($variantSql);
                
                $logSql = "INSERT INTO inventory_logs (variant_id, change_amount, reason) VALUES (?, ?, 'initial_stock')";
                $logStmt = $this->db->prepare($logSql);

                foreach ($data['variants'] as $v) {
                    $variantStmt->execute([
                        $productId,
                        $data['sku'] . '-' . $this->generateSlug($v['name']),
                        $v['price'],
                        $v['stock'],
                        $v['name']
                    ]);
                    $vId = $this->db->lastInsertId();
                    if ($v['stock'] > 0) {
                        $logStmt->execute([$vId, $v['stock']]);
                    }
                }
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
            error_log("Product creation failed! Error: " . $e->getMessage());
            // For development, we can also throw it to see it in the browser if error reporting is on
            if (APP_ENV === 'development') {
                // die("DB Error: " . $e->getMessage()); // Uncomment for deep debugging
            }
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
                    seo_description = :seo_description 
                    WHERE id = :id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'brand_id' => $data['brand_id'] ?? null,
                'name' => $data['name'],
                'custom_url' => !empty($data['custom_url']) ? $data['custom_url'] : $this->generateSlug($data['name']),
                'short_desc' => $data['short_desc'] ?? null,
                'long_desc' => $data['long_desc'] ?? null,
                'base_price' => $data['base_price'],
                'status' => $data['status'] ?? 'draft',
                'tags' => $data['tags'] ?? null,
                'seo_title' => $data['seo_title'] ?? null,
                'seo_description' => $data['seo_description'] ?? null
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
     * Get a single product with all related data for the edit page
     */
    public function getProductForEdit($id) {
        $product = $this->find($id);
        if (!$product) return null;

        // Get variants
        $stmt = $this->db->prepare("SELECT * FROM product_variants WHERE product_id = ? ORDER BY id ASC");
        $stmt->execute([$id]);
        $product['variants'] = $stmt->fetchAll();

        // Extract Options (Color, Size etc) from variant names
        $options = [];
        if (!empty($product['variants'])) {
            $firstVariant = $product['variants'][0]['variant_name'];
            if ($firstVariant) {
                // If name is like "White / Small", we assume 2 options
                $parts = explode(' / ', $firstVariant);
                foreach ($parts as $i => $part) {
                    $options[$i] = [
                        'name' => 'Option ' . ($i + 1), // Default names if we don't know
                        'values' => []
                    ];
                }

                // Now collect all unique values for each option position
                foreach ($product['variants'] as $v) {
                    if ($v['variant_name']) {
                        $vParts = explode(' / ', $v['variant_name']);
                        foreach ($vParts as $i => $val) {
                            if (isset($options[$i]) && !in_array($val, $options[$i]['values'])) {
                                $options[$i]['values'][] = $val;
                            }
                        }
                    }
                }
                
                // Try to be smarter about Option Names if they follow "Name: Value" format
                foreach ($options as $i => &$opt) {
                    if (!empty($opt['values'][0]) && strpos($opt['values'][0], ': ') !== false) {
                        $tempParts = explode(': ', $opt['values'][0]);
                        $opt['name'] = $tempParts[0];
                        // Strip the "Name: " part from all values
                        foreach ($opt['values'] as &$v) {
                            $v = explode(': ', $v)[1] ?? $v;
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
    public function getAdminList() {
        $sql = "SELECT p.*, b.name as brand_name, 
                       (SELECT image_url FROM product_images WHERE product_id = p.id ORDER BY sort_order ASC LIMIT 1) as featured_image,
                       GROUP_CONCAT(DISTINCT c.name SEPARATOR ', ') as collection_names,
                       (SELECT COUNT(*) FROM product_variants WHERE product_id = p.id) as variants_count
                FROM products p 
                LEFT JOIN brands b ON p.brand_id = b.id 
                LEFT JOIN product_collections pc ON p.id = pc.product_id
                LEFT JOIN collections c ON pc.collection_id = c.id
                GROUP BY p.id
                ORDER BY p.id DESC";
        return $this->query($sql);
    }

    /**
     * Sync images: remove ones not in the provided list
     */
    public function syncImages($productId, $imagesToKeep = []) {
        // Get all current images
        $stmt = $this->db->prepare("SELECT id, image_url FROM product_images WHERE product_id = ?");
        $stmt->execute([$productId]);
        $dbImages = $stmt->fetchAll();

        foreach ($dbImages as $dbImg) {
            if (!in_array($dbImg['image_url'], $imagesToKeep)) {
                // Delete from DB
                $this->db->prepare("DELETE FROM product_images WHERE id = ?")->execute([$dbImg['id']]);
                // Delete file
                $filePath = ROOT_DIR . '/public/' . $dbImg['image_url'];
                if (file_exists($filePath)) @unlink($filePath);
            }
        }
    }

    /**
     * Add an image to a product
     */
    public function addImage($productId, $imageUrl, $sortOrder = 0) {
        $sql = "INSERT INTO product_images (product_id, image_url, sort_order) VALUES (?, ?, ?)";
        return $this->db->prepare($sql)->execute([$productId, $imageUrl, $sortOrder]);
    }

    /**
     * Update sort order for multiple images
     */
    public function updateImageOrder($productId, $imagesOrder = []) {
        if (empty($imagesOrder)) return;
        
        $sql = "UPDATE product_images SET sort_order = ? WHERE image_url = ? AND product_id = ?";
        $stmt = $this->db->prepare($sql);
        
        foreach ($imagesOrder as $index => $url) {
            $stmt->execute([$index, $url, $productId]);
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
}
