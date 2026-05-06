<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Media extends Model {
    protected $table = 'media';

    public function getAll($limit = 50, $offset = 0) {
        $stmt = $this->db->prepare("SELECT * FROM media ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO media (filename, original_name, file_path, file_type, file_size, dimensions) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['filename'],
            $data['original_name'],
            $data['file_path'],
            $data['file_type'],
            $data['file_size'],
            $data['dimensions'] ?? null
        ]);
        return $this->db->lastInsertId();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM media WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $item = $this->find($id);
        if ($item) {
            $stmt = $this->db->prepare("DELETE FROM media WHERE id = ?");
            return $stmt->execute([$id]);
        }
        return false;
    }

    public function search($query) {
        $stmt = $this->db->prepare("SELECT * FROM media WHERE original_name LIKE ? OR filename LIKE ? ORDER BY created_at DESC");
        $stmt->execute(["%$query%", "%$query%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
