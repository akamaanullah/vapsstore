<?php ob_start(); ?>

<div class="account-orders">
    <div class="welcome-header">
        <h2>My Orders</h2>
        <p>Review your complete order history and track the status of your shipments.</p>
    </div>

    <?php if (empty($orders)): ?>
        <div class="empty-orders-state section-padding">
            <div class="empty-icon">
                <i data-lucide="package-search"></i>
            </div>
            <h3>No orders found</h3>
            <p>Looks like you haven't placed any orders yet. Explore our collection to find something you'll love!</p>
            <a href="<?= BASE_URL ?>/collection" class="btn btn-primary mt-20">Browse Products</a>
        </div>
    <?php else: ?>
        <div class="orders-list">
            <div class="orders-table-wrapper">
                <table class="account-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Payment</th>
                            <th>Shipping</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td style="white-space: nowrap;">
                                    <span class="order-id">#<?= htmlspecialchars($order['order_number']) ?></span>
                                </td>
                                <td style="white-space: nowrap;"><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                <td>
                                    <span class="status-badge status-<?= strtolower($order['payment_status']) ?>">
                                        <?= ucfirst($order['payment_status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-<?= strtolower($order['shipping_status']) ?>">
                                        <?= ucfirst($order['shipping_status']) ?>
                                    </span>
                                </td>
                                <td class="order-total">£<?= number_format($order['total_amount'], 2) ?></td>
                                <td>
                                    <div class="order-actions">
                                        <a href="<?= BASE_URL ?>/track-order/status?order=<?= $order['order_number'] ?>&email=<?= urlencode($userEmail) ?>" class="btn-action-view">
                                            Track Order
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
