<?php require VIEW_DIR . '/front/partials/header.php'; 

// Helper for blog images
function getBlogImageUrl($url) {
    if (empty($url)) return BASE_URL . '/assets/product/product-1.jpg';
    if (strpos($url, 'http') === 0) return $url;
    return BASE_URL . '/' . $url;
}
?>

<main class="blog-detail-page">
    <!-- Blog Hero Section -->
    <section class="blog-hero">
        <div class="container">
            <nav class="breadcrumb">
                <a href="<?= BASE_URL ?>">Home</a> / <a href="<?= BASE_URL ?>/blog">Blog</a> / <span><?= htmlspecialchars($post['title']) ?></span>
            </nav>
            
            <div class="blog-meta-top">
                <?php if (!empty($post['category_name'])): ?>
                    <span class="blog-category"><?= htmlspecialchars($post['category_name']) ?></span>
                <?php endif; ?>
                <?php if (!empty($post['published_at'])): ?>
                    <span class="blog-date"><?= date('F d, Y', strtotime($post['published_at'])) ?></span>
                <?php endif; ?>
            </div>
            
            <h1 class="blog-main-title"><?= htmlspecialchars($post['title']) ?></h1>
        </div>
    </section>

    <?php if (!empty($post['featured_image_url'])): ?>
    <div class="blog-featured-img-container">
        <div class="container">
            <img src="<?= getBlogImageUrl($post['featured_image_url']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="blog-featured-img">
        </div>
    </div>
    <?php endif; ?>

    <!-- Blog Content & Sidebar Grid -->
    <div class="blog-content-layout container">
        <div class="blog-main-content">
            <div class="content-body">
                <!-- Excerpt is removed from detail page as it's usually just a summary for the list view -->
                
                <!-- If the content was in a body column, it would go here. 
                     Since the schema only had 'excerpt', we'll use that as the primary text for now.
                     In a real app, you'd have a 'content' or 'body' column. -->
                <!-- Main Blog Content Column -->
                <div class="main-content">
                    <?php if (!empty($sections)): ?>
                        <?php foreach ($sections as $section): ?>
                            <?php
                                $sectionType = $section['type'] ?? 'rich_text';
                                $partialPath = VIEW_DIR . '/front/partials/sections/' . $sectionType . '.php';
                                
                                if (file_exists($partialPath)) {
                                    include $partialPath;
                                    echo '<div class="clearfix"></div>'; // Ensure sections don't bleed into each other
                                } else {
                                    // Generic section rendering
                                    if (!empty($section['items'])):
                            ?>
                                <section class="blog-content-section">
                                    <?php if (!empty($section['title'])): ?>
                                        <h3><?= htmlspecialchars($section['title']) ?></h3>
                                    <?php endif; ?>
                                    <?php foreach ($section['items'] as $item): ?>
                                        <div class="content-block">
                                            <?php if ($sectionType === 'product_embed' && !empty($item['entity_id'])): ?>
                                                <!-- Special handling for product embeds if partial not found -->
                                                <div class="product-embed-placeholder">
                                                    <a href="<?= BASE_URL ?>/product/<?= $item['entity_id'] ?>">View Product #<?= $item['entity_id'] ?></a>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($item['image_url'])): ?>
                                                <img src="<?= BASE_URL ?>/<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['title'] ?? '') ?>" class="content-inline-img">
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($item['title'])): ?>
                                                <h4><?= htmlspecialchars($item['title']) ?></h4>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($item['content'])): ?>
                                                <div class="content-text"><?= $item['content'] ?></div>
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
                        <?= $post['content'] ?? '<p>No content available for this post.</p>' ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="blog-sidebar">
            <div class="sidebar-widget">
                <h3 class="widget-title">Search Blog</h3>
                <form action="<?= BASE_URL ?>/blog" method="GET" class="search-box">
                    <input type="text" name="search" placeholder="Search...">
                    <button type="submit"><i data-lucide="search"></i></button>
                </form>
            </div>

            <?php if (!empty($categories)): ?>
            <div class="sidebar-widget">
                <h3 class="widget-title">Popular Categories</h3>
                <ul class="category-list">
                    <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="<?= BASE_URL ?>/blog?category=<?= htmlspecialchars($cat['slug']) ?>">
                                <?= htmlspecialchars($cat['name']) ?> <span><?= $cat['post_count'] ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <?php if (!empty($recentPosts)): ?>
            <div class="sidebar-widget">
                <h3 class="widget-title">Recent Posts</h3>
                <div class="recent-posts">
                    <?php foreach ($recentPosts as $recent): ?>
                    <div class="recent-post-item">
                        <img src="<?= getBlogImageUrl($recent['featured_image_url']) ?>" alt="<?= htmlspecialchars($recent['title']) ?>">
                        <div class="post-info">
                            <a href="<?= BASE_URL ?>/blog/<?= htmlspecialchars($recent['custom_url_path']) ?>"><?= htmlspecialchars($recent['title']) ?></a>
                            <span><?= date('M d, Y', strtotime($recent['published_at'])) ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </aside>
    </div>

    <!-- Related Articles -->
    <?php if (!empty($relatedPosts)): ?>
    <section class="blog-section">
        <div class="container">
            <div class="section-header">
                <h2>Related Articles</h2>
                <a href="<?= BASE_URL ?>/blog" class="view-all">Explore All Blogs</a>
            </div>
            <div class="blog-grid">
                <?php foreach ($relatedPosts as $rel): ?>
                <article class="blog-card">
                    <div class="blog-img-wrapper">
                        <a href="<?= BASE_URL ?>/blog/<?= htmlspecialchars($rel['custom_url_path']) ?>">
                            <img src="<?= getBlogImageUrl($rel['featured_image_url']) ?>" alt="<?= htmlspecialchars($rel['title']) ?>" loading="lazy">
                        </a>
                        <?php if (!empty($rel['category_name'])): ?>
                            <span class="blog-category"><?= htmlspecialchars($rel['category_name']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date"><?= date('F d, Y', strtotime($rel['published_at'])) ?></span>
                        <h3 class="blog-title">
                            <a href="<?= BASE_URL ?>/blog/<?= htmlspecialchars($rel['custom_url_path']) ?>">
                                <?= htmlspecialchars($rel['title']) ?>
                            </a>
                        </h3>
                        <p class="blog-excerpt"><?= htmlspecialchars(substr($rel['excerpt'] ?? '', 0, 100)) ?>...</p>
                        <a href="<?= BASE_URL ?>/blog/<?= htmlspecialchars($rel['custom_url_path']) ?>" class="read-more">Read More</a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php require VIEW_DIR . '/front/partials/footer.php'; ?>
