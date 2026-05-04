<?php
namespace App\Controllers\Admin;

class MenuController extends AdminController {
    public function index() {
        $this->view('admin/menus');
    }

    public function edit($id = null) {
        $this->view('admin/edit-menu');
    }

    public function settings() {
        $this->view('admin/menu-settings');
    }
}
