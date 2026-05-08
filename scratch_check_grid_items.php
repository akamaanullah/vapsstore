<?php
require 'config/config.php';
require 'app/Core/Database.php';
$db = \App\Core\Database::getInstance()->getConnection();
$stmt = $db->query("SELECT * FROM ui_sections WHERE type = 'collection_grid' AND entity_type = 'global_home'");
$sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($sections as $s) {
    echo "Section ID: " . $s['id'] . "\n";
    $stmt2 = $db->prepare('SELECT COUNT(*) FROM ui_section_items WHERE section_id = ?');
    $stmt2->execute([$s['id']]);
    echo "Items Count: " . $stmt2->fetchColumn() . "\n";
    
    // Also list the items to check image_url
    $stmt3 = $db->prepare('SELECT * FROM ui_section_items WHERE section_id = ?');
    $stmt3->execute([$s['id']]);
    print_r($stmt3->fetchAll(PDO::FETCH_ASSOC));
}
