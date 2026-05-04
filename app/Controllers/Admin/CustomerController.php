<?php
namespace App\Controllers\Admin;

class CustomerController extends AdminController {
    public function index() {
        $this->view('admin/customers');
    }

    public function detail($id = null) {
        $this->view('admin/customer-detail');
    }
}
