<?php
require_once 'app/Core/Database.php';
require_once 'app/Models/Product.php';
require_once 'app/Traits/Sluggable.php';

$data = [
    'name' => 'Test Product ' . time(),
    'base_price' => 10.00,
    'status' => 'draft',
    'variants' => [
        ['name' => 'Small', 'price' => 10.00, 'stock' => 5],
        ['name' => 'Large', 'price' => 15.00, 'stock' => 10]
    ]
];

$product = new App\Models\Product();
$res = $product->createProduct($data);

if ($res) {
    echo "Success! Product ID: $res";
} else {
    echo "Failed! Check logs.";
}
