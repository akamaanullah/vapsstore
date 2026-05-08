<?php
/**
 * Promo Grid Section Component
 * @var array $section The section data from database
 */
if (empty($section['items'])) return;
?>
<section class="promo-section">
    <div class="container">
        <div class="promo-grid">
            <?php 
            $bannerColors = ['banner-blue', 'banner-purple'];
            foreach ($section['items'] as $index => $banner):
                $colorClass = $bannerColors[$index % 2];
            ?>
            <div class="promo-banner <?= $colorClass ?>" style="background-image: url('<?= $banner['image_url'] ?>');">
                <div class="promo-content">
                    <h2><?= htmlspecialchars($banner['title']) ?></h2>
                    <p><?= htmlspecialchars($banner['content']) ?></p>
                    <a href="<?= !empty($banner['button_url']) ? $banner['button_url'] : BASE_URL . '/collection' ?>" class="promo-btn">
                        <?= !empty($banner['button_text']) ? htmlspecialchars($banner['button_text']) : 'Shop Now' ?>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
