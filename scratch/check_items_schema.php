<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

$db = Database::getInstance()->getConnection();

echo "--- UI_SECTION_ITEMS SCHEMA ---\n";
$stmt = $db->query("DESCRIBE ui_section_items");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Field: {$row['Field']} | Type: {$row['Type']} | Null: {$row['Null']}\n";
}
