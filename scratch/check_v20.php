<?php
require_once 'app/Core/Database.php';
$db = App\Core\Database::getInstance()->getConnection();
try {
    $stmt = $db->prepare("SELECT * FROM product_variants WHERE product_id = 20");
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo $e->getMessage();
}
