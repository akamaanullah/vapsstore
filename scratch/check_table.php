<?php
require_once 'app/Core/Database.php';
$db = App\Core\Database::getInstance()->getConnection();
try {
    $db->query("SELECT 1 FROM product_collections LIMIT 1");
    echo "Exists";
} catch (Exception $e) {
    echo $e->getMessage();
}
