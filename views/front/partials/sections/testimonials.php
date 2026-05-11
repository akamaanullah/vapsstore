<?php
/**
 * Testimonials Partial
 * @var array $section The section data
 */
if (empty($section['items'])) return;
?>
<section class="testimonials-section">
    <div class="container">
        <div class="section-header-center">
            <h2><?= htmlspecialchars($section['title'] ?? 'What Our Customers Say') ?></h2>
        </div>
        <div class="swiper testimonials-swiper">
            <div class="swiper-wrapper">
                <?php foreach ($section['items'] as $item): 
                    $image = $item['image_url'];
                    if (!empty($image) && strpos($image, 'http') !== 0 && strpos($image, 'assets/') !== 0) {
                        $image = BASE_URL . '/public/' . $image;
                    } elseif (empty($image)) {
                        $image = BASE_URL . '/assets/image/testimonial-default.jpg';
                    }
                    
                    // Button text is used as Rating/Stars
                    $starsCount = (int)$item['button_text'] ?: 5;
                ?>
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="quote-icon"><i data-lucide="quote"></i></div>
                            <p class="testimonial-text">"<?= htmlspecialchars($item['content']) ?>"</p>
                            <div class="testimonial-author">
                                <img src="<?= $image ?>" alt="<?= htmlspecialchars($item['title'] ?? 'Customer') ?>">
                                <div class="author-info">
                                    <h4><?= htmlspecialchars($item['title'] ?? 'Happy Customer') ?></h4>
                                    <div class="stars">
                                        <?php for ($i = 0; $i < 5; $i++): ?>
                                            <i data-lucide="star" class="<?= $i < $starsCount ? 'fill' : '' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
