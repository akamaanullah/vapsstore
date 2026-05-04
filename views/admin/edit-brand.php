<?php 
$pageTitle = "Edit Brand | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/brands" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Edit Brand: <?= htmlspecialchars($brand['name']) ?></h1>
    </div>
</div>

<form action="<?= BASE_URL ?>/admin/brands/update/<?= $brand['id'] ?>" method="POST" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
<div class="form-layout">
    <div class="form-main">
        <div class="card">
            <div class="form-group">
                <label>Brand Name</label>
                <input type="text" name="name" id="brandNameInput" class="modal-field-input" value="<?= htmlspecialchars($brand['name']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>URL Slug</label>
                <input type="text" name="slug" id="slugInput" class="modal-field-input" value="<?= htmlspecialchars($brand['slug']) ?>">
            </div>
        </div>

        <div class="card">
            <h3 class="card-title-sm mb-15">Brand Logo</h3>
            <div class="media-upload-area" id="logoUploadArea" style="min-height: 120px; padding: 20px;">
                <input type="file" name="logo" id="logoInput" accept="image/*" style="display: none;">
                
                <div class="media-placeholder" id="logoPlaceholder" style="<?= $brand['logo_url'] ? 'display: none;' : 'display: flex;' ?>">
                    <i data-lucide="image" class="icon-lg text-muted"></i>
                    <p class="mt-10 mb-5 fw-600">Click to upload logo</p>
                    <button type="button" class="btn btn-outline btn-sm mt-15" onclick="document.getElementById('logoInput').click()">Add Logo</button>
                </div>

                <div id="logoPreview" class="media-preview-grid" style="<?= $brand['logo_url'] ? 'display: grid;' : 'display: none;' ?> grid-template-columns: 1fr; gap: 0;">
                    <?php if ($brand['logo_url']): ?>
                    <div class="preview-item">
                        <img src="<?= BASE_URL . '/' . $brand['logo_url'] ?>" style="width: 100%; max-height: 150px; object-fit: contain;">
                        <button type="button" class="remove-preview-btn" onclick="removeLogo()">&times;</button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <div class="card">
            <h3 class="card-title-sm mb-10">Status</h3>
            <select name="status" class="modal-field-input">
                <option value="active" <?= $brand['is_active'] ? 'selected' : '' ?>>Active</option>
                <option value="hidden" <?= !$brand['is_active'] ? 'selected' : '' ?>>Hidden</option>
            </select>
        </div>
    </div>
</div>

<div class="form-actions-bar">
    <div class="actions-left">
        <a href="<?= BASE_URL ?>/admin/brands" class="btn-outline" style="text-decoration: none;">Discard</a>
    </div>
    <div class="actions-right">
        <button type="submit" class="btn btn-primary">Update Brand</button>
    </div>
</div>
</form>

<script>
document.getElementById('logoInput').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('logoPlaceholder').style.display = 'none';
            const preview = document.getElementById('logoPreview');
            preview.style.display = 'grid';
            preview.innerHTML = `
                <div class="preview-item">
                    <img src="${e.target.result}" style="width: 100%; max-height: 150px; object-fit: contain;">
                    <button type="button" class="remove-preview-btn" onclick="removeLogo()">&times;</button>
                </div>
            `;
        }
        reader.readAsDataURL(file);
    }
});

function removeLogo() {
    document.getElementById('logoInput').value = '';
    document.getElementById('logoPlaceholder').style.display = 'flex';
    document.getElementById('logoPreview').style.display = 'none';
}
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>
