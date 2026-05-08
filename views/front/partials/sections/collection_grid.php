<?php
/**
 * Collection Grid / Product Grid Component
 * @var array $section The section data
 */
use App\Models\Product;
use App\Helpers\ProductHelper;

if (empty($section['items'])) return;

// Extract product IDs
$productIds = array_filter(array_column($section['items'], 'entity_id'));

if (empty($productIds)) return;

// Fetch actual product data
$productModel = new Product();
$products = $productModel->getByIds($productIds);

if (empty($products)) return;
?>
<section class="product-section">
    <div class="container">
        <div class="section-header">
            <h2><?= htmlspecialchars($section['title']) ?></h2>
            <?php if (!empty($section['button_url'])): ?>
                <a href="<?= $section['button_url'] ?>" class="view-all"><?= !empty($section['button_text']) ? htmlspecialchars($section['button_text']) : 'View All' ?></a>
            <?php endif; ?>
        </div>
        
        <?php if (count($products) > 4): // Use slider if many products ?>
            <div class="swiper product-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($products as $product): ?>
                        <div class="swiper-slide">
                            <?= ProductHelper::renderCard($product) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        <?php else: // Use grid for few products ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <?= ProductHelper::renderCard($product) ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
