<?php
$pageTitle = "Home | The Perfect Vape Premium Store";
require VIEW_DIR . '/front/partials/header.php';
?>

<main id="main-content">

    <!-- Hero Slider -->
    <?php 
    if (isset($sections['hero_slider'])) {
        $section = $sections['hero_slider'];
        include VIEW_DIR . '/front/partials/sections/hero_slider.php';
    }
    ?>

    <!-- Categories Grid -->
    <section class="categories-section">
        <div class="container">
            <div class="categories-grid">
                <div class="category-card-v2">
                    <img src="<?= BASE_URL ?>/assets/image/1.jpg" alt="Accessories" loading="lazy">
                    <h4>Accessories</h4>
                    <p>Browse the best brands <br>and flavours</p>
                </div>
                <div class="category-card-v2">
                    <img src="<?= BASE_URL ?>/assets/image/2.jpg" alt="Shop Coils" loading="lazy">
                    <h4>Shop Coils</h4>
                    <p>Browse the best brands <br>and flavours</p>
                </div>
                <div class="category-card-v2">
                    <img src="<?= BASE_URL ?>/assets/image/3.jpg" alt="Shop E-Liquids" loading="lazy">
                    <h4>Shop E-Liquids</h4>
                    <p>Browse the best brands <br>and flavours</p>
                </div>
                <div class="category-card-v2">
                    <img src="<?= BASE_URL ?>/assets/image/4.jpg" alt="Shop Tanks" loading="lazy">
                    <h4>Shop Tanks</h4>
                    <p>Browse the best brands <br>and flavours</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Promo Banners Section -->
    <?php 
    if (isset($sections['promo_grid'])) {
        $section = $sections['promo_grid'];
        include VIEW_DIR . '/front/partials/sections/promo_grid.php';
    }
    ?>

    <!-- Feature Highlight Section -->
    <?php 
    if (isset($sections['feature_highlight'])) {
        $section = $sections['feature_highlight'];
        include VIEW_DIR . '/front/partials/sections/feature_highlight.php';
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
    <section class="blog-section">
        <div class="container">
            <div class="section-header">
                <h2>Latest Vaping Insights</h2>
                <a href="<?= BASE_URL ?>/blog" class="view-all">Explore All Blogs</a>
            </div>
            <div class="blog-grid">
                <!-- Blog 1 -->
                <article class="blog-card">
                    <div class="blog-img-wrapper">
                        <img src="<?= BASE_URL ?>/assets/product/product-1.jpg" alt="Vape Guide" loading="lazy">
                        <span class="blog-category">Guides</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">April 20, 2026</span>
                        <h3 class="blog-title">How to Choose the Perfect Mod for Your Style</h3>
                        <p class="blog-excerpt">Finding the right device can be overwhelming. We break down the top
                            features to look for this season...</p>
                        <a href="<?= BASE_URL ?>/blog" class="read-more">Read More</a>
                    </div>
                </article>
                <!-- Blog 2 -->
                <article class="blog-card">
                    <div class="blog-img-wrapper">
                        <img src="<?= BASE_URL ?>/assets/product/product-2.jpg" alt="E-Liquid Trends" loading="lazy">
                        <span class="blog-category">Trends</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">April 18, 2026</span>
                        <h3 class="blog-title">Top 5 Fruit Flavours That Are Trending Right Now</h3>
                        <p class="blog-excerpt">From icy mango to sweet strawberry, discover the blends that our
                            community is raving about...</p>
                        <a href="<?= BASE_URL ?>/blog" class="read-more">Read More</a>
                    </div>
                </article>
                <!-- Blog 3 -->
                <article class="blog-card">
                    <div class="blog-img-wrapper">
                        <img src="<?= BASE_URL ?>/assets/product/product-3.jpg" alt="Vape Maintenance" loading="lazy">
                        <span class="blog-category">Maintenance</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">April 15, 2026</span>
                        <h3 class="blog-title">Coil Care: How to Make Your Coils Last Longer</h3>
                        <p class="blog-excerpt">Tired of burnt hits? Follow our essential maintenance tips to extend the
                            life of your hardware...</p>
                        <a href="<?= BASE_URL ?>/blog" class="read-more">Read More</a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-header-center">
                <h2>Frequently Asked Questions</h2>
            </div>
            <div class="faq-container-single">
                <!-- FAQ Item 1 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What is the minimum age to purchase?</h3>
                        <div class="faq-toggle"></div>
                    </div>
                    <div class="faq-answer">
                        <p>You must be at least 18 years old to purchase any vaping products from our store. We perform
                            age verification on all orders to ensure compliance with local laws.</p>
                    </div>
                </div>
                <!-- FAQ Item 2 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How do I track my order?</h3>
                        <div class="faq-toggle"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Once your order is shipped, you will receive an email with a tracking number and a link to
                            the courier's website to monitor your delivery progress.</p>
                    </div>
                </div>
                <!-- FAQ Item 6 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How often should I change my coil?</h3>
                        <div class="faq-toggle"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Generally, a coil lasts between 1-2 weeks depending on how frequently you vape and the type
                            of e-liquid you use (sweet liquids tend to burn coils faster).</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Brands Showcase Section -->
    <section class="brands-section">
        <div class="container">
            <div class="swiper brands-swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide brand-item">
                        <img src="<?= BASE_URL ?>/assets/image/slideshow-1.png" alt="Brand 1">
                    </div>
                    <div class="swiper-slide brand-item">
                        <img src="<?= BASE_URL ?>/assets/image/slideshow-2.png" alt="Brand 2">
                    </div>
                    <div class="swiper-slide brand-item">
                        <img src="<?= BASE_URL ?>/assets/image/slideshow-3.png" alt="Brand 3">
                    </div>
                    <div class="swiper-slide brand-item">
                        <img src="<?= BASE_URL ?>/assets/image/slideshow-4.png" alt="Brand 4">
                    </div>
                    <div class="swiper-slide brand-item">
                        <img src="<?= BASE_URL ?>/assets/image/slideshow-5.png" alt="Brand 5">
                    </div>
                    <div class="swiper-slide brand-item">
                        <img src="<?= BASE_URL ?>/assets/image/slideshow-6.png" alt="Brand 6">
                    </div>
                </div>
            </div>
        </div>
    </section>

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
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header-center">
                <h2>What Our Customers Say</h2>
            </div>
            <div class="swiper testimonials-swiper">
                <div class="swiper-wrapper">
                    <!-- Testimonial 1 -->
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="quote-icon"><i data-lucide="quote"></i></div>
                            <p class="testimonial-text">"The quality of the e-liquids here is unmatched. I've tried many
                                stores, but the flavor profiles and smooth delivery from The Perfect Vape are on another
                                level."</p>
                            <div class="testimonial-author">
                                <img src="<?= BASE_URL ?>/assets/image/testimonial-1.jpg" alt="James Wilson">
                                <div class="author-info">
                                    <h4>James Wilson</h4>
                                    <div class="stars">
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 2 -->
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="quote-icon"><i data-lucide="quote"></i></div>
                            <p class="testimonial-text">"Fast shipping and incredible customer support. They helped me
                                pick the right coil for my device and it's been working perfectly ever since. Highly
                                recommend!"</p>
                            <div class="testimonial-author">
                                <img src="<?= BASE_URL ?>/assets/image/testimonial-2.jpg" alt="Sarah Jenkins">
                                <div class="author-info">
                                    <h4>Sarah Jenkins</h4>
                                    <div class="stars">
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 3 -->
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="quote-icon"><i data-lucide="quote"></i></div>
                            <p class="testimonial-text">"As a wholesale partner, I couldn't be happier. The consistent
                                quality and professional communication make them the best supplier in the industry."</p>
                            <div class="testimonial-author">
                                <img src="<?= BASE_URL ?>/assets/image/testimonial-3.jpg" alt="Michael Chen">
                                <div class="author-info">
                                    <h4>Michael Chen</h4>
                                    <div class="stars">
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 4 -->
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="quote-icon"><i data-lucide="quote"></i></div>
                            <p class="testimonial-text">"The flavor variety is mind-blowing. I particularly love the ice
                                range, it's so refreshing and stays consistent until the last drop."</p>
                            <div class="testimonial-author">
                                <img src="<?= BASE_URL ?>/assets/image/testimonial-4.jpg" alt="Emily Davis">
                                <div class="author-info">
                                    <h4>Emily Davis</h4>
                                    <div class="stars">
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 5 -->
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="quote-icon"><i data-lucide="quote"></i></div>
                            <p class="testimonial-text">"Finally found a shop that stocks everything I need. From pods
                                to high-end mods, their inventory is always up to date with the latest tech."</p>
                            <div class="testimonial-author">
                                <img src="<?= BASE_URL ?>/assets/image/testimonial-5.jpg" alt="Robert Taylor">
                                <div class="author-info">
                                    <h4>Robert Taylor</h4>
                                    <div class="stars">
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                        <i data-lucide="star" class="fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slider Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

</main>

<?php require VIEW_DIR . '/front/partials/footer.php'; ?>