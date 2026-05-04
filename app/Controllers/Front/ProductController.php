<?php
namespace App\Controllers\Front;

use App\Core\Controller;

class ProductController extends Controller {
    public function show($slug = null) {
        // TODO: Build the frontend product detail page
        $this->view('front/product', ['slug' => $slug]);
    }
}
