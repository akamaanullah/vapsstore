<?php
namespace App\Models;

use App\Core\Database;

class User {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Find a user by email
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Create a new customer account
     */
    public function create($data) {
        $sql = "INSERT INTO users (role, first_name, last_name, email, password_hash, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
        
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            'customer',
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT)
        ]);

        return $success ? $this->db->lastInsertId() : false;
    }

    /**
     * Verify user credentials
     */
    public function authenticate($email, $password) {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user['password_hash'])) {
            // Remove sensitive info before returning
            unset($user['password_hash']);
            return $user;
        }

        return false;
    }

    /**
     * Update user profile
     */
    public function update($data) {
        $fields = [];
        $params = [];

        if (isset($data['first_name'])) {
            $fields[] = "first_name = ?";
            $params[] = $data['first_name'];
        }
        if (isset($data['last_name'])) {
            $fields[] = "last_name = ?";
            $params[] = $data['last_name'];
        }
        if (isset($data['password_hash'])) {
            $fields[] = "password_hash = ?";
            $params[] = $data['password_hash'];
        }

        if (empty($fields)) return true;

        $params[] = $data['id'];
        $sql = "UPDATE users SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}
