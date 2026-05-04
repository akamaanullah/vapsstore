<?php
namespace App\Controllers\Admin;

class ThemeController extends AdminController {
    public function index() {
        include __DIR__ . '/../../../views/admin/theme.php';
    }
}
