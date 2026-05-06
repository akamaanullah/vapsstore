<?php
require 'vendor/autoload.php';
$db = App\Core\Database::getInstance()->getConnection();
$db->exec("ALTER TABLE menu_items MODIFY COLUMN link_type ENUM('collection','brand','page','custom_url','mega_menu_column','promo_banner','text_block','newsletter','html') NOT NULL");
$db->exec("ALTER TABLE menu_items MODIFY COLUMN link_value TEXT DEFAULT NULL");
echo "Database updated successfully.\n";
