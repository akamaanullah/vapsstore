<?php
require 'config/config.php';
require 'app/Core/Database.php';
$db = \App\Core\Database::getInstance()->getConnection();
$stmt = $db->query('SELECT image_url FROM product_images LIMIT 5');
print_r($stmt->fetchAll(PDO::FETCH_COLUMN));
