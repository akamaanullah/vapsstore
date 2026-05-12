<?php 
require VIEW_DIR . '/front/partials/header.php'; 
$pageName = htmlspecialchars($page['title'] ?? 'Page');
?>

<main class="static-page">
    <section class="policy-hero">
        <div class="container">
            <nav class="breadcrumb">
                <a href="<?= BASE_URL ?>">Home</a> / <span><?= $pageName ?></span>
            </nav>
            <h1 class="page-title"><?= $pageName ?></h1>
        </div>
    </section>

    <div class="container page-content-wrapper">
        <?php if (!empty($sections)): ?>
            <?php foreach ($sections as $section): ?>
                <?php
                    $sectionType = $section['type'] ?? 'text_block';
                    $partialPath = VIEW_DIR . '/front/partials/sections/' . $sectionType . '.php';
                    
                    if (file_exists($partialPath)) {
                        include $partialPath;
                    } else {
                        // Fallback: render items as generic content blocks
                        if (!empty($section['items'])):
                ?>
                    <section class="page-section">
                        <?php if (!empty($section['title'])): ?>
                            <h2><?= htmlspecialchars($section['title']) ?></h2>
                        <?php endif; ?>
                        <?php foreach ($section['items'] as $item): ?>
                            <div class="page-content-block">
                                <?php if (!empty($item['image_url'])): ?>
                                    <img src="<?= BASE_URL ?>/<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['title'] ?? '') ?>" loading="lazy">
                                <?php endif; ?>
                                <?php if (!empty($item['title'])): ?>
                                    <h3><?= htmlspecialchars($item['title']) ?></h3>
                                <?php endif; ?>
                                <?php if (!empty($item['content'])): ?>
                                    <div class="content-body"><?= $item['content'] ?></div>
                                <?php endif; ?>
                                <?php if (!empty($item['button_text']) && !empty($item['button_url'])): ?>
                                    <a href="<?= htmlspecialchars($item['button_url']) ?>" class="btn btn-dark"><?= htmlspecialchars($item['button_text']) ?></a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </section>
                <?php 
                        endif;
                    }
                ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-page-state" style="text-align:center; padding: 80px 20px;">
                <i data-lucide="file-text" style="width: 64px; height: 64px; color: #ccc; margin-bottom: 20px;"></i>
                <h2>Page Content Coming Soon</h2>
                <p style="color: #888; margin-top: 10px;">This page is currently being built. Check back shortly!</p>
                <a href="<?= BASE_URL ?>/" class="btn btn-dark" style="margin-top: 25px; display: inline-block; padding: 14px 35px;">Return Home</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require VIEW_DIR . '/front/partials/footer.php'; ?>
