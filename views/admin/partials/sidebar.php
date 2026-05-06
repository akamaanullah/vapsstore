<?php
// Simple helper to check active route
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="<?= BASE_URL ?>/admin" class="sidebar-branding">
            <img src="<?= BASE_URL ?>/admin_assets/image/theperfectvape.png" alt="Logo" class="sidebar-logo">
        </a>
    </div>

    <ul class="sidebar-menu" style="margin-top: 15px;">
        <li>
            <a href="<?= BASE_URL ?>/admin" class="<?= (strpos($uri, '/admin') !== false && strpos($uri, '/admin/') === false) ? 'active' : ''; ?>">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-nav-header">Catalog</div>
    <ul class="sidebar-menu">
        <li>
            <a href="<?= BASE_URL ?>/admin/products" class="<?= strpos($uri, '/admin/products') !== false ? 'active' : ''; ?>">
                <i data-lucide="store"></i>
                <span>Products</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/collections" class="<?= strpos($uri, '/admin/collections') !== false ? 'active' : ''; ?>">
                <i data-lucide="package"></i>
                <span>Collections</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/brands" class="<?= strpos($uri, '/admin/brands') !== false ? 'active' : ''; ?>">
                <i data-lucide="tag"></i>
                <span>Brands</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-nav-header">Sales</div>
    <ul class="sidebar-menu">
        <li>
            <a href="<?= BASE_URL ?>/admin/orders" class="<?= strpos($uri, '/admin/orders') !== false ? 'active' : ''; ?>">
                <i data-lucide="shopping-cart"></i>
                <span>Orders</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/customers" class="<?= strpos($uri, '/admin/customers') !== false ? 'active' : ''; ?>">
                <i data-lucide="users"></i>
                <span>Customers</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/refunds" class="<?= strpos($uri, '/admin/refunds') !== false ? 'active' : ''; ?>">
                <i data-lucide="undo-2"></i>
                <span>Refunds</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-nav-header">Storefront</div>
    <ul class="sidebar-menu">
        <li>
            <a href="<?= BASE_URL ?>/admin/pages" class="<?= strpos($uri, '/admin/pages') !== false ? 'active' : ''; ?>">
                <i data-lucide="layout"></i>
                <span>Pages</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/menus" class="<?= strpos($uri, '/admin/menus') !== false ? 'active' : ''; ?>">
                <i data-lucide="menu"></i>
                <span>Navigation</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/theme" class="<?= strpos($uri, '/admin/theme') !== false ? 'active' : ''; ?>">
                <i data-lucide="palette"></i>
                <span>Theme Sections</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/media" class="<?= strpos($uri, '/admin/media') !== false ? 'active' : ''; ?>">
                <i data-lucide="image"></i>
                <span>Media Gallery</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-nav-header">Marketing</div>
    <ul class="sidebar-menu">
        <li>
            <a href="<?= BASE_URL ?>/admin/blogs" class="<?= strpos($uri, '/admin/blogs') !== false ? 'active' : ''; ?>">
                <i data-lucide="file-text"></i>
                <span>Blogs</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/blog-categories" class="<?= strpos($uri, '/admin/blog-categories') !== false ? 'active' : ''; ?>">
                <i data-lucide="hash"></i>
                <span>Blog Categories</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/coupons" class="<?= strpos($uri, '/admin/coupons') !== false ? 'active' : ''; ?>">
                <i data-lucide="ticket"></i>
                <span>Coupons</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/reviews" class="<?= strpos($uri, '/admin/reviews') !== false ? 'active' : ''; ?>">
                <i data-lucide="star"></i>
                <span>Reviews</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/messages" class="<?= strpos($uri, '/admin/messages') !== false ? 'active' : ''; ?>">
                <i data-lucide="message-square"></i>
                <span>Messages</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-nav-header">System</div>
    <ul class="sidebar-menu">
        <li>
            <a href="<?= BASE_URL ?>/admin/settings" class="<?= strpos($uri, '/admin/settings') !== false ? 'active' : ''; ?>">
                <i data-lucide="settings"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>

    <script>
        document.querySelectorAll('.submenu-toggle').forEach(toggle => {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                const parent = this.parentElement;
                parent.classList.toggle('open');

                // Optional: Close other submenus
                document.querySelectorAll('.has-submenu').forEach(item => {
                    if (item !== parent) item.classList.remove('open');
                });
            });
        });
    </script>

</aside>