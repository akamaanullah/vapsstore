<?php
namespace App\Controllers\Front;

use App\Core\Controller;
use App\Core\Session;

class CheckoutController extends Controller {

    public function index() {
        $cart = Session::get('cart') ?: [];
        $productModel = $this->model('Product');
        $subtotal = 0;
        $verifiedCart = [];

        foreach ($cart as $key => $item) {
            $variant = $productModel->getVariant($item['variant_id']);
            if ($variant && $variant['product_status'] === 'published') {
                $item['price'] = (float)$variant['price'];
                $subtotal += $item['price'] * $item['quantity'];
                $verifiedCart[$key] = $item;
            }
        }
        $cart = $verifiedCart;

        if (empty($cart)) {
            $this->redirect('/collection');
        }

        // Fetch user info and addresses if logged in
        $userAddresses = [];
        $userId = Session::get('user_id');
        $userEmail = Session::get('user_email');
        
        if ($userId) {
            // Link any pending guest addresses just in case
            $this->model('UserAddress')->linkGuestAddresses($userId, $userEmail);
            $userAddresses = $this->model('UserAddress')->getByUser($userId);
        }

        $this->view('front/checkout', [
            'pageTitle' => 'Checkout | The Perfect Vape',
            'cart' => $cart,
            'subtotal' => $subtotal,
            'userAddresses' => $userAddresses,
            'userEmail' => $userEmail,
            'userId' => $userId
        ]);
    }

    public function placeOrder() {
        $this->validateCsrf();

        $cart = Session::get('cart') ?: [];
        if (empty($cart)) {
            $this->jsonResponse(['success' => false, 'message' => 'Your cart is empty.'], 400);
        }

        // 0. Rate Limiting (Phase 3.3)
        $lastAttempt = Session::get('last_checkout_attempt');
        if ($lastAttempt && (time() - $lastAttempt < 30)) {
            $this->jsonResponse(['success' => false, 'message' => 'Please wait 30 seconds before trying again.'], 429);
            return;
        }
        Session::set('last_checkout_attempt', time());

        // 1. Sanitization & Validation
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $this->jsonResponse(['success' => false, 'message' => 'Please provide a valid email address.'], 400);
            return;
        }

        // Helper to sanitize text
        $sanitize = function($str, $max = 255) {
            return mb_substr(strip_tags(trim($str)), 0, $max);
        };

        $fname = $sanitize($_POST['fname'] ?? '', 50);
        $lname = $sanitize($_POST['lname'] ?? '', 50);
        $phone = preg_replace('/[^0-9+\-\s()]/', '', $_POST['phone'] ?? '');
        $address = $sanitize($_POST['address'] ?? '', 255);
        $apartment = $sanitize($_POST['apartment'] ?? '', 100);
        $city = $sanitize($_POST['city'] ?? '', 100);
        $postal = $sanitize($_POST['postal'] ?? '', 20);

        if (!$fname || !$lname || !$address || !$city || !$postal || !$phone) {
            $this->jsonResponse(['success' => false, 'message' => 'Please fill in all required fields.'], 400);
            return;
        }

        // 2. Financial Integrity Check: Re-fetch LIVE prices from DB
        $productModel = $this->model('Product');
        $verifiedItems = [];
        $subtotal = 0;

        foreach ($cart as $key => $item) {
            $variant = $productModel->getVariant($item['variant_id']);
            
            if (!$variant || $variant['product_status'] !== 'published') {
                $this->jsonResponse(['success' => false, 'message' => "Sorry, '{$item['name']}' is no longer available."], 400);
                return;
            }

            $item['price'] = (float)$variant['price'];
            $subtotal += $item['price'] * $item['quantity'];
            $verifiedItems[$key] = $item;
        }
        $cart = $verifiedItems;

        $orderModel = $this->model('Order');
        $addressModel = $this->model('UserAddress');
        $orderNumber = $orderModel->generateOrderNumber();
        $userId = Session::get('user_id'); // null if guest

        // 2. Prepare Shipping Address
        $shippingAddress = [
            'user_id' => $userId,
            'first_name' => $fname,
            'last_name' => $lname,
            'phone' => $phone,
            'street' => $address . ($apartment ? ', ' . $apartment : ''),
            'city' => $city,
            'zip' => $postal,
            'country' => 'United Kingdom'
        ];

        // 3. Prepare Billing Address (if different)
        $billingAddress = null;
        if (($_POST['billing_choice'] ?? '') === 'different') {
            $billingAddress = [
                'user_id' => $userId,
                'first_name' => $sanitize($_POST['billing_fname'] ?: $fname, 50),
                'last_name' => $sanitize($_POST['billing_lname'] ?: $lname, 50),
                'phone' => $phone,
                'street' => $sanitize($_POST['billing_address'], 255) . ($_POST['billing_apartment'] ? ', ' . $sanitize($_POST['billing_apartment'], 100) : ''),
                'city' => $sanitize($_POST['billing_city'], 100),
                'zip' => $sanitize($_POST['billing_postal'], 20),
                'country' => $sanitize($_POST['billing_country'] ?? 'United Kingdom', 100)
            ];
        }

        // 4. Create Order Atomically
        $orderData = [
            'order_number' => $orderNumber,
            'user_id' => $userId,
            'customer_email' => $email,
            'customer_first_name' => $fname,
            'customer_last_name' => $lname,
            'customer_phone' => $phone,
            'subtotal' => $subtotal,
            'total_amount' => $subtotal,
            'customer_notes' => 'Store Order'
        ];

        try {
            $orderId = $orderModel->create($orderData, $cart, $shippingAddress, $billingAddress);

            if ($orderId) {
                // Clear Cart
                Session::set('cart', []);
                
                // Secure Success Redirect: Use Flash Session instead of URL parameter
                Session::setFlashData('placed_order_number', $orderNumber);

                // Send Confirmation Email
                try {
                    $fullOrder = $orderModel->getDetail($orderNumber);
                    if ($fullOrder) {
                        \App\Helpers\MailHelper::sendOrderConfirmation($fullOrder);
                    }
                } catch (\Exception $e) {
                    // Log but don't fail the checkout if email fails
                    error_log("Failed to send order confirmation: " . $e->getMessage());
                }
                
                $this->jsonResponse([
                    'success' => true, 
                    'message' => 'Order placed successfully!',
                    'redirect' => BASE_URL . '/checkout/success'
                ]);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Failed to place order. Please try again.'], 500);
            }
        } catch (\RuntimeException $e) {
            // Handle specific errors like OUT_OF_STOCK
            $message = $e->getMessage();
            if (strpos($message, 'OUT_OF_STOCK') !== false) {
                $this->jsonResponse(['success' => false, 'message' => 'One or more items in your cart just went out of stock. Please update your cart.'], 400);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'An error occurred while processing your order: ' . $message], 500);
            }
        } catch (\Exception $e) {
            error_log("[CheckoutController::placeOrder] " . $e->getMessage());
            $this->jsonResponse(['success' => false, 'message' => 'A critical error occurred. Please contact support.'], 500);
        }

    }

    public function success() {
        $orderNumber = Session::getFlashData('placed_order_number');
        
        // If no flash data, they shouldn't be here (or they refreshed)
        if (!$orderNumber) {
            $this->redirect('/');
            return;
        }

        $this->view('front/checkout-success', [
            'pageTitle' => 'Order Success | The Perfect Vape',
            'orderNumber' => $orderNumber
        ]);
    }
}
