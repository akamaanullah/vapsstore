<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Setting extends Model {
    protected $table = 'settings';

    public function all($limit = 1000) {
        $stmt = $this->db->query("SELECT * FROM settings");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['key']] = $row['value'];
        }
        return $settings;
    }

    public function get($key, $default = null) {
        $stmt = $this->db->prepare("SELECT value FROM settings WHERE `key` = ?");
        $stmt->execute([$key]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['value'] : $default;
    }

    public function update($key, $value) {
        // Check if exists
        $stmt = $this->db->prepare("SELECT id FROM settings WHERE `key` = ?");
        $stmt->execute([$key]);
        if ($stmt->fetch()) {
            $stmt = $this->db->prepare("UPDATE settings SET value = ? WHERE `key` = ?");
            return $stmt->execute([$value, $key]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO settings (`key`, value) VALUES (?, ?)");
            return $stmt->execute([$key, $value]);
        }
    }

    public function updateMultiple($data) {
        try {
            $this->db->beginTransaction();
            foreach ($data as $key => $value) {
                $this->update($key, $value);
            }
            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
