<?php 
$pageTitle = "Edit Collection | Vape Store Admin";
$pageScript = ["add-collection.js", "section-builder.js"]; 
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/collections" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Edit: <?= htmlspecialchars($collection['name']) ?></h1>
    </div>
    <div class="header-actions">
        <form action="<?= BASE_URL ?>/admin/collections/delete/<?= $collection['id'] ?>" method="POST" id="deleteCollectionForm" style="display:inline;">
            <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
            <button type="button" class="btn btn-outline text-error" id="deleteCollectionBtn">Delete collection</button>
        </form>
    </div>
</div>

<form action="<?= BASE_URL ?>/admin/collections/update/<?= $collection['id'] ?>" method="POST" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
<div class="form-layout">
    <div class="form-main">
        <div class="card">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="name" id="collectionTitleInput" class="modal-field-input" value="<?= htmlspecialchars($collection['name']) ?>" placeholder="e.g. Summer Sale, Disposables" required>
            </div>
            <div class="form-group mb-0">
                <label>Description</label>
                <div class="rich-text-editor">
                    <div class="rte-toolbar">
                        <button type="button" data-command="bold" title="Bold"><i data-lucide="bold"></i></button>
                        <button type="button" data-command="italic" title="Italic"><i data-lucide="italic"></i></button>
                        <button type="button" data-command="underline" title="Underline"><i data-lucide="underline"></i></button>
                        <button type="button" data-command="insertUnorderedList" title="Bullet List"><i data-lucide="list"></i></button>
                        <button type="button" data-command="insertOrderedList" title="Numbered List"><i data-lucide="list-ordered"></i></button>
                        <button type="button" data-command="createLink" title="Insert Link"><i data-lucide="link"></i></button>
                        <button type="button" data-command="formatBlock" data-value="h2" title="Heading 2"><i data-lucide="heading-2"></i></button>
                        <button type="button" data-command="formatBlock" data-value="h3" title="Heading 3"><i data-lucide="heading-3"></i></button>
                        <button type="button" data-command="removeFormat" title="Clear Formatting"><i data-lucide="remove-formatting"></i></button>
                    </div>
                    <div class="rte-editor-content" contenteditable="true" data-placeholder="Add a detailed description for your collection...">
                        <?= $collection['short_description'] ?>
                    </div>
                    <textarea name="description" id="descriptionInput" style="display: none;"><?= htmlspecialchars($collection['short_description']) ?></textarea>
                </div>
            </div>
        </div>

        <!-- Collection Image -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Collection Image</h3>
            <div class="media-upload-area" id="mediaUploadArea" style="min-height: 120px; padding: 20px;">
                <input type="hidden" name="header_image_url" id="collectionImageUrlInput" value="<?= htmlspecialchars($collection['header_image_url'] ?? '') ?>">
                
                <div class="media-placeholder" id="imagePlaceholder" style="<?= !empty($collection['header_image_url']) ? 'display: none;' : '' ?>">
                    <i data-lucide="image" class="icon-lg text-muted"></i>
                    <p class="mt-10 mb-5 fw-600">Select collection image</p>
                    <p class="text-muted-sm m-0">This image will appear at the top of the collection page.</p>
                    <button type="button" class="btn btn-outline btn-sm mt-15" id="openMediaPickerBtn">Browse Media</button>
                </div>
                
                <div id="imagePreview" class="media-preview-grid" style="<?= !empty($collection['header_image_url']) ? 'display: grid;' : 'display: none;' ?> grid-template-columns: 1fr; gap: 0;">
                    <div class="media-item" style="margin: 0; height: 180px;">
                        <img id="collectionPreviewImg" src="<?= !empty($collection['header_image_url']) ? BASE_URL . '/' . ltrim($collection['header_image_url'], '/') : '' ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                        <button type="button" class="btn-action-icon remove-img-btn" onclick="removeCollectionImage()" style="position: absolute; top: 10px; right: 10px; background: white; border: 1px solid var(--border-color); box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <i data-lucide="trash-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Engine Listing -->
        <div class="card">
            <div class="card-header-flex">
                <h3 class="card-title-sm">Search engine listing</h3>
                <a href="#" id="toggleSeoBtn" class="link-primary-sm">Edit website SEO</a>
            </div>
            <p class="text-muted-sm">Add a title and description to see how this collection might appear in a search engine listing</p>
            
            <div id="seoFields" class="seo-fields-container">
                <div class="form-group">
                    <label>Page title</label>
                    <input type="text" name="seo_title" class="modal-field-input seo-title-input" value="<?= htmlspecialchars($collection['meta_title'] ?? '') ?>" placeholder="Enter page title" maxlength="70">
                    <div class="char-counter"><span class="seo-title-count"><?= strlen($collection['meta_title'] ?? '') ?></span> of 70 characters used</div>
                </div>
                
                <div class="form-group">
                    <label>Meta description</label>
                    <textarea name="seo_description" class="modal-field-input seo-desc-input" rows="4" placeholder="Enter meta description" maxlength="320"><?= htmlspecialchars($collection['meta_desc'] ?? '') ?></textarea>
                    <div class="char-counter"><span class="seo-desc-count"><?= strlen($collection['meta_desc'] ?? '') ?></span> of 320 characters used</div>
                </div>

                <div class="form-group">
                    <label>URL handle</label>
                    <div class="input-prefix-container">
                        <span class="prefix">.../collections/</span>
                        <input type="text" name="custom_url" id="slugInput" class="modal-field-input" value="<?= htmlspecialchars($collection['custom_url_path']) ?>" placeholder="summer-sale">
                    </div>
                </div>

                <div class="seo-preview-box">
                    <div class="seo-preview-header">
                        <i data-lucide="globe" class="seo-preview-icon"></i>
                        <span class="seo-preview-site">The Perfect Vape</span>
                    </div>
                    <div class="seo-preview-url">www.theperfectvape.com/collections/<?= $collection['custom_url_path'] ?></div>
                    <div class="seo-preview-title"><?= htmlspecialchars($collection['meta_title'] ?: $collection['name']) ?></div>
                    <div class="seo-preview-desc"><?= htmlspecialchars($collection['meta_desc'] ?: 'Discover our curated selection of high-performance products...') ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <div class="card">
            <h3 class="card-title-sm mb-10">Status</h3>
            <select name="status" class="modal-field-input">
                <option value="active" <?= $collection['is_active'] ? 'selected' : '' ?>>Active</option>
                <option value="hidden" <?= !$collection['is_active'] ? 'selected' : '' ?>>Hidden</option>
            </select>
        </div>

        <div class="card">
            <h3 class="card-title-sm mb-10">Organization</h3>
            <div class="form-group mb-0">
                <label>Parent Collection</label>
                <select name="parent_id" class="modal-field-input">
                    <option value="">None</option>
                    <?php foreach ($allCollections as $col): ?>
                        <?php if ($col['id'] != $collection['id']): // Prevent selecting itself as parent ?>
                            <option value="<?= $col['id'] ?>" <?= $col['id'] == $collection['parent_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($col['name']) ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <p class="text-muted-sm mt-5">Choose a parent if this is a sub-collection.</p>
            </div>
        </div>
    </div>
</div>

<!-- Dynamic Section Builder -->
<div class="card mt-20">
    <div class="card-header-flex">
        <h3 class="card-title-sm">Page Sections (Dynamic Builder)</h3>
        <button type="button" class="btn btn-outline btn-sm" id="addSectionBtn">
            <i data-lucide="plus" class="icon-xs"></i> Add Section
        </button>
    </div>
    <p class="text-muted-sm">Enhance your collection page with Bento Grids, Smoke Sections, FAQs, and more.</p>
    
    <div id="sectionsContainer" class="sections-builder-container">
        <!-- Sections will be rendered here by section-builder.js -->
        <?php if (empty($sections)): ?>
            <div class="empty-sections-placeholder">
                <i data-lucide="layout" class="icon-lg text-muted opacity-2"></i>
                <p>No custom sections added yet. Click "Add Section" to start building.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-actions-bar">
    <div class="actions-left">
        <a href="<?= BASE_URL ?>/admin/collections" class="btn-outline" style="text-decoration: none;">Discard</a>
    </div>
    <div class="actions-right">
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</div>
</form>

<script>
    window.initialSectionsData = <?= json_encode($sections) ?>;

    document.getElementById('openMediaPickerBtn').addEventListener('click', () => {
        if (window.mediaPicker) {
            window.mediaPicker.open({
                multiple: false,
                onSelect: (item) => {
                    document.getElementById('collectionImageUrlInput').value = item.file_path;
                    document.getElementById('collectionPreviewImg').src = window.MEDIA_BASE_URL + '/' + item.file_path;
                    document.getElementById('imagePlaceholder').style.display = 'none';
                    document.getElementById('imagePreview').style.display = 'grid';
                }
            });
        }
    });

    function removeCollectionImage() {
        document.getElementById('collectionImageUrlInput').value = '';
        document.getElementById('imagePlaceholder').style.display = 'flex';
        document.getElementById('imagePreview').style.display = 'none';
    }
</script>

<?php include __DIR__ . '/partials/media-picker-modal.php'; ?>
<?php include __DIR__ . '/partials/footer.php'; ?>
