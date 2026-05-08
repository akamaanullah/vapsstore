<?php
require_once 'app/Core/Database.php';
$db = App\Core\Database::getInstance()->getConnection();
try {
    $stmt = $db->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($tables, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo $e->getMessage();
}
