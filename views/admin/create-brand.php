<?php 
$pageTitle = "Add Brand | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/brands" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Add Brand</h1>
    </div>
</div>

<div class="form-layout">
    <div class="form-main">
        <div class="card">
            <div class="form-group">
                <label>Brand Name</label>
                <input type="text" class="modal-field-input" placeholder="e.g. GeekVape">
            </div>
            <div class="form-group mb-0">
                <label>URL Slug</label>
                <input type="text" class="modal-field-input" placeholder="geekvape">
            </div>
        </div>

        <div class="card">
            <h3 class="card-title-sm mb-15">Brand Logo</h3>
            <div class="media-upload-area">
                <div class="media-placeholder">
                    <i data-lucide="upload-cloud" class="icon-lg text-muted"></i>
                    <p class="mt-10 mb-5 fw-600">Click to upload logo</p>
                    <button class="btn btn-outline btn-sm mt-15">Add Media</button>
                </div>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <div class="card">
            <h3 class="card-title-sm mb-10">Status</h3>
            <select class="modal-field-input">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="form-actions-bar">
    <div class="actions-left">
        <a href="<?= BASE_URL ?>/admin/brands" class="btn-outline" style="text-decoration: none;">Discard</a>
    </div>
    <div class="actions-right">
        <button class="btn btn-primary">Save Brand</button>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
