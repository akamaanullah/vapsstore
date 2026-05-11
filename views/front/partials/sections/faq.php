<?php
/**
 * FAQ Section Partial
 * @var array $section The section data
 */
if (empty($section['items'])) return;
?>
<section class="faq-section">
    <div class="container">
        <div class="section-header-center">
            <h2><?= htmlspecialchars($section['title'] ?? 'Frequently Asked Questions') ?></h2>
        </div>
        <div class="faq-container-single">
            <?php foreach ($section['items'] as $item): ?>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3><?= htmlspecialchars($item['title']) ?></h3>
                        <div class="faq-toggle"></div>
                    </div>
                    <div class="faq-answer">
                        <p><?= nl2br(htmlspecialchars($item['content'])) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
