<?php
/**
 * Feature Highlight Section Component
 * @var array $section The section data from database
 */
if (empty($section['items'])) return;
$item = $section['items'][0];
$paragraphs = explode("\n\n", $item['content']);
?>
<section class="feature-highlight">
    <div class="container">
        <div class="feature-grid">
            <div class="feature-content">
                <span class="feature-badge"><?= !empty($section['title']) ? htmlspecialchars($section['title']) : 'Elite Selection' ?></span>
                <h2><?= str_replace("\n", "<br>", htmlspecialchars($item['title'])) ?></h2>
                
                <?php if (isset($paragraphs[0])): ?>
                    <p><?= htmlspecialchars(trim($paragraphs[0])) ?></p>
                <?php endif; ?>
                
                <?php if (isset($paragraphs[1])): ?>
                    <p class="feature-extra-text"><?= htmlspecialchars(trim($paragraphs[1])) ?></p>
                <?php endif; ?>

                <div class="feature-btns">
                    <a href="<?= !empty($item['button_url']) ? $item['button_url'] : BASE_URL . '/collection' ?>" class="btn btn-primary">
                        <?= !empty($item['button_text']) ? htmlspecialchars($item['button_text']) : 'Discover More' ?>
                    </a>
                </div>
            </div>
            <div class="feature-visual">
                <div class="visual-wrapper">
                    <img src="<?= $item['image_url'] ?>" alt="<?= htmlspecialchars($item['title']) ?>" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>
