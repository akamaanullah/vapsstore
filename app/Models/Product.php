<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Product extends Model {
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
                'long_desc' => $data['description'] ?? null,
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
     * Update an existing product
     */
    public function updateProduct($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                brand_id = :brand_id, 
                name = :name, 
                short_desc = :short_desc, 
                long_desc = :long_desc, 
                base_price = :base_price, 
                status = :status 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'brand_id' => $data['brand_id'] ?? null,
            'name' => $data['name'],
            'short_desc' => $data['short_desc'] ?? null,
            'long_desc' => $data['long_desc'] ?? null,
            'base_price' => $data['base_price'],
            'status' => $data['status'] ?? 'draft'
        ]);
    }

    /**
     * Simple slug generator
     */
    private function generateSlug($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return $text ?: 'n-a';
    }

    /**
     * Get products with brand names for the admin list
     */
    public function getAdminList() {
        $sql = "SELECT p.*, b.name as brand_name, 
                       GROUP_CONCAT(c.name SEPARATOR ', ') as collection_names
                FROM products p 
                LEFT JOIN brands b ON p.brand_id = b.id 
                LEFT JOIN product_collections pc ON p.id = pc.product_id
                LEFT JOIN collections c ON pc.collection_id = c.id
                GROUP BY p.id
                ORDER BY p.created_at DESC";
        return $this->query($sql);
    }

    /**
     * Add an image to a product
     */
    public function addImage($productId, $imageUrl, $sortOrder = 0) {
        $sql = "INSERT INTO product_images (product_id, image_url, sort_order) VALUES (?, ?, ?)";
        return $this->db->prepare($sql)->execute([$productId, $imageUrl, $sortOrder]);
    }
}
