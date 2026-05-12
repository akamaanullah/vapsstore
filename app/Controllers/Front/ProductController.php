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
        
        // Get UI Sections
        $uiModel = $this->model('UISection');
        $sections = $uiModel->getSections('product', $prod['id']);
        
        $this->view('front/product-detail', [
            'pageTitle' => ($product['seo_title'] ?: $product['name']) . ' | The Perfect Vape',
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'reviews' => $reviews,
            'avgRating' => round($avgRating, 1),
            'sections' => $sections
        ]);
    }

    public function submitReview() {
        $this->validateCsrf();

        // Honeypot check (website_url should be empty)
        if (!empty($_POST['website_url'])) {
            // Silently fail for bots
            $this->jsonResponse(['success' => true, 'message' => 'Thank you! Your review has been submitted for approval.']);
        }

        // Input Validation
        $productId = (int)($_POST['product_id'] ?? 0);
        $rating = (int)($_POST['rating'] ?? 0);
        $customerName = trim($_POST['customer_name'] ?? '');
        $comment = trim($_POST['comment'] ?? '');

        if ($productId <= 0 || $rating < 1 || $rating > 5 || empty($customerName) || empty($comment)) {
            $this->jsonResponse(['success' => false, 'message' => 'Please provide all required fields correctly.'], 400);
        }

        if (strlen($customerName) > 255 || strlen($comment) > 2000) {
            $this->jsonResponse(['success' => false, 'message' => 'Input exceeds allowed character limits.'], 400);
        }

        $productModel = $this->model('Product');
        
        // Verify product exists and is published
        $product = $productModel->find($productId);
        if (!$product || $product['status'] !== 'published') {
            $this->jsonResponse(['success' => false, 'message' => 'Product not found.'], 404);
        }

        $success = $productModel->saveReview([
            'product_id' => $productId,
            'customer_name' => $customerName,
            'rating' => $rating,
            'title' => trim($_POST['title'] ?? ''),
            'comment' => $comment
        ]);

        $this->jsonResponse([
            'success' => $success,
            'message' => $success ? 'Thank you! Your review has been submitted for approval.' : 'Failed to save review.'
        ]);
    }

}
