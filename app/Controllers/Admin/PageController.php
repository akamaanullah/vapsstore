<?php
namespace App\Controllers\Admin;

class PageController extends AdminController {
    public function index() {
        $this->view('admin/pages');
    }

    public function create() {
        $this->view('admin/create-page');
    }

    public function edit($id = null) {
        $this->view('admin/edit-page');
    }
}
