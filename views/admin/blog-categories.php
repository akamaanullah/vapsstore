<?php 
$pageTitle = "Blog Categories | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <h1 class="m-0">Blog Categories</h1>
    </div>
    <div class="header-actions">
        <button class="btn btn-primary btn-add">
            <i data-lucide="plus"></i>
            <span>Add Category</span>
        </button>
    </div>
</div>

<div class="card card-no-padding">
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th class="th-default">Category Name</th>
                    <th class="th-default">Slug</th>
                    <th class="th-default">Posts Count</th>
                    <th class="th-action">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="td-default fw-600">Vaping Guides</td>
                    <td class="td-default text-muted">vaping-guides</td>
                    <td class="td-default">12 posts</td>
                    <td class="td-action">
                        <div class="action-flex">
                            <button class="btn-action-icon edit-btn"><i data-lucide="pencil"></i></button>
                            <button class="btn-action-icon delete-btn"><i data-lucide="trash-2"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="td-default fw-600">Product Reviews</td>
                    <td class="td-default text-muted">product-reviews</td>
                    <td class="td-default">8 posts</td>
                    <td class="td-action">
                        <div class="action-flex">
                            <button class="btn-action-icon edit-btn"><i data-lucide="pencil"></i></button>
                            <button class="btn-action-icon delete-btn"><i data-lucide="trash-2"></i></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
