<?php
namespace App\Controllers\Front;

use App\Core\Controller;

class CollectionController extends Controller {
    public function show($slug = null) {
        if (!$slug) $this->redirect('/');

        $collectionModel = $this->model('Collection');
        $productModel = $this->model('Product');

        $collection = $collectionModel->findBySlug($slug);
        if (!$collection) {
            // Handle 404
            header("HTTP/1.0 404 Not Found");
            $this->view('front/404');
            return;
        }

        $products = $productModel->getByCollectionId($collection['id']);
        
        $uiModel = $this->model('UISection');
        $sections = $uiModel->getSections('collection', $collection['id']);

        $this->view('front/collection', [
            'collection' => $collection,
            'products' => $products,
            'sections' => $sections
        ]);
    }
}
