<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

$db = Database::getInstance()->getConnection();

// 1. Create Homepage Sections
$sections = [
    ['type' => 'hero_slider', 'order' => 1],
    ['type' => 'promo_grid', 'order' => 2],
    ['type' => 'feature_highlight', 'order' => 3],
    ['type' => 'brand_story', 'order' => 4],
    ['type' => 'starter_cta', 'order' => 5],
];

echo "Seeding Homepage Sections...\n";

foreach ($sections as $sec) {
    // Check if exists
    $stmt = $db->prepare("SELECT id FROM ui_sections WHERE entity_type = 'global_home' AND type = ?");
    $stmt->execute([$sec['type']]);
    $existing = $stmt->fetch();

    if (!$existing) {
        $stmt = $db->prepare("INSERT INTO ui_sections (entity_type, type, sort_order, is_active) VALUES ('global_home', ?, ?, 1)");
        $stmt->execute([$sec['type'], $sec['order']]);
        $sectionId = $db->lastInsertId();
        echo "Created section: {$sec['type']} (ID: $sectionId)\n";

        // Add initial items based on index.php content
        if ($sec['type'] === 'hero_slider') {
            // Slide 1
            $db->prepare("INSERT INTO ui_section_items (section_id, title, content, image_url, button_text, button_url, sort_order) 
                VALUES (?, 'Experience Vaping Elevated to Art', 'Explore our curated collection of elite e-liquids...', 'assets/image/carousel-1.jpg', 'Shop New', '#', 0)")
                ->execute([$sectionId]);
        }
        if ($sec['type'] === 'feature_highlight') {
            $db->prepare("INSERT INTO ui_section_items (section_id, title, content, image_url, button_text, button_url) 
                VALUES (?, 'Redefining the Art of Vaping', 'At The Perfect Vape, we believe that vaping is more than just an alternative...', 'assets/product/product-7.jpg', 'Discover More', '#')")
                ->execute([$sectionId]);
        }
    } else {
        echo "Section {$sec['type']} already exists.\n";
    }
}

echo "Done!\n";
