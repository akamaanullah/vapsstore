<?php
/**
 * Smoke Section (Expandable Story)
 * @var array $section The section data
 */
if (empty($section['items'])) return;
$item = $section['items'][0];
$content = trim($item['content'] ?? '');

// Try splitting by double newline first, then single newline
$paragraphs = explode("\n\n", $content);
if (count($paragraphs) <= 1) {
    $paragraphs = explode("\n", $content);
}

// If it's still one big block, we could split by word count for a "Read More" effect
if (count($paragraphs) <= 1 && strlen($content) > 300) {
    $pos = strpos($content, ' ', 250); // Find first space after 250 chars
    if ($pos !== false) {
        $paragraphs = [
            substr($content, 0, $pos),
            substr($content, $pos)
        ];
    }
}
?>
<section class="smoke-section">
    <div class="smoke-overlay"></div>
    <div class="container">
        <div class="smoke-content">
            <h2><?= htmlspecialchars($item['title'] ?? 'Our Story') ?></h2>
            <div class="expandable-text-wrapper">
                <p class="expandable-text" id="storyText">
                    <?php if (count($paragraphs) > 1): ?>
                        <?= htmlspecialchars(trim($paragraphs[0])) ?>
                        <span class="hidden-text" id="moreText" style="display: none;">
                            <?= htmlspecialchars(trim(implode("\n\n", array_slice($paragraphs, 1)))) ?>
                        </span>
                    <?php else: ?>
                        <?= htmlspecialchars($content) ?>
                    <?php endif; ?>
                </p>
                <?php if (count($paragraphs) > 1): ?>
                    <button id="toggleStoryBtn" class="btn-show-more">Read More <i data-lucide="chevron-down"></i></button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
