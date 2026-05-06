<?php
$pageTitle = "Home | The Perfect Vape Premium Store";
require 'partials/header.php';
?>

<main id="main-content">

    <!-- Hero Slider -->
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide hero-slide">
                <div class="hero-slide-bg" style="background-image: url('assets/image/carousel-1.jpg');"
                    fetchpriority="high"></div>
                <div class="container">
                    <div class="hero-content">
                        <!-- <span class="hero-badge">Premium Selection</span> -->
                        <h1>Experience Vaping <br>Elevated to Art</h1>
                        <p>Explore our curated collection of elite e-liquids and cutting-edge hardware designed for the
                            true connoisseur.</p>
                        <div class="hero-btns">
                            <a href="#" class="btn btn-primary">Shop New</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="swiper-slide hero-slide">
                <div class="hero-slide-bg" style="background-image: url('assets/image/carousel-2.jpg');"></div>
                <div class="container">
                    <div class="hero-content">
                        <!-- <span class="hero-badge">Wholesale Deals</span> -->
                        <h1>Unmatched Quality <br>For Your Business</h1>
                        <p>Join our wholesale program and get access to exclusive prices on the world's most popular
                            vape brands.</p>
                        <div class="hero-btns">
                            <a href="#" class="btn btn-outline">Shop New</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="swiper-slide hero-slide">
                <div class="hero-slide-bg" style="background-image: url('assets/image/carousel-3.webp');"></div>
                <div class="container">
                    <div class="hero-content">
                        <!-- <span class="hero-badge">New Arrivals</span> -->
                        <h1>The Future of <br>Vaping is Here</h1>
                        <p>Discover the latest technology and trending flavors that are redefining the vaping
                            experience.</p>
                        <div class="hero-btns">
                            <a href="#" class="btn btn-primary">Shop New</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slider Controls -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <!-- Categories Grid -->
    <section class="categories-section">
        <div class="container">
            <div class="categories-grid">
                <div class="category-card-v2">
                    <img src="assets/image/1.jpg" alt="Accessories" loading="lazy">
                    <h4>Accessories</h4>
                    <p>Browse the best brands <br>and flavours</p>
                </div>
                <div class="category-card-v2">
                    <img src="assets/image/2.jpg" alt="Shop Coils" loading="lazy">
                    <h4>Shop Coils</h4>
                    <p>Browse the best brands <br>and flavours</p>
                </div>
                <div class="category-card-v2">
                    <img src="assets/image/3.jpg" alt="Shop E-Liquids" loading="lazy">
                    <h4>Shop E-Liquids</h4>
                    <p>Browse the best brands <br>and flavours</p>
                </div>
                <div class="category-card-v2">
                    <img src="assets/image/4.jpg" alt="Shop Tanks" loading="lazy">
                    <h4>Shop Tanks</h4>
                    <p>Browse the best brands <br>and flavours</p>
                </div>
                <!-- <div class="category-card-v2">
                    <img src="assets/image/2.jpg" alt="Shop Vap Kits" loading="lazy">
                    <h4>Shop Vap Kits</h4>
                    <p>Browse the best brands <br>and flavours</p>
                </div> -->
            </div>
        </div>
    </section>

    <!-- Promo Banners Section -->
    <section class="promo-section">
        <div class="container">
            <div class="promo-grid">
                <div class="promo-banner banner-blue" style="background-image: url('assets/image/carousel-1.jpg');">
                    <div class="promo-content">
                        <h2>Devices</h2>
                        <p>The most sought-after hardware</p>
                        <a href="#" class="promo-btn">Shop Now</a>
                    </div>
                </div>
                <div class="promo-banner banner-purple" style="background-image: url('assets/image/carousel-2.jpg');">
                    <div class="promo-content">
                        <h2>High End</h2>
                        <p>Top picks from across the Globe</p>
                        <a href="#" class="promo-btn">Shop Now</a>
                    </div>
                </div>
                <!-- <div class="promo-banner" style="background-image: url('assets/image/carousel-3.webp');">
                    <div class="promo-content">
                        <h2>E-Liquids</h2>
                        <p>Shortfills, Nic Salts, Concentrates</p>
                        <a href="#" class="promo-btn">Shop Now</a>
                    </div>
                </div> -->
            </div>
        </div>
    </section>

    <!-- Feature Highlight Section -->
    <section class="feature-highlight">
        <div class="container">
            <div class="feature-grid">
                <div class="feature-content">
                    <span class="feature-badge">Elite Selection</span>
                    <h2>Redefining the Art <br>of Vaping</h2>
                    <p>At The Perfect Vape, we believe that vaping is more than just an alternative—it's a lifestyle.
                        Our curated selection of premium devices and artisan e-liquids are crafted for those who demand
                        excellence in every puff.</p>
                    <p class="feature-extra-text">We take pride in sourcing only the most reliable hardware and artisan
                        e-liquids from around the globe, ensuring a consistently superior experience for every customer.
                    </p>
                    <div class="feature-btns">
                        <a href="#" class="btn btn-primary">Discover More</a>
                    </div>
                </div>
                <div class="feature-visual">
                    <div class="visual-wrapper">
                        <img src="assets/product/product-7.jpg" alt="Premium Experience">
                        <!-- <div class="visual-accent"></div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Selling Flavours Section -->
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
                        <img src="assets/product/product-1.jpg" class="flavour-img" alt="Blueberry">
                    </div>
                    <h4>Blueberry</h4>
                </div>
                <!-- Flavour 2 -->
                <div class="flavour-item">
                    <div class="flavour-circle">
                        <img src="assets/product/product-2.jpg" class="flavour-img" alt="Grape">
                    </div>
                    <h4>Grape</h4>
                </div>
                <!-- Flavour 3 -->
                <div class="flavour-item">
                    <div class="flavour-circle">
                        <img src="assets/product/product-3.jpg" class="flavour-img" alt="Menthol">
                    </div>
                    <h4>Menthol</h4>
                </div>
                <!-- Flavour 4 -->
                <div class="flavour-item">
                    <div class="flavour-circle">
                        <img src="assets/product/product-4.jpg" class="flavour-img" alt="Raspberry">
                    </div>
                    <h4>Raspberry</h4>
                </div>
                <!-- Flavour 5 -->
                <div class="flavour-item">
                    <div class="flavour-circle">
                        <img src="assets/product/product-5.jpg" class="flavour-img" alt="Strawberry">
                    </div>
                    <h4>Strawberry</h4>
                </div>
                <!-- Flavour 6 -->
                <div class="flavour-item">
                    <div class="flavour-circle">
                        <img src="assets/product/product-6.jpg" class="flavour-img" alt="Tobacco">
                    </div>
                    <h4>Tobacco</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Slider -->
    <section class="product-section">
        <div class="container">
            <div class="section-header">
                <h2>Featured Products</h2>
                <a href="#" class="view-all">View All Products</a>
            </div>
            <div class="swiper product-swiper">
                <div class="swiper-wrapper">
                    <!-- Product 1 -->
                    <div class="swiper-slide">
                        <div class="product-card" data-id="feat-1">
                            <div class="product-img-wrapper">
                                <img src="assets/image/1.jpg" alt="Product" loading="lazy">
                                <div class="product-actions">
                                    <button class="action-btn" title="Add to Wishlist"><i
                                            data-lucide="heart"></i></button>
                                    <a href="product-detail.php" class="action-btn" title="Quick View"><i
                                            data-lucide="eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><a href="product-detail.php">Premium Mesh Coil Pack</a></h3>
                                <div class="product-price-container">
                                    <span class="old-price">£15.00</span>
                                    <span class="current-price">£12.99</span>
                                </div>
                                <button class="btn-buy">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 2 -->
                    <div class="swiper-slide">
                        <div class="product-card" data-id="feat-2">
                            <div class="product-img-wrapper">
                                <img src="assets/image/2.jpg" alt="Product" loading="lazy">
                                <div class="product-actions">
                                    <button class="action-btn" title="Add to Wishlist"><i
                                            data-lucide="heart"></i></button>
                                    <a href="product-detail.php" class="action-btn" title="Quick View"><i
                                            data-lucide="eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><a href="product-detail.php">Artisan Mint E-Liquid</a></h3>
                                <div class="product-price-container">
                                    <span class="old-price">£20.00</span>
                                    <span class="current-price">£15.50</span>
                                </div>
                                <button class="btn-buy">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 3 -->
                    <div class="swiper-slide">
                        <div class="product-card" data-id="feat-3">
                            <div class="product-img-wrapper">
                                <img src="assets/image/3.jpg" alt="Product" loading="lazy">
                                <div class="product-actions">
                                    <button class="action-btn" title="Add to Wishlist"><i
                                            data-lucide="heart"></i></button>
                                    <a href="product-detail.php" class="action-btn" title="Quick View"><i
                                            data-lucide="eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><a href="product-detail.php">Advanced Sub-Ohm Tank</a></h3>
                                <div class="product-price-container">
                                    <span class="old-price">£30.00</span>
                                    <span class="current-price">£24.00</span>
                                </div>
                                <button class="btn-buy">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 4 -->
                    <div class="swiper-slide">
                        <div class="product-card" data-id="feat-4">
                            <div class="product-img-wrapper">
                                <img src="assets/image/4.jpg" alt="Product" loading="lazy">
                                <div class="product-actions">
                                    <button class="action-btn" title="Add to Wishlist"><i
                                            data-lucide="heart"></i></button>
                                    <a href="product-detail.php" class="action-btn" title="Quick View"><i
                                            data-lucide="eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><a href="product-detail.php">Vape Accessories Kit</a></h3>
                                <div class="product-price-container">
                                    <span class="old-price">£12.00</span>
                                    <span class="current-price">£8.99</span>
                                </div>
                                <button class="btn-buy">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 5 -->
                    <div class="swiper-slide">
                        <div class="product-card" data-id="feat-5">
                            <div class="product-img-wrapper">
                                <img src="assets/image/1.jpg" alt="Product" loading="lazy">
                                <div class="product-actions">
                                    <button class="action-btn" title="Add to Wishlist"><i
                                            data-lucide="heart"></i></button>
                                    <a href="product-detail.php" class="action-btn" title="Quick View"><i
                                            data-lucide="eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><a href="product-detail.php">Classic Tobacco Pack</a></h3>
                                <div class="product-price-container">
                                    <span class="old-price">£18.00</span>
                                    <span class="current-price">£14.00</span>
                                </div>
                                <button class="btn-buy">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 6 -->
                    <div class="swiper-slide">
                        <div class="product-card" data-id="feat-6">
                            <div class="product-img-wrapper">
                                <img src="assets/image/2.jpg" alt="Product" loading="lazy">
                                <div class="product-actions">
                                    <button class="action-btn" title="Add to Wishlist"><i
                                            data-lucide="heart"></i></button>
                                    <a href="product-detail.php" class="action-btn" title="Quick View"><i
                                            data-lucide="eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><a href="product-detail.php">Sweet Mango Pods</a></h3>
                                <div class="product-price-container">
                                    <span class="old-price">£12.00</span>
                                    <span class="current-price">£8.99</span>
                                </div>
                                <button class="btn-buy">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 5 -->
                    <div class="swiper-slide">
                        <div class="product-card" data-id="pop-3">
                            <div class="product-img-wrapper">
                                <img src="assets/image/1.jpg" alt="Product" loading="lazy">
                                <div class="product-actions">
                                    <button class="action-btn" title="Add to Wishlist"><i
                                            data-lucide="heart"></i></button>
                                    <button class="action-btn" title="Compare"><i data-lucide="shuffle"></i></button>
                                    <a href="product-detail.php" class="action-btn" title="Quick View"><i
                                            data-lucide="eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">Classic Tobacco Pack</h3>
                                <div class="product-price-container">
                                    <span class="old-price">£18.00</span>
                                    <span class="current-price">£14.00</span>
                                </div>
                                <button class="btn-buy">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 6 -->
                    <div class="swiper-slide">
                        <div class="product-card" data-id="pop-3">
                            <div class="product-img-wrapper">
                                <img src="assets/image/2.jpg" alt="Product" loading="lazy">
                                <div class="product-actions">
                                    <button class="action-btn" title="Add to Wishlist"><i
                                            data-lucide="heart"></i></button>
                                    <button class="action-btn" title="Compare"><i data-lucide="shuffle"></i></button>
                                    <a href="product-detail.php" class="action-btn" title="Quick View"><i
                                            data-lucide="eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">Sweet Mango Pods</h3>
                                <div class="product-price-container">
                                    <span class="old-price">£15.00</span>
                                    <span class="current-price">£11.99</span>
                                </div>
                                <button class="btn-buy">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slider Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <!-- Slider Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- Banner Section -->
    <section class="flavour-banner-section">
        <div class="flavour-banner-bg">
            <div class="flavour-banner-content">
                <h2>Find Your E-Liquid Flavour</h2>
                <a href="#" class="btn-banner-shop">Shop Now</a>
            </div>
        </div>
    </section>

    <!-- New Arrivals Grid -->
    <section class="product-section">
        <div class="container">
            <div class="section-header">
                <h2>New Arrivals</h2>
                <a href="#" class="view-all">Shop All Arrivals</a>
            </div>
            <div class="product-grid">
                <?php
                $products = [
                    ['name' => 'Classic Tobacco Blend', 'price' => '£14.99', 'old' => '£19.99', 'img' => 'product-1.jpg'],
                    ['name' => 'Strawberry Ice Pods', 'price' => '£11.00', 'old' => '£15.00', 'img' => 'product-2.jpg'],
                    ['name' => 'High-Capacity Battery', 'price' => '£18.50', 'old' => '£25.00', 'img' => 'product-3.jpg'],
                    ['name' => 'Custom Drip Tip', 'price' => '£5.99', 'old' => '£8.00', 'img' => 'product-4.jpg'],
                    ['name' => 'Organic Cotton Pack', 'price' => '£4.50', 'old' => '£6.00', 'img' => 'product-5.jpg'],
                    ['name' => 'Replacement Glass Tank', 'price' => '£7.00', 'old' => '£10.00', 'img' => 'product-6.jpg'],
                    ['name' => 'Lanyard & Case Set', 'price' => '£9.99', 'old' => '£15.00', 'img' => 'product-7.jpg'],
                    ['name' => 'USB-C Fast Charger', 'price' => '£12.00', 'old' => '£18.00', 'img' => 'product-8.jpg'],
                ];
                foreach ($products as $p): ?>
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <img src="assets/product/<?php echo $p['img']; ?>" alt="<?php echo $p['name']; ?>"
                                loading="lazy">
                            <div class="product-actions">
                                <button class="action-btn" title="Add to Wishlist"><i data-lucide="heart"></i></button>
                                <a href="product-detail.php" class="action-btn" title="Quick View"><i
                                        data-lucide="eye"></i></a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name"><a href="product-detail.php"><?php echo $p['name']; ?></a></h3>
                            <div class="product-price-container">
                                <span class="old-price"><?php echo $p['old']; ?></span>
                                <span class="current-price"><?php echo $p['price']; ?></span>
                            </div>
                            <button class="btn-buy">Add to Cart</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Brand Story Smoke Section -->
    <section class="smoke-section">
        <div class="smoke-overlay"></div>
        <div class="container">
            <div class="smoke-content">
                <h2>The Essence of Pure Vaping</h2>
                <div class="expandable-text-wrapper">
                    <p class="expandable-text" id="storyText">
                        Discover the philosophy behind The Perfect Vape. We are dedicated to bringing you the most
                        sophisticated vaping experiences by combining cutting-edge technology with the finest artisanal
                        blends. Every product in our collection is handpicked to ensure it meets our rigorous standards
                        for quality and performance.
                        <span class="hidden-text" id="moreText">
                            Our journey began with a simple mission: to elevate the vaping community by providing access
                            to world-class hardware and exclusive e-liquids that were previously hard to find. Today, we
                            stand as a beacon for enthusiasts who value precision, flavor, and style. From sub-ohm
                            powerhouses to elegant pod systems, we cater to every level of vaper with unparalleled
                            expertise and customer support.
                        </span>
                    </p>
                    <button id="toggleStoryBtn" class="btn-show-more">Read Our Story <i
                            data-lucide="chevron-down"></i></button>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Products Slider -->
    <section class="product-section">
        <div class="container">
            <div class="section-header">
                <h2>Popular Products</h2>
                <a href="#" class="view-all">View All Popular</a>
            </div>
            <div class="swiper product-swiper">
                <div class="swiper-wrapper">
                    <!-- Product 1 -->
                    <div class="swiper-slide">
                        <div class="product-card" data-id="pop-1">
                            <div class="product-img-wrapper">
                                <img src="assets/image/1.jpg" alt="Product" loading="lazy">
                                <div class="product-actions">
                                    <button class="action-btn" title="Add to Wishlist"><i
                                            data-lucide="heart"></i></button>
                                    <a href="product-detail.php" class="action-btn" title="Quick View"><i
                                            data-lucide="eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><a href="product-detail.php">Premium Mesh Coil Pack</a></h3>
                                <div class="product-price-container">
                                    <span class="old-price">£15.00</span>
                                    <span class="current-price">£12.99</span>
                                </div>
                                <button class="btn-buy">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 2 -->
                    <div class="swiper-slide">
                        <div class="product-card" data-id="pop-2">
                            <div class="product-img-wrapper">
                                <img src="assets/image/2.jpg" alt="Product" loading="lazy">
                                <div class="product-actions">
                                    <button class="action-btn" title="Add to Wishlist"><i
                                            data-lucide="heart"></i></button>
                                    <a href="product-detail.php" class="action-btn" title="Quick View"><i
                                            data-lucide="eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><a href="product-detail.php">Artisan Mint E-Liquid</a></h3>
                                <div class="product-price-container">
                                    <span class="old-price">£20.00</span>
                                    <span class="current-price">£15.50</span>
                                </div>
                                <button class="btn-buy">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 3 -->
                    <div class="swiper-slide">
                        <div class="product-card" data-id="pop-3">
                            <div class="product-img-wrapper">
                                <img src="assets/image/3.jpg" alt="Product" loading="lazy">
                                <div class="product-actions">
                                    <button class="action-btn" title="Add to Wishlist"><i
                                            data-lucide="heart"></i></button>
                                    <a href="product-detail.php" class="action-btn" title="Quick View"><i
                                            data-lucide="eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><a href="product-detail.php">Advanced Sub-Ohm Tank</a></h3>
                                <div class="product-price-container">
                                    <span class="old-price">£30.00</span>
                                    <span class="current-price">£24.00</span>
                                </div>
                                <button class="btn-buy">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 4 -->
                    <div class="swiper-slide">
                        <div class="product-card" data-id="pop-4">
                            <div class="product-img-wrapper">
                                <img src="assets/image/4.jpg" alt="Product" loading="lazy">
                                <div class="product-actions">
                                    <button class="action-btn" title="Add to Wishlist"><i
                                            data-lucide="heart"></i></button>
                                    <a href="product-detail.php" class="action-btn" title="Quick View"><i
                                            data-lucide="eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><a href="product-detail.php">Vape Accessories Kit</a></h3>
                                <div class="product-price-container">
                                    <span class="old-price">£12.00</span>
                                    <span class="current-price">£8.99</span>
                                </div>
                                <button class="btn-buy">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 5 -->
                    <div class="swiper-slide">
                        <div class="product-card" data-id="pop-5">
                            <div class="product-img-wrapper">
                                <img src="assets/image/1.jpg" alt="Product" loading="lazy">
                                <div class="product-actions">
                                    <button class="action-btn" title="Add to Wishlist"><i
                                            data-lucide="heart"></i></button>
                                    <a href="product-detail.php" class="action-btn" title="Quick View"><i
                                            data-lucide="eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><a href="product-detail.php">Classic Tobacco Pack</a></h3>
                                <div class="product-price-container">
                                    <span class="old-price">£18.00</span>
                                    <span class="current-price">£14.00</span>
                                </div>
                                <button class="btn-buy">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 6 -->
                    <div class="swiper-slide">
                        <div class="product-card" data-id="pop-6">
                            <div class="product-img-wrapper">
                                <img src="assets/image/2.jpg" alt="Product" loading="lazy">
                                <div class="product-actions">
                                    <button class="action-btn" title="Add to Wishlist"><i
                                            data-lucide="heart"></i></button>
                                    <a href="product-detail.php" class="action-btn" title="Quick View"><i
                                            data-lucide="eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><a href="product-detail.php">Sweet Mango Pods</a></h3>
                                <div class="product-price-container">
                                    <span class="old-price">£15.00</span>
                                    <span class="current-price">£11.99</span>
                                </div>
                                <button class="btn-buy">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slider Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <!-- Slider Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="blog-section">
        <div class="container">
            <div class="section-header">
                <h2>Latest Vaping Insights</h2>
                <a href="#" class="view-all">Explore All Blogs</a>
            </div>
            <div class="blog-grid">
                <!-- Blog 1 -->
                <article class="blog-card">
                    <div class="blog-img-wrapper">
                        <img src="assets/product/product-1.jpg" alt="Vape Guide" loading="lazy">
                        <span class="blog-category">Guides</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">April 20, 2026</span>
                        <h3 class="blog-title">How to Choose the Perfect Mod for Your Style</h3>
                        <p class="blog-excerpt">Finding the right device can be overwhelming. We break down the top
                            features to look for this season...</p>
                        <a href="#" class="read-more">Read More</a>
                    </div>
                </article>
                <!-- Blog 2 -->
                <article class="blog-card">
                    <div class="blog-img-wrapper">
                        <img src="assets/product/product-2.jpg" alt="E-Liquid Trends" loading="lazy">
                        <span class="blog-category">Trends</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">April 18, 2026</span>
                        <h3 class="blog-title">Top 5 Fruit Flavours That Are Trending Right Now</h3>
                        <p class="blog-excerpt">From icy mango to sweet strawberry, discover the blends that our
                            community is raving about...</p>
                        <a href="#" class="read-more">Read More</a>
                    </div>
                </article>
                <!-- Blog 3 -->
                <article class="blog-card">
                    <div class="blog-img-wrapper">
                        <img src="assets/product/product-3.jpg" alt="Vape Maintenance" loading="lazy">
                        <span class="blog-category">Maintenance</span>
                    </div>
                    <div class="blog-info">
                        <span class="blog-date">April 15, 2026</span>
                        <h3 class="blog-title">Coil Care: How to Make Your Coils Last Longer</h3>
                        <p class="blog-excerpt">Tired of burnt hits? Follow our essential maintenance tips to extend the
                            life of your hardware...</p>
                        <a href="#" class="read-more">Read More</a>
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

    <!-- Brands Showcase Section -->
    <section class="brands-section">
        <div class="container">
            <div class="swiper brands-swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide brand-item">
                        <img src="assets/image/slideshow-1.png" alt="Brand 1">
                    </div>
                    <div class="swiper-slide brand-item">
                        <img src="assets/image/slideshow-2.png" alt="Brand 2">
                    </div>
                    <div class="swiper-slide brand-item">
                        <img src="assets/image/slideshow-3.png" alt="Brand 3">
                    </div>
                    <div class="swiper-slide brand-item">
                        <img src="assets/image/slideshow-4.png" alt="Brand 4">
                    </div>
                    <div class="swiper-slide brand-item">
                        <img src="assets/image/slideshow-5.png" alt="Brand 5">
                    </div>
                    <div class="swiper-slide brand-item">
                        <img src="assets/image/slideshow-6.png" alt="Brand 6">
                    </div>
                    <div class="swiper-slide brand-item">
                        <img src="assets/image/slideshow-1.png" alt="Brand 6">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- New Starter CTA Section -->
    <section class="starter-cta-section">
        <div class="container">
            <div class="cta-content-wrapper">
                <div class="cta-text">
                    <h2>Ready to Experience The Perfect Vape?</h2>
                    <p>Join thousands of satisfied customers who have elevated their vaping journey with our premium
                        selection and expert support.</p>
                </div>
                <div class="cta-actions">
                    <a href="#" class="btn btn-primary btn-lg">Shop Best Sellers</a>
                    <a href="#" class="btn btn-outline btn-lg">Contact Expert</a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php require 'partials/footer.php'; ?>