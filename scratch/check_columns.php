<?php
require_once __DIR__ . '/../config/config.php';
$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);

echo "=== PRODUCTS columns ===\n";
foreach ($pdo->query('DESCRIBE products') as $r) echo $r['Field'] . ': ' . $r['Type'] . "\n";

echo "\n=== COLLECTIONS columns ===\n";
foreach ($pdo->query('DESCRIBE collections') as $r) echo $r['Field'] . ': ' . $r['Type'] . "\n";

echo "\n=== BRANDS columns ===\n";
foreach ($pdo->query('DESCRIBE brands') as $r) echo $r['Field'] . ': ' . $r['Type'] . "\n";
