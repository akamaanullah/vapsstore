<?php
namespace App\Controllers\Admin;

class CouponController extends AdminController {
    public function index() {
        $model = new \App\Models\Coupon();
        $coupons = $model->all();
        $this->view('admin/coupons', ['coupons' => $coupons]);
    }

    public function create() {
        $this->view('admin/create-coupon');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!\App\Core\Session::validateCsrfToken($_POST['csrf_token'] ?? '')) {
                $this->redirect('/admin/coupons/create?error=Invalid CSRF token');
            }
            $model = new \App\Models\Coupon();
            if ($model->create($_POST)) {
                $this->redirect('/admin/coupons?success=Coupon created');
            }
        }
        $this->redirect('/admin/coupons?error=Failed to create coupon');
    }

    public function edit($id = null) {
        $model = new \App\Models\Coupon();
        $coupon = $model->find($id);
        if (!$coupon) {
            $this->redirect('/admin/coupons');
        }
        $this->view('admin/edit-coupon', ['coupon' => $coupon]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!\App\Core\Session::validateCsrfToken($_POST['csrf_token'] ?? '')) {
                $this->redirect('/admin/coupons/edit/' . $id . '?error=Invalid CSRF token');
            }
            $model = new \App\Models\Coupon();
            if ($model->update($id, $_POST)) {
                $this->redirect('/admin/coupons?success=Coupon updated');
            }
        }
        $this->redirect('/admin/coupons?error=Update failed');
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!\App\Core\Session::validateCsrfToken($_POST['csrf_token'] ?? '')) {
                $this->redirect('/admin/coupons?error=Invalid CSRF token');
            }
            $model = new \App\Models\Coupon();
            if ($model->delete($id)) {
                $this->redirect('/admin/coupons?success=Coupon deleted');
            }
        }
        $this->redirect('/admin/coupons?error=Delete failed');
    }
}
