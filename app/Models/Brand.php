<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Brand extends Model {
    protected $table = 'brands';

    public function getAllBrands() {
        $stmt = $this->db->prepare("SELECT * FROM brands ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveBrands() {
        $stmt = $this->db->prepare("SELECT * FROM brands WHERE is_active = 1 ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBrandById($id) {
        $stmt = $this->db->prepare("SELECT * FROM brands WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createBrand($data) {
        $sql = "INSERT INTO brands (name, slug, logo_url, is_active) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['slug'],
            $data['logo_url'] ?? null,
            $data['is_active'] ?? 1
        ]);
    }

    public function updateBrand($id, $data) {
        $sql = "UPDATE brands SET name = ?, slug = ?, logo_url = ?, is_active = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['slug'],
            $data['logo_url'] ?? null,
            $data['is_active'] ?? 1,
            $id
        ]);
    }

    public function deleteBrand($id) {
        // Check if brand is used in products before deleting (optional but good)
        $stmt = $this->db->prepare("DELETE FROM brands WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function search($query) {
        if ($query === 'all') {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} LIMIT 50");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE name LIKE ? LIMIT 10");
        $stmt->execute(["%$query%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
