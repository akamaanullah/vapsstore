<?php 
$pageTitle = "Inventory Management | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <h1 class="m-0">Inventory</h1>
    </div>
    <div class="header-actions">
        <button class="btn btn-outline">
            <i data-lucide="upload"></i>
            <span>Import stock</span>
        </button>
        <button class="btn btn-primary">Save Changes</button>
    </div>
</div>

<div class="card card-no-padding">
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th class="th-product">Product Variant</th>
                    <th class="th-default">SKU</th>
                    <th class="th-default">Current Stock</th>
                    <th class="th-default">Adjustment</th>
                    <th class="th-default">New Stock</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="td-product">
                        <div class="product-info-flex">
                            <img src="<?= BASE_URL ?>/admin_assets/image/placeholder.png" alt="" class="product-image">
                            <div>
                                <p class="product-name-txt m-0">Geek Bar Pulse 15k</p>
                                <p class="text-muted-xs m-0">Blue Razz Ice</p>
                            </div>
                        </div>
                    </td>
                    <td class="td-default text-muted">GB-PULSE-BR</td>
                    <td class="td-default fw-600">12</td>
                    <td class="td-default">
                        <input type="number" class="modal-field-input" style="width: 80px; padding: 5px;" value="0">
                    </td>
                    <td class="td-default text-muted">12</td>
                </tr>
                <tr>
                    <td class="td-product">
                        <div class="product-info-flex">
                            <img src="<?= BASE_URL ?>/admin_assets/image/placeholder.png" alt="" class="product-image">
                            <div>
                                <p class="product-name-txt m-0">Oxbar x Pod Juice</p>
                                <p class="text-muted-xs m-0">Clear / 5%</p>
                            </div>
                        </div>
                    </td>
                    <td class="td-default text-muted">OX-POD-CLR</td>
                    <td class="td-default fw-600">5</td>
                    <td class="td-default">
                        <input type="number" class="modal-field-input" style="width: 80px; padding: 5px;" value="10">
                    </td>
                    <td class="td-default text-success fw-600">15</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
