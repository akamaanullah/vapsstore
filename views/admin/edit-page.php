<?php 
$pageTitle = "Edit Page | Vape Store Admin";
$pageScript = ["section-builder.js"]; 
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/pages" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Edit Page: <?= htmlspecialchars($page['title']) ?></h1>
    </div>
</div>

<form action="<?= BASE_URL ?>/admin/pages/update/<?= $page['id'] ?>" method="POST">
<input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
<div class="form-layout">
    <div class="form-main">
        <div class="card">
            <div class="form-group">
                <label>Page Title</label>
                <input type="text" name="title" id="pageTitleInput" class="modal-field-input" value="<?= htmlspecialchars($page['title']) ?>" required>
            </div>
        </div>

        <!-- Dynamic Section Builder -->
        <div class="card mt-20">
            <div class="card-header-flex">
                <h3 class="card-title-sm">Page Content (Section Builder)</h3>
                <button type="button" class="btn btn-outline btn-sm" id="addSectionBtn">
                    <i data-lucide="plus" class="icon-xs"></i> Add Section
                </button>
            </div>
            <p class="text-muted-sm">Build your page layout using dynamic sections.</p>
            
            <div id="sectionsContainer" class="sections-builder-container">
                <div class="empty-sections-placeholder">
                    <i data-lucide="layout" class="icon-lg text-muted opacity-2"></i>
                    <p>No sections added yet. Click "Add Section" to start building.</p>
                </div>
            </div>
        </div>

        <!-- SEO Listing -->
        <div class="card">
            <div class="card-header-flex">
                <h3 class="card-title-sm">Search engine listing</h3>
                <p class="text-muted-sm m-0">Preview how this page will appear in search results</p>
            </div>
            
            <div class="form-group mt-15">
                <label>Page title (SEO)</label>
                <input type="text" name="meta_title" id="metaTitleInput" class="modal-field-input" value="<?= htmlspecialchars($page['meta_title']) ?>" placeholder="SEO Title" maxlength="70">
                <div class="char-counter"><span id="metaTitleCount"><?= strlen($page['meta_title']) ?></span> of 70 characters used</div>
            </div>
            <div class="form-group">
                <label>Meta description</label>
                <textarea name="meta_desc" id="metaDescInput" class="modal-field-input" rows="3" placeholder="SEO Description" maxlength="320"><?= htmlspecialchars($page['meta_desc']) ?></textarea>
                <div class="char-counter"><span id="metaDescCount"><?= strlen($page['meta_desc']) ?></span> of 320 characters used</div>
            </div>
            <div class="form-group mb-20">
                <label>URL handle</label>
                <div class="input-prefix-container">
                    <span class="prefix">/page/</span>
                    <input type="text" name="custom_url_path" id="slugInput" class="modal-field-input" value="<?= htmlspecialchars($page['custom_url_path']) ?>" placeholder="about-us">
                </div>
            </div>

            <div class="seo-preview-box">
                <div class="seo-preview-header">
                    <i data-lucide="globe" class="seo-preview-icon"></i>
                    <span class="seo-preview-site">The Perfect Vape</span>
                </div>
                <div class="seo-preview-url"><?= BASE_URL ?>/page/<span id="previewSlug"><?= htmlspecialchars($page['custom_url_path']) ?></span></div>
                <div class="seo-preview-title" id="previewTitle"><?= $page['meta_title'] ?: $page['title'] ?></div>
                <div class="seo-preview-desc" id="previewDesc"><?= $page['meta_desc'] ?: 'Add a description to see how this page might appear in a search engine listing...' ?></div>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <div class="card">
            <h3 class="card-title-sm mb-10">Visibility</h3>
            <select name="status" class="modal-field-input">
                <option value="active" <?= $page['is_active'] ? 'selected' : '' ?>>Published</option>
                <option value="hidden" <?= !$page['is_active'] ? 'selected' : '' ?>>Hidden</option>
            </select>
        </div>
    </div>
</div>

<div class="form-actions-bar">
    <div class="actions-left">
        <a href="<?= BASE_URL ?>/admin/pages" class="btn-outline" style="text-decoration: none;">Discard</a>
    </div>
    <div class="actions-right">
        <button type="submit" class="btn btn-primary">Update Page</button>
    </div>
</div>
</form>

<script>
    // Inject existing sections into the builder
    window.initialSectionsData = <?= json_encode($sections) ?>; 

    // SEO Real-time Preview Logic
    const titleInput = document.getElementById('pageTitleInput');
    const metaTitleInput = document.getElementById('metaTitleInput');
    const metaDescInput = document.getElementById('metaDescInput');
    const slugInput = document.getElementById('slugInput');

    const previewTitle = document.getElementById('previewTitle');
    const previewDesc = document.getElementById('previewDesc');
    const previewSlug = document.getElementById('previewSlug');

    const metaTitleCount = document.getElementById('metaTitleCount');
    const metaDescCount = document.getElementById('metaDescCount');

    // Sync Page Title to Slug and SEO Title
    titleInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.auto === 'true') {
            const slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            slugInput.value = slug;
            previewSlug.innerText = slug || 'about-us';
            slugInput.dataset.auto = 'true';
        }
        if (!metaTitleInput.value) {
            previewTitle.innerText = this.value || 'Page Title';
        }
    });

    // On edit, don't auto-sync slug if it already exists
    slugInput.dataset.auto = 'false';

    metaTitleInput.addEventListener('input', function() {
        previewTitle.innerText = this.value || titleInput.value || 'Page Title';
        metaTitleCount.innerText = this.value.length;
    });

    metaDescInput.addEventListener('input', function() {
        previewDesc.innerText = this.value || 'Add a description to see how this page might appear in a search engine listing...';
        metaDescCount.innerText = this.value.length;
    });

    slugInput.addEventListener('input', function() {
        previewSlug.innerText = this.value || 'about-us';
        slugInput.dataset.auto = 'false';
    });
</script>
<?php include __DIR__ . '/partials/footer.php'; ?>
