<?php
require 'config/config.php';
require 'app/Core/Database.php';
$db = \App\Core\Database::getInstance()->getConnection();
$stmt = $db->query("SELECT * FROM ui_sections WHERE entity_type = 'global_home'");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
