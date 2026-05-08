<?php
$db = new PDO('mysql:host=localhost;dbname=vapestore', 'root', '');
$query = "Box";
$limit = 50;
$sql = "SELECT p.id, p.name, p.base_price, p.custom_url,
        (SELECT image_url FROM product_images WHERE product_id = p.id ORDER BY sort_order ASC LIMIT 1) as featured_image 
        FROM products p 
        WHERE p.name LIKE ? 
        LIMIT ?";
$stmt = $db->prepare($sql);
$stmt->execute(['%' . $query . '%', (int)$limit]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "SEARCH RESULTS FOR 'Box':\n";
print_r($results);
