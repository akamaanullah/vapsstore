<?php
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

try {
    $db = Database::getInstance()->getConnection();
    
    $sql = "CREATE TABLE IF NOT EXISTS `sessions` (
        `id` VARCHAR(128) NOT NULL PRIMARY KEY,
        `data` TEXT NOT NULL,
        `last_access` INT(11) NOT NULL,
        INDEX `last_access_idx` (`last_access`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    $db->exec($sql);
    echo "Sessions table created successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
