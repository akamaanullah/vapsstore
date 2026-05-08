<?php
namespace App\Controllers\Front;

use App\Core\Controller;

class ProductController extends Controller {
    public function show($slug = null) {
        // Filhal sirf product detail view load kar rahe hen
        $this->view('front/product-detail', [
            'pageTitle' => 'Product Detail | The Perfect Vape'
        ]);
    }
}
