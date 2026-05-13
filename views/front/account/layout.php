<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<main class="account-page section-padding">
    <div class="container">
        <div class="account-container">
            <!-- Sidebar Navigation -->
            <aside class="account-sidebar">
                <div class="user-profile-brief">
                    <div class="user-avatar">
                        <i data-lucide="user"></i>
                    </div>
                    <div class="user-info">
                        <h3><?= htmlspecialchars(\App\Core\Session::get('user_name')) ?></h3>
                        <p><?= htmlspecialchars(\App\Core\Session::get('user_email')) ?></p>
                    </div>
                </div>

                <nav class="account-nav">
                    <a href="<?= BASE_URL ?>/account" class="account-nav-link <?= ($activeTab === 'dashboard') ? 'active' : '' ?>">
                        <i data-lucide="layout-dashboard"></i> Dashboard
                    </a>
                    <a href="<?= BASE_URL ?>/account/orders" class="account-nav-link <?= ($activeTab === 'orders') ? 'active' : '' ?>">
                        <i data-lucide="package"></i> My Orders
                    </a>
                    <a href="<?= BASE_URL ?>/account/profile" class="account-nav-link <?= ($activeTab === 'profile') ? 'active' : '' ?>">
                        <i data-lucide="settings"></i> Profile Settings
                    </a>
                    <a href="<?= BASE_URL ?>/account/addresses" class="account-nav-link <?= ($activeTab === 'addresses') ? 'active' : '' ?>">
                        <i data-lucide="map"></i> Manage Addresses
                    </a>
                    <a href="<?= BASE_URL ?>/track-order" class="account-nav-link">
                        <i data-lucide="map-pin"></i> Track My Order
                    </a>
                    <div class="nav-divider"></div>
                    <a href="<?= BASE_URL ?>/logout" class="account-nav-link logout-btn">
                        <i data-lucide="log-out"></i> Logout
                    </a>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <section class="account-content">
                <div class="account-card">
                    <?php echo $content; ?>
                </div>
            </section>
        </div>
    </div>
</main>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>
