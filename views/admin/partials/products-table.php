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
        <?php 
            $start = ($pagination['current_page'] - 1) * $pagination['per_page'] + 1;
            $end = min($start + $pagination['per_page'] - 1, $pagination['total']);
        ?>
        Showing <span id="page-start"><?= $start ?></span> to <span id="page-end"><?= $end ?></span> of <span id="page-total"><?= $pagination['total'] ?></span> entries
    </div>
    <?= \App\Helpers\PaginationHelper::render($pagination, BASE_URL . '/admin/products') ?>
</div>
