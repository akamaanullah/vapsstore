<?php
/**
 * What We Offer Section
 * @var array $section The section data
 */
if (empty($section['items'])) return;

$sectionTitle = !empty($section['title']) ? $section['title'] : 'WHAT WE OFFER';
// Add <br> after the second word for the split look if it's the default title
if ($sectionTitle === 'WHAT WE OFFER') {
    $sectionTitle = 'WHAT WE<br>OFFER';
}
?>
<section class="offer-section">
    <div class="offer-container">
        <div class="offer-header">
            <h2><?= $sectionTitle ?></h2>
            <p><?= htmlspecialchars($section['content'] ?? 'Comprehensive vaping services and premium product selections tailored to bring your ultimate vision to life. From curated kits to expert support, we handle every detail.') ?></p>
        </div>
        <div class="offer-grid">
            <?php foreach ($section['items'] as $item): 
                // Clean icon name (remove 'lucide-' prefix if present)
                $icon = str_replace('lucide-', '', $item['image_url'] ?: 'box');
            ?>
            <div class="offer-card">
                <div class="offer-icon">
                    <i data-lucide="<?= htmlspecialchars($icon) ?>"></i>
                </div>
                <h3><?= htmlspecialchars($item['title'] ?? '') ?></h3>
                <p><?= htmlspecialchars($item['content'] ?? '') ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
