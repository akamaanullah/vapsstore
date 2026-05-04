<?php
namespace App\Controllers\Admin;

class BrandController extends AdminController {
    public function index() {
        include __DIR__ . '/../../../views/admin/brands.php';
    }

    public function create() {
        include __DIR__ . '/../../../views/admin/create-brand.php';
    }

    public function edit() {
        include __DIR__ . '/../../../views/admin/edit-brand.php';
    }
}
