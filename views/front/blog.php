<?php require VIEW_DIR . '/front/partials/header.php'; ?>

<main class="blog-listing-page">
    <section class="policy-hero">
        <div class="container">
            <nav class="breadcrumb">
                <a href="index.php">Home</a> / <span>Blog</span>
            </nav>
            <h1 class="page-title">Vape Insights & News</h1>
            <p class="page-subtitle">Discover the latest trends, guides, and reviews in the vaping world.</p>
        </div>
    </section>

    <div class="blog-content-layout container">
        <!-- Left Section: Blog Cards -->
        <div class="blog-main-content">
            <div class="blog-grid listing-grid" id="blogGrid">
                <!-- Blog 1 -->
                <article class="blog-card" data-category="guides">
                    <div class="blog-img-wrapper">
                        <img src="<?= BASE_URL ?>/assets/product/product-1.jpg" alt="Vape Guide" loading="lazy">
                        <span class="blog-category">Guides & Tips</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">April 20, 2026</span>
                        <h3 class="blog-title">How to Choose the Perfect Mod for Your Style</h3>
                        <p class="blog-excerpt">Finding the right device can be overwhelming. We break down the top features to look for this season...</p>
                        <a href="blog-detail.php" class="read-more">Read More</a>
                    </div>
                </article>
                
                <!-- Blog 2 -->
                <article class="blog-card" data-category="news">
                    <div class="blog-img-wrapper">
                        <img src="<?= BASE_URL ?>/assets/product/product-2.jpg" alt="E-Liquid Trends" loading="lazy">
                        <span class="blog-category">Industry News</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">April 18, 2026</span>
                        <h3 class="blog-title">Top 5 Fruit Flavours Trending Right Now</h3>
                        <p class="blog-excerpt">From icy mango to sweet strawberry, discover the blends that our community is raving about...</p>
                        <a href="blog-detail.php" class="read-more">Read More</a>
                    </div>
                </article>
                
                <!-- Blog 3 -->
                <article class="blog-card" data-category="reviews">
                    <div class="blog-img-wrapper">
                        <img src="<?= BASE_URL ?>/assets/product/product-3.jpg" alt="Vape Maintenance" loading="lazy">
                        <span class="blog-category">Vape Reviews</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">April 15, 2026</span>
                        <h3 class="blog-title">Coil Care: How to Make Your Coils Last Longer</h3>
                        <p class="blog-excerpt">Tired of burnt hits? Follow our essential maintenance tips to extend the life of your hardware...</p>
                        <a href="blog-detail.php" class="read-more">Read More</a>
                    </div>
                </article>

                <!-- Blog 4 -->
                <article class="blog-card" data-category="arrivals">
                    <div class="blog-img-wrapper">
                        <img src="<?= BASE_URL ?>/assets/product/product-4.jpg" alt="New Arrival Pods" loading="lazy">
                        <span class="blog-category">New Arrivals</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">April 10, 2026</span>
                        <h3 class="blog-title">First Look: The New Caliburn Explorer</h3>
                        <p class="blog-excerpt">The highly anticipated dual-flavor pod system has arrived. Here is our hands-on first impression...</p>
                        <a href="blog-detail.php" class="read-more">Read More</a>
                    </div>
                </article>
                
                <!-- Blog 5 -->
                <article class="blog-card" data-category="guides">
                    <div class="blog-img-wrapper">
                        <img src="<?= BASE_URL ?>/assets/product/product-5.jpg" alt="Battery Safety" loading="lazy">
                        <span class="blog-category">Guides & Tips</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">April 5, 2026</span>
                        <h3 class="blog-title">Vape Battery Safety 101</h3>
                        <p class="blog-excerpt">Crucial safety tips every vaper needs to know about handling and charging external batteries properly...</p>
                        <a href="blog-detail.php" class="read-more">Read More</a>
                    </div>
                </article>

                <!-- Blog 6 -->
                <article class="blog-card" data-category="reviews">
                    <div class="blog-img-wrapper">
                        <img src="<?= BASE_URL ?>/assets/product/product-6.jpg" alt="Disposable vs Pod" loading="lazy">
                        <span class="blog-category">Vape Reviews</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">April 1, 2026</span>
                        <h3 class="blog-title">Disposables vs. Pod Systems: Ultimate Showdown</h3>
                        <p class="blog-excerpt">Which is better for your wallet and the environment? We break down the pros and cons of both options...</p>
                        <a href="blog-detail.php" class="read-more">Read More</a>
                    </div>
                </article>

                <!-- Blog 7 -->
                <article class="blog-card" data-category="guides">
                    <div class="blog-img-wrapper">
                        <img src="<?= BASE_URL ?>/assets/product/product-7.jpg" alt="Vape Guide" loading="lazy">
                        <span class="blog-category">Guides & Tips</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">March 28, 2026</span>
                        <h3 class="blog-title">How to Switch to Pod Kits Smoothly</h3>
                        <p class="blog-excerpt">Making the transition from smoking to vaping? Here is a step-by-step guide to choosing your first pod kit...</p>
                        <a href="blog-detail.php" class="read-more">Read More</a>
                    </div>
                </article>
                
                <!-- Blog 8 -->
                <article class="blog-card" data-category="news">
                    <div class="blog-img-wrapper">
                        <img src="<?= BASE_URL ?>/assets/product/product-8.jpg" alt="Vape News" loading="lazy">
                        <span class="blog-category">Industry News</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">March 25, 2026</span>
                        <h3 class="blog-title">Vape Regulations in 2026: What You Need to Know</h3>
                        <p class="blog-excerpt">Stay updated with the latest industry regulations and how they might affect your access to vaping products...</p>
                        <a href="blog-detail.php" class="read-more">Read More</a>
                    </div>
                </article>

                <!-- Blog 9 -->
                <article class="blog-card" data-category="reviews">
                    <div class="blog-img-wrapper">
                        <img src="<?= BASE_URL ?>/assets/product/product-9.jpg" alt="E-Liquid Review" loading="lazy">
                        <span class="blog-category">Vape Reviews</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">March 20, 2026</span>
                        <h3 class="blog-title">Top 10 Nic Salt E-Liquids of the Year</h3>
                        <p class="blog-excerpt">We tested over 50 different nicotine salt liquids to bring you the definitive list of the best flavors available...</p>
                        <a href="blog-detail.php" class="read-more">Read More</a>
                    </div>
                </article>

                <!-- Blog 10 -->
                <article class="blog-card" data-category="news">
                    <div class="blog-img-wrapper">
                        <img src="<?= BASE_URL ?>/assets/product/product-10.jpg" alt="Vape Expo" loading="lazy">
                        <span class="blog-category">Industry News</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">March 15, 2026</span>
                        <h3 class="blog-title">Highlights from the Global Vape Expo 2026</h3>
                        <p class="blog-excerpt">Our team attended the biggest vape convention of the year. Here is a look at the innovative devices coming soon...</p>
                        <a href="blog-detail.php" class="read-more">Read More</a>
                    </div>
                </article>
                
                <!-- Blog 11 -->
                <article class="blog-card" data-category="arrivals">
                    <div class="blog-img-wrapper">
                        <img src="<?= BASE_URL ?>/assets/product/product-1.jpg" alt="New Mods" loading="lazy">
                        <span class="blog-category">New Arrivals</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">March 10, 2026</span>
                        <h3 class="blog-title">Unboxing the Latest High-Power Box Mods</h3>
                        <p class="blog-excerpt">Take a first look at the newest 200W+ devices hitting our shelves, featuring advanced chipsets and sleek designs...</p>
                        <a href="blog-detail.php" class="read-more">Read More</a>
                    </div>
                </article>

                <!-- Blog 12 -->
                <article class="blog-card" data-category="guides">
                    <div class="blog-img-wrapper">
                        <img src="<?= BASE_URL ?>/assets/product/product-2.jpg" alt="Vaping Etiquette" loading="lazy">
                        <span class="blog-category">Guides & Tips</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">March 5, 2026</span>
                        <h3 class="blog-title">The Unspoken Rules of Vaping in Public</h3>
                        <p class="blog-excerpt">A quick guide on how to enjoy your vape responsibly without bothering those around you...</p>
                        <a href="blog-detail.php" class="read-more">Read More</a>
                    </div>
                </article>
            </div>
            
            <!-- Pagination -->
            <div class="pagination-wrapper" id="blogPagination">
                <button class="page-btn" disabled>PREV</button>
                <button class="page-num active">1</button>
                <button class="page-num">2</button>
                <button class="page-btn">NEXT</button>
            </div>
            
            <!-- Empty State -->
            <div id="blogEmptyState" style="display: none; text-align: center; padding: 50px 0;">
                <i data-lucide="search-X" style="width: 48px; height: 48px; color: #ccc; margin-bottom: 15px;"></i>
                <h3 style="font-size: 20px;">No posts found</h3>
                <p style="color: #888;">Try adjusting your search or category filters.</p>
            </div>
        </div>

        <!-- Right Section: Sidebar Filters -->
        <aside class="blog-sidebar">
            <div class="sidebar-widget">
                <h3 class="widget-title">Search Blog</h3>
                <div class="search-box">
                    <input type="text" id="blogSearchInput" placeholder="Search blogs...">
                    <button type="button"><i data-lucide="search"></i></button>
                </div>
            </div>

            <div class="sidebar-widget">
                <h3 class="widget-title">Categories</h3>
                <ul class="category-list" id="blogCategoryList">
                    <li class="active"><a href="#" data-filter="all">All Posts <span>12</span></a></li>
                    <li><a href="#" data-filter="arrivals">New Arrivals <span>2</span></a></li>
                    <li><a href="#" data-filter="guides">Guides & Tips <span>4</span></a></li>
                    <li><a href="#" data-filter="reviews">Vape Reviews <span>3</span></a></li>
                    <li><a href="#" data-filter="news">Industry News <span>3</span></a></li>
                </ul>
            </div>
        </aside>
    </div>
</main>

<script src="<?= BASE_URL ?>/js/blog.js"></script>

<?php require VIEW_DIR . '/front/partials/footer.php'; ?>
