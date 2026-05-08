<?php
require 'config/config.php';
require 'app/Core/Database.php';
$db = \App\Core\Database::getInstance()->getConnection();

$types = ['collection_grid', 'product_embed', 'faq'];

foreach ($types as $type) {
    echo "\n--- SECTION: $type ---\n";
    $stmt = $db->prepare("SELECT * FROM ui_sections WHERE type = ? LIMIT 1");
    $stmt->execute([$type]);
    $section = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($section) {
        print_r($section);
        $stmt2 = $db->prepare("SELECT * FROM ui_section_items WHERE section_id = ?");
        $stmt2->execute([$section['id']]);
        print_r($stmt2->fetchAll(PDO::FETCH_ASSOC));
    } else {
        echo "No $type section found.\n";
    }
}
