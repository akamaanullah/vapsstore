<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'The Perfect Vape | Premium Vape Store'; ?></title>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div id="scroll-sentinel"></div>
    <header class="header">
        <div class="container">
            <div class="nav-top">
                <a href="index.php" class="logo">
                    <img src="assets/image/theperfectvape.png" alt="The Perfect Vape" class="logo-img">
                </a>

                <div class="search-bar">
                    <input type="text" placeholder="Search flavors, brands or devices...">
                    <i data-lucide="search"></i>
                </div>

                <div class="header-actions">
                    <a href="wishlist.php" class="header-icon-btn">
                        <i data-lucide="heart"></i>
                        <span class="icon-badge wishlist-count" style="display:none;">0</span>
                    </a>
                    <button class="header-icon-btn" id="cartToggle">
                        <i data-lucide="shopping-bag"></i>
                        <span class="icon-badge cart-count" style="display:none;">0</span>
                    </button>
                    <a href="login.php" class="header-icon-btn">
                        <i data-lucide="user"></i>
                    </a>
                    <button class="menu-toggle header-icon-btn" id="mobileMenuToggle">
                        <i data-lucide="menu"></i>
                    </button>
                </div>
            </div>

            <!-- Cart Sidebar Drawer -->
            <div class="cart-sidebar" id="cartSidebar">
                <div class="cart-sidebar-header">
                    <h3>Shopping Cart</h3>
                    <button class="cart-close" id="cartClose">
                        <i data-lucide="x"></i>
                    </button>
                </div>

                <div class="cart-items-container" id="cartItemsList">
                    <!-- Cart items will be injected here by JS -->
                    <div class="empty-cart-msg">
                        <i data-lucide="shopping-cart"></i>
                        <p>Your cart is empty</p>
                        <a href="collection.php" class="btn-shop-now">Shop Our Collection</a>
                    </div>
                </div>

                <div class="cart-sidebar-footer" id="cartFooter" style="display:none;">
                    <div class="cart-total">
                        <span>Subtotal</span>
                        <span class="total-amount">£0.00</span>
                    </div>
                    <p class="shipping-note">Taxes and shipping calculated at checkout</p>
                    <button class="btn-checkout" onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
                    <button class="btn-view-cart" onclick="window.location.href='collection.php'">View Shopping Cart</button>
                </div>
            </div>
            <!-- Cart Overlay -->
            <div class="cart-overlay" id="cartOverlay"></div>

            <nav class="nav-bottom">
                <div class="mobile-menu-header">
                    <a href="index.php" class="logo">
                        <img src="assets/image/theperfectvape.png" alt="The Perfect Vape" class="logo-img">
                    </a>
                    <button class="mobile-close-btn" id="mobileMenuClose">
                        <i data-lucide="x"></i>
                    </button>
                </div>

                <ul class="nav-list">
                    <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                    
                    <li class="nav-item has-dropdown">
                        <a href="collection.php" class="nav-link">Shop <i data-lucide="chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="collection.php">All Products</a></li>
                            <li><a href="collection.php?sort=newest">New Arrivals</a></li>
                            <li><a href="collection.php?sort=best-selling">Best Sellers</a></li>
                            <li><a href="collection.php?on_sale=true">Hot Sale</a></li>
                        </ul>
                    </li>

                    <li class="nav-item has-mega">
                        <a href="collection.php?cat=disposables" class="nav-link">Disposables <i data-lucide="chevron-down"></i></a>
                        <div class="mega-menu">
                            <div class="mega-grid">
                                <div class="mega-col">
                                    <h4>By Brand</h4>
                                    <ul>
                                        <li><a href="collection.php?brand=geek-bar">Geek Bar</a></li>
                                        <li><a href="collection.php?brand=hayati">Hayati</a></li>
                                        <li><a href="collection.php?brand=gold-bar">Gold Bar</a></li>
                                        <li><a href="collection.php?brand=crystal">Crystal</a></li>
                                        <li><a href="collection.php?brand=lost-mary">Lost Mary</a></li>
                                    </ul>
                                </div>
                                <div class="mega-col">
                                    <h4>By Puff Count</h4>
                                    <ul>
                                        <li><a href="collection.php?puffs=600">600 Puffs</a></li>
                                        <li><a href="collection.php?puffs=4000">4000 Puffs</a></li>
                                        <li><a href="collection.php?puffs=10000">10000+ Puffs</a></li>
                                        <li><a href="collection.php?nic=0">Nicotine Free</a></li>
                                    </ul>
                                </div>
                                <div class="mega-col">
                                    <h4>Trending Now</h4>
                                    <ul>
                                        <li><a href="product-detail.php">Hayati Pro Max</a></li>
                                        <li><a href="product-detail.php">Geek Bar Meloso</a></li>
                                        <li><a href="product-detail.php">SKE Crystal 600</a></li>
                                        <li><a href="product-detail.php">IVG 2400 Edition</a></li>
                                    </ul>
                                </div>
                                <div class="mega-col">
                                    <div class="mega-promo">
                                        <img src="assets/product/product-4.jpg" alt="Promo">
                                        <h5>Weekly Disposable Deal</h5>
                                        <p>Buy 5 for £20 on selected brands</p>
                                        <a href="collection.php" class="btn-mega">Shop Deal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item has-mega">
                        <a href="collection.php?cat=vape-juices" class="nav-link">Vape Juices <i data-lucide="chevron-down"></i></a>
                        <div class="mega-menu">
                            <div class="mega-grid">
                                <div class="mega-col">
                                    <h4>By Flavor</h4>
                                    <ul>
                                        <li><a href="collection.php?flavor=fruit">Fruit Blends</a></li>
                                        <li><a href="collection.php?flavor=dessert">Dessert & Creamy</a></li>
                                        <li><a href="collection.php?flavor=menthol">Menthol & Ice</a></li>
                                        <li><a href="collection.php?flavor=candy">Candy & Sweets</a></li>
                                        <li><a href="collection.php?flavor=tobacco">Classic Tobacco</a></li>
                                    </ul>
                                </div>
                                <div class="mega-col">
                                    <h4>By Juice Type</h4>
                                    <ul>
                                        <li><a href="collection.php?type=nic-salts">Nicotine Salts</a></li>
                                        <li><a href="collection.php?type=shortfills">High VG Shortfills</a></li>
                                        <li><a href="collection.php?type=50-50">50/50 Freebase</a></li>
                                        <li><a href="collection.php?type=concentrates">Flavor Concentrates</a></li>
                                    </ul>
                                </div>
                                <div class="mega-col">
                                    <h4>Top Brands</h4>
                                    <ul>
                                        <li><a href="collection.php?brand=nasty-juice">Nasty Juice</a></li>
                                        <li><a href="collection.php?brand=dinner-lady">Dinner Lady</a></li>
                                        <li><a href="collection.php?brand=vampire-vape">Vampire Vape</a></li>
                                        <li><a href="collection.php?brand=ivg">IVG Premium</a></li>
                                    </ul>
                                </div>
                                <div class="mega-col">
                                    <div class="mega-promo">
                                        <img src="assets/product/product-5.jpg" alt="Promo">
                                        <h5>Salt Bundle Offer</h5>
                                        <p>Mix & Match any 3 Nic Salts for £10</p>
                                        <a href="collection.php" class="btn-mega">Grab Offer</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item"><a href="collection.php?cat=nicotine-pouches" class="nav-link">Nicotine Pouches</a></li>

                    <li class="nav-item has-dropdown">
                        <a href="#" class="nav-link">Resources <i data-lucide="chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="blog.php">Our Blog</a></li>
                            <li><a href="contact-us.php">Contact Us</a></li>
                            <li><a href="#">Shipping Policy</a></li>
                            <li><a href="#">Track Order</a></li>
                            <li><a href="collection.php">FAQs</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            </div>
        </header>