<?php
namespace App\Controllers\Front;

use App\Core\Controller;

class CollectionController extends Controller {
    public function index() {
        $this->view('front/collection', [
            'pageTitle' => 'Shop All Products | The Perfect Vape'
        ]);
    }
}
