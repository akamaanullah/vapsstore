<?php 
$pageTitle = "Edit Discount | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/coupons" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Edit Discount: WELCOME10</h1>
    </div>
</div>

<div class="form-layout">
    <div class="form-main">
        <div class="card">
            <h3 class="card-title-sm mb-15">Amount</h3>
            <div class="form-group">
                <label>Discount Code</label>
                <input type="text" class="modal-field-input" value="WELCOME10">
            </div>
            <div class="info-grid-2">
                <div class="form-group">
                    <label>Type</label>
                    <select class="modal-field-input">
                        <option selected>Percentage</option>
                        <option>Fixed Amount</option>
                        <option>Free Shipping</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Value</label>
                    <input type="number" class="modal-field-input" value="10">
                </div>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <div class="card">
            <h3 class="card-title-sm mb-10">Status</h3>
            <span class="status-badge badge-active mb-10 d-inline-block">Active</span>
            <button class="btn btn-outline btn-sm btn-block">Deactivate</button>
        </div>
    </div>
</div>

<div class="form-actions-bar">
    <div class="actions-left">
        <button class="btn-outline text-danger">Delete Discount</button>
    </div>
    <div class="actions-right">
        <a href="<?= BASE_URL ?>/admin/coupons" class="btn-outline" style="text-decoration: none;">Cancel</a>
        <button class="btn btn-primary">Update Discount</button>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
