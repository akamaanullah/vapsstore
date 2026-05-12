<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Coupon extends Model {
    protected $table = 'coupons';

    public function all($limit = 1000) {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (code, type, value, min_order_amount, max_uses, start_date, end_date, is_active) 
                VALUES (:code, :type, :value, :min_order_amount, :max_uses, :start_date, :end_date, :is_active)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'code' => strtoupper($data['code']),
            'type' => $data['discount_type'],
            'value' => $data['discount_value'],
            'min_order_amount' => !empty($data['min_order_amount']) ? $data['min_order_amount'] : null,
            'max_uses' => !empty($data['max_uses']) ? $data['max_uses'] : null,
            'start_date' => !empty($data['start_date']) ? $data['start_date'] : null,
            'end_date' => !empty($data['end_date']) ? $data['end_date'] : null,
            'is_active' => isset($data['is_active']) ? $data['is_active'] : 1
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                code = :code, 
                type = :type, 
                value = :value, 
                min_order_amount = :min_order_amount, 
                max_uses = :max_uses, 
                start_date = :start_date, 
                end_date = :end_date, 
                is_active = :is_active 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'code' => strtoupper($data['code']),
            'type' => $data['discount_type'],
            'value' => $data['discount_value'],
            'min_order_amount' => !empty($data['min_order_amount']) ? $data['min_order_amount'] : null,
            'max_uses' => !empty($data['max_uses']) ? $data['max_uses'] : null,
            'start_date' => !empty($data['start_date']) ? $data['start_date'] : null,
            'end_date' => !empty($data['end_date']) ? $data['end_date'] : null,
            'is_active' => isset($data['is_active']) ? $data['is_active'] : 1
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
