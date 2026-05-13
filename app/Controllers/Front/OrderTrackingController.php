<?php
namespace App\Controllers\Front;

use App\Core\Controller;
use App\Core\Session;

class OrderTrackingController extends Controller {
    
    public function index() {
        $this->view('front/track-order', [
            'pageTitle' => 'Track Your Order | The Perfect Vape'
        ]);
    }

    public function track() {
        $orderNumber = trim($_GET['order'] ?? '');
        $email = trim($_GET['email'] ?? '');

        if (empty($orderNumber) || empty($email)) {
            $this->redirect('/track-order');
            return;
        }

        $orderModel = $this->model('Order');
        $order = $orderModel->getDetail($orderNumber);

        if (!$order || strtolower($order['customer_email']) !== strtolower($email)) {
            Session::setFlash('error', 'Order not found with those details.');
            $this->redirect('/track-order');
            return;
        }

        $this->view('front/order-status', [
            'pageTitle' => "Order #{$orderNumber} | The Perfect Vape",
            'order' => $order
        ]);
    }
}
