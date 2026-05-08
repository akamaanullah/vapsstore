<?php
$db = new PDO('mysql:host=localhost;dbname=vapestore', 'root', '');
$stmt = $db->query("SELECT p.id, p.name, (SELECT image_url FROM product_images WHERE product_id = p.id ORDER BY sort_order ASC LIMIT 1) as featured_image FROM products p WHERE p.id = 23");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
print_r($row);
