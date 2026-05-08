<?php
namespace App\Helpers;

class ProductHelper {
    /**
     * Render a standard product card HTML
     * @param array $product The product data
     * @return string HTML content
     */
    public static function renderCard($product) {
        $name = htmlspecialchars($product['name'] ?? 'Product');
        $id = $product['id'] ?? 0;
        $customUrl = $product['custom_url'] ?? $id;
        $url = BASE_URL . '/product/' . $customUrl;
        
        $rawPrice = $product['current_price'] ?? ($product['base_price'] ?? 0);
        $price = '£' . number_get_formatted($rawPrice);
        
        $featuredImage = $product['featured_image'] ?? '';
        if (!empty($featuredImage)) {
            if (strpos($featuredImage, 'http') === 0) {
                $image = $featuredImage;
            } elseif (strpos($featuredImage, 'uploads/') === 0) {
                $image = BASE_URL . '/' . $featuredImage;
            } else {
                $image = BASE_URL . '/public/' . $featuredImage;
            }
        } else {
            $image = 'https://placehold.co/600x600?text=No+Image';
        }
        
        // Check for old price (just a mock for now or fetch from variants)
        $oldPrice = ''; 
        if (!empty($product['old_price'])) {
            $oldPrice = '<span class="old-price">£' . number_get_formatted($product['old_price']) . '</span>';
        }

        ob_start();
        ?>
        <div class="product-card" data-id="<?= $product['id'] ?>">
            <div class="product-img-wrapper">
                <img src="<?= $image ?>" alt="<?= $name ?>" loading="lazy">
                <div class="product-actions">
                    <button class="action-btn" title="Add to Wishlist"><i data-lucide="heart"></i></button>
                    <a href="<?= $url ?>" class="action-btn" title="Quick View"><i data-lucide="eye"></i></a>
                </div>
            </div>
            <div class="product-info">
                <h3 class="product-name"><a href="<?= $url ?>"><?= $name ?></a></h3>
                <div class="product-price-container">
                    <?= $oldPrice ?>
                    <span class="current-price"><?= $price ?></span>
                </div>
                <button class="btn-buy">Add to Cart</button>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

/**
 * Simple helper for number formatting if not defined globally
 */
if (!function_exists('number_get_formatted')) {
    function number_get_formatted($number) {
        return number_format((float)$number, 2, '.', ',');
    }
}
