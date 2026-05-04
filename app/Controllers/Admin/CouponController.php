<?php
namespace App\Controllers\Admin;

class CouponController extends AdminController {
    public function index() {
        $this->view('admin/coupons');
    }

    public function create() {
        $this->view('admin/create-coupon');
    }

    public function edit($id = null) {
        $this->view('admin/edit-coupon');
    }
}
