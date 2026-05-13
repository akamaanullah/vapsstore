<?php
namespace App\Controllers\Front;

use App\Core\Controller;

class HomeController extends Controller {
    
    public function index() {
        $sections = \App\Helpers\UIHelper::getSections('global_home');
        
        // Fetch latest 3 blog posts for the home page
        $db = \App\Core\Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT b.*, c.name as category_name 
            FROM blog_posts b 
            LEFT JOIN blog_categories c ON b.category_id = c.id 
            WHERE b.is_active = 1 
            ORDER BY b.published_at DESC 
            LIMIT 3
        ");
        $latestPosts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $this->view('front/home', [
            'sections' => $sections,
            'latestPosts' => $latestPosts
        ]);
    }

    public function contact() {
        $this->view('front/contact-us', [
            'pageTitle' => 'Contact Us | The Perfect Vape'
        ]);
    }

    public function wishlist() {
        $this->view('front/wishlist', [
            'pageTitle' => 'Your Wishlist | The Perfect Vape'
        ]);
    }

    public function cart() {
        $cart = \App\Core\Session::get('cart') ?: [];
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $this->view('front/cart', [
            'pageTitle' => 'Shopping Cart | The Perfect Vape',
            'cart' => [
                'items' => array_values($cart),
                'subtotal' => $subtotal,
                'formatted_subtotal' => '£' . number_format($subtotal, 2)
            ]
        ]);
    }

    public function checkout() {
        $cart = \App\Core\Session::get('cart') ?: [];
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        if (empty($cart)) {
            $this->redirect('/collection');
        }

        $this->view('front/checkout', [
            'pageTitle' => 'Checkout | The Perfect Vape',
            'cart' => $cart,
            'subtotal' => $subtotal
        ]);
    }

    // Policy Methods
    public function shippingPolicy() {
        $this->view('front/shipping-policy', ['pageTitle' => 'Shipping Policy']);
    }

    public function refundPolicy() {
        $this->view('front/refund-policy', ['pageTitle' => 'Refund Policy']);
    }

    public function returnPolicy() {
        $this->view('front/return-policy', ['pageTitle' => 'Return Policy']);
    }

    public function privacyPolicy() {
        $this->view('front/privacy-policy', ['pageTitle' => 'Privacy Policy']);
    }

    public function termsAndConditions() {
        $this->view('front/terms-and-conditions', ['pageTitle' => 'Terms & Conditions']);
    }

    public function fdaDisclaimer() {
        $this->view('front/fda-disclaimer', ['pageTitle' => 'FDA Disclaimer']);
    }

    public function login() {
        if (\App\Core\Session::get('user_id')) {
            $this->redirect('/');
            return;
        }
        $this->view('front/login', [
            'pageTitle' => 'Login | The Perfect Vape'
        ]);
    }

    public function signup() {
        if (\App\Core\Session::get('user_id')) {
            $this->redirect('/');
            return;
        }
        $this->view('front/login', [
            'pageTitle' => 'Sign Up | The Perfect Vape'
        ]);
    }
}
