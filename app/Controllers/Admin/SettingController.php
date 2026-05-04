<?php
namespace App\Controllers\Admin;

class SettingController extends AdminController {
    public function index() {
        include __DIR__ . '/../../../views/admin/settings.php';
    }
}
