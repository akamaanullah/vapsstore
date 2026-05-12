<?php
namespace App\Helpers;

use App\Core\Database;
use PDO;

class UIHelper {
    
    /**
     * Get all active UI sections for a specific entity (e.g. global_home)
     * Organized by section type for O(1) access in views
     */
    public static function getSections($entityType = 'global_home', $entityId = null) {
        $db = Database::getInstance()->getConnection();
        
        try {
            // 1. Fetch all active sections for this entity
            $query = "SELECT * FROM ui_sections WHERE entity_type = ? AND is_active = 1 ";
            $params = [$entityType];
            
            if ($entityId !== null) {
                $query .= " AND entity_id = ? ";
                $params[] = $entityId;
            } else {
                $query .= " AND entity_id IS NULL ";
            }
            
            $query .= " ORDER BY sort_order ASC";
            
            $stmt = $db->prepare($query);
            $stmt->execute($params);
            $sections = [];
            $sectionIds = [];
            
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $section) {
                $section['items'] = [];
                $sections[$section['id']] = $section;
                $sectionIds[] = $section['id'];
            }
            
            if (empty($sectionIds)) return [];

            // 2. Optimized: Fetch ALL items for all sections in ONE query
            $idsPlaceholders = implode(',', array_fill(0, count($sectionIds), '?'));
            $sqlItems = "SELECT i.*, p.name as prod_name, p.base_price, 
                        (SELECT image_url FROM product_images WHERE product_id = p.id ORDER BY sort_order ASC LIMIT 1) as prod_image
                        FROM ui_section_items i
                        LEFT JOIN products p ON i.entity_id = p.id AND i.entity_type = 'product'
                        WHERE i.section_id IN ($idsPlaceholders)
                        ORDER BY i.sort_order ASC";
            
            $stmtItems = $db->prepare($sqlItems);
            $stmtItems->execute($sectionIds);
            
            foreach ($stmtItems->fetchAll(PDO::FETCH_ASSOC) as $item) {
                if ($item['entity_type'] === 'product') {
                    $item['title'] = !empty($item['title']) ? $item['title'] : $item['prod_name'];
                    $item['image_url'] = !empty($item['image_url']) ? $item['image_url'] : $item['prod_image'];
                    $item['price'] = $item['base_price'];
                }
                $sections[$item['section_id']]['items'][] = $item;
            }
            
            // 3. Re-group by section type for the view (Always as an array of sections)
            $result = [];
            foreach ($sections as $section) {
                $type = $section['type'];
                if (!isset($result[$type])) {
                    $result[$type] = [];
                }
                $result[$type][] = $section;
            }
            
            return $result;
        } catch (\Exception $e) {
            error_log("UIHelper Error: " . $e->getMessage());
            return [];
        }
    }

    private static $settingsCache = null;

    /**
     * Get all global settings (Cached per request)
     */
    public static function getSettings() {
        if (self::$settingsCache !== null) {
            return self::$settingsCache;
        }

        $db = Database::getInstance()->getConnection();
        try {
            $stmt = $db->query("SELECT `key`, `value` FROM settings");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $settings = [];
            foreach ($rows as $row) {
                $settings[$row['key']] = $row['value'];
            }
            self::$settingsCache = $settings;
            return $settings;
        } catch (\Exception $e) {
            error_log("UIHelper Settings Error: " . $e->getMessage());
            return [];
        }
    }
}
