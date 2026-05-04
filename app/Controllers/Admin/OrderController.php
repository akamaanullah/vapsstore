<?php
namespace App\Controllers\Admin;

class OrderController extends AdminController {
    public function index() {
        $this->view('admin/orders');
    }

    public function detail($id = null) {
        $this->view('admin/order-detail');
    }
}
