<?php
namespace App\Helpers;

use App\Core\Database;
use PDO;

class UIHelper {
    
    /**
     * Get all active UI sections for a specific entity (e.g. global_home)
     * Organized by section type for O(1) access in views
     */
    public static function getSections($entityType = 'global_home') {
        $db = Database::getInstance()->getConnection();
        
        try {
            $stmt = $db->prepare("SELECT * FROM ui_sections WHERE entity_type = ? AND is_active = 1 ORDER BY sort_order ASC");
            $stmt->execute([$entityType]);
            $rawSections = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $sections = [];
            
            foreach ($rawSections as $section) {
                $stmtItems = $db->prepare("SELECT * FROM ui_section_items WHERE section_id = ? ORDER BY sort_order ASC");
                $stmtItems->execute([$section['id']]);
                $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
                
                // Enrich items if they are products
                foreach ($items as &$item) {
                    if ($item['entity_type'] === 'product') {
                        $stmtP = $db->prepare("SELECT name, base_price, 
                                               (SELECT image_url FROM product_images WHERE product_id = products.id ORDER BY sort_order ASC LIMIT 1) as featured_image 
                                               FROM products WHERE id = ?");
                        $stmtP->execute([$item['entity_id']]);
                        $prod = $stmtP->fetch(PDO::FETCH_ASSOC);
                        if ($prod) {
                            $item['title'] = !empty($item['title']) ? $item['title'] : $prod['name'];
                            $item['image_url'] = !empty($item['image_url']) ? $item['image_url'] : $prod['featured_image'];
                            $item['price'] = $prod['base_price'];
                            $item['current_price'] = $prod['base_price']; // Fallback
                        }
                    }
                }
                $section['items'] = $items;
                
                // Key by type for easy access, but support multiple sections of same type if needed
                if (!isset($sections[$section['type']])) {
                    $sections[$section['type']] = $section;
                } else {
                    // If multiple sections of same type exist, make it an array of sections
                    if (!isset($sections[$section['type']][0])) {
                        $sections[$section['type']] = [$sections[$section['type']]];
                    }
                    $sections[$section['type']][] = $section;
                }
            }
            
            return $sections;
        } catch (\Exception $e) {
            error_log("UIHelper Error: " . $e->getMessage());
            return [];
        }
    }
}
