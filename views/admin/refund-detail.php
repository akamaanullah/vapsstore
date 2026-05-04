<?php 
$pageTitle = "Refund Detail | Vape Store Admin";
$pageScript = "refund-detail.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/refunds" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Refund REF-63-2362</h1>
        <span class="status-badge badge-draft ml-10">Pending</span>
    </div>
    <div class="header-actions">
        <button class="btn btn-outline">Cancel Refund</button>
        <button class="btn btn-primary">Process Refund</button>
    </div>
</div>

<div class="form-layout">
    <div class="form-main">
        <!-- Refund Items Selection -->
        <div class="card card-no-padding">
            <div class="card-header-padding">
                <h3 class="card-title-sm">Refund Items Selection</h3>
                <p class="text-muted-sm">Select items and quantities to refund from Order #ORD-1052</p>
            </div>
            <div class="table-responsive">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th class="th-product w-50"><input type="checkbox" checked></th>
                            <th class="th-product">Product</th>
                            <th class="th-default">Price</th>
                            <th class="th-default">Quantity</th>
                            <th class="th-default">Refund Qty</th>
                            <th class="th-default text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="td-product"><input type="checkbox" checked></td>
                            <td class="td-product">
                                <div class="product-info-flex">
                                    <img src="<?= BASE_URL ?>/admin_assets/image/placeholder.png" class="product-image" alt="">
                                    <div>
                                        <div class="product-name-txt">GeekVape L200 Classic</div>
                                        <div class="text-muted-sm">Color: Matte Black</div>
                                    </div>
                                </div>
                            </td>
                            <td class="td-default">$85.00</td>
                            <td class="td-default">1</td>
                            <td class="td-default">
                                <input type="number" class="modal-field-input w-70" value="1" min="0" max="1">
                            </td>
                            <td class="td-default text-right">$85.00</td>
                        </tr>
                        <tr>
                            <td class="td-product"><input type="checkbox" checked></td>
                            <td class="td-product">
                                <div class="product-info-flex">
                                    <img src="<?= BASE_URL ?>/admin_assets/image/placeholder.png" class="product-image" alt="">
                                    <div>
                                        <div class="product-name-txt">HorizonTech Sakerz Tank</div>
                                        <div class="text-muted-sm">Size: 5ml</div>
                                    </div>
                                </div>
                            </td>
                            <td class="td-default">$29.50</td>
                            <td class="td-default">2</td>
                            <td class="td-default">
                                <input type="number" class="modal-field-input w-70" value="1" min="0" max="2">
                            </td>
                            <td class="td-default text-right">$29.50</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Refund Reason & Admin Notes -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Refund Reason & Notes</h3>
            <div class="form-group mb-15">
                <label class="modal-field-label">Refund Reason</label>
                <select class="modal-field-input">
                    <option value="defective">Defective item</option>
                    <option value="wrong_product">Wrong product received</option>
                    <option value="customer_request">Customer request</option>
                    <option value="not_as_described">Not as described</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group mb-0">
                <label class="modal-field-label">Admin Notes (Internal only)</label>
                <textarea class="modal-field-input" rows="4" placeholder="Enter internal notes for staff..."></textarea>
            </div>
        </div>

        <!-- Refund Amount Adjustment -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Refund summary</h3>
            <div class="refund-summary-box">
                <div class="summary-row">
                    <span class="summary-label">Available to refund</span>
                    <span class="summary-value">$1,250.00</span>
                </div>
                <div class="summary-divider"></div>
                
                <div class="summary-row">
                    <span class="summary-label">Subtotal (2 items)</span>
                    <span class="summary-value">$114.50</span>
                </div>
                
                <div class="summary-row">
                    <span class="summary-label">Tax (8.5%)</span>
                    <div class="summary-input-group">
                        <span class="input-prefix">$</span>
                        <input type="number" class="summary-input" value="9.73" step="0.01">
                    </div>
                </div>
                
                <div class="summary-row">
                    <span class="summary-label">Shipping Refund</span>
                    <div class="summary-input-group">
                        <span class="input-prefix">$</span>
                        <input type="number" class="summary-input" value="5.00" step="0.01">
                    </div>
                </div>
                
                <div class="summary-row">
                    <span class="summary-label">Discount Reversal</span>
                    <div class="summary-input-group">
                        <span class="input-prefix">-$</span>
                        <input type="number" class="summary-input" value="3.73" step="0.01">
                    </div>
                </div>
                
                <div class="summary-total-row">
                    <div class="total-label-group">
                        <span class="total-title">Total Refund Amount</span>
                        <span class="total-subtitle">Refunded to customer's Visa **** 4242</span>
                    </div>
                    <span class="total-amount">$125.50</span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <!-- Refund Status & Transaction Details -->
        <div class="card">
            <h3 class="card-title-sm mb-10">Status & Transaction</h3>
            <div class="info-list">
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="status-badge badge-draft">Pending</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Requested:</span>
                    <span class="info-value">Jan 26, 2026 at 10:53 pm</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Transaction ID:</span>
                    <span class="info-value">#TXN-88273645</span>
                </div>
            </div>
        </div>

        <!-- Refund Type Toggle -->
        <div class="card">
            <h3 class="card-title-sm mb-10">Refund Type</h3>
            <div class="radio-group-vertical">
                <label class="radio-label">
                    <input type="radio" name="refund_type" value="full" checked>
                    <span>Full Refund</span>
                </label>
                <label class="radio-label">
                    <input type="radio" name="refund_type" value="partial">
                    <span>Partial Refund</span>
                </label>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="card">
            <h3 class="card-title-sm mb-10">Payment Method</h3>
            <div class="form-group mb-0">
                <select class="modal-field-input">
                    <option value="perfect_vape">Perfect Vape Payments</option>
                    <option value="paypal">PayPal</option>
                    <option value="stripe">Stripe</option>
                    <option value="manual">Manual Payment</option>
                </select>
                <p class="text-muted-sm mt-10">Original payment was via Perfect Vape Payments (Visa **** 4242)</p>
            </div>
        </div>

        <!-- Refund Options -->
        <div class="card">
            <h3 class="card-title-sm mb-10">Options</h3>
            <div class="checkbox-group-vertical">
                <label class="checkbox-label">
                    <input type="checkbox" checked>
                    <span>Restock items</span>
                </label>
                <label class="checkbox-label">
                    <input type="checkbox" checked>
                    <span>Send email notification</span>
                </label>
            </div>
        </div>


    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>


