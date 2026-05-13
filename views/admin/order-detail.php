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
        <h1 class="m-0">Order #<?= $order['order_number'] ?></h1>
        <div class="badge-group ml-10">
            <?php 
                $payClass = ($order['payment_status'] === 'paid') ? 'badge-active' : 'badge-draft';
                $shipClass = ($order['shipping_status'] === 'pending') ? 'badge-draft' : 'badge-active';
            ?>
            <span class="status-badge <?= $payClass ?>">Payment: <?= ucfirst($order['payment_status']) ?></span>
            <span class="status-badge <?= $shipClass ?>">Fulfillment: <?= ucfirst($order['shipping_status']) ?></span>
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
                        <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td class="td-product">
                                <div class="product-info-flex">
                                    <?php 
                                        $imgUrl = $item['featured_image'];
                                        $displayImg = BASE_URL . '/admin_assets/image/placeholder.png';
                                        
                                        if ($imgUrl) {
                                            if (filter_var($imgUrl, FILTER_VALIDATE_URL)) {
                                                $displayImg = $imgUrl;
                                            } else {
                                                $displayImg = BASE_URL . '/' . ltrim($imgUrl, '/');
                                            }
                                        }
                                    ?>
                                    <img src="<?= $displayImg ?>" class="product-image" alt="<?= htmlspecialchars($item['product_name']) ?>">
                                    <div>
                                        <div class="product-name-txt"><?= htmlspecialchars($item['product_name']) ?></div>
                                        <?php if ($item['variant_name']): ?>
                                            <div class="text-muted-sm"><?= htmlspecialchars($item['variant_name']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="td-default"><?= $item['sku'] ?></td>
                            <td class="td-default">£<?= number_format($item['price_at_purchase'], 2) ?></td>
                            <td class="td-default"><?= $item['quantity'] ?></td>
                            <td class="td-default text-right">£<?= number_format($item['price_at_purchase'] * $item['quantity'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer-padding">
                <div class="refund-summary-box">
                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value">£<?= number_format($order['subtotal'], 2) ?></span>
                    </div>
                    <?php if ($order['discount_amount'] > 0): ?>
                    <div class="summary-row">
                        <span class="summary-label">Discount</span>
                        <span class="summary-value">-£<?= number_format($order['discount_amount'], 2) ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="summary-row">
                        <span class="summary-label">Shipping</span>
                        <span class="summary-value">£<?= number_format($order['shipping_cost'], 2) ?></span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Tax</span>
                        <span class="summary-value">£<?= number_format($order['tax_amount'], 2) ?></span>
                    </div>
                    <div class="summary-divider"></div>
                    <div class="summary-row fw-700">
                        <span>Total</span>
                        <span class="text-price">£<?= number_format($order['total_amount'], 2) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping / Fulfillment -->
        <div class="card">
            <div class="card-header-flex">
                <h3 class="card-title-sm">Fulfillment</h3>
                <span class="status-badge <?= $shipClass ?>">● <?= ucfirst($order['shipping_status']) ?></span>
            </div>
            
            <?php if ($order['shipping_status'] === 'pending'): ?>
            <div class="alert-box-warning mt-15">
                <i data-lucide="alert-triangle"></i>
                <span><strong>Action required:</strong> This order needs to be fulfilled.</span>
            </div>
            <?php endif; ?>

            <div class="fulfillment-stepper-container mt-25">
                <div class="stepper-track"></div>
                <div class="stepper-items">
                    <?php 
                    $status = $order['shipping_status'];
                    $steps = [
                        ['id' => 'placed', 'label' => 'Order Placed', 'icon' => 'check-circle', 'active' => true],
                        ['id' => 'confirmed', 'label' => 'Confirmed', 'icon' => 'user-check', 'active' => in_array($status, ['confirmed', 'shipped', 'in_transit', 'out_for_delivery', 'delivered'])],
                        ['id' => 'shipped', 'label' => ($status === 'in_transit' ? 'In Transit' : ($status === 'out_for_delivery' ? 'Out for Delivery' : 'Shipped')), 'icon' => 'truck', 'active' => in_array($status, ['shipped', 'in_transit', 'out_for_delivery', 'delivered'])],
                        ['id' => 'delivered', 'label' => 'Delivered', 'icon' => 'package-check', 'active' => ($status === 'delivered')]
                    ];
                    ?>
                    
                    <?php foreach ($steps as $step): ?>
                    <div class="stepper-item <?= $step['active'] ? 'completed' : 'pending' ?>">
                        <div class="stepper-icon">
                            <i data-lucide="<?= $step['icon'] ?>"></i>
                        </div>
                        <div class="stepper-content">
                            <span class="stepper-title"><?= $step['label'] ?></span>
                            <span class="stepper-date"><?= $step['active'] ? 'Updated' : 'Pending' ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>


    <div class="form-sidebar">
        <!-- Order Actions -->
        <div class="card">
            <div class="card-header-flex mb-15">
                <h3 class="card-title-sm">Order Fulfillment</h3>
                <?php 
                    $shipStatus = $order['shipping_status'];
                    $badgeClass = 'badge-neutral';
                    if (in_array($shipStatus, ['shipped', 'in_transit', 'out_for_delivery', 'delivered'])) $badgeClass = 'badge-active';
                    if ($shipStatus === 'cancelled') $badgeClass = 'badge-inactive';
                    if ($shipStatus === 'pending' || $shipStatus === 'confirmed') $badgeClass = 'badge-draft';
                ?>
                <span class="status-badge <?= $badgeClass ?>">
                    <?= ucfirst(str_replace('_', ' ', $shipStatus)) ?>
                </span>
            </div>
            
            <form action="<?= BASE_URL ?>/admin/orders/update-status/<?= $order['id'] ?>" method="POST" class="mb-20">
                <?= $this->csrf_field() ?>
                <input type="hidden" name="order_number" value="<?= $order['order_number'] ?>">
                <input type="hidden" name="type" value="fulfillment">
                
                <div class="form-group mb-10">
                    <label class="info-label">Fulfillment Status</label>
                    <select name="status" class="modal-field-input w-100">
                        <option value="pending" <?= $order['shipping_status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="confirmed" <?= $order['shipping_status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                        <option value="shipped" <?= $order['shipping_status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                        <option value="in_transit" <?= $order['shipping_status'] === 'in_transit' ? 'selected' : '' ?>>In Transit</option>
                        <option value="out_for_delivery" <?= $order['shipping_status'] === 'out_for_delivery' ? 'selected' : '' ?>>Out for Delivery</option>
                        <option value="delivered" <?= $order['shipping_status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                        <option value="cancelled" <?= $order['shipping_status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>

                <div class="form-group mb-15">
                    <label class="info-label">Tracking Number</label>
                    <input type="text" name="tracking_number" class="modal-field-input w-100" placeholder="Enter tracking ID" value="<?= htmlspecialchars($order['tracking_number'] ?? '') ?>">
                </div>

                <button type="submit" class="btn btn-primary btn-sm w-100">Update Fulfillment</button>
            </form>

            <hr class="mb-15" style="border: 0; border-top: 1px solid #eee;">

            <h3 class="card-title-sm mb-15">Payment Status</h3>
            <form action="<?= BASE_URL ?>/admin/orders/update-status/<?= $order['id'] ?>" method="POST">
                <?= $this->csrf_field() ?>
                <input type="hidden" name="order_number" value="<?= $order['order_number'] ?>">
                <input type="hidden" name="type" value="payment">
                
                <div class="d-flex gap-10">
                    <select name="status" class="modal-field-input btn-sm">
                        <option value="pending" <?= $order['payment_status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="paid" <?= $order['payment_status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
                        <option value="refunded" <?= $order['payment_status'] === 'refunded' ? 'selected' : '' ?>>Refunded</option>
                        <option value="failed" <?= $order['payment_status'] === 'failed' ? 'selected' : '' ?>>Failed</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </form>
        </div>

        <!-- Order Info -->
        <div class="card">
            <h3 class="card-title-sm mb-10">Order Information</h3>
            <div class="info-list">
                <div class="info-item">
                    <span class="info-label">Date & Time</span>
                    <span class="info-value"><?= date('M d, Y \a\t h:i a', strtotime($order['created_at'])) ?></span>
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
                    <span class="fw-600 d-block"><?= htmlspecialchars($order['customer_first_name'] . ' ' . $order['customer_last_name']) ?></span>
                    <a href="mailto:<?= htmlspecialchars($order['customer_email']) ?>" class="link-primary-sm"><?= htmlspecialchars($order['customer_email']) ?></a>
                    <span class="text-muted-sm d-block mt-5"><?= htmlspecialchars($order['customer_phone']) ?></span>
                </div>
                <div class="summary-divider my-10"></div>
                <div class="account-type-badge">
                    <span class="status-badge badge-neutral"><?= $order['user_id'] ? 'Registered Customer' : 'Guest Checkout' ?></span>
                </div>
            </div>
            
            <div class="summary-divider my-15"></div>
            
            <div class="address-section">
                <div class="card-header-flex">
                    <h4 class="card-title-xs">Shipping Address</h4>
                </div>
                <address class="address-box mt-5">
                    <?php if (!empty($order['shipping_address'])): ?>
                        <?= htmlspecialchars($order['shipping_address']['first_name'] . ' ' . $order['shipping_address']['last_name']) ?><br>
                        <?= htmlspecialchars($order['shipping_address']['street']) ?><br>
                        <?= htmlspecialchars($order['shipping_address']['city']) ?>, <?= htmlspecialchars($order['shipping_address']['zip']) ?><br>
                        <?= htmlspecialchars($order['shipping_address']['country']) ?>
                    <?php else: ?>
                        <span class="text-muted-sm italic">No shipping address provided.</span>
                    <?php endif; ?>
                </address>
            </div>
            
            <div class="summary-divider my-15"></div>
            
            <div class="address-section">
                <div class="card-header-flex">
                    <h4 class="card-title-xs">Billing Address</h4>
                </div>
                <address class="address-box mt-5">
                    <?php if (!empty($order['billing_address'])): ?>
                        <?= htmlspecialchars($order['billing_address']['first_name'] . ' ' . $order['billing_address']['last_name']) ?><br>
                        <?= htmlspecialchars($order['billing_address']['street']) ?><br>
                        <?= htmlspecialchars($order['billing_address']['city']) ?>, <?= htmlspecialchars($order['billing_address']['zip']) ?><br>
                        <?= htmlspecialchars($order['billing_address']['country']) ?>
                    <?php else: ?>
                        <span class="text-muted-sm italic">No billing address provided.</span>
                    <?php endif; ?>
                </address>
            </div>
        </div>

        <!-- Notes -->
        <div class="card">
            <h3 class="card-title-sm mb-10">Customer Notes</h3>
            <div class="form-group mb-0">
                <p class="text-muted-sm <?= empty($order['customer_notes']) ? 'italic' : '' ?>">
                    <?= !empty($order['customer_notes']) ? htmlspecialchars($order['customer_notes']) : "No notes provided." ?>
                </p>
            </div>
        </div>
    </div>
</div>
<script>
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const btn = this.querySelector('button[type="submit"]');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i data-lucide="loader-2" class="animate-spin icon-xs"></i> Updating...';
            // If lucide is not initialized for new icons, fallback to text
            setTimeout(() => {
                if (btn.innerText.trim() === '') btn.innerText = 'Updating...';
            }, 10);
        }
    });
});
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>



