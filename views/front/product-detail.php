<?php 
require VIEW_DIR . '/front/partials/header.php'; 
use App\Helpers\ProductHelper;

$name = htmlspecialchars($product['name']);
$basePrice = $product['base_price'];
$comparePrice = $product['compare_price'] ?? 0;
$tags = $product['tags'] ?? '';

// Badge Logic
$isNew = false;
if (!empty($product['created_at'])) {
    $createdAt = strtotime($product['created_at']);
    $thirtyDaysAgo = strtotime('-30 days');
    if ($createdAt >= $thirtyDaysAgo) $isNew = true;
}
if (!$isNew && !empty($tags) && stripos($tags, 'new') !== false) $isNew = true;

// Image Logic
$images = $product['images'] ?? [];
$mainImage = !empty($images) ? $images[0]['image_url'] : 'https://placehold.co/600x600?text=No+Image';

// Helper for image URLs
function getImageUrl($url) {
    if (empty($url)) return 'https://placehold.co/600x600?text=No+Image';
    if (strpos($url, 'http') === 0) return $url;
    if (strpos($url, 'uploads/') === 0) return BASE_URL . '/' . $url;
    return BASE_URL . '/public/' . $url;
}
?>

<main class="product-detail-page" data-product-id="<?= $product['id'] ?>">
    <div class="container">
        <!-- Breadcrumbs -->
        <nav class="breadcrumb">
            <a href="<?= BASE_URL ?>">Home</a> / 
            <span><?= $name ?></span>
        </nav>

        <div class="product-main-area">
            <!-- Left Side: Images -->
            <div class="product-gallery-side">
                <div class="main-image-container">
                    <?php if ($comparePrice > 0): ?>
                        <span class="detail-badge sale">Sale</span>
                    <?php elseif ($isNew): ?>
                        <span class="detail-badge new">New</span>
                    <?php endif; ?>
                    <img src="<?= getImageUrl($mainImage) ?>" id="mainProductImage" alt="<?= $name ?>">
                </div>

                <?php if (count($images) > 1): ?>
                <div class="swiper product-thumb-slider">
                    <div class="swiper-wrapper">
                        <?php foreach ($images as $index => $img): ?>
                        <div class="swiper-slide thumb-item <?= $index === 0 ? 'active' : '' ?>">
                            <img src="<?= getImageUrl($img['image_url']) ?>" alt="Thumb <?= $index + 1 ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="thumb-next"><i data-lucide="chevron-right"></i></div>
                    <div class="thumb-prev"><i data-lucide="chevron-left"></i></div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Right Side: Product Details -->
            <div class="product-info-side">
                <h1 class="product-title"><?= $name ?></h1>

                <?php if (!empty($reviews)): ?>
                <div class="product-rating-summary">
                    <div class="stars">
                        <?php for($i=1; $i<=5; $i++): ?>
                            <i data-lucide="star" class="<?= $i <= round($avgRating) ? 'fill' : '' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="review-count">(<?= count($reviews) ?> <?= count($reviews) === 1 ? 'Review' : 'Reviews' ?>)</span>
                </div>
                <?php endif; ?>

                <div class="price-area">
                    <span class="detail-current-price" id="displayPrice">£<?= number_format($basePrice, 2) ?></span>
                    <span id="comparePriceContainer" style="<?= $comparePrice > 0 ? 'display: inline-flex; align-items: center; gap: 10px;' : 'display: none;' ?>">
                        <span class="detail-old-price" id="displayComparePrice">£<?= number_format($comparePrice, 2) ?></span>
                        <span class="sale-percentage" id="displaySalePercentage">
                            Save <?= $comparePrice > 0 ? round((($comparePrice - $basePrice) / $comparePrice) * 100) : 0 ?>%
                        </span>
                    </span>
                </div>

                <a href="#" class="shipping-policy-link">
                    <i data-lucide="truck"></i> Shipping Policy
                </a>

                <div class="product-selection">
                    <?php if (!empty($product['options']) && count($product['variants']) > 1): ?>
                        <?php foreach ($product['options'] as $index => $option): ?>
                            <div class="selection-group">
                                <label><?= htmlspecialchars($option['name']) ?></label>
                                <select class="custom-select variant-option-select" data-option-index="<?= $index ?>">
                                    <?php foreach ($option['values'] as $value): ?>
                                        <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($value) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endforeach; ?>
                        <!-- Hidden select for actual variant ID submission -->
                        <select id="variantSelect" style="display: none;">
                            <?php foreach ($product['variants'] as $v): ?>
                                <option value="<?= $v['id'] ?>" 
                                        data-name="<?= htmlspecialchars($v['variant_name']) ?>"
                                        data-price="<?= $v['price'] ?>" 
                                        data-compare-price="<?= $v['compare_price'] ?? 0 ?>"
                                        data-stock="<?= $v['stock_quantity'] ?>">
                                    <?= htmlspecialchars($v['variant_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>

                    <div class="product-actions-btns">
                        <div class="quantity-picker-wrapper">
                            <label>Quantity</label>
                            <div class="quantity-picker">
                                <button type="button" class="qty-btn minus" id="qtyMinus">-</button>
                                <input type="number" id="qtyInput" value="1" min="1" max="100" readonly>
                                <button type="button" class="qty-btn plus" id="qtyPlus">+</button>
                            </div>
                        </div>

                        <div class="purchase-buttons">
                            <button class="btn-add-to-cart" id="addToCartDetail">Add to cart</button>
                            <button class="btn-buy-now" id="buyNowDetail">Buy it now</button>
                            <button class="detail-wishlist-btn" title="Add to Wishlist" data-id="<?= $product['id'] ?>">
                                <i data-lucide="heart"></i>
                            </button>
                        </div>
                    </div>

                    <div class="short-description">
                        <h4 class="specs-title">Product Details</h4>
                        <div class="short-desc-content">
                            <?= $product['short_desc'] ?: 'Experience the premium quality with ' . $name . '.' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="product-long-description">
            <div class="description-tabs">
                <button class="tab-btn active" data-tab="tab-description">Description</button>
                <button class="tab-btn" data-tab="tab-reviews">Reviews (<?= count($reviews) ?>)</button>
            </div>

            <div class="tab-content-wrapper">
                <div class="tab-content active" id="tab-description">
                    <div class="long-desc-body">
                        <?= $product['long_desc'] ?: 'No detailed description available for this product.' ?>
                    </div>
                </div>

                <div class="tab-content" id="tab-reviews" style="display: none;">
                    <div class="reviews-header">
                        <?php if (!empty($reviews)): ?>
                            <div class="overall-rating">
                                <h2><?= $avgRating ?></h2>
                                <div class="stars">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <i data-lucide="star" class="<?= $i <= round($avgRating) ? 'fill' : '' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <p>Based on <?= count($reviews) ?> <?= count($reviews) === 1 ? 'Review' : 'Reviews' ?></p>
                            </div>
                        <?php else: ?>
                            <div class="overall-rating">
                                <p>No reviews yet. Be the first to review this product!</p>
                            </div>
                        <?php endif; ?>
                        <button class="btn-write-review">Write a Review</button>
                    </div>

                    <div id="reviewFormContainer" class="review-form-inline" style="display: none;">
                         <div class="form-wrapper">
                            <div class="form-header">
                                <h3>Write a review</h3>
                                <p>Share your experience with other customers</p>
                            </div>
                            <form id="submitReviewForm" class="review-form">
                                <?= $this->csrf_field() ?>
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <!-- Honeypot to prevent bot spam -->
                                <div style="display:none;">
                                    <input type="text" name="website_url" value="">
                                </div>
                                <div class="form-row">
                                    <div class="form-group flex-1">
                                        <label>Name</label>
                                        <input type="text" name="customer_name" placeholder="Enter your name" required>
                                    </div>
                                    <div class="form-group flex-1">
                                        <label>Rating</label>
                                        <div class="star-rating-input" id="starRating">
                                            <i data-lucide="star" data-value="1"></i>
                                            <i data-lucide="star" data-value="2"></i>
                                            <i data-lucide="star" data-value="3"></i>
                                            <i data-lucide="star" data-value="4"></i>
                                            <i data-lucide="star" data-value="5"></i>
                                        </div>
                                        <input type="hidden" name="rating" id="ratingInput" value="5" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Review Title</label>
                                    <input type="text" name="title" placeholder="Give your review a title">
                                </div>
                                <div class="form-group">
                                    <label>Review Content</label>
                                    <textarea name="comment" rows="4" placeholder="Write your comments here..." required></textarea>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn-submit-review btn-dark" style="padding: 15px 40px; text-transform: uppercase; font-weight: 700; border: none; cursor: pointer;">Submit Review</button>
                                </div>
                            </form>
                         </div>
                    </div>
                    
                    <?php if (!empty($reviews)): ?>
                    <div class="reviews-list mt-30">
                        <?php foreach($reviews as $review): ?>
                            <div class="review-item">
                                <div class="review-meta">
                                    <div class="review-user">
                                        <div class="user-initial"><?= strtoupper(substr($review['customer_name'] ?? 'V', 0, 1)) ?></div>
                                        <div>
                                            <h4 class="m-0"><?= htmlspecialchars($review['customer_name'] ?? 'Verified Buyer') ?></h4>
                                            <div class="review-rating">
                                                <?php for($i=1; $i<=5; $i++): ?>
                                                    <i data-lucide="star" class="<?= $i <= $review['rating'] ? 'fill' : '' ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="review-date"><?= date('M d, Y', strtotime($review['created_at'])) ?></span>
                                </div>
                                <h4 class="mt-15 mb-10 fs-16"><?= htmlspecialchars($review['title'] ?: 'Review') ?></h4>
                                <p class="review-text"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Dynamic UI Sections -->
        <?php if (!empty($sections)): ?>
            <div class="product-extra-sections">
                <?php foreach ($sections as $section): 
                    $sectionType = $section['type'];
                    $partialPath = VIEW_DIR . '/front/partials/sections/' . $sectionType . '.php';
                    
                    if (file_exists($partialPath)) {
                        include $partialPath;
                    } else {
                        // Fallback generic renderer
                        echo '<section class="generic-section">';
                        echo '<div class="container">';
                        if (!empty($section['title'])) echo '<h2>' . htmlspecialchars($section['title']) . '</h2>';
                        foreach ($section['items'] as $item) {
                            if (!empty($item['title'])) echo '<h3>' . htmlspecialchars($item['title']) . '</h3>';
                            if (!empty($item['content'])) echo '<div>' . $item['content'] . '</div>';
                        }
                        echo '</div>';
                        echo '</section>';
                    }
                endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Related Products -->
        <?php if (!empty($relatedProducts)): ?>
        <section class="product-section">
            <div class="section-header">
                <h2>You May Also Like</h2>
                <a href="<?= BASE_URL ?>/collection" class="view-all">View All</a>
            </div>
            <div class="product-grid">
                <?php foreach ($relatedProducts as $rp): ?>
                    <?= ProductHelper::renderCard($rp) ?>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // Pass PHP data to JS
    window.productData = <?= json_encode($product) ?>;
</script>
<script src="<?= BASE_URL ?>/js/product-detail.js"></script>

<?php require VIEW_DIR . '/front/partials/footer.php'; ?>