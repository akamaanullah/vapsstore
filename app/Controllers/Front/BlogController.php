<?php
namespace App\Controllers\Front;

use App\Core\Controller;

class BlogController extends Controller {
    public function show($slug = null) {
        // TODO: Build the frontend blog post page
        $this->view('front/blog', ['slug' => $slug]);
    }
}
