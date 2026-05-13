<?php
namespace App\Controllers\Admin;

class OrderController extends AdminController {
    public function index() {
        $orderModel = $this->model('Order');
        
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_GET['per_page'] ?? 10);
        $filters = [
            'search' => $_GET['search'] ?? '',
            'payment_status' => $_GET['payment_status'] ?? 'all',
            'shipping_status' => $_GET['shipping_status'] ?? 'all'
        ];

        $results = $orderModel->getAdminList($page, $perPage, $filters);

        $this->view('admin/orders', [
            'orders' => $results['data'],
            'pagination' => [
                'total' => $results['total'],
                'per_page' => $results['per_page'],
                'current_page' => $results['current_page'],
                'last_page' => $results['last_page']
            ],
            'filters' => $filters
        ]);
    }

    public function detail($id = null) {
        if (!$id) {
            $this->redirect('/admin/orders');
            return;
        }

        $orderModel = $this->model('Order');
        $order = $orderModel->getDetail($id);

        if (!$order) {
            $this->redirect('/admin/orders');
            return;
        }

        $this->view('admin/order-detail', [
            'order' => $order
        ]);
    }

    public function updateStatus($id = null) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) {
            $this->redirect('/admin/orders');
            return;
        }

        $this->validateCsrf();

        $type = $_POST['type'] ?? ''; // payment or fulfillment
        $status = $_POST['status'] ?? '';
        $trackingNumber = $_POST['tracking_number'] ?? null;
        
        $orderModel = $this->model('Order');
        $success = $orderModel->updateStatus($id, $type, $status, $trackingNumber);

        if ($success) {
            // Trigger Email if it's a shipping update
            if ($type === 'fulfillment') {
                $order = $orderModel->getDetailById($id);
                if ($order) {
                    \App\Helpers\MailHelper::sendShippingUpdate($order);
                }
            }
            \App\Core\Session::setFlash('success', 'Order status updated successfully.');
        } else {
            \App\Core\Session::setFlash('error', 'Failed to update order status.');
        }

        $orderNumber = $_POST['order_number'] ?? '';
        $this->redirect('/admin/orders/detail/' . $orderNumber);
    }
}
