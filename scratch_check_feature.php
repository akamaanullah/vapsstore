<?php
require 'config/config.php';
require 'app/Core/Database.php';
$db = \App\Core\Database::getInstance()->getConnection();

echo "\n--- SAMPLE DATA (FEATURE HIGHLIGHT) ---\n";
$stmt = $db->query("SELECT * FROM ui_sections WHERE type = 'feature_highlight' LIMIT 1");
$section = $stmt->fetch(PDO::FETCH_ASSOC);
if ($section) {
    print_r($section);
    $stmt2 = $db->prepare("SELECT * FROM ui_section_items WHERE section_id = ?");
    $stmt2->execute([$section['id']]);
    print_r($stmt2->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo "No feature_highlight section found.\n";
}
