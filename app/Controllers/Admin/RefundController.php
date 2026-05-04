<?php
namespace App\Controllers\Admin;

class RefundController extends AdminController {
    public function index() {
        $this->view('admin/refunds');
    }

    public function requests() {
        $this->view('admin/refund-requests');
    }

    public function detail($id = null) {
        $this->view('admin/refund-detail');
    }
}
