<?php
require_once __DIR__ . '/../app/Core/Model.php';
require_once __DIR__ . '/../config/config.php';

// Direct DB connection
$host = DB_HOST;
$db   = DB_NAME;
$user = DB_USER;
$pass = DB_PASS;
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Add columns to ui_sections
    $sql = "ALTER TABLE ui_sections 
            ADD COLUMN IF NOT EXISTS button_text VARCHAR(255) NULL AFTER title,
            ADD COLUMN IF NOT EXISTS button_url VARCHAR(255) NULL AFTER button_text";
    
    $pdo->exec($sql);
    echo "Successfully updated ui_sections table with button columns.\n";
    
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
