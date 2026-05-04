<?php 
$pageTitle = "Add Collection | Vape Store Admin";
$pageScript = "add-collection.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/collections" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Create Collection</h1>
    </div>
</div>

<form action="<?= BASE_URL ?>/admin/collections/store" method="POST" enctype="multipart/form-data">
<div class="form-layout">
    <div class="form-main">
        <div class="card">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="name" id="collectionTitleInput" class="modal-field-input" placeholder="e.g. Summer Sale, Disposables" required>
            </div>
            <div class="form-group mb-0">
                <label>Description</label>
                <div class="rich-text-editor">
                    <div class="rte-toolbar">
                        <select class="rte-select-clean">
                            <option>Normal</option>
                            <option>Heading 1</option>
                            <option>Heading 2</option>
                        </select>
                        <button type="button" title="Bold"><i data-lucide="bold"></i></button>
                        <button type="button" title="Italic"><i data-lucide="italic"></i></button>
                        <button type="button" title="Link"><i data-lucide="link"></i></button>
                        <button type="button" title="List"><i data-lucide="list"></i></button>
                    </div>
                    <div class="rte-editor-content" contenteditable="true" data-placeholder="Add a detailed description for your collection..."></div>
                    <textarea name="description" id="descriptionInput" style="display: none;"></textarea>
                </div>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title-sm mb-15">Collection Image</h3>
            <div class="media-upload-area" id="mediaUploadArea" style="min-height: 120px; padding: 20px;">
                <input type="file" name="image" id="collectionImageInput" accept="image/*" style="display: none;">
                <div class="media-placeholder" id="imagePlaceholder">
                    <i data-lucide="image" class="icon-lg text-muted"></i>
                    <p class="mt-10 mb-5 fw-600">Click to upload collection image</p>
                    <p class="text-muted-sm m-0">This image will appear at the top of the collection page.</p>
                    <button type="button" class="btn btn-outline btn-sm mt-15" onclick="document.getElementById('collectionImageInput').click()">Add Image</button>
                </div>
                <div id="imagePreview" class="media-preview-grid" style="display: none; grid-template-columns: 1fr; gap: 0;">
                    <!-- Preview will go here -->
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
                    <input type="text" name="seo_title" class="modal-field-input seo-title-input" placeholder="Enter page title" maxlength="70">
                    <div class="char-counter"><span class="seo-title-count">0</span> of 70 characters used</div>
                </div>
                
                <div class="form-group">
                    <label>Meta description</label>
                    <textarea name="seo_description" class="modal-field-input seo-desc-input" rows="4" placeholder="Enter meta description" maxlength="320"></textarea>
                    <div class="char-counter"><span class="seo-desc-count">0</span> of 320 characters used</div>
                </div>

                <div class="form-group">
                    <label>URL handle</label>
                    <div class="input-prefix-container">
                        <span class="prefix">.../collections/</span>
                        <input type="text" name="custom_url" id="slugInput" class="modal-field-input" placeholder="summer-sale">
                    </div>
                </div>

                <div class="seo-preview-box">
                    <div class="seo-preview-header">
                        <i data-lucide="globe" class="seo-preview-icon"></i>
                        <span class="seo-preview-site">The Perfect Vape</span>
                    </div>
                    <div class="seo-preview-url">www.theperfectvape.com/collections/...</div>
                    <div class="seo-preview-title">Collection Title</div>
                    <div class="seo-preview-desc">Collection description will appear here...</div>
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

        <div class="card">
            <h3 class="card-title-sm mb-10">Organization</h3>
            <div class="form-group mb-0">
                <label>Parent Collection</label>
                <select name="parent_id" class="modal-field-input">
                    <option value="">None</option>
                    <?php foreach ($allCollections as $col): ?>
                        <option value="<?= $col['id'] ?>"><?= $col['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <p class="text-muted-sm mt-5">Choose a parent if this is a sub-collection.</p>
            </div>
        </div>
    </div>
</div>

<div class="form-actions-bar">
    <div class="actions-left">
        <a href="<?= BASE_URL ?>/admin/collections" class="btn-outline" style="text-decoration: none;">Discard</a>
    </div>
    <div class="actions-right">
        <button type="submit" class="btn btn-primary">Save collection</button>
    </div>
</div>
</form>

<?php include __DIR__ . '/partials/footer.php'; ?>
