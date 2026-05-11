<?php
/**
 * Brands Showcase Partial
 * @var array $section The section data
 */
if (empty($section['items'])) return;
?>
<section class="brands-section">
    <div class="container">
        <?php if (!empty($section['title'])): ?>
            <div class="section-header-center">
                <h2><?= htmlspecialchars($section['title']) ?></h2>
            </div>
        <?php endif; ?>
        <div class="swiper brands-swiper">
            <div class="swiper-wrapper">
                <?php foreach ($section['items'] as $item): 
                    $image = $item['image_url'];
                    if (!empty($image) && strpos($image, 'http') !== 0 && strpos($image, 'assets/') !== 0) {
                        $image = BASE_URL . '/public/' . $image;
                    } elseif (empty($image)) {
                        $image = 'https://placehold.co/200x100?text=Brand';
                    }
                ?>
                    <div class="swiper-slide brand-item">
                        <?php if (!empty($item['button_url'])): ?>
                            <a href="<?= $item['button_url'] ?>">
                        <?php endif; ?>
                        <img src="<?= $image ?>" alt="<?= htmlspecialchars($item['title'] ?? 'Brand') ?>">
                        <?php if (!empty($item['button_url'])): ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
