<?php
require 'config/config.php';
require 'app/Core/Database.php';
$db = \App\Core\Database::getInstance()->getConnection();

echo "\n--- SAMPLE DATA (PROMO GRID) ---\n";
$stmt = $db->query("SELECT * FROM ui_sections WHERE type = 'promo_grid' LIMIT 1");
$section = $stmt->fetch(PDO::FETCH_ASSOC);
if ($section) {
    print_r($section);
    $stmt2 = $db->prepare("SELECT * FROM ui_section_items WHERE section_id = ?");
    $stmt2->execute([$section['id']]);
    print_r($stmt2->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo "No promo_grid section found.\n";
}
