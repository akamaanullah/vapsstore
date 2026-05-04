<?php
namespace App\Controllers\Admin;

class MenuController extends AdminController {
    public function index() {
        include __DIR__ . '/../../../views/admin/menus.php';
    }

    public function edit() {
        include __DIR__ . '/../../../views/admin/edit-menu.php';
    }

    public function settings() {
        include __DIR__ . '/../../../views/admin/menu-settings.php';
    }
}
