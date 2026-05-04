<?php 
$pageTitle = "Refund Requests | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <h1 class="m-0">Refund Requests</h1>
    </div>
</div>

<div class="card card-no-padding">
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th class="th-default">Order</th>
                    <th class="th-default">Customer</th>
                    <th class="th-default">Reason</th>
                    <th class="th-default">Status</th>
                    <th class="th-default">Date</th>
                    <th class="th-action">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="td-default"><a href="#" class="order-id-link">#ORD-2395</a></td>
                    <td class="td-default fw-600">Arsalan Khan</td>
                    <td class="td-default text-muted">Defective item received</td>
                    <td class="td-default"><span class="badge-draft">Pending</span></td>
                    <td class="td-default text-muted">May 1, 2026</td>
                    <td class="td-action">
                        <div class="action-flex">
                            <button class="btn btn-outline btn-sm">Review</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
