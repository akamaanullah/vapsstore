<?php
namespace App\Models;

use App\Core\Model;
use App\Traits\Sluggable;
use PDO;

class Page extends Model {
    use Sluggable;

    protected $table = 'pages';

    public function getAllPages() {
        $stmt = $this->db->prepare("SELECT * FROM pages ORDER BY title ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPageById($id) {
        $stmt = $this->db->prepare("SELECT * FROM pages WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPage($data) {
        $sql = "INSERT INTO pages (title, custom_url_path, meta_title, meta_desc, is_active) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            $data['title'],
            $data['custom_url_path'] ?: $this->generateSlug($data['title']),
            $data['meta_title'] ?? null,
            $data['meta_desc'] ?? null,
            $data['is_active'] ?? 1
        ]);
        return $success ? $this->db->lastInsertId() : false;
    }

    public function updatePage($id, $data) {
        $sql = "UPDATE pages SET title = ?, custom_url_path = ?, meta_title = ?, meta_desc = ?, is_active = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['title'],
            $data['custom_url_path'],
            $data['meta_title'] ?? null,
            $data['meta_desc'] ?? null,
            $data['is_active'] ?? 1,
            $id
        ]);
    }

    public function search($query) {
        if ($query === 'all') {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} LIMIT 50");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE title LIKE ? LIMIT 10");
        $stmt->execute(["%$query%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
