<?php
namespace App\Controllers\Front;

use App\Core\Controller;

class HomeController extends Controller {
    
    public function index() {
        $sections = \App\Helpers\UIHelper::getSections('global_home');
        
        $this->view('front/home', [
            'sections' => $sections
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

    public function checkout() {
        $this->view('front/checkout', [
            'pageTitle' => 'Checkout | The Perfect Vape'
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
}
