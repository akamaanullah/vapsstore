<?php
define('BASE_PATH', dirname(__DIR__));
require BASE_PATH . '/app/Core/Database.php';

try {
    $db = \App\Core\Database::getInstance()->getConnection();
    
    $stmt = $db->query("DESCRIBE products");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $col) {
        echo $col['Field'] . " (" . $col['Type'] . ")\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
