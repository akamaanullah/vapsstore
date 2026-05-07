<?php
// Simple helper to check active route
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = parse_url(BASE_URL, PHP_URL_PATH) ?? '';
$currentPath = rtrim(str_replace($basePath, '', $uri), '/');
?>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="<?= BASE_URL ?>/admin" class="sidebar-branding">
            <img src="<?= BASE_URL ?>/admin_assets/image/theperfectvape.png" alt="Logo" class="sidebar-logo">
        </a>
    </div>

    <ul class="sidebar-menu" style="margin-top: 15px;">
        <li>
            <a href="<?= BASE_URL ?>/admin" class="<?= ($currentPath === '/admin') ? 'active' : ''; ?>" data-tooltip="Dashboard">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-nav-header">Catalog</div>
    <ul class="sidebar-menu">
        <li>
            <a href="<?= BASE_URL ?>/admin/products" class="<?= strpos($uri, '/admin/products') !== false ? 'active' : ''; ?>" data-tooltip="Products">
                <i data-lucide="store"></i>
                <span>Products</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/collections" class="<?= strpos($uri, '/admin/collections') !== false ? 'active' : ''; ?>" data-tooltip="Collections">
                <i data-lucide="package"></i>
                <span>Collections</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/brands" class="<?= strpos($uri, '/admin/brands') !== false ? 'active' : ''; ?>" data-tooltip="Brands">
                <i data-lucide="tag"></i>
                <span>Brands</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-nav-header">Sales</div>
    <ul class="sidebar-menu">
        <li>
            <a href="<?= BASE_URL ?>/admin/orders" class="<?= strpos($uri, '/admin/orders') !== false ? 'active' : ''; ?>" data-tooltip="Orders">
                <i data-lucide="shopping-cart"></i>
                <span>Orders</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/customers" class="<?= strpos($uri, '/admin/customers') !== false ? 'active' : ''; ?>" data-tooltip="Customers">
                <i data-lucide="users"></i>
                <span>Customers</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/refunds" class="<?= strpos($uri, '/admin/refunds') !== false ? 'active' : ''; ?>" data-tooltip="Refunds">
                <i data-lucide="undo-2"></i>
                <span>Refunds</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-nav-header">Storefront</div>
    <ul class="sidebar-menu">
        <li>
            <a href="<?= BASE_URL ?>/admin/pages" class="<?= strpos($uri, '/admin/pages') !== false ? 'active' : ''; ?>" data-tooltip="Pages">
                <i data-lucide="layout"></i>
                <span>Pages</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/menus" class="<?= strpos($uri, '/admin/menus') !== false ? 'active' : ''; ?>" data-tooltip="Navigation">
                <i data-lucide="menu"></i>
                <span>Navigation</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/theme" class="<?= strpos($uri, '/admin/theme') !== false ? 'active' : ''; ?>" data-tooltip="Theme Sections">
                <i data-lucide="palette"></i>
                <span>Theme Sections</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/media" class="<?= strpos($uri, '/admin/media') !== false ? 'active' : ''; ?>" data-tooltip="Media Gallery">
                <i data-lucide="image"></i>
                <span>Media Gallery</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-nav-header">Marketing</div>
    <ul class="sidebar-menu">
        <li>
            <a href="<?= BASE_URL ?>/admin/blogs" class="<?= strpos($uri, '/admin/blogs') !== false ? 'active' : ''; ?>" data-tooltip="Blogs">
                <i data-lucide="file-text"></i>
                <span>Blogs</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/blog-categories" class="<?= strpos($uri, '/admin/blog-categories') !== false ? 'active' : ''; ?>" data-tooltip="Blog Categories">
                <i data-lucide="hash"></i>
                <span>Blog Categories</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/coupons" class="<?= strpos($uri, '/admin/coupons') !== false ? 'active' : ''; ?>" data-tooltip="Coupons">
                <i data-lucide="ticket"></i>
                <span>Coupons</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/reviews" class="<?= strpos($uri, '/admin/reviews') !== false ? 'active' : ''; ?>" data-tooltip="Reviews">
                <i data-lucide="star"></i>
                <span>Reviews</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/admin/messages" class="<?= strpos($uri, '/admin/messages') !== false ? 'active' : ''; ?>" data-tooltip="Messages">
                <i data-lucide="message-square"></i>
                <span>Messages</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-nav-header">System</div>
    <ul class="sidebar-menu">
        <li>
            <a href="<?= BASE_URL ?>/admin/settings" class="<?= strpos($uri, '/admin/settings') !== false ? 'active' : ''; ?>" data-tooltip="Settings">
                <i data-lucide="settings"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>

    <script>
        // Submenu Toggle
        document.querySelectorAll('.submenu-toggle').forEach(toggle => {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                const parent = this.parentElement;
                parent.classList.toggle('open');

                document.querySelectorAll('.has-submenu').forEach(item => {
                    if (item !== parent) item.classList.remove('open');
                });
            });
        });

        // Collapsed Sidebar Tooltips (JS powered to avoid overflow clipping)
        const sidebarLinks = document.querySelectorAll('.sidebar-menu a[data-tooltip]');
        const tooltipEl = document.createElement('div');
        tooltipEl.className = 'sidebar-js-tooltip';
        document.body.appendChild(tooltipEl);

        sidebarLinks.forEach(link => {
            link.addEventListener('mouseenter', function() {
                if (document.body.classList.contains('collapsed-sidebar')) {
                    const rect = this.getBoundingClientRect();
                    tooltipEl.innerText = this.getAttribute('data-tooltip');
                    tooltipEl.style.top = (rect.top + rect.height / 2) + 'px';
                    tooltipEl.style.left = (rect.right + 10) + 'px';
                    tooltipEl.classList.add('show');
                }
            });

            link.addEventListener('mouseleave', function() {
                tooltipEl.classList.remove('show');
            });
        });
    </script>

</aside>