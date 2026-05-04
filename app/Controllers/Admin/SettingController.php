<?php
namespace App\Controllers\Admin;

class SettingController extends AdminController {
    public function index() {
        $this->view('admin/settings');
    }
}
