<?php
namespace App\Controllers\Front;

use App\Core\Controller;

class CollectionController extends Controller {
    public function index($filters = null) {
        $collectionModel = $this->model('Collection');
        $productModel = $this->model('Product');
        $brandModel = $this->model('Brand');

        $allCollections = $collectionModel->getAllWithParent();
        $allBrands = $brandModel->getActiveBrands();
        
        $filterArray = [
            'page' => $_GET['page'] ?? 1,
            'per_page' => 12
        ];

        // Parse Path-based filters
        if ($filters) {
            $segments = explode('/', $filters);
            foreach ($segments as $segment) {
                $parts = explode(':', $segment);
                if (count($parts) === 2) {
                    $key = $parts[0];
                    $value = str_replace('+', ',', $parts[1]);
                    
                    if ($key === 'category') $filterArray['category'] = $value;
                    else if ($key === 'brand') $filterArray['brand'] = $value;
                    else if ($key === 'max_price') $filterArray['price_max'] = $value;
                    else if ($key === 'sort') $filterArray['sort'] = $value;
                    else if ($key === 'page') $filterArray['page'] = (int)$value;
                    else if ($key === 'per_page') $filterArray['per_page'] = (int)$value;
                }
            }
        }

        $result = $productModel->getFiltered($filterArray);
        
        $sidebarData = $collectionModel->getSidebarData(null, $allCollections);
        $sections = \App\Helpers\UIHelper::getSections('collection_page');
        
        $this->view('front/collection', [
            'pageTitle' => 'Shop All Products | The Perfect Vape',
            'sections' => $sections,
            'products' => $result['data'],
            'pagination' => $result,
            'collection' => null,
            'allCollections' => $allCollections,
            'allBrands' => $allBrands,
            'sidebarData' => $sidebarData
        ]);
    }


    public function show($url, $filters = null) {
        $collectionModel = $this->model('Collection');
        $productModel = $this->model('Product');
        $brandModel = $this->model('Brand');

        $collection = $collectionModel->findByCustomPath($url);
        
        if (!$collection) {
            $this->redirect('/collection');
        }
        
        $allCollections = $collectionModel->getAllWithParent();
        $allBrands = $brandModel->getActiveBrands();
        
        // Prepare initial filter array
        $filterArray = [
            'cat' => [$collection['id']],
            'page' => $_GET['page'] ?? 1,
            'per_page' => 12
        ];

        // Parse Path-based filters if present (category:slug1+slug2/brand:slug3)
        if ($filters) {
            $segments = explode('/', $filters);
            foreach ($segments as $segment) {
                $parts = explode(':', $segment);
                if (count($parts) === 2) {
                    $key = $parts[0];
                    $value = str_replace('+', ',', $parts[1]); // Product model handles comma separated strings
                    
                    if ($key === 'category') $filterArray['category'] = $value;
                    else if ($key === 'brand') $filterArray['brand'] = $value;
                    else if ($key === 'max_price') $filterArray['price_max'] = $value;
                    else if ($key === 'sort') $filterArray['sort'] = $value;
                    else if ($key === 'page') $filterArray['page'] = (int)$value;
                    else if ($key === 'per_page') $filterArray['per_page'] = (int)$value;
                }
            }
        }
        
        // Use getFiltered to include child category products recursively
        $result = $productModel->getFiltered($filterArray);
        
        $sidebarData = $collectionModel->getSidebarData($collection, $allCollections);
        $sections = \App\Helpers\UIHelper::getSections('collection', $collection['id']);
        
        $this->view('front/collection', [
            'pageTitle' => ($collection['meta_title'] ?: $collection['name']) . ' | The Perfect Vape',
            'metaDescription' => $collection['meta_desc'],
            'collection' => $collection,
            'sections' => $sections,
            'products' => $result['data'],
            'pagination' => $result,
            'allCollections' => $allCollections,
            'allBrands' => $allBrands,
            'sidebarData' => $sidebarData
        ]);
    }



    public function apiSearch() {
        header('Content-Type: application/json');
        
        $filters = [
            'cat' => $_GET['cat'] ?? null,
            'brand' => $_GET['brand'] ?? null,
            'price_min' => $_GET['min_price'] ?? null,
            'price_max' => $_GET['max_price'] ?? null,
            'sort' => $_GET['sort'] ?? 'newest',
            'page' => $_GET['page'] ?? 1,
            'per_page' => $_GET['per_page'] ?? 12
        ];

        $productModel = $this->model('Product');
        $result = $productModel->getFiltered($filters);

        // Render HTML for each product card to avoid JS template complexity
        $html = '';
        if (empty($result['data'])) {
            $html = '<div class="no-products" style="grid-column: 1/-1; text-align: center; padding: 40px; color: #666;">No products found matching your filters.</div>';
        } else {
            foreach ($result['data'] as $product) {
                $html .= \App\Helpers\ProductHelper::renderCard($product);
            }
        }

        echo json_encode([
            'status' => 'success',
            'html' => $html,
            'pagination' => [
                'total' => $result['total'],
                'per_page' => $result['per_page'],
                'current_page' => $result['current_page'],
                'last_page' => $result['last_page']
            ]
        ]);
        exit;
    }
}
