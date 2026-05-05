<?php
namespace App\Models;

use App\Core\Model;

class MenuItem extends Model {
    protected $table = 'menu_items';

    /**
     * Get all items for a specific menu, ordered by parent and sort_order
     */
    public function getByMenu($menuId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE menu_id = ? ORDER BY sort_order ASC");
        $stmt->execute([$menuId]);
        return $stmt->fetchAll();
    }

    /**
     * Clear all items for a menu (used before syncing)
     */
    public function clearMenu($menuId) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE menu_id = ?");
        return $stmt->execute([$menuId]);
    }

    /**
     * Add a single menu item
     */
    public function add($data) {
        $fields = array_keys($data);
        $placeholders = implode(',', array_fill(0, count($fields), '?'));
        $sql = "INSERT INTO {$this->table} (" . implode(',', $fields) . ") VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(array_values($data));
    }

    /**
     * Build a nested tree structure for the menu
     */
    public function getTree($menuId) {
        $items = $this->getByMenu($menuId);
        return $this->buildTree($items);
    }

    private function buildTree(array $elements, $parentId = null) {
        $branch = [];
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }
}
