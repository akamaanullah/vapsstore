<?php
namespace App\Models;

use App\Core\Model;

class Menu extends Model {
    protected $table = 'menus';

    public function getItems() {
        $menuItems = new MenuItem();
        return $menuItems->getByMenu($this->id);
    }

    /**
     * Get menu by its location (e.g. header_main)
     */
    public function getByLocation($location) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE location = ?");
        $stmt->execute([$location]);
        return $stmt->fetch();
    }

    /**
     * Create a new menu
     */
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, location) VALUES (?, ?)");
        return $stmt->execute([$data['name'], $data['location']]);
    }
}
