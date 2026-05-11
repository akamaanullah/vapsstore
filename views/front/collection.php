<?php 
require VIEW_DIR . '/front/partials/header.php'; 
?>

<main class="collection-page" data-collection-id="<?= $collection ? $collection['id'] : '' ?>">
    <!-- SEO Breadcrumb Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "<?= BASE_URL ?>/"
      },
      <?php if ($collection): ?>
      {
        "@type": "ListItem",
        "position": 2,
        "name": "All Products",
        "item": "<?= BASE_URL ?>/collection"
      }, {
        "@type": "ListItem",
        "position": 3,
        "name": "<?= htmlspecialchars($collection['name']) ?>",
        "item": "<?= BASE_URL ?>/collection/<?= $collection['custom_url_path'] ?>"
      }
      <?php else: ?>
      {
        "@type": "ListItem",
        "position": 2,
        "name": "All Products",
        "item": "<?= BASE_URL ?>/collection"
      }
      <?php endif; ?>
      ]
    }
    </script>

    <div class="container">
        <!-- Collection Header / Breadcrumbs -->
        <nav class="breadcrumb">
            <a href="<?= BASE_URL ?>/">Home</a> / 
            <?php if ($collection): ?>
                <a href="<?= BASE_URL ?>/collection">All Products</a> / <span><?= htmlspecialchars($collection['name']) ?></span>
            <?php else: ?>
                <span>All Products</span>
            <?php endif; ?>
        </nav>

        <!-- Collection Header -->
        <header class="collection-header">
            <h1 class="collection-title"><?= $collection ? htmlspecialchars($collection['name']) : 'Premium Vape Collection' ?></h1>
            <p class="collection-description">
                <?= $collection ? htmlspecialchars($collection['meta_desc'] ?? '') : 'Explore our curated selection of high-end vaping devices, artisan e-liquids, and essential accessories.' ?>
            </p>
        </header>

        <div class="collection-layout">
            <!-- Left Sidebar (Filters) -->
            <aside class="collection-sidebar" id="collectionSidebar">
                <div class="sidebar-main-title">
                    <h2>Filter By</h2>
                    <button class="close-sidebar" id="closeFilters">&times;</button>
                </div>

                <!-- Categories -->
                <div class="filter-widget active">
                    <?php 
                    $displayCollections = $sidebarData['items'];
                    $sidebarTitle = $sidebarData['title'];
                    ?>
                    <h4 class="filter-title accordion-trigger">
                        <span><?= $sidebarTitle ?></span>
                        <i data-lucide="chevron-down"></i>
                    </h4>
                    <div class="filter-content">
                        <ul class="category-accordion">
                            <?php foreach ($displayCollections as $item): 
                                $subChildren = array_filter($allCollections, fn($c) => $c['parent_id'] == $item['id']);
                            ?>
                            <li class="<?= (!empty($subChildren)) ? 'has-children' : '' ?> <?= ($collection && $collection['id'] == $item['id']) ? 'active' : '' ?>">
                                <div class="accordion-item">
                                    <div class="cat-filter-group">
                                        <input type="checkbox" class="filter-checkbox" name="cat" id="cat-<?= $item['id'] ?>" value="<?= $item['id'] ?>" data-slug="<?= $item['custom_url_path'] ?>" <?= ($collection && $collection['id'] == $item['id']) ? 'checked' : '' ?>>
                                        <label for="cat-<?= $item['id'] ?>" class="cat-check-label"></label>
                                        <span class="cat-name-toggle"><?= htmlspecialchars($item['name']) ?></span>
                                    </div>
                                    <?php if (!empty($subChildren)): ?>
                                        <i data-lucide="chevron-down"></i>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($subChildren)): ?>
                                <ul class="sub-categories">
                                    <?php foreach ($subChildren as $subChild): ?>
                                    <li>
                                        <div class="cat-filter-group">
                                            <input type="checkbox" class="filter-checkbox" name="cat" id="cat-<?= $subChild['id'] ?>" value="<?= $subChild['id'] ?>" data-slug="<?= $subChild['custom_url_path'] ?>" <?= ($collection && $collection['id'] == $subChild['id']) ? 'checked' : '' ?>>
                                            <label for="cat-<?= $subChild['id'] ?>" class="cat-check-label"></label>
                                            <span class="cat-name"><?= htmlspecialchars($subChild['name']) ?></span>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- Price Range -->
                <div class="filter-widget active">
                    <h4 class="filter-title accordion-trigger">
                        <span>Price Range</span>
                        <i data-lucide="chevron-down"></i>
                    </h4>
                    <div class="filter-content">
                        <div class="price-slider-wrapper">
                            <input type="range" id="priceRange" min="0" max="500" value="500" step="10">
                            <div class="price-labels">
                                <span>£0</span>
                                <span id="priceValue">£0 - £500</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Brands -->
                <div class="filter-widget active">
                    <h4 class="filter-title accordion-trigger">
                        <span>Brands</span>
                        <i data-lucide="chevron-down"></i>
                    </h4>
                    <div class="filter-content">
                        <ul class="brand-list">
                            <?php foreach ($allBrands as $brand): ?>
                                <li>
                                    <div class="cat-filter-group">
                                        <input type="checkbox" class="filter-checkbox" name="brand" id="brand-<?= $brand['id'] ?>" value="<?= $brand['id'] ?>" data-slug="<?= $brand['slug'] ?? $brand['id'] ?>">
                                        <label for="brand-<?= $brand['id'] ?>" class="cat-check-label"></label>
                                        <span class="cat-name"><?= htmlspecialchars($brand['name']) ?></span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
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
                            <option value="newest">Newest</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="name-az">Name: A-Z</option>
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
                    <!-- Products will be loaded here via collection.js AJAX -->
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <?= \App\Helpers\ProductHelper::renderCard($product) ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-products">No products found in this collection.</div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper" id="pagination"></div>
            </div>
        </div>
    </div>
</main>

<!-- Dynamic Sections from Builder -->
<?php 
if (!empty($sections)) {
    foreach ($sections as $type => $sectionData) {
        foreach ($sectionData as $section) {
            $sectionFile = VIEW_DIR . '/front/partials/sections/' . $type . '.php';
            if (file_exists($sectionFile)) {
                include $sectionFile;
            }
        }
    }
}
?>

<script src="<?= BASE_URL ?>/js/collection.js"></script>

<?php require VIEW_DIR . '/front/partials/footer.php'; ?>