<?php
$pageTitle = "Home | The Perfect Vape Premium Store";
require VIEW_DIR . '/front/partials/header.php';
?>

<main id="main-content">

    <!-- Hero Slider -->
    <?php 
    if (isset($sections['hero_slider'])) {
        foreach ($sections['hero_slider'] as $section) {
            include VIEW_DIR . '/front/partials/sections/hero_slider.php';
        }
    }
    ?>

    <!-- Categories Grid -->
    <?php 
    if (isset($sections['categories_grid'])) {
        foreach ($sections['categories_grid'] as $section) {
            include VIEW_DIR . '/front/partials/sections/categories_grid.php';
        }
    }
    ?>

    <!-- Promo Banners Section -->
    <?php 
    if (isset($sections['promo_grid'])) {
        foreach ($sections['promo_grid'] as $section) {
            include VIEW_DIR . '/front/partials/sections/promo_grid.php';
        }
    }
    ?>

    <!-- Feature Highlight Section -->
    <?php 
    if (isset($sections['feature_highlight'])) {
        foreach ($sections['feature_highlight'] as $section) {
            include VIEW_DIR . '/front/partials/sections/feature_highlight.php';
        }
    }
    ?>

    <!-- Top Selling Flavours Section (Static for now) -->
    <section class="flavours-section">
        <div class="container">
            <div class="section-header-center">
                <h2>Top Selling Flavours</h2>
                <p>Explore our top selling delicious E-Liquid flavours here!</p>
            </div>
            <div class="flavours-container">
                <!-- Flavour 1 -->
                <div class="flavour-item">
                    <div class="flavour-circle">
                        <img src="<?= BASE_URL ?>/assets/product/product-1.jpg" class="flavour-img" alt="Blueberry">
                    </div>
                    <h4>Blueberry</h4>
                </div>
                <!-- Flavour 2 -->
                <div class="flavour-item">
                    <div class="flavour-circle">
                        <img src="<?= BASE_URL ?>/assets/product/product-2.jpg" class="flavour-img" alt="Grape">
                    </div>
                    <h4>Grape</h4>
                </div>
                <!-- Flavour 3 -->
                <div class="flavour-item">
                    <div class="flavour-circle">
                        <img src="<?= BASE_URL ?>/assets/product/product-3.jpg" class="flavour-img" alt="Menthol">
                    </div>
                    <h4>Menthol</h4>
                </div>
                <!-- Flavour 4 -->
                <div class="flavour-item">
                    <div class="flavour-circle">
                        <img src="<?= BASE_URL ?>/assets/product/product-4.jpg" class="flavour-img" alt="Raspberry">
                    </div>
                    <h4>Raspberry</h4>
                </div>
                <!-- Flavour 5 -->
                <div class="flavour-item">
                    <div class="flavour-circle">
                        <img src="<?= BASE_URL ?>/assets/product/product-5.jpg" class="flavour-img" alt="Strawberry">
                    </div>
                    <h4>Strawberry</h4>
                </div>
                <!-- Flavour 6 -->
                <div class="flavour-item">
                    <div class="flavour-circle">
                        <img src="<?= BASE_URL ?>/assets/product/product-6.jpg" class="flavour-img" alt="Tobacco">
                    </div>
                    <h4>Tobacco</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products / Collection Grids (First Section) -->
    <?php 
    if (isset($sections['collection_grid'])) {
        $gridSections = is_array($sections['collection_grid']) && isset($sections['collection_grid'][0]) 
            ? $sections['collection_grid'] 
            : [$sections['collection_grid']];
            
        // Render first collection
        if (isset($gridSections[0])) {
            $section = $gridSections[0];
            include VIEW_DIR . '/front/partials/sections/collection_grid.php';
        }
    }
    ?>

    <!-- Flavour Banner Section -->
    <section class="flavour-banner-section">
        <div class="flavour-banner-bg" style="background-image: url('<?= BASE_URL ?>/assets/image/cta.jpg');">
            <div class="flavour-banner-content">
                <h2>Find Your E-Liquid Flavour</h2>
                <a href="<?= BASE_URL ?>/collection" class="btn-banner-shop">Shop Now</a>
            </div>
        </div>
    </section>

    <!-- Remaining Collection Grids -->
    <?php 
    if (isset($gridSections) && count($gridSections) > 1) {
        for ($i = 1; $i < count($gridSections); $i++) {
            $section = $gridSections[$i];
            include VIEW_DIR . '/front/partials/sections/collection_grid.php';
        }
    }
    ?>
    <!-- Brand Story Section -->
    <?php 
    if (isset($sections['brand_story'])) {
        $storySections = is_array($sections['brand_story']) && isset($sections['brand_story'][0]) 
            ? $sections['brand_story'] 
            : [$sections['brand_story']];
            
        foreach ($storySections as $section) {
            include VIEW_DIR . '/front/partials/sections/brand_story.php';
        }
    }
    ?>

    <!-- Blog Section -->
    <?php if (!empty($latestPosts)): ?>
    <section class="blog-section">
        <div class="container">
            <div class="section-header">
                <h2>Latest Vaping Insights</h2>
                <a href="<?= BASE_URL ?>/blog" class="view-all">Explore All Blogs</a>
            </div>
            <div class="blog-grid">
                <?php foreach ($latestPosts as $post): ?>
                <article class="blog-card">
                    <div class="blog-img-wrapper">
                        <a href="<?= BASE_URL ?>/blog/<?= htmlspecialchars($post['custom_url_path']) ?>">
                            <img src="<?= !empty($post['featured_image_url']) ? BASE_URL . '/' . htmlspecialchars($post['featured_image_url']) : BASE_URL . '/assets/product/product-1.jpg' ?>" alt="<?= htmlspecialchars($post['title']) ?>" loading="lazy">
                        </a>
                        <?php if (!empty($post['category_name'])): ?>
                            <span class="blog-category"><?= htmlspecialchars($post['category_name']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date"><?= date('F d, Y', strtotime($post['published_at'])) ?></span>
                        <h3 class="blog-title">
                            <a href="<?= BASE_URL ?>/blog/<?= htmlspecialchars($post['custom_url_path']) ?>">
                                <?= htmlspecialchars($post['title']) ?>
                            </a>
                        </h3>
                        <p class="blog-excerpt"><?= htmlspecialchars(substr($post['excerpt'] ?? '', 0, 100)) ?>...</p>
                        <a href="<?= BASE_URL ?>/blog/<?= htmlspecialchars($post['custom_url_path']) ?>" class="read-more">Read More</a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- FAQ Section -->
    <?php 
    if (isset($sections['faq'])) {
        foreach ($sections['faq'] as $section) {
            include VIEW_DIR . '/front/partials/sections/faq.php';
        }
    }
    ?>

    <!-- Brands Showcase Section -->
    <?php 
    if (isset($sections['brands_swiper'])) {
        foreach ($sections['brands_swiper'] as $section) {
            include VIEW_DIR . '/front/partials/sections/brands_swiper.php';
        }
    }
    ?>

    <!-- New Starter CTA Section -->
    <section class="starter-cta-section">
        <div class="container">
            <div class="starter-container">
                <!-- Floating Pod Left -->
                <div class="floating-pod pod-left">
                    <img src="<?= BASE_URL ?>/assets/image/cta-1.png" alt="Vape Pod Left" id="podLeftImg">
                </div>

                <div class="starter-content">
                    <span class="starter-badge">Get Started</span>
                    <h2>Are you ready to vape with us?</h2>
                    <p>Experience the next level of satisfaction with our premium starter kits. Crafted for performance,
                        styled for you.</p>
                    <div class="starter-actions">
                        <a href="<?= BASE_URL ?>/collection" class="btn btn-starter-solid">Get Started</a>
                        <a href="<?= BASE_URL ?>/contact-us" class="btn btn-starter-outline"><i data-lucide="play"></i> About Us</a>
                    </div>
                </div>

                <!-- Floating Pod Right -->
                <div class="floating-pod pod-right">
                    <img src="<?= BASE_URL ?>/assets/image/cta-2.png" alt="Vape Pod Right" id="podRightImg">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <?php 
    if (isset($sections['testimonials'])) {
        foreach ($sections['testimonials'] as $section) {
            include VIEW_DIR . '/front/partials/sections/testimonials.php';
        }
    }
    ?>

</main>

<?php require VIEW_DIR . '/front/partials/footer.php'; ?>