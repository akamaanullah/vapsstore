<?php
namespace App\Models;

use App\Core\Database;

class UserAddress {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) {
        $sql = "INSERT INTO user_addresses (
            user_id, order_id, first_name, last_name, phone, address_type, street, city, state, zip, country, is_default
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['user_id'] ?? null,
            $data['order_id'] ?? null,
            $data['first_name'] ?? null,
            $data['last_name'] ?? null,
            $data['phone'] ?? null,
            $data['address_type'] ?? 'shipping',
            $data['street'],
            $data['city'],
            $data['state'] ?? '',
            $data['zip'],
            $data['country'] ?? 'United Kingdom',
            $data['is_default'] ?? 0
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Get all addresses for a user
     */
    public function getByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM user_addresses WHERE user_id = ? ORDER BY is_default DESC, created_at DESC");
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $unique = [];
        $seen = [];
        foreach ($rows as $row) {
            $key = strtolower(trim($row['street']) . '|' . trim($row['city']) . '|' . trim($row['zip']));
            if (!isset($seen[$key])) {
                $unique[] = $row;
                $seen[$key] = true;
            }
        }
        return $unique;
    }

    /**
     * Get default address for a user
     */
    public function getDefault($userId) {
        $stmt = $this->db->prepare("SELECT * FROM user_addresses WHERE user_id = ? AND is_default = 1 LIMIT 1");
        $stmt->execute([$userId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Set default address
     */
    public function setDefault($id, $userId) {
        // Unset current default
        $stmt = $this->db->prepare("UPDATE user_addresses SET is_default = 0 WHERE user_id = ?");
        $stmt->execute([$userId]);

        // Set new default
        $stmt = $this->db->prepare("UPDATE user_addresses SET is_default = 1 WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $userId]);
    }

    /**
     * Delete an address
     */
    public function delete($id, $userId) {
        $stmt = $this->db->prepare("SELECT order_id FROM user_addresses WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $userId]);
        $address = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($address) {
            if (!empty($address['order_id'])) {
                // If linked to an order, detach it from the address book but preserve the order snapshot
                $stmt = $this->db->prepare("UPDATE user_addresses SET user_id = NULL WHERE id = ? AND user_id = ?");
                return $stmt->execute([$id, $userId]);
            } else {
                // Not linked to any order, safe to hard delete
                $stmt = $this->db->prepare("DELETE FROM user_addresses WHERE id = ? AND user_id = ?");
                return $stmt->execute([$id, $userId]);
            }
        }
        return false;
    }

    /**
     * Update an address
     */
    public function update($id, $data) {
        $fields = [];
        $params = [];
        
        $allowedFields = ['first_name', 'last_name', 'phone', 'street', 'city', 'state', 'zip', 'country', 'is_default'];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fields[] = "$field = ?";
                $params[] = $data[$field];
            }
        }
        
        if (empty($fields)) return true;
        
        $params[] = $id;
        $params[] = $data['user_id'];
        
        $sql = "UPDATE user_addresses SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = ? AND user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Link guest addresses to a registered user
     */
    public function linkGuestAddresses($userId, $email) {
        $stmt = $this->db->prepare("
            UPDATE user_addresses 
            SET user_id = ? 
            WHERE user_id IS NULL AND order_id IN (
                SELECT id FROM orders WHERE customer_email = ?
            )
        ");
        return $stmt->execute([$userId, $email]);
    }
}
