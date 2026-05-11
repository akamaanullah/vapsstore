<?php
/**
 * Categories Grid Partial
 * @var array $section The section data
 */
if (empty($section['items'])) return;
?>
<section class="categories-section">
    <div class="container">
        <?php if (!empty($section['title'])): ?>
            <div class="section-header-center">
                <h2><?= htmlspecialchars($section['title']) ?></h2>
            </div>
        <?php endif; ?>
        <div class="categories-grid">
            <?php foreach ($section['items'] as $item): 
                $image = $item['image_url'];
                if (!empty($image) && strpos($image, 'http') !== 0 && strpos($image, 'assets/') !== 0) {
                    $image = BASE_URL . '/public/' . $image;
                } elseif (empty($image)) {
                    $image = 'https://placehold.co/400x400?text=Category';
                }
            ?>
                <div class="category-card-v2">
                    <a href="<?= $item['button_url'] ?? '#' ?>" style="text-decoration: none; color: inherit;">
                        <img src="<?= $image ?>" alt="<?= htmlspecialchars($item['title']) ?>" loading="lazy">
                        <h4><?= htmlspecialchars($item['title']) ?></h4>
                        <p><?= nl2br(htmlspecialchars($item['content'] ?? '')) ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
