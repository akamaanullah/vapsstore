<?php
require_once __DIR__ . '/app/Core/Database.php';
$db = App\Core\Database::getInstance()->getConnection();

echo "=== 1. UNIQUE INDEX on orders.order_number ===\n";
$stmt = $db->query("SHOW INDEX FROM orders WHERE Column_name = 'order_number'");
$found = false;
foreach ($stmt as $row) {
    $found = true;
    echo "  Key: {$row['Key_name']}, Unique: " . ($row['Non_unique'] ? 'NO' : 'YES') . "\n";
}
if (!$found) echo "  ❌ MISSING: No index on order_number\n";

echo "\n=== 2. order_id column in inventory_logs ===\n";
$stmt = $db->query("SHOW COLUMNS FROM inventory_logs LIKE 'order_id'");
$col = $stmt->fetch();
echo $col ? "  ✅ Found: order_id ({$col['Type']})\n" : "  ❌ MISSING: order_id column\n";

echo "\n=== 3. CHECK constraint on product_variants.stock_quantity ===\n";
$stmt = $db->query("SHOW CREATE TABLE product_variants");
$create = $stmt->fetch();
$hasCheck = strpos($create['Create Table'], 'stock_quantity') !== false && strpos($create['Create Table'], 'CHECK') !== false;
echo $hasCheck ? "  ✅ CHECK constraint found\n" : "  ⚠️ No CHECK constraint (MySQL 8.0.16+ only)\n";

echo "\n=== 4. created_at/updated_at in user_addresses ===\n";
$stmt = $db->query("SHOW COLUMNS FROM user_addresses");
$cols = [];
foreach ($stmt as $row) $cols[] = $row['Field'];
$hasCreated = in_array('created_at', $cols);
$hasUpdated = in_array('updated_at', $cols);
echo "  created_at: " . ($hasCreated ? '✅' : '❌') . "\n";
echo "  updated_at: " . ($hasUpdated ? '✅' : '❌') . "\n";

echo "\n=== 5. sessions table exists ===\n";
$stmt = $db->query("SHOW TABLES LIKE 'sessions'");
echo $stmt->rowCount() > 0 ? "  ✅ sessions table exists\n" : "  ❌ sessions table MISSING\n";

echo "\n=== 6. shipping_status ENUM values ===\n";
$stmt = $db->query("SHOW COLUMNS FROM orders LIKE 'shipping_status'");
$col = $stmt->fetch();
echo "  " . ($col ? $col['Type'] : 'NOT FOUND') . "\n";

echo "\n=== 7. storage/cache directory ===\n";
echo is_dir(__DIR__ . '/storage/cache') ? "  ✅ Exists\n" : "  ❌ MISSING\n";
