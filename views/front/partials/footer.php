<?php 
use App\Helpers\UIHelper;
use App\Helpers\NavigationHelper;

$settings = UIHelper::getSettings();
$footerMenu = NavigationHelper::getMenuTree('footer_menu');

// Helper to get setting value safely with fallback
$s = function($key, $default = '') use ($settings) {
    return !empty($settings[$key]) ? htmlspecialchars($settings[$key]) : $default;
};
?>
<footer class="footer">
    <div class="container">
        <div class="footer-main-grid">
            <!-- Left Content -->
            <div class="footer-content-left">
                <?php if (!empty($footerMenu)): ?>
                    <?php 
                    $hasLinks = false;
                    foreach ($footerMenu as $item) {
                        if ($item['link_type'] === 'text_block') {
                            // Warning Section
                            echo '<div class="footer-warning-section mb-40">';
                            echo '    <h1 class="footer-large-title mb-20">' . $item['title'] . '</h1>';
                            echo '    <div class="footer-description text-14 text-muted">' . $item['link_value'] . '</div>';
                            echo '</div>';
                        } elseif ($item['link_type'] !== 'promo_banner') {
                            $hasLinks = true;
                        }
                    }
                    
                    if ($hasLinks): ?>
                    <div class="footer-links-grid mb-40">
                        <?php 
                        foreach ($footerMenu as $item) {
                            if ($item['link_type'] !== 'text_block' && $item['link_type'] !== 'promo_banner') {
                                if (!empty($item['children'])) {
                                    echo '<div class="link-col">';
                                    echo '    <h4>' . htmlspecialchars($item['title']) . '</h4>';
                                    echo '    <ul>';
                                    foreach ($item['children'] as $child) {
                                        $url = !empty($child['link_value']) ? (strpos($child['link_value'], 'http') === 0 ? $child['link_value'] : BASE_URL . $child['link_value']) : '#';
                                        echo '<li><a href="' . $url . '">' . htmlspecialchars($child['title']) . '</a></li>';
                                    }
                                    echo '    </ul>';
                                    echo '</div>';
                                } else {
                                    // Single column item without children
                                    echo '<div class="link-col">';
                                    if ($item['link_type'] !== 'no_link') {
                                        $url = !empty($item['link_value']) ? (strpos($item['link_value'], 'http') === 0 ? $item['link_value'] : BASE_URL . $item['link_value']) : '#';
                                        echo '    <h4><a href="' . $url . '">' . htmlspecialchars($item['title']) . '</a></h4>';
                                    } else {
                                        echo '    <h4>' . htmlspecialchars($item['title']) . '</h4>';
                                    }
                                    if ($item['link_type'] === 'html') echo $item['link_value'];
                                    echo '</div>';
                                }
                            }
                        }
                        ?>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="footer-bottom-bar">
                    <p class="text-12 text-muted mb-15"><?= $s('footer_copyright', '© 2025 The Perfect Vape. All Rights Reserved. | Designed, Developed & Managed By Antigravity') ?></p>
                    <div class="payment-methods">
                        <?php 
                        for($i=1; $i<=8; $i++) {
                            $key = "payment_logo_$i";
                            $val = $settings[$key] ?? '';
                            if (empty($val)) continue;
                            
                            $imgSrc = (strpos($val, 'http') === 0) ? $val : BASE_URL . '/' . $val;
                            echo '<img src="' . $imgSrc . '" alt="Payment">';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Right Branding Image -->
            <div class="footer-content-right">
                <?php 
                foreach ($footerMenu as $item) {
                    if ($item['link_type'] === 'promo_banner') {
                        $imgSrc = (strpos($item['image_url'], 'http') === 0) ? $item['image_url'] : BASE_URL . '/' . $item['image_url'];
                        echo '<div class="footer-branding-card">';
                        echo '    <img src="' . $imgSrc . '" alt="' . htmlspecialchars($item['title']) . '" class="footer-brand-img">';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script src="<?= BASE_URL ?>/js/cart.js"></script>
<script src="<?= BASE_URL ?>/js/main.js"></script>
</body>

</html>