<?php 
$pageTitle = "Orders | Vape Store Admin";
$pageScript = "orders.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Orders</h1>
    
    <form action="" method="GET" class="header-actions">
        <div class="search-container">
            <input type="text" name="search" placeholder="Search orders..." class="search-input" value="<?= htmlspecialchars($filters['search']) ?>">
        </div>
        <select name="payment_status" class="status-dropdown" onchange="this.form.submit()">
            <option value="all" <?= $filters['payment_status'] === 'all' ? 'selected' : '' ?>>Payment: All</option>
            <option value="paid" <?= $filters['payment_status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
            <option value="pending" <?= $filters['payment_status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="refunded" <?= $filters['payment_status'] === 'refunded' ? 'selected' : '' ?>>Refunded</option>
        </select>
        <select name="shipping_status" class="status-dropdown" onchange="this.form.submit()">
            <option value="all" <?= $filters['shipping_status'] === 'all' ? 'selected' : '' ?>>Fulfillment: All</option>
            <option value="shipped" <?= $filters['shipping_status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
            <option value="pending" <?= $filters['shipping_status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="delivered" <?= $filters['shipping_status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
        </select>
        <div class="per-page-container">
            <span class="text-label">Rows:</span>
            <select name="per_page" class="per-page-select" onchange="this.form.submit()">
                <option value="10" <?= $pagination['per_page'] == 10 ? 'selected' : '' ?>>10</option>
                <option value="25" <?= $pagination['per_page'] == 25 ? 'selected' : '' ?>>25</option>
                <option value="50" <?= $pagination['per_page'] == 50 ? 'selected' : '' ?>>50</option>
            </select>
        </div>
        <button type="button" class="btn btn-primary btn-add" id="exportBtn">
            <i data-lucide="download"></i>
            <span>Export CSV</span>
        </button>
    </form>
</div>

<div class="card card-no-padding">
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th class="th-default th-id">Order</th>
                    <th class="th-default">Date</th>
                    <th class="th-product">Customer</th>
                    <th class="th-default">Total</th>
                    <th class="th-default">Payment Status</th>
                    <th class="th-default">Fulfillment Status</th>
                    <th class="th-default">Items</th>
                    <th class="th-default">Delivery Method</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="8" class="text-center py-20">No orders found.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td class="td-default">
                            <a href="<?= BASE_URL ?>/admin/orders/detail/<?= $order['order_number'] ?>" class="order-id-txt">
                                #<?= $order['order_number'] ?>
                            </a>
                        </td>
                        <td class="td-default text-muted"><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                        <td class="td-product">
                            <span class="product-name-txt"><?= htmlspecialchars($order['customer_first_name'] . ' ' . $order['customer_last_name']) ?></span>
                            <div class="text-muted-sm"><?= htmlspecialchars($order['customer_email']) ?></div>
                        </td>
                        <td class="td-default text-price">£<?= number_format($order['total_amount'], 2) ?></td>
                        <td class="td-default">
                            <?php 
                            $payClass = 'badge-active'; // paid
                            if ($order['payment_status'] == 'pending') { $payClass = 'badge-draft'; }
                            if ($order['payment_status'] == 'refunded') { $payClass = 'badge-neutral'; }
                            if ($order['payment_status'] == 'failed') { $payClass = 'badge-inactive'; }
                            ?>
                            <span class="status-badge <?= $payClass; ?>">
                                <?= ucfirst($order['payment_status']) ?>
                            </span>
                        </td>
                        <td class="td-default">
                            <?php 
                            $fulfillClass = 'badge-active'; // delivered/shipped
                            if ($order['shipping_status'] == 'pending') { $fulfillClass = 'badge-draft'; }
                            if ($order['shipping_status'] == 'cancelled') { $fulfillClass = 'badge-inactive'; }
                            ?>
                            <span class="status-badge <?= $fulfillClass; ?>">
                                <?= ucfirst($order['shipping_status']) ?>
                            </span>
                        </td>
                        <td class="td-default text-muted"><?= $order['items_count'] ?> items</td>
                        <td class="td-default text-muted">Standard</td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="pagination-container">
        <div class="pagination-info">
            Showing <span id="page-start"><?= ($pagination['current_page'] - 1) * $pagination['per_page'] + 1 ?></span> to <span id="page-end"><?= min($pagination['current_page'] * $pagination['per_page'], $pagination['total']) ?></span> of <span id="page-total"><?= $pagination['total'] ?></span> entries
        </div>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $pagination['last_page']; $i++): ?>
                <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                    <a href="?page=<?= $i ?>&search=<?= urlencode($filters['search']) ?>&payment_status=<?= $filters['payment_status'] ?>&shipping_status=<?= $filters['shipping_status'] ?>" class="page-link"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>


