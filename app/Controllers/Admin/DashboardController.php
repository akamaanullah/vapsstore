<?php
namespace App\Controllers\Admin;

class DashboardController extends AdminController {
    
    public function index() {
        $orderModel = $this->model('Order');
        $stats = $orderModel->getDashboardStats();

        $this->view('admin/index', [
            'stats' => $stats
        ]);
    }
}
