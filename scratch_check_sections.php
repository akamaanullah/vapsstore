<?php
require 'config/config.php';
require 'app/Core/Database.php';
$db = \App\Core\Database::getInstance()->getConnection();

echo "--- UI SECTIONS ---\n";
$stmt = $db->query('DESCRIBE ui_sections');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

echo "\n--- UI SECTION ITEMS ---\n";
$stmt = $db->query('DESCRIBE ui_section_items');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

echo "\n--- SAMPLE DATA (HERO SLIDER) ---\n";
$stmt = $db->query("SELECT * FROM ui_sections WHERE type = 'hero_slider' LIMIT 1");
$section = $stmt->fetch(PDO::FETCH_ASSOC);
if ($section) {
    print_r($section);
    $stmt2 = $db->prepare("SELECT * FROM ui_section_items WHERE section_id = ?");
    $stmt2->execute([$section['id']]);
    print_r($stmt2->fetchAll(PDO::FETCH_ASSOC));
}
