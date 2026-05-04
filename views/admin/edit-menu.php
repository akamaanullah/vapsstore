<?php 
$pageTitle = "Edit Menu Items | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/menus" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Edit Menu Items: Main Menu</h1>
    </div>
    <div class="header-actions">
        <button class="btn btn-primary">Save Menu</button>
    </div>
</div>

<div class="card">
    <div class="menu-builder-container">
        <div class="menu-item-row" style="display: flex; align-items: center; gap: 15px; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 10px; background: white;">
            <i data-lucide="grip-vertical" class="text-muted"></i>
            <span class="fw-600" style="flex-grow: 1;">Home</span>
            <span class="text-muted-sm">/</span>
            <button class="btn-action-icon"><i data-lucide="pencil"></i></button>
            <button class="btn-action-icon text-danger"><i data-lucide="trash-2"></i></button>
        </div>
        
        <div class="menu-item-row" style="display: flex; align-items: center; gap: 15px; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 10px; background: white;">
            <i data-lucide="grip-vertical" class="text-muted"></i>
            <span class="fw-600" style="flex-grow: 1;">Shop All</span>
            <span class="text-muted-sm">/collections/all</span>
            <button class="btn-action-icon"><i data-lucide="pencil"></i></button>
            <button class="btn-action-icon text-danger"><i data-lucide="trash-2"></i></button>
        </div>

        <div class="menu-item-row" style="display: flex; align-items: center; gap: 15px; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 10px; background: white; margin-left: 40px; border-left: 3px solid var(--primary-color);">
            <i data-lucide="grip-vertical" class="text-muted"></i>
            <span class="fw-600" style="flex-grow: 1;">Disposable Vapes</span>
            <span class="text-muted-sm">/collections/disposables</span>
            <button class="btn-action-icon"><i data-lucide="pencil"></i></button>
            <button class="btn-action-icon text-danger"><i data-lucide="trash-2"></i></button>
        </div>
    </div>
    
    <button class="btn btn-outline btn-block mt-20">
        <i data-lucide="plus"></i>
        <span>Add Menu Item</span>
    </button>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
