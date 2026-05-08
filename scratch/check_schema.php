<?php
require_once 'app/Core/Database.php';
$db = App\Core\Database::getInstance()->getConnection();
$tableName = $argv[1] ?? 'products';
try {
    $stmt = $db->query("DESCRIBE $tableName");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo $e->getMessage();
}
