<?php require VIEW_DIR . '/front/partials/header.php'; 

// Helper for blog images
function getBlogImageUrl($url) {
    if (empty($url)) return BASE_URL . '/assets/product/product-1.jpg';
    if (strpos($url, 'http') === 0) return $url;
    return BASE_URL . '/' . $url;
}
?>

<main class="blog-listing-page">
    <section class="policy-hero">
        <div class="container">
            <nav class="breadcrumb">
                <a href="<?= BASE_URL ?>">Home</a> / <span>Blog</span>
            </nav>
            <h1 class="page-title">Vape Insights & News</h1>
            <p class="page-subtitle">Discover the latest trends, guides, and reviews in the vaping world.</p>
        </div>
    </section>

    <div class="blog-content-layout container">
        <!-- Left Section: Blog Cards -->
        <div class="blog-main-content">
            <div class="blog-grid listing-grid" id="blogGrid">
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <article class="blog-card" data-category="<?= htmlspecialchars($post['category_slug'] ?? '') ?>">
                            <div class="blog-img-wrapper">
                                <a href="<?= BASE_URL ?>/blog/<?= htmlspecialchars($post['custom_url_path']) ?>">
                                    <img src="<?= getBlogImageUrl($post['featured_image_url']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" loading="lazy">
                                </a>
                                <?php if (!empty($post['category_name'])): ?>
                                    <span class="blog-category"><?= htmlspecialchars($post['category_name']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="blog-info">
                                <?php if (!empty($post['published_at'])): ?>
                                    <span class="blog-date"><?= date('F d, Y', strtotime($post['published_at'])) ?></span>
                                <?php endif; ?>
                                <h3 class="blog-title">
                                    <a href="<?= BASE_URL ?>/blog/<?= htmlspecialchars($post['custom_url_path']) ?>">
                                        <?= htmlspecialchars($post['title']) ?>
                                    </a>
                                </h3>
                                <?php if (!empty($post['excerpt'])): ?>
                                    <p class="blog-excerpt"><?= htmlspecialchars(substr($post['excerpt'], 0, 150)) ?>...</p>
                                <?php endif; ?>
                                <a href="<?= BASE_URL ?>/blog/<?= htmlspecialchars($post['custom_url_path']) ?>" class="read-more">Read More</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div id="blogEmptyState" style="text-align: center; padding: 50px 0; grid-column: 1/-1;">
                        <i data-lucide="notebook-pen" style="width: 48px; height: 48px; color: #ccc; margin-bottom: 15px;"></i>
                        <h3 style="font-size: 20px;">No blog posts yet</h3>
                        <p style="color: #888;">Check back soon for the latest vaping insights and news.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Section: Sidebar -->
        <aside class="blog-sidebar">
            <div class="sidebar-widget">
                <h3 class="widget-title">Search Blog</h3>
                <div class="search-box">
                    <input type="text" id="blogSearchInput" placeholder="Search blogs...">
                    <button type="button"><i data-lucide="search"></i></button>
                </div>
            </div>

            <?php if (!empty($categories)): ?>
            <div class="sidebar-widget">
                <h3 class="widget-title">Categories</h3>
                <ul class="category-list" id="blogCategoryList">
                    <li class="active"><a href="#" data-filter="all">All Posts <span><?= count($posts) ?></span></a></li>
                    <?php foreach ($categories as $cat): ?>
                        <li><a href="#" data-filter="<?= htmlspecialchars($cat['slug']) ?>"><?= htmlspecialchars($cat['name']) ?> <span><?= $cat['post_count'] ?></span></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </aside>
    </div>
</main>

<script src="<?= BASE_URL ?>/js/blog.js"></script>

<?php require VIEW_DIR . '/front/partials/footer.php'; ?>
