<?php
require 'd:/xampp/htdocs/vapestore/config/config.php';
require 'd:/xampp/htdocs/vapestore/app/Core/Database.php';
use App\Core\Database;

try {
    $db = Database::getInstance()->getConnection();
    // Check if column exists
    $columns = $db->query("SHOW COLUMNS FROM ui_sections LIKE 'title'")->fetchAll();
    if (empty($columns)) {
        $db->exec("ALTER TABLE ui_sections ADD COLUMN title VARCHAR(255) DEFAULT NULL AFTER type");
        echo "Successfully added 'title' column to ui_sections.\n";
    } else {
        echo "Column 'title' already exists in ui_sections.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
