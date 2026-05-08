<?php
require 'config/config.php';
require 'app/Core/Database.php';
$db = \App\Core\Database::getInstance()->getConnection();
$stmt = $db->query('SELECT DISTINCT type FROM ui_sections');
print_r($stmt->fetchAll(PDO::FETCH_COLUMN));
