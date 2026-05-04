<?php
namespace App\Models;

use App\Core\Model;

class Collection extends Model {
    protected $table = 'collections';

    public function getAllWithParent() {
        $sql = "SELECT c.*, p.name as parent_name 
                FROM collections c 
                LEFT JOIN collections p ON c.parent_id = p.id 
                ORDER BY c.name ASC";
        return $this->query($sql);
    }

    public function createCollection($data) {
        $sql = "INSERT INTO collections (parent_id, name, custom_url_path, header_image_url, short_description, meta_title, meta_desc, is_active) 
                VALUES (:parent_id, :name, :custom_url_path, :header_image_url, :short_description, :meta_title, :meta_desc, :is_active)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'parent_id' => !empty($data['parent_id']) ? $data['parent_id'] : null,
            'name' => $data['name'],
            'custom_url_path' => !empty($data['custom_url_path']) ? $data['custom_url_path'] : $this->generateSlug($data['name']),
            'header_image_url' => $data['header_image_url'] ?? null,
            'short_description' => $data['short_description'] ?? null,
            'meta_title' => $data['meta_title'] ?? null,
            'meta_desc' => $data['meta_desc'] ?? null,
            'is_active' => $data['is_active'] ?? 1
        ]);
    }

    public function updateCollection($id, $data) {
        $sql = "UPDATE collections SET 
                parent_id = :parent_id, 
                name = :name, 
                custom_url_path = :custom_url_path, 
                header_image_url = :header_image_url, 
                short_description = :short_description, 
                meta_title = :meta_title, 
                meta_desc = :meta_desc, 
                is_active = :is_active 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'parent_id' => !empty($data['parent_id']) ? $data['parent_id'] : null,
            'name' => $data['name'],
            'custom_url_path' => !empty($data['custom_url_path']) ? $data['custom_url_path'] : $this->generateSlug($data['name']),
            'header_image_url' => $data['header_image_url'] ?? null,
            'short_description' => $data['short_description'] ?? null,
            'meta_title' => $data['meta_title'] ?? null,
            'meta_desc' => $data['meta_desc'] ?? null,
            'is_active' => $data['is_active'] ?? 1
        ]);
    }

    private function generateSlug($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return empty($text) ? 'n-a' : $text;
    }
}
