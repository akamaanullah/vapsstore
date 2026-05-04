<?php
namespace App\Controllers\Front;

use App\Core\Controller;

class CollectionController extends Controller {
    public function show($slug = null) {
        // TODO: Build the frontend collection page
        // For now, load legacy collection view
        $this->view('front/collection', ['slug' => $slug]);
    }
}
