<?php
namespace App\Controllers\Front;

use App\Core\Controller;

class ProductController extends Controller {
    public function show($slug = null, $filters = null) {
        $productModel = $this->model('Product');
        $collectionModel = $this->model('Collection');
        
        // Find product by slug
        $db = \App\Core\Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id FROM products WHERE custom_url = ? AND status = 'published' LIMIT 1");
        $stmt->execute([$slug]);
        $prod = $stmt->fetch();

        if (!$prod) {
            $this->redirect('/');
        }

        $product = $productModel->getProductForEdit($prod['id']);
        
        // Get related products (same collection)
        $relatedProducts = [];
        if (!empty($product['collection_ids'])) {
            $relatedProducts = $productModel->getFiltered([
                'cat' => [$product['collection_ids'][0]],
                'exclude' => [$product['id']],
                'per_page' => 4
            ])['data'];
        }

        // Get reviews
        $reviews = $productModel->getReviews($prod['id']);
        $avgRating = 0;
        if (count($reviews) > 0) {
            $avgRating = array_sum(array_column($reviews, 'rating')) / count($reviews);
        }
        
        $this->view('front/product-detail', [
            'pageTitle' => ($product['seo_title'] ?: $product['name']) . ' | The Perfect Vape',
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'reviews' => $reviews,
            'avgRating' => round($avgRating, 1)
        ]);
    }

    public function submitReview() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $data = $_POST;
        $data['rating'] = (int)($data['rating'] ?? 5);

        $productModel = $this->model('Product');
        $success = $productModel->saveReview($data);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Thank you! Your review has been submitted for approval.' : 'Failed to save review.'
        ]);
    }

}
