<?php
require_once 'config/config.php';
require_once 'app/Core/Database.php';

try {
    $db = \App\Core\Database::getInstance()->getConnection();
    
    echo "Phase 1.1: Starting Database Hardening...\n";

    // 1. Add UNIQUE index to orders.order_number
    echo "Adding UNIQUE index to orders.order_number...\n";
    $db->exec("ALTER TABLE `orders` ADD UNIQUE INDEX `idx_order_number_unique` (`order_number`) ");

    // 2. Add order_id to inventory_logs
    echo "Adding order_id to inventory_logs...\n";
    $db->exec("ALTER TABLE `inventory_logs` ADD COLUMN `order_id` bigint(20) UNSIGNED NULL AFTER `variant_id` ");

    // 3. Add CHECK constraint to product_variants (requires MySQL 8.0.16+)
    // If on older MySQL, this will be ignored but won't crash
    echo "Enforcing non-negative stock on product_variants...\n";
    try {
        $db->exec("ALTER TABLE `product_variants` ADD CONSTRAINT `chk_stock_positive` CHECK (stock_quantity >= 0) ");
    } catch (Exception $e) {
        echo "Note: CHECK constraint not supported or already exists. Skipping.\n";
    }

    // 4. Add timestamps to user_addresses
    echo "Adding timestamps to user_addresses...\n";
    $db->exec("ALTER TABLE `user_addresses` ADD COLUMN `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ");
    $db->exec("ALTER TABLE `user_addresses` ADD COLUMN `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ");

    echo "Phase 1.1 Completed successfully!\n";

} catch (Exception $e) {
    echo "Phase 1.1 Failed: " . $e->getMessage() . "\n";
}
