<?php
define('BASE_PATH', dirname(__DIR__));
require BASE_PATH . '/app/Core/Database.php';

try {
    $db = \App\Core\Database::getInstance()->getConnection();
    $db->exec("ALTER TABLE products ADD COLUMN compare_price DECIMAL(10,2) DEFAULT NULL AFTER base_price");
    echo "Column 'compare_price' added successfully to 'products' table.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
