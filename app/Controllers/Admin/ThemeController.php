<?php
namespace App\Controllers\Admin;

class ThemeController extends AdminController {
    public function index() {
        $this->view('admin/theme');
    }
}
