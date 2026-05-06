<?php
require 'vendor/autoload.php';
$db = App\Core\Database::getInstance()->getConnection();
$stmt = $db->query('DESCRIBE menu_items');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
