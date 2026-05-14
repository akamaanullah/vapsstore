<?php
namespace App\Controllers\Front;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Product;

class CartController extends Controller {

    public function index() {
        $this->jsonResponse($this->getCartData());
    }

    public function add() {
        $this->validateCsrf();
        
        $productId = (int)($_POST['product_id'] ?? 0);
        $variantId = (int)($_POST['variant_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);

        if ($productId <= 0 || $quantity <= 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid product or quantity.'], 400);
        }

        if ($quantity > 99) {
            $this->jsonResponse(['success' => false, 'message' => 'Maximum quantity per item is 99.'], 400);
        }

        $cart = Session::get('cart') ?: [];
        if (count($cart) >= 50 && !isset($cart[$productId . '-' . $variantId])) {
            $this->jsonResponse(['success' => false, 'message' => 'Your cart is full (max 50 unique items).'], 400);
        }

        $productModel = $this->model('Product');
        
        // If variantId is not provided, find the best available variant
        if ($variantId <= 0) {
            $db = \App\Core\Database::getInstance()->getConnection();
            
            // 1. Try default variant that is in stock
            $stmt = $db->prepare("SELECT id FROM product_variants WHERE product_id = ? AND is_default = 1 AND stock_quantity >= ? LIMIT 1");
            $stmt->execute([$productId, $quantity]);
            $v = $stmt->fetch();
            
            if (!$v) {
                // 2. Try ANY variant that is in stock
                $stmt = $db->prepare("SELECT id FROM product_variants WHERE product_id = ? AND stock_quantity >= ? ORDER BY is_default DESC, id ASC LIMIT 1");
                $stmt->execute([$productId, $quantity]);
                $v = $stmt->fetch();
            }

            if ($v) {
                $variantId = $v['id'];
            } else {
                // 3. Absolute fallback to default or first (will fail stock check below if totally out)
                $stmt = $db->prepare("SELECT id FROM product_variants WHERE product_id = ? ORDER BY is_default DESC, id ASC LIMIT 1");
                $stmt->execute([$productId]);
                $v = $stmt->fetch();
                if ($v) $variantId = $v['id'];
            }
        }

        if ($variantId <= 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Product variant not found.'], 404);
        }

        $variant = $productModel->getVariant($variantId);

        if (!$variant || $variant['product_status'] !== 'published') {
            $this->jsonResponse(['success' => false, 'message' => 'Product not available.'], 404);
        }

        // Stock Check
        if ($variant['stock_quantity'] < $quantity) {
            $this->jsonResponse(['success' => false, 'message' => 'Requested quantity not available in stock.'], 400);
        }

        // Initialize cart in session if not exists
        $cart = Session::get('cart') ?: [];
        $cartKey = $productId . '-' . $variantId;

        if (isset($cart[$cartKey])) {
            // Check total stock if updating
            if ($variant['stock_quantity'] < ($cart[$cartKey]['quantity'] + $quantity)) {
                $this->jsonResponse(['success' => false, 'message' => 'Cannot add more. Stock limit reached.'], 400);
            }
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $productId,
                'variant_id' => $variantId,
                'name' => $variant['product_name'],
                'variant_name' => $variant['variant_name'],
                'price' => (float)$variant['price'],
                'image' => $variant['featured_image'] ? BASE_URL . '/' . $variant['featured_image'] : BASE_URL . '/assets/image/placeholder.jpg',
                'url' => $variant['custom_url'],
                'quantity' => $quantity
            ];
        }

        Session::set('cart', $cart);
        $this->jsonResponse(['success' => true, 'message' => 'Added to cart.', 'cart' => $this->getCartData()]);
    }

    public function update() {
        $this->validateCsrf();
        
        $cartKey = $_POST['cart_key'] ?? '';
        $quantity = (int)($_POST['quantity'] ?? 0);

        if (empty($cartKey) || $quantity <= 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request.'], 400);
        }

        if ($quantity > 99) {
            $this->jsonResponse(['success' => false, 'message' => 'Maximum quantity per item is 99.'], 400);
        }

        $cart = Session::get('cart') ?: [];

        if (!isset($cart[$cartKey])) {
            $this->jsonResponse(['success' => false, 'message' => 'Item not found in cart.'], 404);
        }

        $productModel = $this->model('Product');
        $variant = $productModel->getVariant($cart[$cartKey]['variant_id']);

        if ($variant['stock_quantity'] < $quantity) {
            $this->jsonResponse(['success' => false, 'message' => 'Requested quantity not available.'], 400);
        }

        $cart[$cartKey]['quantity'] = $quantity;
        Session::set('cart', $cart);

        $this->jsonResponse(['success' => true, 'cart' => $this->getCartData()]);
    }

    public function remove() {
        $this->validateCsrf();
        
        $cartKey = $_POST['cart_key'] ?? '';
        $cart = Session::get('cart') ?: [];

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            Session::set('cart', $cart);
        }

        $this->jsonResponse(['success' => true, 'cart' => $this->getCartData()]);
    }

    public function clear() {
        $this->validateCsrf();
        Session::set('cart', []);
        $this->jsonResponse(['success' => true, 'cart' => $this->getCartData()]);
    }

    private function getCartData() {
        $cart = Session::get('cart') ?: [];
        $subtotal = 0;
        $count = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $count += $item['quantity'];
        }

        return [
            'items' => array_values($cart), // Return as indexed array for JS
            'subtotal' => $subtotal,
            'count' => $count,
            'formatted_subtotal' => '£' . number_format($subtotal, 2)
        ];
    }
}
