<?php 
$pageTitle = "Edit Menu | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<style>
    /* Menu Builder UI Fixes */
    .modal-container {
        position: fixed !important;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.6);
        display: none; /* JS will set to flex */
        align-items: center; justify-content: center;
        z-index: 9999 !important;
        backdrop-filter: blur(8px);
    }
    .modal-content {
        background: white; border-radius: 16px;
        width: 100%; max-width: 500px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        animation: modalSlideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
    }
    @keyframes modalSlideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .modal-header {
        padding: 24px; border-bottom: 1px solid #f1f5f9;
        display: flex; justify-content: space-between; align-items: center;
    }
    .modal-header h2 { font-size: 20px; font-weight: 700; color: #1e293b; margin: 0; }
    .close-modal { 
        background: #f1f5f9; border: none; border-radius: 50%; 
        width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: #64748b; transition: all 0.2s;
    }
    .close-modal:hover { background: #e2e8f0; color: #0f172a; }
    
    .modal-form-body { padding: 24px; }
    .modal-footer {
        padding: 20px 24px; background: #f8fafc;
        border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 12px;
    }

    .menu-item-row {
        background: white; border: 1px solid #e2e8f0;
        border-radius: 12px; padding: 14px 18px;
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 12px; cursor: default; transition: all 0.2s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .menu-item-row:hover { border-color: #e16449; box-shadow: 0 4px 12px rgba(225,100,73,0.08); }
    
    .menu-tree-list { list-style: none; padding: 0; margin: 0; min-height: 5px; }
    .menu-tree-list .menu-tree-list {
        margin-left: 44px; margin-top: 10px;
        border-left: 2px dashed #cbd5e1; padding-left: 20px;
        position: relative;
    }
    .menu-tree-list .menu-tree-list::before {
        content: ''; position: absolute; top: 20px; left: 0; width: 15px; height: 2px;
        background: #cbd5e1;
    }

    .drag-handle { cursor: move; color: #94a3b8; padding: 5px; border-radius: 4px; }
    .drag-handle:hover { background: #f1f5f9; color: #1e293b; }
    
    .empty-menu-placeholder {
        text-align: center; padding: 60px 20px;
        border: 2px dashed #e2e8f0; border-radius: 16px; color: #64748b;
        background: #fcfcfc;
    }

    /* Search Results Dropdown */
    .search-results-dropdown {
        position: absolute; width: 100%; max-height: 220px;
        background: white; border: 1px solid #cbd5e1; border-radius: 12px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        z-index: 9999; overflow-y: auto; display: none;
        margin-top: 5px;
    }
    .search-result-item {
        padding: 12px 16px; cursor: pointer; transition: all 0.2s;
        display: flex; align-items: center; gap: 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: #334155;
    }
    .search-result-item i { color: #94a3b8; }
    .search-result-item:last-child { border-bottom: none; }
    .search-result-item:hover { background: #f8fafc; color: #e16449; }
    .search-result-item:hover i { color: #e16449; }
</style>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/menus" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0"><?= htmlspecialchars($menu['name']) ?></h1>
    </div>
    <div class="header-actions">
        <button type="button" class="btn btn-primary" id="saveMenuBtn">Save Menu</button>
    </div>
</div>

<div class="form-layout">
    <div class="form-main">
        <div class="card">
            <h3 class="card-title-sm mb-10">Menu Items</h3>
            <p class="text-muted-sm mb-20">Drag and drop items to reorder or nest them. You can add up to 3 levels of nesting.</p>
            
            <div id="menuItemsContainer" class="menu-items-builder mt-20">
                <!-- Nested Sortable List will be rendered here -->
                <?php if (empty($items)): ?>
                <div class="empty-menu-placeholder">
                    <i data-lucide="list" class="icon-lg text-muted opacity-2"></i>
                    <p>This menu is empty. Add your first item below.</p>
                </div>
                <?php endif; ?>
            </div>

            <button type="button" class="btn btn-outline btn-sm mt-20" id="addMenuItemBtn">
                <i data-lucide="plus" class="icon-xs"></i> Add Menu Item
            </button>
        </div>
    </div>

    <div class="form-sidebar">
        <div class="card">
            <h3 class="card-title-sm mb-15">Menu Settings</h3>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="menu_name" class="modal-field-input" value="<?= htmlspecialchars($menu['name']) ?>">
            </div>
            <div class="form-group mb-0">
                <label>Handle / Location</label>
                <input type="text" class="modal-field-input" value="<?= htmlspecialchars($menu['location']) ?>" disabled>
                <p class="text-muted-sm mt-5">The location handle is used in the theme code to display this menu.</p>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Menu Item Modal -->
<div id="menuItemModal" class="modal-container" style="display: none;">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h2 id="modalTitle">Add Menu Item</h2>
            <button type="button" class="close-modal" id="closeMenuItemModal"><i data-lucide="x"></i></button>
        </div>
        <form id="menuItemForm">
            <div class="modal-form-body">
                <input type="hidden" id="edit_item_id">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" id="item_title" class="modal-field-input" placeholder="e.g. Disposables" required>
                </div>
                <div class="form-group">
                    <label>Link Type</label>
                    <select id="item_link_type" class="modal-field-input">
                        <option value="collection">Collection</option>
                        <option value="brand">Brand</option>
                        <option value="page">Page</option>
                        <option value="custom_url">Custom URL</option>
                        <option value="no_link">No Link (Text Only)</option>
                        <option value="mega_menu_column">Mega Menu Heading (Column)</option>
                        <option value="promo_banner">Promo Banner</option>
                    </select>
                </div>
                <div id="linkValueContainer" class="form-group" style="position: relative;">
                    <label id="linkValueLabel">Select Collection</label>
                    <div id="linkSelectorContainer">
                        <input type="text" id="item_link_value" class="modal-field-input" placeholder="Type to search or paste URL">
                        <div id="searchResults" class="search-results-dropdown"></div>
                    </div>
                </div>
                
                <div id="promoFields" style="display: none;">
                    <div class="form-group">
                        <label>Image URL</label>
                        <input type="text" id="item_image_url" class="modal-field-input" placeholder="assets/img/promo.jpg">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline" id="cancelMenuItemBtn">Cancel</button>
                <button type="submit" class="btn btn-primary" id="saveItemBtn">Add Item</button>
            </div>
        </form>
    </div>
</div>

<script>
    window.BASE_URL = '<?= BASE_URL ?>';
    window.menuId = <?= $menu['id'] ?>;
    window.initialMenuItems = <?= json_encode($items) ?>;
</script>
<script src="<?= BASE_URL ?>/admin_assets/js/menu-builder.js"></script>

<?php include __DIR__ . '/partials/footer.php'; ?>
