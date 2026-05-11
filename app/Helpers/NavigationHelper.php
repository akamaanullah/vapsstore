<?php
namespace App\Helpers;

use App\Models\Menu;
use App\Models\MenuItem;

class NavigationHelper {
    
    /**
     * Get menu tree by location handle
     */
    public static function getMenuTree($location) {
        $menuModel = new Menu();
        $menuItemModel = new MenuItem();
        
        $menu = $menuModel->getByLocation($location);
        return $menu ? $menuItemModel->getTree($menu['id']) : [];
    }

    /**
     * Render a menu item recursively for the storefront header
     */
    public static function renderHeaderMenu($item) {
        $hasChildren = !empty($item['children']);
        $isMega = false;
        
        if ($hasChildren) {
            foreach ($item['children'] as $child) {
                if ($child['link_type'] === 'mega_menu_column' || $child['link_type'] === 'promo_banner' || !empty($child['children'])) {
                    $isMega = true;
                    break;
                }
            }
        }

        $liClass = 'nav-item' . ($hasChildren ? ($isMega ? ' has-mega' : ' has-dropdown') : '');
        $linkUrl = !empty($item['link_value']) ? (strpos($item['link_value'], 'http') === 0 ? $item['link_value'] : BASE_URL . $item['link_value']) : '#';
        
        echo '<li class="' . $liClass . '">';
        echo '    <a href="' . $linkUrl . '" class="nav-link">';
        echo '        ' . htmlspecialchars($item['title']);
        if ($hasChildren) {
            echo ' <i data-lucide="chevron-down"></i>';
        }
        echo '    </a>';
        
        if ($hasChildren) {
            if ($isMega) {
                echo '<div class="mega-menu">';
                echo '    <div class="mega-grid">';
                foreach ($item['children'] as $child) {
                    // Render as a column if it's a mega_menu_column OR just a regular item with children (fallback)
                    if ($child['link_type'] === 'mega_menu_column' || (!empty($child['children']) && $child['link_type'] !== 'promo_banner')) {
                        echo '<div class="mega-col">';
                        echo '    <h4>' . htmlspecialchars($child['title']) . '</h4>';
                        if (!empty($child['children'])) {
                            echo '<ul>';
                            foreach ($child['children'] as $grandChild) {
                                $gcUrl = !empty($grandChild['link_value']) ? (strpos($grandChild['link_value'], 'http') === 0 ? $grandChild['link_value'] : BASE_URL . $grandChild['link_value']) : '#';
                                echo '<li><a href="' . $gcUrl . '">' . htmlspecialchars($grandChild['title']) . '</a></li>';
                            }
                            echo '</ul>';
                        }
                        echo '</div>';
                    } elseif ($child['link_type'] === 'promo_banner') {
                        echo '<div class="mega-col">';
                        echo '    <div class="mega-promo">';
                        if (!empty($child['image_url'])) {
                            $imgSrc = (strpos($child['image_url'], 'http') === 0) ? $child['image_url'] : BASE_URL . '/' . $child['image_url'];
                            echo '        <img src="' . $imgSrc . '" alt="Promo">';
                        }
                        echo '        <h5>' . htmlspecialchars($child['title']) . '</h5>';
                        // Use link_value for the button URL instead of showing it as text
                        $promoUrl = !empty($child['link_value']) ? (strpos($child['link_value'], 'http') === 0 ? $child['link_value'] : BASE_URL . $child['link_value']) : '#';
                        echo '        <a href="' . $promoUrl . '" class="btn-mega">Shop Now</a>';
                        echo '    </div>';
                        echo '</div>';
                    }
                }
                echo '    </div>';
                echo '</div>';
            } else {
                echo '<ul class="dropdown-menu">';
                foreach ($item['children'] as $child) {
                    $childUrl = !empty($child['link_value']) ? (strpos($child['link_value'], 'http') === 0 ? $child['link_value'] : BASE_URL . $child['link_value']) : '#';
                    echo '<li><a href="' . $childUrl . '">' . htmlspecialchars($child['title']) . '</a></li>';
                }
                echo '</ul>';
            }
        }
        echo '</li>';
    }

    /**
     * Render a footer menu column
     */
    public static function renderFooterColumn($location, $defaultTitle = 'Quick Links') {
        $items = self::getMenuTree($location);
        if (empty($items)) return;

        echo '<div class="link-col">';
        echo '    <h4>' . htmlspecialchars($defaultTitle) . '</h4>';
        echo '    <ul>';
        foreach ($items as $item) {
            $url = !empty($item['link_value']) ? (strpos($item['link_value'], 'http') === 0 ? $item['link_value'] : BASE_URL . $item['link_value']) : '#';
            echo '<li><a href="' . $url . '">' . htmlspecialchars($item['title']) . '</a></li>';
        }
        echo '    </ul>';
        echo '</div>';
    }

    /**
     * Render the entire footer dynamically from a menu structure
     */
    public static function renderDynamicFooter($location = 'footer_main') {
        $menuItems = self::getMenuTree($location);
        if (empty($menuItems)) return;

        foreach ($menuItems as $item) {
            $type = $item['link_type'];

            if ($type === 'text_block') {
                // Render as Warning Section or Info Block
                echo '<div class="footer-warning-section mb-40">';
                echo '    <h1 class="footer-large-title mb-20">' . $item['title'] . '</h1>';
                echo '    <div class="footer-description text-14 text-muted">';
                echo        $item['link_value']; // This is the HTML content from Quill
                echo '    </div>';
                echo '</div>';
            } 
            elseif ($type === 'promo_banner') {
                // Render as Branding Card (Right Side)
                $imgSrc = (strpos($item['image_url'], 'http') === 0) ? $item['image_url'] : BASE_URL . '/' . $item['image_url'];
                echo '<div class="footer-branding-card">';
                echo '    <img src="' . $imgSrc . '" alt="' . htmlspecialchars($item['title']) . '" class="footer-brand-img">';
                echo '</div>';
            }
            elseif (!empty($item['children'])) {
                // Render as a Navigation Column
                echo '<div class="link-col">';
                echo '    <h4>' . htmlspecialchars($item['title']) . '</h4>';
                echo '    <ul>';
                foreach ($item['children'] as $child) {
                    $url = !empty($child['link_value']) ? (strpos($child['link_value'], 'http') === 0 ? $child['link_value'] : BASE_URL . $child['link_value']) : '#';
                    echo '<li><a href="' . $url . '">' . htmlspecialchars($child['title']) . '</a></li>';
                }
                echo '    </ul>';
                echo '</div>';
            }
            elseif ($type === 'html' || $type === 'newsletter') {
                // Render raw content or custom blocks
                echo '<div class="link-col">';
                if (!empty($item['title'])) echo '<h4>' . htmlspecialchars($item['title']) . '</h4>';
                echo $item['link_value'];
                echo '</div>';
            }
        }
    }
}
