<?php 
$pageTitle = "Add Blog | Vape Store Admin";
$pageScript = "section-builder.js";
include __DIR__ . '/partials/header.php'; 
?>

<form action="<?= BASE_URL ?>/admin/blogs/store" method="POST">
<input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
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
                <input type="text" name="title" id="blogTitleInput" class="modal-field-input" placeholder="e.g. Top 10 Disposable Vapes of 2026" required>
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
            <div class="card-header-flex">
                <h3 class="card-title-sm">Search Engine Listing</h3>
                <p class="text-muted-sm m-0">Preview how this post will appear in search results</p>
            </div>
            
            <div class="form-group mt-15">
                <label>Page Title</label>
                <input type="text" name="seo_title" id="seoTitleInput" class="modal-field-input" placeholder="SEO Title" maxlength="70">
                <div class="char-counter"><span id="seoTitleCount">0</span> of 70 characters used</div>
            </div>
            
            <div class="form-group">
                <label>Meta Description</label>
                <textarea name="seo_description" id="seoDescInput" class="modal-field-input" rows="3" placeholder="SEO Description" maxlength="320"></textarea>
                <div class="char-counter"><span id="seoDescCount">0</span> of 320 characters used</div>
            </div>

            <div class="form-group mb-20">
                <label>URL handle</label>
                <div class="input-prefix-container">
                    <span class="prefix">/blogs/</span>
                    <input type="text" name="slug" id="slugInput" class="modal-field-input" placeholder="top-10-vapes">
                </div>
            </div>

            <div class="seo-preview-box">
                <div class="seo-preview-header">
                    <i data-lucide="globe" class="seo-preview-icon"></i>
                    <span class="seo-preview-site">The Perfect Vape</span>
                </div>
                <div class="seo-preview-url"><?= BASE_URL ?>/blogs/<span id="previewSlug">top-10-vapes</span></div>
                <div class="seo-preview-title" id="previewTitle">Blog Title</div>
                <div class="seo-preview-desc" id="previewDesc">Add a description to see how this blog post might appear in search results...</div>
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

    // SEO Real-time Preview Logic
    const blogTitleInput = document.getElementById('blogTitleInput');
    const seoTitleInput = document.getElementById('seoTitleInput');
    const seoDescInput = document.getElementById('seoDescInput');
    const slugInput = document.getElementById('slugInput');

    const previewTitle = document.getElementById('previewTitle');
    const previewDesc = document.getElementById('previewDesc');
    const previewSlug = document.getElementById('previewSlug');

    const seoTitleCount = document.getElementById('seoTitleCount');
    const seoDescCount = document.getElementById('seoDescCount');

    // Sync Blog Title to Slug and SEO Title
    blogTitleInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.auto === 'true') {
            const slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            slugInput.value = slug;
            previewSlug.innerText = slug || 'top-10-vapes';
            slugInput.dataset.auto = 'true';
        }
        if (!seoTitleInput.value) {
            previewTitle.innerText = this.value || 'Blog Title';
        }
    });

    slugInput.addEventListener('input', () => slugInput.dataset.auto = 'false');

    seoTitleInput.addEventListener('input', function() {
        previewTitle.innerText = this.value || blogTitleInput.value || 'Blog Title';
        seoTitleCount.innerText = this.value.length;
    });

    seoDescInput.addEventListener('input', function() {
        previewDesc.innerText = this.value || 'Add a description to see how this blog post might appear in search results...';
        seoDescCount.innerText = this.value.length;
    });

    slugInput.addEventListener('input', function() {
        previewSlug.innerText = this.value || 'top-10-vapes';
    });
</script>

<?php include __DIR__ . '/partials/media-picker-modal.php'; ?>
<?php include __DIR__ . '/partials/footer.php'; ?>
