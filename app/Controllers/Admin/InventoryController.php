<?php
namespace App\Controllers\Admin;

class InventoryController extends AdminController {
    public function index() {
        $this->view('admin/inventory');
    }
}
