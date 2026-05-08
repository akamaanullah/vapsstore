<?php
/**
 * Hero Slider Section Component
 * @var array $section The section data from database
 */
if (empty($section['items'])) return;
?>
<div class="swiper hero-swiper">
    <div class="swiper-wrapper">
        <?php foreach ($section['items'] as $slide): ?>
        <div class="swiper-slide hero-slide">
            <div class="hero-slide-bg" style="background-image: url('<?= $slide['image_url'] ?>');"></div>
            <div class="container">
                <div class="hero-content">
                    <?php if (!empty($section['title'])): ?>
                        <span class="hero-subtitle"><?= htmlspecialchars($section['title']) ?></span>
                    <?php endif; ?>
                    <h1><?= htmlspecialchars($slide['title']) ?></h1>
                    <p><?= htmlspecialchars($slide['content']) ?></p>
                    <div class="hero-btns">
                        <a href="<?= !empty($slide['button_url']) ? $slide['button_url'] : BASE_URL . '/collection' ?>" class="btn btn-primary">
                            <?= !empty($slide['button_text']) ? htmlspecialchars($slide['button_text']) : 'Shop Now' ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <!-- Slider Controls -->
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>
