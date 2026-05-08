<?php
require_once 'app/Core/Database.php';
$db = App\Core\Database::getInstance()->getConnection();

try {
    // 1. Update blog_posts table
    $db->exec("ALTER TABLE blog_posts ADD COLUMN IF NOT EXISTS featured_image_url VARCHAR(255) AFTER author_id");
    $db->exec("ALTER TABLE blog_posts ADD COLUMN IF NOT EXISTS excerpt TEXT AFTER featured_image_url");
    
    echo "Database schema updated successfully for Blogs.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
