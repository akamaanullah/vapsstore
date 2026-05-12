<?php
use App\Helpers\NavigationHelper;
use App\Helpers\UIHelper;

$settings = UIHelper::getSettings();
$menuTree = NavigationHelper::getMenuTree('main_menu');

// Helper for logo/favicon
$img = function($key, $default) use ($settings) {
    $val = $settings[$key] ?? '';
    if (empty($val)) return BASE_URL . '/' . $default;
    return (strpos($val, 'http') === 0) ? $val : BASE_URL . '/' . $val;
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : ($settings['seo_home_title'] ?? 'The Perfect Vape | Premium Vape Store'); ?></title>
    <meta name="description" content="<?php echo isset($metaDescription) ? $metaDescription : ($settings['seo_home_desc'] ?? 'Find the best vapes, e-liquids, and accessories at The Perfect Vape.'); ?>">
    <?php 
    $faviconUrl = $img('store_favicon', 'favicon.ico');
    $ext = pathinfo($faviconUrl, PATHINFO_EXTENSION);
    $type = ($ext === 'png') ? 'image/png' : (($ext === 'svg') ? 'image/svg+xml' : 'image/x-icon');
    ?>
    <link rel="icon" type="<?= $type ?>" href="<?= $faviconUrl ?>">
    <?php if (isset($noIndex) && $noIndex): ?>
    <meta name="robots" content="noindex, nofollow">
    <?php endif; ?>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    
    <script>
        const BASE_URL = "<?= BASE_URL ?>";
    </script>
</head>

<body>
    <div id="scroll-sentinel"></div>
    <header class="header">
        <div class="container">
            <div class="nav-top">
                <a href="<?= BASE_URL ?>/" class="logo">
                    <img src="<?= $img('store_logo', 'assets/image/theperfectvape.png') ?>" alt="<?= htmlspecialchars($settings['store_name'] ?? 'The Perfect Vape') ?>" class="logo-img">
                </a>

                <div class="search-bar">
                    <input type="text" placeholder="Search flavors, brands or devices...">
                    <i data-lucide="search"></i>
                </div>

                <div class="header-actions">
                    <a href="<?= BASE_URL ?>/wishlist" class="header-icon-btn">
                        <i data-lucide="heart"></i>
                        <span class="icon-badge wishlist-count" style="display:none;">0</span>
                    </a>
                    <button class="header-icon-btn" id="cartToggle">
                        <i data-lucide="shopping-bag"></i>
                        <span class="icon-badge cart-count" style="display:none;">0</span>
                    </button>
                    <a href="<?= BASE_URL ?>/login" class="header-icon-btn">
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
                        <a href="<?= BASE_URL ?>/collection" class="btn-shop-now">Shop Our Collection</a>
                    </div>
                </div>

                <div class="cart-sidebar-footer" id="cartFooter" style="display:none;">
                    <div class="cart-total">
                        <span>Subtotal</span>
                        <span class="total-amount">£0.00</span>
                    </div>
                    <p class="shipping-note">Taxes and shipping calculated at checkout</p>
                    <button class="btn-checkout" onclick="window.location.href='<?= BASE_URL ?>/checkout'">Proceed to Checkout</button>
                    <button class="btn-view-cart" onclick="window.location.href='<?= BASE_URL ?>/collection'">View Shopping Cart</button>
                </div>
            </div>
            <!-- Cart Overlay -->
            <div class="cart-overlay" id="cartOverlay"></div>

            <nav class="nav-bottom">
                <div class="mobile-menu-header">
                    <a href="<?= BASE_URL ?>/" class="logo">
                        <img src="<?= $img('store_logo', 'assets/image/theperfectvape.png') ?>" alt="<?= htmlspecialchars($settings['store_name'] ?? 'The Perfect Vape') ?>" class="logo-img">
                    </a>
                    <button class="mobile-close-btn" id="mobileMenuClose">
                        <i data-lucide="x"></i>
                    </button>
                </div>

                <ul class="nav-list">
                    <?php if (empty($menuTree)): ?>
                        <li class="nav-item"><a href="<?= BASE_URL ?>/" class="nav-link">Home</a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>/collection" class="nav-link">Shop</a></li>
                    <?php else: ?>
                        <?php foreach ($menuTree as $item): ?>
                            <?php NavigationHelper::renderHeaderMenu($item); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </nav>
            </div>
        </header>