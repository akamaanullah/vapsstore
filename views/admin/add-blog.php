<?php 
$pageTitle = "Add Blog | Vape Store Admin";
$pageScript = "section-builder.js";
include __DIR__ . '/partials/header.php'; 
?>

<form action="<?= BASE_URL ?>/admin/blogs/store" method="POST">
<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/blogs" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Add Blog Post</h1>
    </div>
</div>

<div class="form-layout">
    <div class="form-main">
        <!-- Title Card -->
        <div class="card mb-20">
            <div class="form-group mb-0">
                <label>Blog Title</label>
                <input type="text" name="title" id="blogTitle" class="modal-field-input" placeholder="e.g. Top 10 Disposable Vapes of 2026" required>
            </div>
        </div>

        <!-- Section Builder Container -->
        <div id="sectionsContainer" class="sections-builder-wrapper">
            <div class="empty-sections-placeholder">
                <i data-lucide="layout" class="icon-lg text-muted opacity-2"></i>
                <p>No content sections added yet. Click "Add Section" to start building your article.</p>
            </div>
        </div>

        <button type="button" id="addSectionBtn" class="btn btn-outline btn-full mt-20">
            <i data-lucide="plus"></i>
            <span>Add Content Section</span>
        </button>

        <!-- SEO Card -->
        <div class="card mt-30">
            <h3 class="card-title-sm mb-15">Search Engine Listing</h3>
            <div class="form-group">
                <label>Page Title</label>
                <input type="text" name="seo_title" class="modal-field-input" placeholder="SEO Title">
            </div>
            <div class="form-group mb-0">
                <label>Meta Description</label>
                <textarea name="seo_description" class="modal-field-input" rows="3" placeholder="SEO Description"></textarea>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <!-- Visibility Card -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Visibility</h3>
            <select name="status" class="modal-field-input">
                <option value="active">Visible</option>
                <option value="hidden" selected>Hidden</option>
            </select>
        </div>

        <!-- Category Card -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Category</h3>
            <select name="category_id" class="modal-field-input">
                <option value="">Uncategorized</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Featured Image Card -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Featured Image</h3>
            <div class="image-upload-box" id="imageUploadBox">
                <input type="hidden" name="featured_image_url" id="featuredImageUrlInput">
                <div id="imagePreviewContainer" style="display: none;">
                    <img id="imagePreview" src="" alt="Preview" style="width: 100%; border-radius: 8px; margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline btn-sm btn-full text-error" onclick="removeFeaturedImage()">Remove Image</button>
                </div>
                <button type="button" class="btn btn-outline btn-full" id="openMediaPickerBtn">
                    <i data-lucide="image" class="icon-xs"></i> Select Image
                </button>
            </div>
        </div>

        <!-- Excerpt Card -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Excerpt</h3>
            <textarea name="excerpt" class="modal-field-input" rows="4" placeholder="Summary for blog listing..."></textarea>
            <p class="text-muted-xs mt-10">This summary will appear on the blog listing page.</p>
        </div>
    </div>
</div>

<div class="form-actions-bar">
    <div class="actions-left">
        <a href="<?= BASE_URL ?>/admin/blogs" class="btn-outline" style="text-decoration: none;">Discard</a>
    </div>
    <div class="actions-right">
        <button type="submit" class="btn btn-primary">Save Blog Post</button>
    </div>
</div>
</form>

<script>
document.getElementById('openMediaPickerBtn').addEventListener('click', () => {
    if (window.mediaPicker) {
        window.mediaPicker.open({
            multiple: false,
            onSelect: (item) => {
                document.getElementById('featuredImageUrlInput').value = item.file_path;
                document.getElementById('imagePreview').src = window.MEDIA_BASE_URL + '/' + item.file_path;
                document.getElementById('imagePreviewContainer').style.display = 'block';
                document.getElementById('openMediaPickerBtn').style.display = 'none';
            }
        });
    }
});

function removeFeaturedImage() {
    document.getElementById('featuredImageUrlInput').value = '';
    document.getElementById('imagePreviewContainer').style.display = 'none';
    document.getElementById('openMediaPickerBtn').style.display = 'block';
}
</script>

<?php include __DIR__ . '/partials/media-picker-modal.php'; ?>
<?php include __DIR__ . '/partials/footer.php'; ?>
