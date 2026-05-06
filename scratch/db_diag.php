<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

$db = Database::getInstance()->getConnection();

echo "--- UI SECTIONS SCHEMA CHECK ---\n";
$stmt = $db->query("SELECT id, entity_type, entity_id, type FROM ui_sections WHERE entity_type = 'global_home'");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: {$row['id']} | EntityType: {$row['entity_type']} | EntityID: " . ($row['entity_id'] === null ? "NULL" : "'".$row['entity_id']."'") . " | Type: {$row['type']}\n";
}

echo "\n--- RAW INPUT TEST ---\n";
// Let's see if we can update directly
$testId = 5; // Hero Slider
$newOrder = 0;
$update = $db->prepare("UPDATE ui_sections SET sort_order = ? WHERE id = ?");
$update->execute([$newOrder, $testId]);
echo "Direct Update test on section 5: " . ($update->rowCount() > 0 ? "SUCCESS" : "NO CHANGE / FAILED") . "\n";
