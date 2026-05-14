<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Wishlist extends Model {
    protected $table = 'wishlists';

    public function add($userId, $productId) {
        // Check if already exists
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        if ($stmt->fetch()) {
            return false; // Already in wishlist
        }

        $stmt = $this->db->prepare("INSERT INTO {$this->table} (user_id, product_id) VALUES (?, ?)");
        return $stmt->execute([$userId, $productId]);
    }

    public function remove($userId, $productId) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE user_id = ? AND product_id = ?");
        return $stmt->execute([$userId, $productId]);
    }

    public function clear($userId) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }

    public function getByUser($userId) {
        $sql = "
            SELECT w.product_id as id, 
                   p.name, 
                   p.base_price,
                   p.custom_url as url,
                   v.price, 
                   (SELECT SUM(stock_quantity) FROM product_variants WHERE product_id = p.id) as total_stock,
                   p.status,
                   (SELECT image_url FROM product_images WHERE product_id = p.id ORDER BY sort_order ASC LIMIT 1) as image
            FROM {$this->table} w
            JOIN products p ON w.product_id = p.id
            LEFT JOIN product_variants v ON v.id = (
                SELECT id FROM product_variants 
                WHERE product_id = p.id 
                ORDER BY is_default DESC, id ASC 
                LIMIT 1
            )
            WHERE w.user_id = ?
            ORDER BY w.created_at DESC
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Format data to match session/js structure
        foreach ($results as &$item) {
            $item['price'] = (float)($item['price'] ?: $item['base_price']);
            $item['stock'] = ($item['total_stock'] ?? 0) > 0 ? 'In Stock' : 'Out of Stock';
            $item['image'] = $item['image'] ? BASE_URL . '/' . $item['image'] : BASE_URL . '/assets/image/placeholder.jpg';
        }

        return $results;
    }

    public function getUserProductIds($userId) {
        $stmt = $this->db->prepare("SELECT product_id FROM {$this->table} WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
