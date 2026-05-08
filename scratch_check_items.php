<?php
require 'config/config.php';
require 'app/Core/Database.php';
require 'app/Core/Model.php';
require 'app/Models/MenuItem.php';
$itemModel = new \App\Models\MenuItem();
$items = $itemModel->getTree(2); // ID 2 is Main menu
echo json_encode($items, JSON_PRETTY_PRINT);
