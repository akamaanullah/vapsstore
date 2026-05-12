<?php
namespace App\Core;

use PDO;

class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Find a record by its primary key
     */
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Get all records from the table
     */
    public function all($limit = 1000) {
        $stmt = $this->db->query("SELECT * FROM {$this->table} LIMIT " . (int)$limit);
        return $stmt->fetchAll();
    }

    /**
     * Delete a record by its primary key
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Count all records (or with a WHERE clause)
     */
    public function count($where = '', $params = []) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch()['total'];
    }

    /**
     * Execute a custom raw query
     */
    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Get paginated results
     */
    public function paginate($page = 1, $perPage = 10, $where = '', $params = [], $orderBy = 'id DESC') {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM {$this->table}";
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        $sql .= " ORDER BY {$orderBy} LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        
        // Bind parameters
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val);
            }
        }
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        
        $stmt->execute();
        $items = $stmt->fetchAll();
        
        $total = $this->count($where, $params);
        
        return [
            'data' => $items,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => (int)$page,
            'last_page' => (int)ceil($total / $perPage)
        ];
    }
}
