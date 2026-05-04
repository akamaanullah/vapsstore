<?php
$pageTitle = "Collections | The Perfect Vape";
require 'partials/header.php';
?>

<main class="collection-page">
    <div class="container">
        <!-- Collection Header / Breadcrumbs -->
        <nav class="breadcrumb">
            <a href="index.php">Home</a> / <span>All Products</span>
        </nav>

        <!-- Collection Header -->
        <header class="collection-header">
            <h1 class="collection-title">Premium Vape Collection</h1>
            <p class="collection-description">Explore our curated selection of high-end vaping devices, artisan
                e-liquids, and essential accessories. Whether you're a beginner or a cloud-chasing veteran, we have the
                perfect gear for your lifestyle.</p>
        </header>

        <div class="collection-layout">
            <!-- Left Sidebar (Filters) -->
            <aside class="collection-sidebar" id="collectionSidebar">
                <div class="sidebar-main-title">
                    <h2>Filter By</h2>
                    <button class="close-sidebar" id="closeFilters">&times;</button>
                </div>

                <!-- Categories Accordion -->
                <div class="filter-widget">
                    <h4 class="filter-title accordion-trigger">
                        <span>Categories</span>
                        <i data-lucide="chevron-down"></i>
                    </h4>
                    <div class="filter-content">
                        <ul class="category-accordion">
                            <li>
                                <div class="accordion-item">
                                    <span>Vape Kits</span>
                                    <i data-lucide="chevron-down"></i>
                                </div>
                                <ul class="sub-categories">
                                    <li><label><input type="checkbox" name="cat" value="starter"> Starter Kits</label>
                                    </li>
                                    <li><label><input type="checkbox" name="cat" value="pod"> Pod Systems</label></li>
                                    <li><label><input type="checkbox" name="cat" value="advanced"> Advanced Mods</label>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <div class="accordion-item">
                                    <span>E-Liquids</span>
                                    <i data-lucide="chevron-down"></i>
                                </div>
                                <ul class="sub-categories">
                                    <li><label><input type="checkbox" name="cat" value="nic-salts"> Nic Salts</label>
                                    </li>
                                    <li><label><input type="checkbox" name="cat" value="freebase"> Freebase</label></li>
                                </ul>
                            </li>
                            <li>
                                <div class="accordion-item">
                                    <span>Disposable Vapes</span>
                                    <i data-lucide="chevron-down"></i>
                                </div>
                                <ul class="sub-categories">
                                    <li><label><input type="checkbox" name="cat" value="600-puffs"> 600 Puffs</label>
                                    </li>
                                    <li><label><input type="checkbox" name="cat" value="10000-puffs"> 10000+
                                            Puffs</label></li>
                                    <li><label><input type="checkbox" name="cat" value="nic-free"> Nicotine Free</label>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Price Range Slider -->
                <div class="filter-widget">
                    <h4 class="filter-title accordion-trigger">
                        <span>Price Range</span>
                        <i data-lucide="chevron-down"></i>
                    </h4>
                    <div class="filter-content">
                        <div class="price-slider-wrapper">
                            <input type="range" id="priceRange" min="0" max="500" value="500" step="10">
                            <div class="price-labels">
                                <span>$0</span>
                                <span id="priceValue">$0 - $500</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Brands Filter -->
                <div class="filter-widget">
                    <h4 class="filter-title accordion-trigger">
                        <span>Brands</span>
                        <i data-lucide="chevron-down"></i>
                    </h4>
                    <div class="filter-content">
                        <ul class="brand-list">
                            <li><label><input type="checkbox" name="brand" value="SMOK"> SMOK</label></li>
                            <li><label><input type="checkbox" name="brand" value="Vaporesso"> Vaporesso</label></li>
                            <li><label><input type="checkbox" name="brand" value="Voopoo"> Voopoo</label></li>
                            <li><label><input type="checkbox" name="brand" value="GeekVape"> GeekVape</label></li>
                        </ul>
                    </div>
                </div>

                <button class="btn-clear-filters" id="clearFilters">Clear All Filters</button>
            </aside>

            <!-- Right Side (Product Listing) -->
            <div class="collection-main">
                <!-- Top Controls -->
                <div class="collection-controls">
                    <button class="btn-mobile-filter" id="openFilters">
                        <i data-lucide="filter"></i> Filters
                    </button>

                    <div class="control-group">
                        <label>Sort By:</label>
                        <select id="sortSelect" class="control-select">
                            <option value="default">Default</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="newest">Newest</option>
                        </select>
                    </div>

                    <div class="control-group">
                        <label>Show:</label>
                        <select id="perPageSelect" class="control-select">
                            <option value="12">12</option>
                            <option value="24">24</option>
                            <option value="36">36</option>
                        </select>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="product-grid" id="productGrid">
                    <!-- Products will be loaded here via collection.js -->
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper" id="pagination">
                    <!-- Pagination links will be loaded here -->
                </div>
            </div>
        </div>
    </div>



</main>

<!-- Brand Story Smoke Section -->
<section class="smoke-section">
    <div class="smoke-overlay"></div>
    <div class="container">
        <div class="smoke-content">
            <h2>Explore Our Premium Collections</h2>
            <div class="expandable-text-wrapper">
                <p class="expandable-text" id="storyText">
                    Welcome to the ultimate vaping destination. At The Perfect Vape, our collections are meticulously
                    curated to bring you industry-leading devices, mouth-watering e-liquids, and essential accessories.
                    Whether you are searching for your first starter kit or upgrading to a high-performance mod, our
                    extensive catalog is designed to deliver satisfaction.
                    <span class="hidden-text" id="moreText">
                        We partner with top global brands like Geek Bar, Hayati, and Gold Bar to ensure that every puff
                        you take is backed by quality and innovation. Our diverse range includes everything from
                        convenient disposable vapes and sleek pod systems to premium nicotine salts and robust sub-ohm
                        tanks. Dive into our collections today and experience unparalleled flavor profiles, massive
                        cloud production, and reliable performance tailored precisely to your vaping lifestyle.
                    </span>
                </p>
                <button id="toggleStoryBtn" class="btn-show-more">Read More <i data-lucide="chevron-down"></i></button>
            </div>
        </div>
    </div>
</section>

<!-- What We Offer Section -->
<section class="offer-section">
    <div class="offer-container">
        <div class="offer-header">
            <h2>What We Offer</h2>
            <p>Comprehensive vaping services and premium product selections tailored to bring your ultimate vision to
                life. From curated kits to expert support, we handle every detail.</p>
        </div>
        <div class="offer-grid">
            <!-- Card 1 -->
            <div class="offer-card">
                <div class="offer-icon">
                    <i data-lucide="box"></i>
                </div>
                <h3>Premium Selection</h3>
                <p>Fresh, creative concepts that transform ordinary vaping into extraordinary experiences with our
                    hand-picked hardware.</p>
            </div>
            <!-- Card 2 -->
            <div class="offer-card">
                <div class="offer-icon">
                    <i data-lucide="zap"></i>
                </div>
                <h3>Expert Guidance</h3>
                <p>Tailored solutions that reflect your unique style and personality, guided by our industry experts.
                </p>
            </div>
            <!-- Card 3 -->
            <div class="offer-card">
                <div class="offer-icon">
                    <i data-lucide="truck"></i>
                </div>
                <h3>Global Logistics</h3>
                <p>From checkout to your doorstep, we handle every detail of your delivery with precision and speed.</p>
            </div>
            <!-- Card 4 -->
            <div class="offer-card">
                <div class="offer-icon">
                    <i data-lucide="shield-check"></i>
                </div>
                <h3>Certified Quality</h3>
                <p>Exceptional craftsmanship and attention to detail in every product, backed by our 100% authenticity
                    guarantee.</p>
            </div>
        </div>
    </div>
</section>

<!-- Bento Grid Section (Masonry Redesign) -->
<section class="bento-section" style="margin-top: 80px; margin-bottom: 80px; padding: 0 40px;">
    <div class="bento-grid">
        <!-- Item 1 (Big - 2x2) -->
        <div class="bento-item span-2-2" onclick="window.location.href='#'">
            <img src="assets/product/product-1.jpg" alt="Vape Mods" loading="lazy">
            <div class="bento-overlay"></div>
            <div class="bento-content">
                <span class="bento-label">Advanced</span>
                <h3 class="bento-title">High-Power Box Mods</h3>
                <p class="bento-desc">Experience maximum cloud production and unrivaled battery life for all-day vaping.
                    Our premium selection of advanced high-power box mods is engineered to deliver peak performance.
                </p>
            </div>
        </div>

        <!-- Item 2 (1x1) -->
        <div class="bento-item" onclick="window.location.href='#'">
            <img src="assets/product/product-2.jpg" alt="E-Liquids" loading="lazy">
            <div class="bento-overlay"></div>
            <div class="bento-content">
                <span class="bento-label">Premium</span>
                <h3 class="bento-title">Nic Salts</h3>
                <p class="bento-desc">Expertly blended for a smooth throat hit and rapid nicotine satisfaction.</p>
            </div>
        </div>

        <!-- Item 3 (1x1) -->
        <div class="bento-item" onclick="window.location.href='#'">
            <img src="assets/product/product-3.jpg" alt="Pod Systems" loading="lazy">
            <div class="bento-overlay"></div>
            <div class="bento-content">
                <span class="bento-label">Starter Kits</span>
                <h3 class="bento-title">Sleek Pods</h3>
                <p class="bento-desc">Perfect for beginners and stealth vaping on the go.</p>
            </div>
        </div>

        <!-- Item 4 (1x1) -->
        <div class="bento-item" onclick="window.location.href='#'">
            <img src="assets/product/product-4.jpg" alt="Disposables" loading="lazy">
            <div class="bento-overlay"></div>
            <div class="bento-content">
                <span class="bento-label">On The Go</span>
                <h3 class="bento-title">Disposables</h3>
                <p class="bento-desc">Zero maintenance, massive flavor payoff straight out of the box.</p>
            </div>
        </div>

        <!-- Item 5 (1x1) -->
        <div class="bento-item" onclick="window.location.href='#'">
            <img src="assets/product/product-6.jpg" alt="New Arrivals" loading="lazy">
            <div class="bento-overlay"></div>
            <div class="bento-content">
                <span class="bento-label">Trending</span>
                <h3 class="bento-title">New Arrivals</h3>
                <p class="bento-desc">Stay ahead of the curve with the latest vaping tech.</p>
            </div>
        </div>

        <!-- Item 6 (1x1) -->
        <div class="bento-item" onclick="window.location.href='#'">
            <img src="assets/product/product-5.jpg" alt="Accessories" loading="lazy">
            <div class="bento-overlay"></div>
            <div class="bento-content">
                <span class="bento-label">Essentials</span>
                <h3 class="bento-title">Coils & Tanks</h3>
                <p class="bento-desc">Keep your device running at peak performance.</p>
            </div>
        </div>

        <!-- Item 7 (Wide - 2x1) -->
        <div class="bento-item span-2-1" onclick="window.location.href='#'">
            <img src="assets/product/product-8.jpg" alt="Vape Juice" loading="lazy">
            <div class="bento-overlay"></div>
            <div class="bento-content">
                <span class="bento-label">Liquid Collection</span>
                <h3 class="bento-title">Premium E-Liquid Series</h3>
                <p class="bento-desc">Explore hundreds of flavors from top global brands like Hayati and Nasty Juice.
                    Our curated series offers something for every palate.</p>
            </div>
        </div>

        <!-- Item 8 (1x1) -->
        <div class="bento-item" onclick="window.location.href='#'">
            <img src="assets/product/product-9.jpg" alt="Sale" loading="lazy">
            <div class="bento-overlay"></div>
            <div class="bento-content">
                <span class="bento-label">Offers</span>
                <h3 class="bento-title">Hot Deals</h3>
                <p class="bento-desc">Get the best prices on top-rated gear.</p>
            </div>
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
                    <div class="faq-icon-wrapper"></div>
                    <div class="faq-toggle"></div>
                </div>
                <div class="faq-answer">
                    <p>Once your order is shipped, you will receive an email with a tracking number and a link to
                        the courier's website to monitor your delivery progress.</p>
                </div>
            </div>
            <!-- FAQ Item 3 -->
            <div class="faq-item">
                <div class="faq-question">
                    <h3>What are Nicotine Salts?</h3>
                    <div class="faq-toggle"></div>
                </div>
                <div class="faq-answer">
                    <p>Nicotine salts are a type of nicotine processed differently to allow for higher
                        concentrations that are smoother on the throat and absorbed faster into the bloodstream.</p>
                </div>
            </div>
            <!-- FAQ Item 4 -->
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Which e-liquid is right for my device?</h3>
                    <div class="faq-toggle"></div>
                </div>
                <div class="faq-answer">
                    <p>Sub-ohm devices typically use High VG liquids (70/30), while pod kits and starter kits work
                        best with 50/50 liquids or Nicotine Salts.</p>
                </div>
            </div>
            <!-- FAQ Item 5 -->
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Do you offer international shipping?</h3>
                    <div class="faq-icon-wrapper"></div>
                    <div class="faq-toggle"></div>
                </div>
                <div class="faq-answer">
                    <p>Yes, we ship to most countries worldwide. Shipping costs and delivery times vary depending on
                        the destination and will be calculated at checkout.</p>
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

<script src="js/collection.js"></script>

<?php require 'partials/footer.php'; ?>