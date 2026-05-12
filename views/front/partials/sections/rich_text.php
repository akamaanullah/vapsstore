<?php if (!empty($section['items'])): ?>
<div class="rich-text-section">
    <?php if (!empty($section['title'])): ?>
        <h2 class="section-title"><?= htmlspecialchars($section['title']) ?></h2>
    <?php endif; ?>
    <div class="rich-text-content">
        <?php foreach ($section['items'] as $item): ?>
            <div class="rich-text-item">
                <?php if (!empty($item['title'])): ?>
                    <h3><?= htmlspecialchars($item['title']) ?></h3>
                <?php endif; ?>
                <?php if (!empty($item['content'])): ?>
                    <div class="content-body">
                        <?= $item['content'] ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($item['button_text']) && !empty($item['button_url'])): ?>
                    <a href="<?= htmlspecialchars($item['button_url']) ?>" class="btn btn-dark"><?= htmlspecialchars($item['button_text']) ?></a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
