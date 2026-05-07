<?php 
$pageTitle = "Coupons | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/admin_assets/css/coupons.css">

<div class="page-header-container">
    <h1>Coupons & Discounts</h1>
    
    <div class="header-actions">
        <a href="<?= BASE_URL ?>/admin/coupons/create" class="btn btn-primary btn-add">
            <i data-lucide="plus"></i>
            <span>Create Discount</span>
        </a>
    </div>
</div>

<div class="card card-no-padding">
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th class="th-product">Code</th>
                    <th class="th-default">Status</th>
                    <th class="th-default">Value</th>
                    <th class="th-default">Used</th>
                    <th class="th-default">Expiry</th>
                    <th class="th-action">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($coupons)): ?>
                    <?php foreach ($coupons as $coupon): 
                        $statusClass = 'badge-archived';
                        $statusText = 'Inactive';
                        if ($coupon['is_active']) {
                            $now = time();
                            $endDate = $coupon['end_date'] ? strtotime($coupon['end_date']) : null;
                            if ($endDate && $endDate < $now) {
                                $statusClass = 'badge-archived';
                                $statusText = 'Expired';
                            } else {
                                $statusClass = 'badge-active';
                                $statusText = 'Active';
                            }
                        }

                        $displayValue = '';
                        if ($coupon['type'] === 'percentage') {
                            $displayValue = $coupon['value'] . '% off';
                        } elseif ($coupon['type'] === 'fixed_amount') {
                            $displayValue = '$' . number_format($coupon['value'], 2) . ' off';
                        } elseif ($coupon['type'] === 'free_shipping') {
                            $displayValue = 'Free Shipping';
                        }
                    ?>
                    <tr>
                        <td class="td-product">
                            <span class="product-name-txt fw-700" style="color: var(--primary-color); letter-spacing: 0.5px;"><?php echo htmlspecialchars($coupon['code']); ?></span>
                        </td>
                        <td class="td-default">
                            <span class="status-badge <?php echo $statusClass; ?>">
                                <?php echo $statusText; ?>
                            </span>
                        </td>
                        <td class="td-default fw-600 text-dark"><?php echo $displayValue; ?></td>
                        <td class="td-default"><span class="badge badge-light"><?php echo $coupon['uses_count']; ?> / <?php echo $coupon['max_uses'] ?: '∞'; ?></span></td>
                        <td class="td-default text-muted fs-12">
                            <?php echo $coupon['end_date'] ? date('M d, Y', strtotime($coupon['end_date'])) : 'Never'; ?>
                        </td>
                        <td class="td-action">
                            <div class="action-flex">
                                <a href="<?= BASE_URL ?>/admin/coupons/edit/<?php echo $coupon['id']; ?>" class="btn-action-icon edit-btn" title="Edit">
                                    <i data-lucide="pencil"></i>
                                </a>
                                <button type="button" class="btn-action-icon delete-btn" title="Delete" onclick="confirmDelete(<?php echo $coupon['id']; ?>)">
                                    <i data-lucide="trash-2"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="p-0">
                            <div class="empty-state-wrapper">
                                <div class="empty-state-icon">
                                    <i data-lucide="ticket"></i>
                                </div>
                                <h3 class="empty-state-title">No Coupons Found</h3>
                                <p class="empty-state-desc">Boost your sales by creating your first discount code here.</p>
                                <a href="<?= BASE_URL ?>/admin/coupons/create" class="btn btn-primary btn-add-first">
                                    <i data-lucide="plus"></i> Create Discount
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="<?= BASE_URL ?>/admin_assets/js/coupons.js"></script>

<?php include __DIR__ . '/partials/footer.php'; ?>
