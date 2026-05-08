<?php
require 'config/config.php';
require 'app/Core/Database.php';
$db = \App\Core\Database::getInstance()->getConnection();
$stmt = $db->prepare('SELECT * FROM ui_section_items WHERE section_id = ?');
$stmt->execute([8]);
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
