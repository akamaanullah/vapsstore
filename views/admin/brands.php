<?php 
$pageTitle = "Brands | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Brands</h1>
    
    <div class="header-actions">
        <div class="search-container">
            <input type="text" placeholder="Search brands..." class="search-input" id="brandSearch">
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
                <?php if (empty($brands)): ?>
                <tr>
                    <td colspan="4">
                        <div class="empty-table-state py-50" style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%;">
                            <div class="empty-state-icon mb-15" style="color: #cbd5e0;">
                                <i data-lucide="shield-off" style="width: 64px; height: 64px;"></i>
                            </div>
                            <h3 class="m-0 text-muted-sm" style="font-size: 18px; font-weight: 600;">No brands found</h3>
                            <p class="text-muted-sm mt-5">Click the "Add Brand" button to create your first brand.</p>
                        </div>
                    </td>
                </tr>
                <?php else: ?>
                    <?php foreach ($brands as $brand): ?>
                    <tr>
                        <td class="td-product">
                            <div class="product-info-flex">
                                <div class="brand-logo-preview" style="width: 40px; height: 40px; border-radius: 4px; overflow: hidden; border: 1px solid #eee; display: flex; align-items: center; justify-content: center;">
                                    <?php if ($brand['logo_url']): ?>
                                        <img src="<?= BASE_URL . '/' . $brand['logo_url'] ?>" alt="<?= $brand['name'] ?>" style="width: 100%; height: 100%; object-fit: contain;">
                                    <?php else: ?>
                                        <i data-lucide="image" class="text-muted-sm" style="width: 20px;"></i>
                                    <?php endif; ?>
                                </div>
                                <span class="product-name-txt"><?php echo htmlspecialchars($brand['name']); ?></span>
                            </div>
                        </td>
                        <td class="td-default text-muted"><?php echo htmlspecialchars($brand['slug']); ?></td>
                        <td class="td-default">
                            <span class="status-badge <?= $brand['is_active'] ? 'badge-active' : 'badge-draft' ?>">
                                <?= $brand['is_active'] ? 'Active' : 'Hidden' ?>
                            </span>
                        </td>
                        <td class="td-action">
                            <div class="action-flex">
                                <a href="<?= BASE_URL ?>/admin/brands/edit/<?= $brand['id'] ?>" class="btn-action-icon edit-btn" title="Edit">
                                    <i data-lucide="pencil"></i>
                                </a>
                                <button class="btn-action-icon delete-btn" title="Delete" onclick="deleteBrand(<?= $brand['id'] ?>)">
                                    <i data-lucide="trash-2"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function deleteBrand(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e16449',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= BASE_URL ?>/admin/brands/delete/' + id;
        }
    });
}

// Simple search logic
document.getElementById('brandSearch').addEventListener('keyup', function() {
    let filter = this.value.toUpperCase();
    let rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        let name = row.querySelector('.product-name-txt')?.textContent || '';
        if (name.toUpperCase().indexOf(filter) > -1) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>
