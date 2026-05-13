<?php
require_once __DIR__ . '/app/Core/Database.php';
$db = App\Core\Database::getInstance()->getConnection();

echo "=== Users Table Check ===\n";
$stmt = $db->query("SHOW TABLES LIKE 'users'");
if ($stmt->rowCount() === 0) {
    echo "❌ MISSING: users table does not exist.\n";
} else {
    echo "✅ EXISTS: users table found.\n";
    $stmt = $db->query("DESCRIBE users");
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        echo "  {$row['Field']} ({$row['Type']}) " . ($row['Null'] === 'NO' ? 'NOT NULL' : 'NULL') . " {$row['Key']}\n";
    }
}
