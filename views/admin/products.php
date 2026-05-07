<?php 
$pageTitle = "Products | Vape Store Admin";
$pageScript = "products.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Products</h1>
    
    <div class="header-actions">
        <form action="<?= BASE_URL ?>/admin/products" method="GET" class="filter-form" style="display: flex; gap: 10px; align-items: center;">
            <div class="search-container">
                <input type="text" name="search" placeholder="Search products..." class="search-input" value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
            </div>
            <select name="status" class="status-dropdown">
                <option value="">All Status</option>
                <option value="active" <?= ($filters['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="draft" <?= ($filters['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                <option value="archived" <?= ($filters['status'] ?? '') === 'archived' ? 'selected' : '' ?>>Archived</option>
            </select>
            <div class="per-page-container">
                <span class="text-label">Rows:</span>
                <select name="per_page" class="per-page-select">
                    <option value="10" <?= ($pagination['per_page'] ?? 10) == 10 ? 'selected' : '' ?>>10</option>
                    <option value="25" <?= ($pagination['per_page'] ?? 10) == 25 ? 'selected' : '' ?>>25</option>
                    <option value="50" <?= ($pagination['per_page'] ?? 10) == 50 ? 'selected' : '' ?>>50</option>
                </select>
            </div>
            <button type="submit" style="display: none;">Filter</button>
        </form>
        <a href="<?= BASE_URL ?>/admin/products/export" class="btn btn-primary btn-add">
            <i data-lucide="download"></i>
            <span>Export CSV</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/products/create" class="btn btn-primary btn-add">
            <i data-lucide="plus"></i>
            <span>Add Product</span>
        </a>
    </div>
</div>

<div class="card card-no-padding" id="products-table-container">
    <?php include __DIR__ . '/partials/products-table.php'; ?>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>


