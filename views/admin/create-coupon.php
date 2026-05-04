<?php 
$pageTitle = "Create Discount | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/coupons" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Create Discount</h1>
    </div>
</div>

<div class="form-layout">
    <div class="form-main">
        <div class="card">
            <h3 class="card-title-sm mb-15">Amount</h3>
            <div class="form-group">
                <label>Discount Code</label>
                <div style="display: flex; gap: 10px;">
                    <input type="text" class="modal-field-input" placeholder="e.g. SUMMER20" style="flex-grow: 1;">
                    <button class="btn btn-outline btn-sm">Generate</button>
                </div>
            </div>
            <div class="info-grid-2">
                <div class="form-group">
                    <label>Type</label>
                    <select class="modal-field-input">
                        <option>Percentage</option>
                        <option>Fixed Amount</option>
                        <option>Free Shipping</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Value</label>
                    <input type="number" class="modal-field-input" placeholder="10">
                </div>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title-sm mb-15">Minimum Requirements</h3>
            <div class="form-group">
                <label><input type="radio" name="min_req" checked> None</label>
            </div>
            <div class="form-group">
                <label><input type="radio" name="min_req"> Minimum purchase amount ($)</label>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <div class="card">
            <h3 class="card-title-sm mb-10">Active Dates</h3>
            <div class="form-group">
                <label>Start date</label>
                <input type="date" class="modal-field-input">
            </div>
            <div class="form-group mb-0">
                <label>End date (Optional)</label>
                <input type="date" class="modal-field-input">
            </div>
        </div>
    </div>
</div>

<div class="form-actions-bar">
    <div class="actions-left">
        <a href="<?= BASE_URL ?>/admin/coupons" class="btn-outline" style="text-decoration: none;">Discard</a>
    </div>
    <div class="actions-right">
        <button class="btn btn-primary">Save Discount</button>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
