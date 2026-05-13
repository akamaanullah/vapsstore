<?php 
$pageTitle = "Track Order #{$order['order_number']}";
include __DIR__ . '/partials/header.php'; 
?>

<div class="tracking-page-wrapper">
    <div class="tracking-container">
        <!-- Order Header -->
        <div class="tracking-header">
            <div class="header-main">
                <span class="order-label">Order #<?= htmlspecialchars($order['order_number']) ?></span>
                <h1 class="tracking-title">Track Your Delivery</h1>
                <p class="order-date">Placed on <?= date('F d, Y', strtotime($order['created_at'])) ?></p>
            </div>
            <div class="header-status">
                <?php 
                    $shipStatus = $order['shipping_status'];
                    $statusClass = 'status-' . $shipStatus;
                ?>
                <span class="status-pill <?= $statusClass ?>">
                    <?= ucfirst(str_replace('_', ' ', $shipStatus)) ?>
                </span>
            </div>
        </div>

        <!-- Fulfillment Stepper -->
        <div class="tracking-card stepper-card">
            <div class="stepper-container">
                <?php 
                $status = $order['shipping_status'];
                $steps = [
                    ['id' => 'placed', 'label' => 'Order Placed', 'icon' => 'check-circle', 'active' => true],
                    ['id' => 'confirmed', 'label' => 'Confirmed', 'icon' => 'user-check', 'active' => in_array($status, ['confirmed', 'shipped', 'in_transit', 'out_for_delivery', 'delivered'])],
                    ['id' => 'shipped', 'label' => ($status === 'in_transit' ? 'In Transit' : ($status === 'out_for_delivery' ? 'Out for Delivery' : 'Shipped')), 'icon' => 'truck', 'active' => in_array($status, ['shipped', 'in_transit', 'out_for_delivery', 'delivered'])],
                    ['id' => 'delivered', 'label' => 'Delivered', 'icon' => 'package-check', 'active' => ($status === 'delivered')]
                ];
                ?>
                <div class="stepper-track">
                    <div class="stepper-track-progress" style="width: <?= ($status === 'delivered' ? '100' : ($status === 'pending' ? '0' : ($status === 'confirmed' ? '33' : '66'))) ?>%"></div>
                </div>
                <div class="stepper-steps">
                    <?php foreach ($steps as $step): ?>
                    <div class="step-item <?= $step['active'] ? 'active' : '' ?>">
                        <div class="step-icon">
                            <i data-lucide="<?= $step['icon'] ?>"></i>
                        </div>
                        <div class="step-content">
                            <span class="step-label"><?= $step['label'] ?></span>
                            <span class="step-status"><?= $step['active'] ? 'Completed' : 'Pending' ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if (!empty($order['tracking_number'])): ?>
            <div class="tracking-number-box">
                <span class="tn-label">TRACKING NUMBER</span>
                <div class="tn-value"><?= htmlspecialchars($order['tracking_number']) ?></div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Order Content Grid -->
        <div class="tracking-grid">
            <div class="grid-main">
                <div class="tracking-card">
                    <h3 class="card-title">Order Items</h3>
                    <div class="items-list">
                        <?php foreach ($order['items'] as $item): ?>
                        <div class="item-row">
                            <a href="<?= BASE_URL ?>/product/<?= $item['custom_url'] ?>" class="item-link">
                                <div class="item-image">
                                    <?php 
                                        $imgUrl = $item['featured_image'];
                                        $displayImg = BASE_URL . '/admin_assets/image/placeholder.png';
                                        if ($imgUrl) {
                                            $displayImg = (filter_var($imgUrl, FILTER_VALIDATE_URL)) ? $imgUrl : BASE_URL . '/' . ltrim($imgUrl, '/');
                                        }
                                    ?>
                                    <img src="<?= $displayImg ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                                </div>
                            </a>
                            <div class="item-info">
                                <a href="<?= BASE_URL ?>/product/<?= $item['custom_url'] ?>" class="item-link">
                                    <h4 class="item-name"><?= htmlspecialchars($item['product_name']) ?></h4>
                                </a>
                                <?php if ($item['variant_name']): ?>
                                    <span class="item-variant"><?= htmlspecialchars($item['variant_name']) ?></span>
                                <?php endif; ?>
                                <div class="item-price-mobile">£<?= number_format($item['price_at_purchase'], 2) ?> × <?= $item['quantity'] ?></div>
                            </div>
                            <div class="item-qty">Qty: <?= $item['quantity'] ?></div>
                            <div class="item-total">£<?= number_format($item['price_at_purchase'] * $item['quantity'], 2) ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="grid-sidebar">
                <div class="tracking-card">
                    <h3 class="card-title">Price Summary</h3>
                    <div class="summary-list">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>£<?= number_format($order['subtotal'], 2) ?></span>
                        </div>
                        <?php if ($order['discount_amount'] > 0): ?>
                        <div class="summary-row discount">
                            <span>Discount</span>
                            <span>-£<?= number_format($order['discount_amount'], 2) ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span>£<?= number_format($order['shipping_cost'], 2) ?></span>
                        </div>
                        <div class="summary-divider"></div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span>£<?= number_format($order['total_amount'], 2) ?></span>
                        </div>
                    </div>
                </div>

                <div class="help-box">
                    <p>Need help with your order?</p>
                    <a href="<?= BASE_URL ?>/contact" class="btn-help">Contact Support</a>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@700;800;900&display=swap" rel="stylesheet">

<style>
/* Base Layout */
.tracking-page-wrapper {
    background-color: #fcfcfc;
    padding: 80px 20px;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
}

.tracking-container {
    max-width: 1000px;
    margin: 0 auto;
}

/* Header */
.tracking-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
}

.order-label {
    color: #bd0028;
    font-weight: 800;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 2px;
    display: block;
    margin-bottom: 8px;
    font-family: 'Outfit', sans-serif;
}

.tracking-title {
    font-family: 'Outfit', sans-serif;
    font-size: 42px;
    font-weight: 900;
    color: #000;
    margin: 0;
    letter-spacing: -1.5px;
    line-height: 1;
}

.order-date {
    color: #94a3b8;
    font-size: 14px;
    margin: 8px 0 0;
}

.status-pill {
    padding: 10px 24px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 13px;
    background: #f1f5f9;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-shipped, .status-delivered, .status-in_transit, .status-out_for_delivery {
    background: #ecfdf5;
    color: #059669;
}

.status-pending, .status-confirmed {
    background: #fffbeb;
    color: #d97706;
}

/* Cards */
.tracking-card {
    background: #fff;
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    border: 1px solid #f1f5f9;
    margin-bottom: 30px;
}

.card-title {
    font-size: 18px;
    font-weight: 800;
    margin-bottom: 30px;
    color: #000;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Stepper */
.stepper-container {
    position: relative;
    padding: 20px 0;
    margin-bottom: 10px;
}

.stepper-track {
    position: absolute;
    top: 42px;
    left: 60px;
    right: 60px;
    height: 4px;
    background: #f1f5f9;
    z-index: 1;
}

.stepper-track-progress {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    background: #bd0028;
    transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.stepper-steps {
    display: flex;
    justify-content: space-between;
    position: relative;
    z-index: 2;
}

.step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 140px;
    text-align: center;
}

.step-icon {
    width: 52px;
    height: 52px;
    background: #fff;
    border: 2px solid #f1f5f9;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #cbd5e0;
    margin-bottom: 16px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.step-label {
    font-size: 13px;
    font-weight: 700;
    color: #94a3b8;
    margin-bottom: 4px;
}

.step-status {
    font-size: 10px;
    font-weight: 800;
    color: #cbd5e0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.step-item.active .step-icon {
    border-color: #bd0028;
    background: #bd0028;
    color: #fff;
    box-shadow: 0 10px 20px rgba(189, 0, 40, 0.2);
    transform: translateY(-5px);
}

.step-item.active .step-label {
    color: #000;
}

.step-item.active .step-status {
    color: #bd0028;
}

/* Tracking Number */
.tracking-number-box {
    background: #fdf2f4;
    border-radius: 20px;
    padding: 25px;
    text-align: center;
    border: 1px solid rgba(189, 0, 40, 0.1);
}

.tn-label {
    font-size: 10px;
    font-weight: 800;
    color: #bd0028;
    letter-spacing: 2px;
    opacity: 0.7;
}

.tn-value {
    font-size: 28px;
    font-weight: 800;
    color: #bd0028;
    margin-top: 5px;
}

/* Grid */
.tracking-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 30px;
}

/* Items List */
.item-row {
    display: flex;
    align-items: center;
    padding: 20px 0;
    border-bottom: 1px solid #f8fafc;
}

.item-row:last-child { border-bottom: none; padding-bottom: 0; }
.item-row:first-child { padding-top: 0; }

.item-image img {
    width: 80px;
    height: 80px;
    border-radius: 16px;
    object-fit: cover;
    background: #f8fafc;
    margin-right: 20px;
    border: 1px solid #f1f5f9;
}

.item-info { flex: 1; }

.item-name {
    font-size: 16px;
    font-weight: 800;
    color: #000;
    margin: 0;
}

.item-variant {
    font-size: 13px;
    color: #94a3b8;
    display: block;
    margin-top: 2px;
}

.item-qty {
    font-weight: 700;
    color: #64748b;
    font-size: 14px;
    margin: 0 40px;
    white-space: nowrap;
}

.item-total {
    font-weight: 800;
    color: #000;
    font-size: 18px;
    min-width: 90px;
    text-align: right;
}

/* Summary */
.summary-list {
    margin-top: -10px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 16px;
    color: #64748b;
    font-weight: 600;
    font-size: 15px;
}

.summary-row.discount { color: #ef4444; }

.summary-divider {
    height: 1px;
    background: #f1f5f9;
    margin: 20px 0;
}

.summary-row.total {
    font-size: 28px;
    font-weight: 900;
    color: #bd0028;
    margin-top: 5px;
}

.help-box {
    text-align: center;
    padding: 40px 0;
}

.help-box p {
    color: #94a3b8;
    font-weight: 600;
    margin-bottom: 10px;
}

.btn-help {
    color: #bd0028;
    font-weight: 800;
    text-decoration: none;
    font-size: 16px;
    border-bottom: 2px solid rgba(189, 0, 40, 0.2);
    padding-bottom: 2px;
    transition: all 0.3s ease;
}

.btn-help:hover {
    border-color: #bd0028;
}

.item-link {
    text-decoration: none;
    color: inherit;
    transition: opacity 0.2s;
}

.item-link:hover {
    opacity: 0.7;
}

/* Mobile Responsiveness */
@media (max-width: 991px) {
    .tracking-grid { grid-template-columns: 1fr; }
    .tracking-header { flex-direction: column; align-items: flex-start; gap: 20px; }
    .header-status { width: 100%; }
    .status-pill { display: block; text-align: center; }
}

@media (max-width: 600px) {
    .stepper-track { left: 20px; right: 20px; top: 34px; }
    .step-icon { width: 36px; height: 36px; border-radius: 12px; }
    .step-label { font-size: 11px; }
    .step-status { display: none; }
    .item-qty, .item-total { display: none; }
    .item-price-mobile { display: block; font-size: 13px; color: #94a3b8; margin-top: 5px; }
    .tracking-title { font-size: 28px; }
    .tracking-card { padding: 25px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>
