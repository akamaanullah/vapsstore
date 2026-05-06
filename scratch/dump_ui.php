<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

$db = Database::getInstance()->getConnection();

echo "--- UI SECTIONS ---\n";
$sections = $db->query("SELECT * FROM ui_sections WHERE entity_type = 'global_home'")->fetchAll(PDO::FETCH_ASSOC);
print_r($sections);

echo "\n--- UI SECTION ITEMS ---\n";
foreach ($sections as $sec) {
    echo "Section ID: {$sec['id']} ({$sec['type']})\n";
    $items = $db->query("SELECT * FROM ui_section_items WHERE section_id = {$sec['id']}")->fetchAll(PDO::FETCH_ASSOC);
    print_r($items);
}
