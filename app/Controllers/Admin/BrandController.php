<?php
namespace App\Controllers\Admin;

class BrandController extends AdminController {
    public function index() {
        $this->view('admin/brands');
    }

    public function create() {
        $this->view('admin/create-brand');
    }

    public function edit($id = null) {
        $this->view('admin/edit-brand');
    }
}
