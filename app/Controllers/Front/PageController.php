<?php
namespace App\Controllers\Front;

use App\Core\Controller;

class PageController extends Controller {
    public function show($slug = null, $filters = null) {
        // TODO: Build the frontend static page renderer
        $this->view('front/page', ['slug' => $slug]);
    }
}
