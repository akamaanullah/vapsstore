<?php
require 'config/config.php';
require 'app/Core/Database.php';
$db = \App\Core\Database::getInstance()->getConnection();

echo "\n--- HOMEPAGE GRIDS ---\n";
$stmt = $db->query("SELECT * FROM ui_sections WHERE entity_type = 'global_home' AND type IN ('collection_grid', 'product_embed')");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
