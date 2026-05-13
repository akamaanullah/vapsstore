<?php ob_start(); ?>

<div class="account-welcome">
    <div class="welcome-header">
        <h2>Dashboard Overview</h2>
        <p>Hello, <strong><?= htmlspecialchars($user['first_name']) ?></strong>! From your account dashboard you can view your recent orders and manage your profile settings.</p>
    </div>

    <div class="dashboard-grid">
        <!-- Profile Brief -->
        <div class="dashboard-info-card">
            <div class="card-header">
                <h3>Contact Information</h3>
                <a href="<?= BASE_URL ?>/account/profile" class="edit-link">Edit</a>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            </div>
        </div>

        <!-- Address Management -->
        <div class="dashboard-info-card">
            <div class="card-header">
                <h3>Default Address</h3>
                <a href="<?= BASE_URL ?>/account/addresses" class="edit-link">Manage Addresses</a>
            </div>
            <div class="card-body">
                <?php if ($defaultAddress): ?>
                    <p><strong><?= htmlspecialchars($defaultAddress['first_name'] . ' ' . $defaultAddress['last_name']) ?></strong></p>
                    <p><?= htmlspecialchars($defaultAddress['street']) ?></p>
                    <p><?= htmlspecialchars($defaultAddress['city']) ?>, <?= htmlspecialchars($defaultAddress['zip']) ?></p>
                    <p><?= htmlspecialchars($defaultAddress['country']) ?></p>
                <?php else: ?>
                    <p class="text-muted">No default address saved yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="recent-orders-section mt-40">
        <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 20px; font-weight: 700; color: #111827; margin: 0;">Recent Orders</h3>
            <a href="<?= BASE_URL ?>/account/orders" class="view-all">View All &rarr;</a>
        </div>
        
        <?php if (empty($recentOrders)): ?>
            <div class="empty-orders" style="background: #fff; padding: 40px; border-radius: 12px; text-align: center; border: 1px dashed #d1d5db;">
                <p style="color: #6b7280; margin-bottom: 20px;">You haven't placed any orders yet.</p>
                <a href="<?= BASE_URL ?>/collection" class="btn btn-primary">Start Shopping</a>
            </div>
        <?php else: ?>
            <div class="orders-table-wrapper">
                <table class="account-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentOrders as $order): ?>
                            <tr>
                                <td>#<?= htmlspecialchars($order['order_number']) ?></td>
                                <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                <td>£<?= number_format($order['total_amount'], 2) ?></td>
                                <td><span class="status-badge status-<?= strtolower($order['shipping_status']) ?>"><?= ucfirst($order['shipping_status']) ?></span></td>
                                <td><a href="<?= BASE_URL ?>/track-order/status?order=<?= $order['order_number'] ?>&email=<?= urlencode($user['email']) ?>" class="btn-link">Track</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
