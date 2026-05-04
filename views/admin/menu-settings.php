<?php 
$pageTitle = "Menu Settings | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/menus" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Menu Settings</h1>
    </div>
</div>

<div class="form-layout">
    <div class="form-main">
        <div class="card">
            <div class="form-group">
                <label>Menu Name</label>
                <input type="text" class="modal-field-input" value="Main Menu">
            </div>
            <div class="form-group mb-0">
                <label>Menu Handle (Slug)</label>
                <input type="text" class="modal-field-input" value="main-menu" disabled>
                <p class="text-muted-xs mt-5">The handle is used to reference this menu in liquid/code.</p>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <div class="card">
            <h3 class="card-title-sm mb-15">Menu Location</h3>
            <div class="form-group">
                <label><input type="checkbox" checked> Header Navigation</label>
            </div>
            <div class="form-group">
                <label><input type="checkbox"> Footer Column 1</label>
            </div>
            <div class="form-group mb-0">
                <label><input type="checkbox"> Mobile Sidebar</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions-bar">
    <div class="actions-left">
        <a href="<?= BASE_URL ?>/admin/menus" class="btn-outline" style="text-decoration: none;">Discard</a>
    </div>
    <div class="actions-right">
        <button class="btn btn-primary">Save Settings</button>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
