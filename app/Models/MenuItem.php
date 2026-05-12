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

    /**
     * Resolve a dynamic URL from entity_id
     */
    public static function resolveUrl($type, $id, $defaultValue) {
        if (!$id) return $defaultValue;

        $db = \App\Core\Database::getInstance()->getConnection();
        
        switch ($type) {
            case 'page':
                $stmt = $db->prepare("SELECT custom_url_path FROM pages WHERE id = ?");
                $stmt->execute([$id]);
                $slug = $stmt->fetchColumn();
                return $slug ? '/page/' . ltrim($slug, '/') : $defaultValue;
            
            case 'collection':
                $stmt = $db->prepare("SELECT custom_url_path FROM collections WHERE id = ?");
                $stmt->execute([$id]);
                $slug = $stmt->fetchColumn();
                return $slug ? '/collection/' . ltrim($slug, '/') : $defaultValue;

            case 'brand':
                $stmt = $db->prepare("SELECT slug FROM brands WHERE id = ?");
                $stmt->execute([$id]);
                $slug = $stmt->fetchColumn();
                return $slug ? '/brands/' . ltrim($slug, '/') : $defaultValue;

            case 'product':
                $stmt = $db->prepare("SELECT custom_url FROM products WHERE id = ?");
                $stmt->execute([$id]);
                $slug = $stmt->fetchColumn();
                return $slug ? '/products/' . ltrim($slug, '/') : $defaultValue;
        }

        return $defaultValue;
    }
}
