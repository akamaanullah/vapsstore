<?php 
$pageTitle = "Create Discount | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/admin_assets/css/coupons.css">

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/coupons" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Create Discount</h1>
    </div>
</div>

<form action="<?= BASE_URL ?>/admin/coupons/store" method="POST">
    <?= $this->csrf_field() ?>
    <div class="form-layout">
        <div class="form-main">
            <!-- Amount Section -->
            <div class="card mb-20">
                <div class="card-header border-0 pb-0">
                    <h3 class="card-title-sm">General Information</h3>
                </div>
                <div class="card-body">
                    <div class="form-group mb-20">
                        <label class="form-label fw-600 mb-8">Discount Code</label>
                        <div class="input-group-modern">
                            <input type="text" name="code" id="couponCode" class="modal-field-input" placeholder="e.g. SUMMER20" required style="text-transform: uppercase;">
                            <button type="button" class="btn btn-light btn-sm" onclick="generateCode()">Generate</button>
                        </div>
                        <p class="fs-12 text-muted mt-8">Customers will enter this code at checkout.</p>
                    </div>

                    <div class="info-grid-2">
                        <div class="form-group">
                            <label class="form-label fw-600 mb-8">Type</label>
                            <select name="discount_type" id="discountType" class="modal-field-input custom-select">
                                <option value="percentage">Percentage</option>
                                <option value="fixed_amount">Fixed Amount</option>
                                <option value="free_shipping">Free Shipping</option>
                            </select>
                        </div>
                        <div class="form-group" id="valueGroup">
                            <label class="form-label fw-600 mb-8" id="valueLabel">Value</label>
                            <div class="input-prefix-wrapper">
                                <span class="input-prefix" id="valueSymbol">%</span>
                                <input type="number" name="discount_value" id="discountValue" class="modal-field-input" placeholder="10" step="0.01">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Minimum Requirements Section -->
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h3 class="card-title-sm">Minimum Requirements</h3>
                </div>
                <div class="card-body">
                    <div class="requirement-options">
                        <label class="custom-radio-card mb-12">
                            <input type="radio" name="min_req_type" value="none" checked onchange="toggleMinAmount()">
                            <span class="radio-card-content">
                                <span class="radio-bullet"></span>
                                <span class="radio-label">None</span>
                            </span>
                        </label>
                        
                        <label class="custom-radio-card">
                            <input type="radio" name="min_req_type" value="amount" onchange="toggleMinAmount()">
                            <span class="radio-card-content">
                                <span class="radio-bullet"></span>
                                <span class="radio-label">Minimum purchase amount ($)</span>
                            </span>
                        </label>

                        <div id="minAmountGroup" class="mt-15" style="display: none; padding-left: 32px;">
                            <div class="input-prefix-wrapper" style="max-width: 200px;">
                                <span class="input-prefix">$</span>
                                <input type="number" name="min_order_amount" class="modal-field-input" placeholder="0.00" step="0.01">
                            </div>
                            <p class="fs-12 text-muted mt-8">Applies only to selected products or collections.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Limits Section -->
            <div class="card mt-20">
                <div class="card-header border-0 pb-0">
                    <h3 class="card-title-sm">Usage Limits</h3>
                </div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label class="custom-checkbox-item">
                            <input type="checkbox" onchange="toggleMaxUses(this)">
                            <span class="checkbox-label">Limit number of times this discount can be used in total</span>
                        </label>
                        <div id="maxUsesGroup" class="mt-12" style="display: none; padding-left: 28px;">
                            <input type="number" name="max_uses" class="modal-field-input" style="max-width: 150px;" placeholder="e.g. 100">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-sidebar">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h3 class="card-title-sm">Active Dates</h3>
                </div>
                <div class="card-body">
                    <div class="form-group mb-20">
                        <label class="form-label fw-600 mb-8">Start date</label>
                        <input type="date" name="start_date" class="modal-field-input" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label fw-600 mb-8">End date (Optional)</label>
                        <input type="date" name="end_date" class="modal-field-input">
                    </div>
                </div>
            </div>

            <div class="card mt-20">
                <div class="card-header border-0 pb-0">
                    <h3 class="card-title-sm">Status</h3>
                </div>
                <div class="card-body">
                    <select name="is_active" class="modal-field-input custom-select">
                        <option value="1">Active</option>
                        <option value="0">Draft / Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions-bar mt-30">
        <div class="actions-left">
            <a href="<?= BASE_URL ?>/admin/coupons" class="btn btn-light" style="text-decoration: none;">Discard</a>
        </div>
        <div class="actions-right">
            <button type="submit" class="btn btn-primary" style="padding: 0 30px; background: #6f6af8; border: none;">Save Discount</button>
        </div>
    </div>
</form>

<script src="<?= BASE_URL ?>/admin_assets/js/coupons.js"></script>

<?php include __DIR__ . '/partials/footer.php'; ?>
