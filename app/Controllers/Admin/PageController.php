<?php
namespace App\Controllers\Admin;

class PageController extends AdminController {
    public function index() {
        include __DIR__ . '/../../../views/admin/pages.php';
    }

    public function create() {
        include __DIR__ . '/../../../views/admin/create-page.php';
    }

    public function edit() {
        include __DIR__ . '/../../../views/admin/edit-page.php';
    }
}
