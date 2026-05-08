<?php
require_once 'app/Core/Database.php';
$db = App\Core\Database::getInstance()->getConnection();
try {
    // 1. Add professional metadata column
    $db->exec("ALTER TABLE products ADD COLUMN IF NOT EXISTS option_names TEXT AFTER tags");

    // 2. Remove unnecessary hardcoded columns from variants
    $colsToRemove = ['flavor', 'size', 'nicotine_strength', 'puff_count'];
    $currentCols = $db->query("DESCRIBE product_variants")->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($colsToRemove as $col) {
        if (in_array($col, $currentCols)) {
            $db->exec("ALTER TABLE product_variants DROP COLUMN $col");
        }
    }
    
    echo "Success: Database optimized for dynamic variants.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
