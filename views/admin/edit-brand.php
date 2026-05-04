<?php 
$pageTitle = "Edit Brand | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/brands" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Edit Brand: GeekVape</h1>
    </div>
</div>

<div class="form-layout">
    <div class="form-main">
        <div class="card">
            <div class="form-group">
                <label>Brand Name</label>
                <input type="text" class="modal-field-input" value="GeekVape">
            </div>
            <div class="form-group mb-0">
                <label>URL Slug</label>
                <input type="text" class="modal-field-input" value="geekvape">
            </div>
        </div>

        <div class="card">
            <h3 class="card-title-sm mb-15">Brand Logo</h3>
            <div class="media-upload-area">
                <div class="media-preview" style="display: flex; flex-direction: column; align-items: center;">
                    <div style="width: 120px; height: 120px; background: #f8fafc; border: 1px solid var(--border-color); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                         <i data-lucide="image" class="text-muted" style="width: 40px;"></i>
                    </div>
                    <button class="btn btn-outline btn-sm">Change Logo</button>
                </div>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <div class="card">
            <h3 class="card-title-sm mb-10">Status</h3>
            <select class="modal-field-input">
                <option value="active" selected>Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="form-actions-bar">
    <div class="actions-left">
        <button class="btn-outline text-danger">Delete Brand</button>
    </div>
    <div class="actions-right">
        <a href="<?= BASE_URL ?>/admin/brands" class="btn-outline" style="text-decoration: none;">Cancel</a>
        <button class="btn btn-primary">Update Brand</button>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
