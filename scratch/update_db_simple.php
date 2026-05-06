<?php
// Simple script to update database schema
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'vapestore';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("ALTER TABLE menu_items MODIFY COLUMN link_type ENUM('collection','brand','page','custom_url','mega_menu_column','promo_banner','text_block','newsletter','html') NOT NULL");
    $pdo->exec("ALTER TABLE menu_items MODIFY COLUMN link_value TEXT DEFAULT NULL");

    echo "Database updated successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
