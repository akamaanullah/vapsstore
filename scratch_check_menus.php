<?php
require 'config/config.php';
require 'app/Core/Database.php';
$db = \App\Core\Database::getInstance()->getConnection();
$stmt = $db->query('SELECT * FROM menus');
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($menus as $menu) {
    echo "ID: " . $menu['id'] . " | Name: " . $menu['name'] . " | Location: " . $menu['location'] . "\n";
    $stmt2 = $db->prepare('SELECT * FROM menu_items WHERE menu_id = ?');
    $stmt2->execute([$menu['id']]);
    $items = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    echo "Items Count: " . count($items) . "\n";
}
