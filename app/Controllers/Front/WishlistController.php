<?php
namespace App\Controllers\Front;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller {

    public function index() {
        $userId = Session::get('user_id');
        $wishlistModel = $this->model('Wishlist');
        $items = [];

        if ($userId) {
            $items = $wishlistModel->getByUser($userId);
        } else {
            // Guest logic: Fetch full data for items in session
            $sessionWishlist = Session::get('wishlist') ?: [];
            if (!empty($sessionWishlist)) {
                $productModel = $this->model('Product');
                foreach ($sessionWishlist as $productId) {
                    $item = $productModel->getWithDefaultVariant($productId);
                    if ($item) {
                        $items[] = [
                            'id' => $item['id'],
                            'name' => $item['name'],
                            'url' => $item['custom_url'],
                            'price' => (float)($item['price'] ?: $item['base_price']),
                            'stock' => ($item['total_stock'] ?? 0) > 0 ? 'In Stock' : 'Out of Stock',
                            'image' => $item['featured_image'] ? BASE_URL . '/' . $item['featured_image'] : BASE_URL . '/assets/image/placeholder.jpg'
                        ];
                    }
                }
            }
        }

        $this->view('front/wishlist', [
            'pageTitle' => 'Your Wishlist | The Perfect Vape',
            'items' => $items
        ]);
    }

    public function add() {
        $this->validateCsrf();
        $productId = (int)($_POST['product_id'] ?? 0);

        if ($productId <= 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid product.'], 400);
        }

        $userId = Session::get('user_id');
        $wishlistModel = $this->model('Wishlist');

        if ($userId) {
            $existing = $wishlistModel->getUserProductIds($userId);
            if (in_array($productId, $existing)) {
                $wishlistModel->remove($userId, $productId);
                $message = 'Removed from wishlist';
            } else {
                $wishlistModel->add($userId, $productId);
                $message = 'Added to wishlist';
            }
            $success = true;
            $count = count($wishlistModel->getUserProductIds($userId));
        } else {
            $wishlist = Session::get('wishlist') ?: [];
            if (!in_array($productId, $wishlist)) {
                $wishlist[] = $productId;
                Session::set('wishlist', $wishlist);
                $success = true;
                $message = 'Added to wishlist';
            } else {
                $wishlist = array_filter($wishlist, fn($id) => $id != $productId);
                Session::set('wishlist', array_values($wishlist));
                $success = true;
                $message = 'Removed from wishlist';
            }
            $count = count($wishlist);
        }

        $this->jsonResponse([
            'success' => true, 
            'message' => $message ?? 'Wishlist updated',
            'count' => $count
        ]);
    }

    public function remove() {
        $this->validateCsrf();
        $productId = (int)($_POST['product_id'] ?? 0);

        $userId = Session::get('user_id');
        $wishlistModel = $this->model('Wishlist');

        if ($userId) {
            $wishlistModel->remove($userId, $productId);
            $count = count($wishlistModel->getUserProductIds($userId));
        } else {
            $wishlist = Session::get('wishlist') ?: [];
            $wishlist = array_filter($wishlist, fn($id) => $id != $productId);
            Session::set('wishlist', array_values($wishlist));
            $count = count($wishlist);
        }

        $this->jsonResponse(['success' => true, 'count' => $count]);
    }

    public function clear() {
        $this->validateCsrf();
        $userId = Session::get('user_id');

        if ($userId) {
            $this->model('Wishlist')->clear($userId);
        } else {
            Session::set('wishlist', []);
        }

        $this->jsonResponse(['success' => true, 'count' => 0]);
    }
}
