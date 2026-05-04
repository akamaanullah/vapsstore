<?php 
$pageTitle = "Products | Vape Store Admin";
$pageScript = "products.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Products</h1>
    
    <div class="header-actions">
        <div class="search-container">
            <input type="text" placeholder="Search products..." class="search-input">
        </div>
        <select class="status-dropdown">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="draft">Draft</option>
            <option value="archived">Archived</option>
        </select>
        <div class="per-page-container">
            <span class="text-label">Rows:</span>
            <select class="per-page-select">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
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

<div class="card card-no-padding">
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th class="th-product">Product</th>
                    <th class="th-default">Status</th>
                    <th class="th-default">Price</th>
                    <th class="th-default">Collections</th>
                    <th class="th-default">Variants</th>
                    <th class="th-default">Created At</th>
                    <th class="th-action">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (empty($products)): ?>
                    <tr>
                        <td colspan="7" class="text-center" style="padding: 40px; color: var(--text-muted);">
                            <i data-lucide="package-search" style="width: 48px; height: 48px; margin-bottom: 10px; opacity: 0.5;"></i>
                            <p>No products found. Start by adding your first product!</p>
                        </td>
                    </tr>
                <?php else:
                foreach ($products as $product): ?>
                <tr>
                    <td class="td-product">
                        <div class="product-info-flex">
                            <?php 
                            $imgUrl = !empty($product['featured_image']) 
                                      ? BASE_URL . '/' . $product['featured_image'] 
                                      : BASE_URL . '/admin_assets/image/placeholder.png';
                            ?>
                            <img src="<?= $imgUrl ?>" alt="" class="product-image" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                            <span class="product-name-txt"><?= htmlspecialchars($product['name']) ?></span>
                        </div>
                    </td>
                    <td class="td-default">
                        <?php 
                        $badgeClass = 'badge-active';
                        $statusText = 'Active';
                        if ($product['status'] == 'draft') { $badgeClass = 'badge-draft'; $statusText = 'Draft'; }
                        if ($product['status'] == 'archived') { $badgeClass = 'badge-archived'; $statusText = 'Archived'; }
                        ?>
                        <span class="status-badge <?php echo $badgeClass; ?>">
                            <?php echo $statusText; ?>
                        </span>
                    </td>
                    <td class="td-default text-price">$<?php echo number_format($product['base_price'], 2); ?></td>
                    <td class="td-default text-muted"><?php echo !empty($product['collection_names']) ? $product['collection_names'] : '---'; ?></td>
                    <td class="td-default text-muted">
                        <?php 
                        if (isset($product['variants_count']) && $product['variants_count'] > 0) {
                            echo $product['variants_count'] . ' variants';
                        } else {
                            echo 'No variants';
                        }
                        ?>
                    </td>
                    <td class="td-default text-muted"><?php echo date('M d, Y', strtotime($product['created_at'])); ?></td>
                    <td class="td-action">
                        <div class="action-flex">
                            <a href="<?= BASE_URL ?>/admin/products/edit/<?= $product['id'] ?>" class="btn-action-icon edit-btn" title="Edit Product">
                                <i data-lucide="pencil"></i>
                            </a>
                            <form action="<?= BASE_URL ?>/admin/products/delete/<?= $product['id'] ?>" method="POST" class="delete-product-form" style="display:inline;">
                                <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
                                <button type="button" class="btn-action-icon delete-btn" title="Delete">
                                    <i data-lucide="trash-2"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; 
                endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="pagination-container">
        <div class="pagination-info">
            Showing <span id="page-start">0</span> to <span id="page-end">0</span> of <span id="page-total">0</span> entries
        </div>
        <ul class="pagination">
            <!-- Populated by JS -->
        </ul>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>


