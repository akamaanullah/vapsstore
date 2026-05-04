<?php 
$pageTitle = "Brands | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Brands</h1>
    
    <div class="header-actions">
        <div class="search-container">
            <input type="text" placeholder="Search brands..." class="search-input">
        </div>
        <a href="<?= BASE_URL ?>/admin/brands/create" class="btn btn-primary btn-add">
            <i data-lucide="plus"></i>
            <span>Add Brand</span>
        </a>
    </div>
</div>

<div class="card card-no-padding">
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th class="th-product">Brand</th>
                    <th class="th-default">Slug</th>
                    <th class="th-default">Status</th>
                    <th class="th-action">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sampleBrands = [
                    ['name' => 'GeekVape', 'slug' => 'geekvape', 'status' => 'Active'],
                    ['name' => 'Smok', 'slug' => 'smok', 'status' => 'Active'],
                    ['name' => 'Vaporesso', 'slug' => 'vaporesso', 'status' => 'Active'],
                    ['name' => 'Lost Mary', 'slug' => 'lost-mary', 'status' => 'Active'],
                ];
                
                foreach ($sampleBrands as $brand): ?>
                <tr>
                    <td class="td-product">
                        <div class="product-info-flex">
                            <div class="brand-logo-placeholder" style="width: 40px; height: 40px; background: #f0f0f0; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                <i data-lucide="image" class="text-muted-sm" style="width: 20px;"></i>
                            </div>
                            <span class="product-name-txt"><?php echo $brand['name']; ?></span>
                        </div>
                    </td>
                    <td class="td-default text-muted"><?php echo $brand['slug']; ?></td>
                    <td class="td-default">
                        <span class="status-badge badge-active"><?php echo $brand['status']; ?></span>
                    </td>
                    <td class="td-action">
                        <div class="action-flex">
                            <a href="<?= BASE_URL ?>/admin/brands/edit" class="btn-action-icon edit-btn" title="Edit">
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
