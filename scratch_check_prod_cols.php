<?php
require 'config/config.php';
require 'app/Core/Database.php';
$db = \App\Core\Database::getInstance()->getConnection();
$stmt = $db->query("DESCRIBE products");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
