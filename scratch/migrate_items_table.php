<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

$db = Database::getInstance()->getConnection();

try {
    $db->exec("ALTER TABLE ui_section_items ADD COLUMN entity_id BIGINT UNSIGNED NULL AFTER section_id");
    $db->exec("ALTER TABLE ui_section_items ADD COLUMN entity_type VARCHAR(50) NULL AFTER entity_id");
    echo "SUCCESS: Added entity_id and entity_type to ui_section_items\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
