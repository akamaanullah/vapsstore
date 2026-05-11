<?php 
$pageTitle = "Homepage Settings | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<!-- Theme Editor Assets -->
<link rel="stylesheet" href="<?= BASE_URL ?>/admin_assets/css/theme-editor.css?v=1.1">

<div class="page-header-container">
    <div class="header-left">
        <h1 class="page-title">Homepage Settings</h1>
        <p class="text-muted-sm">Manage the content and images of your homepage sections.</p>
    </div>
    <div class="header-actions" style="display: flex; gap: 8px; flex-wrap: wrap; justify-content: flex-end;">
        <button class="btn btn-outline btn-sm add-section-btn" data-section-type="hero_slider" onclick="addNewSection('hero_slider')" title="Add Slider">
            <i data-lucide="image"></i>
            <span>+ Slider</span>
        </button>
        <button class="btn btn-outline btn-sm add-section-btn" data-section-type="promo_grid" onclick="addNewSection('promo_grid')" title="Add Banners">
            <i data-lucide="layout"></i>
            <span>+ Banners</span>
        </button>
        <button class="btn btn-outline btn-sm add-section-btn" data-section-type="feature_highlight" onclick="addNewSection('feature_highlight')" title="Add Highlight">
            <i data-lucide="star"></i>
            <span>+ Highlight</span>
        </button>
        <button class="btn btn-outline btn-sm add-section-btn" data-section-type="brand_story" onclick="addNewSection('brand_story')" title="Add Story">
            <i data-lucide="book-open"></i>
            <span>+ Story</span>
        </button>
        <button class="btn btn-outline btn-sm add-section-btn" data-section-type="collection_grid" onclick="addNewSection('collection_grid')" title="Add Collection">
            <i data-lucide="layers"></i>
            <span>+ Collection</span>
        </button>
        <button class="btn btn-outline btn-sm add-section-btn" data-section-type="faq" onclick="addNewSection('faq')" title="Add FAQ">
            <i data-lucide="help-circle"></i>
            <span>+ FAQ</span>
        </button>
        <button class="btn btn-outline btn-sm add-section-btn" data-section-type="brands_swiper" onclick="addNewSection('brands_swiper')" title="Add Brands">
            <i data-lucide="briefcase"></i>
            <span>+ Brands</span>
        </button>
        <button class="btn btn-outline btn-sm add-section-btn" data-section-type="testimonials" onclick="addNewSection('testimonials')" title="Add Testimonials">
            <i data-lucide="quote"></i>
            <span>+ Testimonials</span>
        </button>
        <button class="btn btn-outline btn-sm add-section-btn" data-section-type="categories_grid" onclick="addNewSection('categories_grid')" title="Add Categories">
            <i data-lucide="grid"></i>
            <span>+ Categories</span>
        </button>
        <button id="saveAllChanges" class="btn btn-primary btn-sm">
            <i data-lucide="save"></i>
            <span>Save All Changes</span>
        </button>
    </div>
</div>

<div class="homepage-sections-grid">
    <?php 
    $sectionIcons = [
        'hero_slider' => 'image',
        'promo_grid' => 'layout',
        'feature_highlight' => 'star',
        'brand_story' => 'book-open',
        'collection_grid' => 'layers',
        'faq' => 'help-circle',
        'brands_swiper' => 'briefcase',
        'testimonials' => 'quote',
        'categories_grid' => 'grid'
    ];
    $sectionNames = [
        'hero_slider' => 'Hero Slider',
        'promo_grid' => 'Promo Banners',
        'feature_highlight' => 'Feature Highlight',
        'brand_story' => 'Brand Story',
        'collection_grid' => 'Collection Showcase',
        'faq' => 'FAQ Section',
        'brands_swiper' => 'Brands Showcase',
        'testimonials' => 'Testimonials',
        'categories_grid' => 'Categories Grid'
    ];

    foreach ($sections as $section): 
        $icon = $sectionIcons[$section['type']] ?? 'box';
        $name = !empty($section['title']) ? $section['title'] : ($sectionNames[$section['type']] ?? ucfirst($section['type']));
    ?>
    <div class="section-card" data-id="<?php echo $section['id']; ?>" data-type="<?php echo $section['type']; ?>">
        <div class="section-card-header">
            <div class="section-icon">
                <i data-lucide="<?php echo $icon; ?>"></i>
            </div>
            <div class="section-info">
                <h3><?php echo htmlspecialchars($name); ?></h3>
                <span class="badge badge-outline"><?php echo count($section['items']); ?> Items</span>
            </div>
            <div class="section-card-controls">
                <button class="control-btn delete" onclick="deleteSection(<?php echo $section['id']; ?>)" title="Delete Section"><i data-lucide="trash-2"></i></button>
            </div>
        </div>
        <div class="section-card-actions">
            <button class="btn btn-outline btn-sm" onclick="editSection(<?php echo $section['id']; ?>)">
                <i data-lucide="edit-2"></i>
                <span>Manage Content</span>
            </button>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Product Picker UI (In-Page) -->
<div id="productPicker" class="product-picker-container" style="display: none;">
    <div class="picker-header">
        <div class="picker-header-left">
            <h2>Select Products</h2>
            <p>Pick products to add to your collection showcase.</p>
        </div>
        <div class="picker-header-actions">
            <select id="collectionFilter" class="modal-field-input" style="width: 200px;">
                <option value="">All Collections</option>
                <?php foreach ($collections as $col): ?>
                    <option value="<?= $col['id'] ?>"><?= $col['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <div class="search-input-wrapper">
                <i data-lucide="search"></i>
                <input type="text" id="productSearch" placeholder="Search products by name...">
            </div>
            <button class="btn btn-outline" id="closePickerBtn">Close Picker</button>
        </div>
    </div>
    
    <div class="picker-layout">
        <div class="picker-results-grid" id="pickerResults">
            <!-- Product cards will be injected here -->
        </div>
        
        <div class="picker-selection-drawer" id="selectionDrawer">
            <div class="drawer-header">
                <h3>Selected Products (<span id="selectedCount">0</span>)</h3>
                <button class="btn btn-primary btn-sm" id="confirmSelectionBtn">Done</button>
            </div>
            <div class="drawer-items" id="selectedItems">
                <!-- Selected items will be listed here -->
            </div>
        </div>
    </div>
</div>

<!-- Edit Section Modal -->
<div id="sectionModal" class="modal-container" style="display: none;">
    <div class="modal-content" style="max-width: 800px;">
        <div class="modal-header">
            <h2 id="modalTitle">Edit Section</h2>
            <button class="close-modal" onclick="closeSectionModal()"><i data-lucide="x"></i></button>
        </div>
        <div class="modal-body">
            <div class="form-group mb-20" id="sectionTitleGroup">
                <label>Section Heading (Display Title)</label>
                <input type="text" id="sectionTitleInput" class="modal-field-input" placeholder="e.g. Featured Products, New Arrivals...">
            </div>

            <div class="row mb-20" id="sectionButtonGroup" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <div class="form-group">
                        <label>Button Text (Optional)</label>
                        <input type="text" id="sectionButtonTextInput" class="modal-field-input" placeholder="e.g. View All, Shop Now">
                    </div>
                </div>
                <div style="flex: 1;">
                    <div class="form-group">
                        <label>Button URL (Optional)</label>
                        <input type="text" id="sectionButtonUrlInput" class="modal-field-input" placeholder="e.g. /collections/all">
                    </div>
                </div>
            </div>
            <div id="itemsContainer">
                <!-- Items will be injected here via theme-editor.js -->
            </div>
            <button id="addItemBtn" class="btn btn-outline btn-block mt-10">
                <i data-lucide="plus"></i>
                <span>Add New Item</span>
            </button>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeSectionModal()">Cancel</button>
            <button id="saveSectionBtn" class="btn btn-primary">Update Section</button>
        </div>
    </div>
</div>

<!-- Initialize Editor Data -->
<script>
    // Robustly determine the base URL for AJAX calls
    window.adminBaseUrl = window.location.origin + window.location.pathname.split('/admin')[0];
    window.homepageSections = <?php echo json_encode($sections); ?>;
</script>

<!-- Scripts -->
<script src="<?= BASE_URL ?>/admin_assets/js/theme-editor.js?v=1.0"></script>

<?php include __DIR__ . '/partials/footer.php'; ?>
