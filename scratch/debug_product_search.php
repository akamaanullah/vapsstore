<?php
$db = new PDO('mysql:host=localhost;dbname=vapestore', 'root', '');
echo "CHECKING PRODUCT 21 (Box Package):\n";
$stmt = $db->query("SELECT * FROM products WHERE id = 21");
print_r($stmt->fetch(PDO::FETCH_ASSOC));

echo "\nCHECKING IMAGES FOR PRODUCT 21:\n";
$stmt = $db->query("SELECT * FROM product_images WHERE product_id = 21");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
