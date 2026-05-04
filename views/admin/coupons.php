<?php 
$pageTitle = "Coupons | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

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
                    <th class="th-action">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sampleCoupons = [
                    ['code' => 'WELCOME10', 'status' => 'Active', 'value' => '10% off', 'used' => '152'],
                    ['code' => 'FREESHIP', 'status' => 'Active', 'value' => 'Free Shipping', 'used' => '84'],
                    ['code' => 'VAPE20', 'status' => 'Expired', 'value' => '$20.00 off', 'used' => '45'],
                ];
                
                foreach ($sampleCoupons as $coupon): ?>
                <tr>
                    <td class="td-product">
                        <span class="product-name-txt fw-700" style="color: var(--primary-color);"><?php echo $coupon['code']; ?></span>
                    </td>
                    <td class="td-default">
                        <span class="status-badge <?php echo $coupon['status'] == 'Active' ? 'badge-active' : 'badge-archived'; ?>">
                            <?php echo $coupon['status']; ?>
                        </span>
                    </td>
                    <td class="td-default text-muted"><?php echo $coupon['value']; ?></td>
                    <td class="td-default text-muted"><?php echo $coupon['used']; ?> times</td>
                    <td class="td-action">
                        <div class="action-flex">
                            <a href="<?= BASE_URL ?>/admin/coupons/edit" class="btn-action-icon edit-btn" title="Edit">
                                <i data-lucide="pencil"></i>
                            </a>
                            <button class="btn-action-icon delete-btn" title="Delete">
                                <i data-lucide="trash-2"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
