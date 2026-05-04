<?php 
$pageTitle = "Refunds | Vape Store Admin";
$pageScript = "refunds.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Refunds</h1>
    
    <div class="header-actions">
        <div class="search-container">
            <input type="text" placeholder="Search refunds..." class="search-input">
        </div>
        <select class="status-dropdown">
            <option>All status</option>
            <option>Pending</option>
            <option>Approved</option>
            <option>Refunded</option>
            <option>Declined</option>
            <option>Cancelled</option>
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
                    <th class="th-default th-id">Refund ID</th>
                    <th class="th-default">Order ID</th>
                    <th class="th-default">Date</th>
                    <th class="th-product">Customer</th>
                    <th class="th-default">Refund Amount</th>
                    <th class="th-default">Status</th>
                    <th class="th-default">Reason</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sampleRefunds = [
                    ['refund' => 'REF-63-2362', 'order' => '#ORD-1052', 'date' => 'Jan 26 at 10:53 pm', 'customer' => 'Alice Johnson', 'amount' => 125.50, 'status' => 'Pending', 'reason' => 'Item arrived damaged and packaging was completely destroyed.'],
                    ['refund' => 'REF-63-2363', 'order' => '#ORD-1049', 'date' => 'Jan 25 at 02:15 pm', 'customer' => 'Bob Smith', 'amount' => 29.89, 'status' => 'Approved', 'reason' => 'Wrong flavor delivered by mistake.'],
                    ['refund' => 'REF-63-2364', 'order' => '#ORD-1041', 'date' => 'Jan 24 at 09:30 am', 'customer' => 'Charlie Brown', 'amount' => 240.00, 'status' => 'Refunded', 'reason' => 'Customer changed their mind before shipping began.'],
                    ['refund' => 'REF-63-2365', 'order' => '#ORD-1033', 'date' => 'Jan 23 at 11:20 am', 'customer' => 'Diana Prince', 'amount' => 85.90, 'status' => 'Declined', 'reason' => 'Device used for over 2 weeks, warranty policy expired.'],
                    ['refund' => 'REF-63-2366', 'order' => '#ORD-1031', 'date' => 'Jan 22 at 04:45 pm', 'customer' => 'Ethan Hunt', 'amount' => 199.99, 'status' => 'Cancelled', 'reason' => 'Customer decided to keep the item in the end.'],
                    ['refund' => 'REF-63-2367', 'order' => '#ORD-1025', 'date' => 'Jan 21 at 01:10 pm', 'customer' => 'Fiona Gallagher', 'amount' => 15.00, 'status' => 'Pending', 'reason' => 'Missing coil in the starter kit box.'],
                    ['refund' => 'REF-63-2368', 'order' => '#ORD-1022', 'date' => 'Jan 20 at 10:05 am', 'customer' => 'George Costanza', 'amount' => 74.25, 'status' => 'Approved', 'reason' => 'Battery not charging properly when plugged into wall adapter.'],
                    ['refund' => 'REF-63-2369', 'order' => '#ORD-1015', 'date' => 'Jan 19 at 03:22 pm', 'customer' => 'Hannah Abbott', 'amount' => 45.60, 'status' => 'Refunded', 'reason' => 'Package completely lost in transit by the courier service.'],
                    ['refund' => 'REF-63-2370', 'order' => '#ORD-1010', 'date' => 'Jan 18 at 08:40 am', 'customer' => 'Ian Malcolm', 'amount' => 310.45, 'status' => 'Declined', 'reason' => 'User dropped the device and physically broke the glass tank.'],
                    ['refund' => 'REF-63-2371', 'order' => '#ORD-1005', 'date' => 'Jan 17 at 05:15 pm', 'customer' => 'Julia Roberts', 'amount' => 25.00, 'status' => 'Pending', 'reason' => 'Received 3mg nicotine instead of the requested 6mg.'],
                    ['refund' => 'REF-63-2372', 'order' => '#ORD-1002', 'date' => 'Jan 16 at 11:55 am', 'customer' => 'Kevin Hart', 'amount' => 180.20, 'status' => 'Refunded', 'reason' => 'Order cancelled by customer immediately after checkout.'],
                    ['refund' => 'REF-63-2373', 'order' => '#ORD-0995', 'date' => 'Jan 15 at 02:30 pm', 'customer' => 'Laura Palmer', 'amount' => 60.00, 'status' => 'Approved', 'reason' => 'Defective pod system, firing auto-draw consistently without stopping.'],
                ];
                
                foreach ($sampleRefunds as $refund): ?>
                <tr>
                    <td class="td-default">
                        <a href="<?= BASE_URL ?>/admin/refunds/detail/<?php echo $refund['refund']; ?>" class="order-id-txt">
                            <?php echo $refund['refund']; ?>
                        </a>
                    </td>
                    <td class="td-default"><span class="order-id-txt"><?php echo $refund['order']; ?></span></td>
                    <td class="td-default text-muted"><?php echo $refund['date']; ?></td>
                    <td class="td-product">
                        <span class="product-name-txt"><?php echo $refund['customer']; ?></span>
                    </td>
                    <td class="td-default text-price">$<?php echo number_format($refund['amount'], 2); ?></td>
                    <td class="td-default">
                        <?php 
                        $statusClass = 'badge-neutral';
                        if ($refund['status'] == 'Pending') { $statusClass = 'badge-draft'; }
                        if ($refund['status'] == 'Approved') { $statusClass = 'badge-active'; }
                        if ($refund['status'] == 'Declined' || $refund['status'] == 'Cancelled') { $statusClass = 'badge-inactive'; }
                        ?>
                        <span class="status-badge <?php echo $statusClass; ?>">
                            <?php echo $refund['status']; ?>
                        </span>
                    </td>
                    <td class="td-default text-muted">
                        <span class="text-truncate" title="<?php echo htmlspecialchars($refund['reason']); ?>">
                            <?php echo $refund['reason']; ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="pagination-container">
        <div class="pagination-info">
            Showing <span id="page-start">1</span> to <span id="page-end">10</span> of <span id="page-total">12</span> entries
        </div>
        <ul class="pagination">
            <!-- Populated by JS -->
        </ul>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>


