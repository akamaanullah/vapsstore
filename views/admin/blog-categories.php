<?php 
$pageTitle = "Blog Categories | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <h1 class="m-0">Blog Categories</h1>
    </div>
    <div class="header-actions">
        <button class="btn btn-primary btn-add" onclick="openAddModal()">
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
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td class="td-default fw-600"><?php echo htmlspecialchars($cat['name']); ?></td>
                        <td class="td-default text-muted"><?php echo htmlspecialchars($cat['slug']); ?></td>
                        <td class="td-default"><span class="badge badge-light"><?php echo $cat['post_count']; ?> posts</span></td>
                        <td class="td-action">
                            <div class="action-flex">
                                <button class="btn-action-icon edit-btn" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($cat)); ?>)">
                                    <i data-lucide="pencil"></i>
                                </button>
                                <button type="button" class="btn-action-icon delete-btn" onclick="confirmDelete(<?php echo $cat['id']; ?>)">
                                    <i data-lucide="trash-2"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="p-0">
                            <div class="empty-state-wrapper">
                                <div class="empty-state-icon">
                                    <i data-lucide="folder-open"></i>
                                </div>
                                <h3 class="empty-state-title">No Categories Found</h3>
                                <p class="empty-state-desc">Organize your blog posts by creating your first category here.</p>
                                <button class="btn btn-primary btn-add-first" onclick="openAddModal()">
                                    <i data-lucide="plus"></i> Add First Category
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="categoryModal" class="custom-modal" style="display: none;">
    <div class="modal-overlay" onclick="closeModal()"></div>
    <div class="modal-content animate-slide-up" style="max-width: 450px;">
        <div class="modal-header border-0 pb-0">
            <h3 id="modalTitle" class="m-0 fs-20 fw-700 text-dark">Add Category</h3>
            <button class="close-modal" onclick="closeModal()"><i data-lucide="x"></i></button>
        </div>
        <form id="categoryForm" action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
            <div class="modal-body pt-20">
                <div class="form-group mb-20">
                    <label class="form-label fw-600 mb-8">Category Name</label>
                    <input type="text" name="name" id="catName" class="form-input form-input-full" required placeholder="e.g. Vaping Guides" style="height: 48px; border-radius: 10px; padding-inline: 10px;">
                </div>
                <div class="form-group mb-0">
                    <label class="form-label fw-600 mb-8">URL Slug (Optional)</label>
                    <div class="input-prefix-wrapper" style="position: relative; width: 100%;">
                        <input type="text" name="slug" id="catSlug" class="form-input form-input-full" placeholder="vaping-guides" style="height: 48px; border-radius: 10px; padding-inline: 10px;">
                    </div>
                    <p class="fs-12 text-muted mt-8">Must be unique, lowercase and use hyphens.</p>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 d-flex justify-content-end gap-12 pb-25">
                <button type="button" class="btn btn-light" onclick="closeModal()" style="height: 44px; padding: 0 20px; border-radius: 10px;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="height: 44px; padding: 0 25px; border-radius: 10px; background: #6f6af8; border: none; box-shadow: 0 4px 6px -1px rgba(111, 106, 248, 0.2);">Save Category</button>
            </div>
        </form>
    </div>
</div>

<style>
.empty-state-wrapper {
    padding: 100px 20px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 400px;
}
.empty-state-icon {
    background: #f8fafc;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}
.empty-state-icon i {
    width: 36px;
    height: 36px;
    color: #94a3b8;
}
.empty-state-title {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
}
.empty-state-desc {
    color: #64748b;
    margin: 10px auto 0;
    font-size: 14px;
    max-width: 300px;
    line-height: 1.5;
}
.btn-add-first {
    margin-top: 25px;
    padding: 0 30px;
    height: 48px;
    border-radius: 12px;
    font-weight: 600;
    box-shadow: 0 10px 15px -3px rgba(111, 106, 248, 0.2);
}

.form-input-group {
    width: 100%;
}
.form-input-full {
    width: 100% !important;
    display: block;
}

.custom-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}
.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
}
.modal-content {
    background: #fff;
    border-radius: 20px;
    width: 90%;
    position: relative;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    z-index: 10001;
}
.animate-slide-up {
    animation: slideUp 0.3s ease-out;
}
@keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
.modal-header { padding: 25px 25px 0; display: flex; justify-content: space-between; align-items: center; }
.modal-body { padding: 25px; }
.modal-footer { padding: 0 25px 25px; display: flex; justify-content: flex-end; gap: 12px; }
.close-modal { 
    background: #f1f5f9; 
    border: none; 
    width: 32px; 
    height: 32px; 
    border-radius: 50%; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    cursor: pointer; 
    color: #64748b; 
    transition: all 0.2s;
}
.close-modal:hover { background: #e2e8f0; color: #0f172a; }
.badge-light {
    background: #f1f5f9;
    color: #475569;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}
</style>

<script>
function openAddModal() {
    document.getElementById('modalTitle').innerText = 'Add Category';
    document.getElementById('categoryForm').action = '<?php echo BASE_URL; ?>/admin/blog-categories/store';
    document.getElementById('catName').value = '';
    document.getElementById('catSlug').value = '';
    document.getElementById('categoryModal').style.display = 'flex';
}

function openEditModal(cat) {
    document.getElementById('modalTitle').innerText = 'Edit Category';
    document.getElementById('categoryForm').action = '<?php echo BASE_URL; ?>/admin/blog-categories/update/' + cat.id;
    document.getElementById('catName').value = cat.name;
    document.getElementById('catSlug').value = cat.slug;
    document.getElementById('categoryModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('categoryModal').style.display = 'none';
}

function confirmDelete(id) {
    Swal.fire({
        title: 'Delete Category?',
        text: "Any blog posts in this category will become un-categorized. This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        borderRadius: '15px'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?php echo BASE_URL; ?>/admin/blog-categories/delete/' + id;
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = 'csrf_token';
            csrf.value = '<?= \App\Core\Session::getCsrfToken() ?>';
            form.appendChild(csrf);

            document.body.appendChild(form);
            form.submit();
        }
    });
}

document.getElementById('catName').addEventListener('input', function() {
    const slug = this.value.toLowerCase().trim().replace(/ /g, '-').replace(/[^\w-]+/g, '');
    document.getElementById('catSlug').placeholder = slug;
});
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>
