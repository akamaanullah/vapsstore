<?php 
$pageTitle = "Orders | Vape Store Admin";
$pageScript = "orders.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Orders</h1>
    
    <div class="header-actions">
        <div class="search-container">
            <input type="text" placeholder="Search orders..." class="search-input">
        </div>
        <select class="status-dropdown">
            <option>Payment: All</option>
            <option>Paid</option>
            <option>Pending</option>
            <option>Refunded</option>
            <option>Voided</option>
        </select>
        <select class="status-dropdown">
            <option>Fulfillment: All</option>
            <option>Fulfilled</option>
            <option>Unfulfilled</option>
        </select>
        <div class="per-page-container">
            <span class="text-label">Rows:</span>
            <select class="per-page-select">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
        <button class="btn btn-primary btn-add" id="exportBtn">
            <i data-lucide="download"></i>
            <span>Export CSV</span>
        </button>
    </div>
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
                    <th class="th-default">Delivery Status</th>
                    <th class="th-default">Delivery Method</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sampleOrders = [
                    ['order' => '#ORD-1052', 'date' => 'Feb 15, 2026', 'customer' => 'Alice Johnson', 'total' => 125.50, 'payment' => 'Paid', 'fulfillment' => 'Fulfilled', 'items' => '3 items', 'delivery_status' => 'Delivered', 'delivery_method' => 'Standard'],
                    ['order' => '#ORD-1053', 'date' => 'Feb 15, 2026', 'customer' => 'Bob Smith', 'total' => 29.89, 'payment' => 'Pending', 'fulfillment' => 'Unfulfilled', 'items' => '1 item', 'delivery_status' => 'Processing', 'delivery_method' => 'Express'],
                    ['order' => '#ORD-1054', 'date' => 'Feb 14, 2026', 'customer' => 'Charlie Brown', 'total' => 240.00, 'payment' => 'Refunded', 'fulfillment' => 'Unfulfilled', 'items' => '5 items', 'delivery_status' => 'Cancelled', 'delivery_method' => 'Standard'],
                    ['order' => '#ORD-1055', 'date' => 'Feb 14, 2026', 'customer' => 'Diana Prince', 'total' => 85.90, 'payment' => 'Paid', 'fulfillment' => 'Fulfilled', 'items' => '2 items', 'delivery_status' => 'Shipped', 'delivery_method' => 'Express'],
                    ['order' => '#ORD-1056', 'date' => 'Feb 13, 2026', 'customer' => 'Ethan Hunt', 'total' => 199.99, 'payment' => 'Voided', 'fulfillment' => 'Unfulfilled', 'items' => '4 items', 'delivery_status' => 'Cancelled', 'delivery_method' => 'Standard'],
                    ['order' => '#ORD-1057', 'date' => 'Feb 13, 2026', 'customer' => 'Fiona Gallagher', 'total' => 15.00, 'payment' => 'Paid', 'fulfillment' => 'Fulfilled', 'items' => '1 item', 'delivery_status' => 'Delivered', 'delivery_method' => 'Standard'],
                    ['order' => '#ORD-1058', 'date' => 'Feb 12, 2026', 'customer' => 'George Costanza', 'total' => 74.25, 'payment' => 'Pending', 'fulfillment' => 'Unfulfilled', 'items' => '3 items', 'delivery_status' => 'Processing', 'delivery_method' => 'Express'],
                    ['order' => '#ORD-1059', 'date' => 'Feb 12, 2026', 'customer' => 'Hannah Abbott', 'total' => 45.60, 'payment' => 'Paid', 'fulfillment' => 'Fulfilled', 'items' => '2 items', 'delivery_status' => 'Delivered', 'delivery_method' => 'Standard'],
                    ['order' => '#ORD-1060', 'date' => 'Feb 11, 2026', 'customer' => 'Ian Malcolm', 'total' => 310.45, 'payment' => 'Paid', 'fulfillment' => 'Unfulfilled', 'items' => '7 items', 'delivery_status' => 'Processing', 'delivery_method' => 'Standard'],
                    ['order' => '#ORD-1061', 'date' => 'Feb 11, 2026', 'customer' => 'Julia Roberts', 'total' => 25.00, 'payment' => 'Refunded', 'fulfillment' => 'Unfulfilled', 'items' => '1 item', 'delivery_status' => 'Cancelled', 'delivery_method' => 'Express'],
                    ['order' => '#ORD-1062', 'date' => 'Feb 10, 2026', 'customer' => 'Kevin Hart', 'total' => 180.20, 'payment' => 'Paid', 'fulfillment' => 'Fulfilled', 'items' => '4 items', 'delivery_status' => 'Shipped', 'delivery_method' => 'Standard'],
                    ['order' => '#ORD-1063', 'date' => 'Feb 10, 2026', 'customer' => 'Laura Palmer', 'total' => 60.00, 'payment' => 'Pending', 'fulfillment' => 'Unfulfilled', 'items' => '2 items', 'delivery_status' => 'Processing', 'delivery_method' => 'Standard'],
                    ['order' => '#ORD-1064', 'date' => 'Feb 09, 2026', 'customer' => 'Michael Scott', 'total' => 210.00, 'payment' => 'Voided', 'fulfillment' => 'Unfulfilled', 'items' => '5 items', 'delivery_status' => 'Cancelled', 'delivery_method' => 'Express'],
                    ['order' => '#ORD-1065', 'date' => 'Feb 09, 2026', 'customer' => 'Nancy Wheeler', 'total' => 95.50, 'payment' => 'Paid', 'fulfillment' => 'Fulfilled', 'items' => '3 items', 'delivery_status' => 'Delivered', 'delivery_method' => 'Standard'],
                    ['order' => '#ORD-1066', 'date' => 'Feb 08, 2026', 'customer' => 'Oscar Martinez', 'total' => 12.99, 'payment' => 'Paid', 'fulfillment' => 'Fulfilled', 'items' => '1 item', 'delivery_status' => 'Delivered', 'delivery_method' => 'Express'],
                ];
                
                foreach ($sampleOrders as $order): ?>
                <tr>
                    <td class="td-default">
                        <a href="<?= BASE_URL ?>/admin/orders/detail/<?php echo str_replace('#', '', $order['order']); ?>" class="order-id-txt">
                            <?php echo $order['order']; ?>
                        </a>
                    </td>
                    <td class="td-default text-muted"><?php echo $order['date']; ?></td>
                    <td class="td-product">
                        <span class="product-name-txt"><?php echo $order['customer']; ?></span>
                    </td>
                    <td class="td-default text-price">$<?php echo number_format($order['total'], 2); ?></td>
                    <td class="td-default">
                        <?php 
                        $payClass = 'badge-active';
                        if ($order['payment'] == 'Pending') { $payClass = 'badge-draft'; }
                        if ($order['payment'] == 'Refunded') { $payClass = 'badge-neutral'; }
                        if ($order['payment'] == 'Voided') { $payClass = 'badge-inactive'; }
                        ?>
                        <span class="status-badge <?php echo $payClass; ?>">
                            <?php echo $order['payment']; ?>
                        </span>
                    </td>
                    <td class="td-default">
                        <?php 
                        $fulfillClass = 'badge-active';
                        if ($order['fulfillment'] == 'Unfulfilled') { $fulfillClass = 'badge-draft'; }
                        ?>
                        <span class="status-badge <?php echo $fulfillClass; ?>">
                            <?php echo $order['fulfillment']; ?>
                        </span>
                    </td>
                    <td class="td-default text-muted"><?php echo $order['items']; ?></td>
                    <td class="td-default text-muted"><?php echo $order['delivery_status']; ?></td>
                    <td class="td-default text-muted"><?php echo $order['delivery_method']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="pagination-container">
        <div class="pagination-info">
            Showing <span id="page-start">1</span> to <span id="page-end">10</span> of <span id="page-total">15</span> entries
        </div>
        <ul class="pagination">
            <!-- Populated by JS -->
        </ul>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>


