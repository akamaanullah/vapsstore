<?php 
$pageTitle = "Pages | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Pages</h1>
    
    <div class="header-actions">
        <div class="search-container">
            <input type="text" placeholder="Search pages..." class="search-input" id="pageSearch">
        </div>
        <a href="<?= BASE_URL ?>/admin/pages/create" class="btn btn-primary btn-add">
            <i data-lucide="plus"></i>
            <span>Add Page</span>
        </a>
    </div>
</div>

<div class="card card-no-padding">
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th class="th-product">Title</th>
                    <th class="th-default">URL Path</th>
                    <th class="th-default">Status</th>
                    <th class="th-action">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pages)): ?>
                <tr>
                    <td colspan="4">
                        <div class="empty-table-state py-50" style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%;">
                            <div class="empty-state-icon mb-15" style="color: #cbd5e0;">
                                <i data-lucide="file-text" style="width: 64px; height: 64px;"></i>
                            </div>
                            <h3 class="m-0 text-muted-sm" style="font-size: 18px; font-weight: 600;">No pages found</h3>
                            <p class="text-muted-sm mt-5">Click "Add Page" to create your first content page.</p>
                        </div>
                    </td>
                </tr>
                <?php else: ?>
                    <?php foreach ($pages as $p): ?>
                    <tr>
                        <td class="td-product">
                            <span class="product-name-txt"><?php echo htmlspecialchars($p['title']); ?></span>
                        </td>
                        <td class="td-default text-muted"><?php echo htmlspecialchars($p['custom_url_path']); ?></td>
                        <td class="td-default">
                            <span class="status-badge <?= $p['is_active'] ? 'badge-active' : 'badge-draft' ?>">
                                <?= $p['is_active'] ? 'Published' : 'Hidden' ?>
                            </span>
                        </td>
                        <td class="td-action">
                            <div class="action-flex">
                                <a href="<?= BASE_URL ?>/admin/pages/edit/<?= $p['id'] ?>" class="btn-action-icon edit-btn" title="Edit">
                                    <i data-lucide="pencil"></i>
                                </a>
                                <button class="btn-action-icon delete-btn" title="Delete" onclick="deletePage(<?= $p['id'] ?>)">
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
function deletePage(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will delete the page and all its sections!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e16449',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= BASE_URL ?>/admin/pages/delete/' + id;
        }
    });
}

document.getElementById('pageSearch').addEventListener('keyup', function() {
    let filter = this.value.toUpperCase();
    let rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        let name = row.querySelector('.product-name-txt')?.textContent || '';
        if (name.toUpperCase().indexOf(filter) > -1) row.style.display = "";
        else row.style.display = "none";
    });
});
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>
