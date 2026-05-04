<?php 
$pageTitle = "Order Detail | Vape Store Admin";
$pageScript = "order-detail.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/orders" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Order #ORD-1052</h1>
        <div class="badge-group ml-10">
            <span class="status-badge badge-active">Paid</span>
            <span class="status-badge badge-active">Fulfilled</span>
        </div>
    </div>
</div>

<div class="form-layout">
    <div class="form-main">
        <!-- Order Items -->
        <div class="card card-no-padding">
            <div class="card-header-padding">
                <h3 class="card-title-sm">Order Items</h3>
            </div>
            <div class="table-responsive">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th class="th-product">Product</th>
                            <th class="th-default">SKU</th>
                            <th class="th-default">Price</th>
                            <th class="th-default">Quantity</th>
                            <th class="th-default text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="td-product">
                                <div class="product-info-flex">
                                    <img src="<?= BASE_URL ?>/admin_assets/image/placeholder.png" class="product-image" alt="">
                                    <div>
                                        <div class="product-name-txt">GeekVape L200 Classic</div>
                                        <div class="text-muted-sm">Color: Matte Black</div>
                                    </div>
                                </div>
                            </td>
                            <td class="td-default">GV-L200-BLK</td>
                            <td class="td-default">$85.00</td>
                            <td class="td-default">1</td>
                            <td class="td-default text-right">$85.00</td>
                        </tr>
                        <tr>
                            <td class="td-product">
                                <div class="product-info-flex">
                                    <img src="<?= BASE_URL ?>/admin_assets/image/placeholder.png" class="product-image" alt="">
                                    <div>
                                        <div class="product-name-txt">HorizonTech Sakerz Tank</div>
                                        <div class="text-muted-sm">Size: 5ml</div>
                                    </div>
                                </div>
                            </td>
                            <td class="td-default">HT-SAK-5ML</td>
                            <td class="td-default">$29.50</td>
                            <td class="td-default">2</td>
                            <td class="td-default text-right">$59.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer-padding">
                <div class="refund-summary-box">
                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value">$144.00</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Discount (WELCOME10)</span>
                        <span class="summary-value">-$14.40</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Shipping (Standard)</span>
                        <span class="summary-value">$5.00</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Tax (8.5%)</span>
                        <span class="summary-value">$10.90</span>
                    </div>
                    <div class="summary-divider"></div>
                    <div class="summary-row fw-700">
                        <span>Total</span>
                        <span class="text-price">$145.50</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments / Transactions -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Payments & Transactions</h3>
            <div class="payment-detail-box">
                <div class="payment-method-row">
                    <div class="method-info">
                        <i data-lucide="credit-card" class="icon-md"></i>
                        <div>
                            <span class="fw-600 d-block">Perfect Vape Payments (Visa **** 4242)</span>
                            <span class="text-muted-sm">Transaction ID: #TXN-88273645</span>
                        </div>
                    </div>
                    <span class="status-badge badge-active">Paid</span>
                </div>
                <div class="summary-divider my-15"></div>
                <div class="info-grid-2">
                    <div class="info-item">
                        <span class="info-label">Authorization</span>
                        <span class="info-value">$145.50 (Feb 15, 10:53 pm)</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Captured</span>
                        <span class="info-value">$145.50 (Feb 15, 10:54 pm)</span>
                    </div>
                </div>
                <!-- Refund Info if any -->
                <div class="refund-note-box mt-15">
                    <span class="text-muted-sm">No refunds have been processed for this order yet.</span>
                    <a href="<?= BASE_URL ?>/admin/refunds/detail/ORD-1052" class="link-primary-sm ml-10">Process Refund</a>
                </div>
            </div>
        </div>

        <!-- Shipping / Fulfillment -->
        <div class="card">
            <div class="card-header-flex">
                <h3 class="card-title-sm">Fulfillment</h3>
                <span class="status-badge badge-draft">● Unfulfilled</span>
            </div>
            
            <div class="alert-box-warning mt-15">
                <i data-lucide="alert-triangle"></i>
                <span><strong>Action required:</strong> This order needs to be fulfilled.</span>
            </div>

            <div class="fulfillment-stepper-container mt-25">
                <div class="stepper-track"></div>
                <div class="stepper-items">
                    <div class="stepper-item completed">
                        <div class="stepper-icon">
                            <i data-lucide="check"></i>
                        </div>
                        <div class="stepper-content">
                            <span class="stepper-title">Order Placed</span>
                            <span class="stepper-date">Jan 26, 10:29 PM</span>
                        </div>
                    </div>
                    <div class="stepper-item pending">
                        <div class="stepper-icon">
                            <i data-lucide="truck"></i>
                        </div>
                        <div class="stepper-content">
                            <span class="stepper-title">In Transit</span>
                            <span class="stepper-date">Pending</span>
                        </div>
                    </div>
                    <div class="stepper-item pending">
                        <div class="stepper-icon">
                            <i data-lucide="package"></i>
                        </div>
                        <div class="stepper-content">
                            <span class="stepper-title">Delivered</span>
                            <span class="stepper-date">Pending</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fulfillment-actions mt-25">
                <button class="btn btn-outline btn-add-tracking">
                    <i data-lucide="plus"></i>
                    <span>Add tracking number</span>
                </button>
            </div>
        </div>
        <!-- Timeline -->
        <div class="card">
            <h3 class="card-title-sm mb-20">Timeline</h3>
            <div class="vertical-timeline-container">
                <div class="timeline-line"></div>
                <div class="timeline-items">
                    <div class="timeline-item">
                        <div class="timeline-marker marker-warning">
                            <i data-lucide="undo-2"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <span class="timeline-title fw-600">Order REFUNDED by admin. Items returned to stock.</span>
                                <span class="timeline-date">Jan 26, 2026 at 6:53 PM</span>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-marker marker-neutral">
                            <i data-lucide="mail"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <span class="timeline-title">Shipping update email sent to customer</span>
                                <span class="timeline-date">Jan 26, 2026 at 11:30 AM</span>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-marker marker-primary"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <span class="timeline-title">Payment of $145.50 was captured via Perfect Vape Payments</span>
                                <span class="timeline-date">Jan 26, 2026 at 10:30 AM</span>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-marker marker-neutral">
                            <i data-lucide="mail"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <span class="timeline-title">Order confirmation email sent to alice@example.com</span>
                                <span class="timeline-date">Jan 26, 2026 at 10:29 AM</span>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-marker marker-primary"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <span class="timeline-title">Order created</span>
                                <span class="timeline-date">January 26, 2026 at 10:29 PM</span>
                            </div>
                            <p class="timeline-desc">Order was created by Mahad Bukhari</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="form-sidebar">
        <!-- Order Info -->
        <div class="card">
            <h3 class="card-title-sm mb-10">Order Information</h3>
            <div class="info-list">
                <div class="info-item">
                    <span class="info-label">Date & Time</span>
                    <span class="info-value">Feb 15, 2026 at 10:53 pm</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Source</span>
                    <span class="info-value">Online Store</span>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="card">
            <div class="card-header-flex">
                <h3 class="card-title-sm">Customer</h3>
            </div>
            <div class="customer-preview-box mt-15">
                <div class="customer-main-info">
                    <span class="fw-600 d-block">Alice Johnson</span>
                    <a href="mailto:alice@example.com" class="link-primary-sm">alice@example.com</a>
                    <span class="text-muted-sm d-block mt-5">+1 (555) 012-3456</span>
                </div>
                <div class="summary-divider my-10"></div>
                <div class="account-type-badge">
                    <span class="status-badge badge-neutral">Registered Customer</span>
                </div>
                <a href="<?= BASE_URL ?>/admin/customers/detail/1" class="link-primary-sm mt-10 d-block">View Customer Profile</a>
            </div>
            
            <div class="summary-divider my-15"></div>
            
            <div class="address-section">
                <div class="card-header-flex">
                    <h4 class="card-title-xs">Shipping Address</h4>
                </div>
                <address class="address-box mt-5">
                    Alice Johnson<br>
                    123 Vape Street, Suite 404<br>
                    Cloud City, CA 90210<br>
                    United States
                </address>
            </div>
            
            <div class="summary-divider my-15"></div>
            
            <div class="address-section">
                <div class="card-header-flex">
                    <h4 class="card-title-xs">Billing Address</h4>
                </div>
                <address class="address-box mt-5">
                    Alice Johnson<br>
                    123 Vape Street, Suite 404<br>
                    Cloud City, CA 90210<br>
                    United States
                </address>
            </div>
        </div>

        <!-- Notes & Tags -->
        <div class="card">
            <h3 class="card-title-sm mb-10">Notes</h3>
            <div class="form-group mb-15">
                <label class="info-label">Staff Notes (Internal)</label>
                <textarea class="modal-field-input" rows="3" placeholder="Add a note..."></textarea>
            </div>
            <div class="form-group mb-0">
                <label class="info-label">Customer Notes</label>
                <p class="text-muted-sm italic">"Please leave the package at the front porch. Thank you!"</p>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title-sm mb-10">Tags</h3>
            <div class="tags-container">
                <div class="tag">VIP Customer <i data-lucide="x"></i></div>
                <div class="tag">Standard <i data-lucide="x"></i></div>
                <div class="tag-input-box">
                    <input type="text" placeholder="Add tag..." class="modal-field-input btn-sm">
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>



