<?php
require_once __DIR__ . '/../app/Core/Database.php';

try {
    $db = \App\Core\Database::getInstance()->getConnection();
    
    // 1. Update the 'type' enum to include 'free_shipping'
    $sql = "ALTER TABLE coupons MODIFY COLUMN type ENUM('percentage', 'fixed_amount', 'free_shipping') NOT NULL";
    $db->exec($sql);
    
    echo "Table 'coupons' updated successfully: 'free_shipping' added to type enum.\n";
} catch (PDOException $e) {
    echo "Error updating table: " . $e->getMessage() . "\n";
}
