<?php
namespace App\Controllers\Admin;

class CouponController extends AdminController {
    public function index() {
        include __DIR__ . '/../../../views/admin/coupons.php';
    }

    public function create() {
        include __DIR__ . '/../../../views/admin/create-coupon.php';
    }

    public function edit() {
        include __DIR__ . '/../../../views/admin/edit-coupon.php';
    }
}
