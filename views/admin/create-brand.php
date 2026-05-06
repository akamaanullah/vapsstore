<?php 
$pageTitle = "Add Brand | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/brands" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Create Brand</h1>
    </div>
</div>

<form action="<?= BASE_URL ?>/admin/brands/store" method="POST" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
<div class="form-layout">
    <div class="form-main">
        <div class="card">
            <div class="form-group">
                <label>Brand Name</label>
                <input type="text" name="name" id="brandNameInput" class="modal-field-input" placeholder="e.g. GeekVape, Smok" required>
            </div>
            
            <div class="form-group">
                <label>URL Slug (Optional)</label>
                <input type="text" name="slug" id="slugInput" class="modal-field-input" placeholder="e.g. geek-vape">
                <p class="text-muted-sm mt-5">Leave blank to auto-generate from name.</p>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title-sm mb-15">Brand Logo</h3>
            <div class="media-upload-area" id="logoUploadArea" style="min-height: 120px; padding: 20px;">
                <input type="hidden" name="logo_url" id="logoUrlInput" value="">
                <div class="media-placeholder" id="logoPlaceholder">
                    <i data-lucide="image" class="icon-lg text-muted"></i>
                    <p class="mt-10 mb-5 fw-600">Select logo from gallery</p>
                    <button type="button" class="btn btn-outline btn-sm mt-15" id="openMediaPickerBtn">Browse Media</button>
                </div>
                <div id="logoPreview" class="media-preview-grid" style="display: none; grid-template-columns: 1fr; gap: 0;">
                    <div class="preview-item">
                        <img id="logoPreviewImg" src="" style="width: 100%; max-height: 150px; object-fit: contain;">
                        <button type="button" class="remove-preview-btn" onclick="removeLogo()">&times;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <div class="card">
            <h3 class="card-title-sm mb-10">Status</h3>
            <select name="status" class="modal-field-input">
                <option value="active">Active</option>
                <option value="hidden">Hidden</option>
            </select>
        </div>
    </div>
</div>

<div class="form-actions-bar">
    <div class="actions-left">
        <a href="<?= BASE_URL ?>/admin/brands" class="btn-outline" style="text-decoration: none;">Discard</a>
    </div>
    <div class="actions-right">
        <button type="submit" class="btn btn-primary">Save Brand</button>
    </div>
</div>
</form>

<script>
document.getElementById('openMediaPickerBtn').addEventListener('click', () => {
    if (window.mediaPicker) {
        window.mediaPicker.open({
            multiple: false,
            onSelect: (item) => {
                document.getElementById('logoUrlInput').value = item.file_path;
                document.getElementById('logoPreviewImg').src = window.MEDIA_BASE_URL + '/' + item.file_path;
                document.getElementById('logoPlaceholder').style.display = 'none';
                document.getElementById('logoPreview').style.display = 'grid';
            }
        });
    }
});

function removeLogo() {
    document.getElementById('logoUrlInput').value = '';
    document.getElementById('logoPlaceholder').style.display = 'flex';
    document.getElementById('logoPreview').style.display = 'none';
}
</script>

<?php include __DIR__ . '/partials/media-picker-modal.php'; ?>

<?php include __DIR__ . '/partials/footer.php'; ?>
