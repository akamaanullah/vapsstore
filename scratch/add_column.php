<?php
require_once 'app/Core/Database.php';
$db = App\Core\Database::getInstance()->getConnection();
try {
    $db->exec("ALTER TABLE products ADD COLUMN IF NOT EXISTS option_names TEXT AFTER tags");
    echo "Success";
} catch (Exception $e) {
    echo $e->getMessage();
}
