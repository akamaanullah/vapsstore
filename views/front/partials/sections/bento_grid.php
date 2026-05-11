<?php
/**
 * Bento Grid Section (Redesigned Masonry)
 * @var array $section The section data
 */
if (empty($section['items'])) return;
?>
<section class="bento-section" style="padding: 0 40px; margin: 80px 0;">
    <div class="bento-grid">
        <?php foreach ($section['items'] as $index => $item): 
            $spanClass = '';
            if ($index === 0) $spanClass = 'span-2-2';
            elseif ($index === 6) $spanClass = 'span-2-1';
            
            $image = $item['image_url'];
            if (!empty($image) && strpos($image, 'http') !== 0 && strpos($image, 'assets/') !== 0) {
                $image = BASE_URL . '/' . $image;
            }
            $url = $item['button_url'] ?: '#';
        ?>
        <div class="bento-item <?= $spanClass ?>" onclick="window.location.href='<?= $url ?>'">
            <img src="<?= $image ?>" alt="<?= htmlspecialchars($item['title'] ?? '') ?>" loading="lazy">
            <div class="bento-overlay"></div>
            <div class="bento-content">
                <?php if (!empty($item['button_text'])): ?>
                    <span class="bento-label"><?= htmlspecialchars($item['button_text']) ?></span>
                <?php endif; ?>
                <h3 class="bento-title"><?= htmlspecialchars($item['title'] ?? '') ?></h3>
                <?php if (!empty($item['content'])): ?>
                    <p class="bento-desc"><?= htmlspecialchars($item['content']) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
