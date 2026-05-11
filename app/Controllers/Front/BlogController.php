<?php
namespace App\Controllers\Front;

use App\Core\Controller;

class BlogController extends Controller {
    public function index() {
        $this->view('front/blog', [
            'pageTitle' => 'Vape Insights & News | The Perfect Vape'
        ]);
    }

    public function show($slug = null, $filters = null) {
        $this->view('front/blog-detail', [
            'pageTitle' => 'Blog Detail | The Perfect Vape'
        ]);
    }
}
