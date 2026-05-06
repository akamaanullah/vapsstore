<?php 
$pageTitle = "Add Product | Vape Store Admin";
$pageScript = "add-product.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/products" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Add Product</h1>
    </div>
</div>

<form id="productForm" action="<?= BASE_URL ?>/admin/products/store" method="POST" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
<div class="form-layout">
    <div class="form-main">
        <!-- Title & Description -->
        <div class="card">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="name" id="productTitleInput" class="modal-field-input" placeholder="Short Sleeve T-Shirt" required>
            </div>
            <div class="form-group">
                <label>Short Description</label>
                <textarea name="short_desc" class="modal-field-input" rows="3" placeholder="A brief summary of the product for listing pages..."></textarea>
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
                    <div class="rte-editor-content" contenteditable="true" data-placeholder="Add a detailed description for your product..."></div>
                    <textarea name="description" id="descriptionInput" style="display: none;"></textarea>
                </div>
            </div>
        </div>

        <!-- Media -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Media</h3>
            <div class="media-upload-area" id="mediaUploadArea">
                <div id="productMediaUrlsContainer"></div>
                <div class="media-placeholder" id="mediaPlaceholder">
                    <i data-lucide="image" class="icon-lg text-muted"></i>
                    <p class="mt-10 mb-5 fw-600">Select images from gallery</p>
                    <button type="button" class="btn btn-outline btn-sm mt-15" id="openMediaPickerBtn">Browse Media</button>
                </div>
                <div class="media-preview-grid" id="mediaPreviewGrid" style="display: none;">
                    <!-- Previews will go here -->
                </div>
            </div>
        </div>

        <!-- Pricing -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Pricing</h3>
            <div class="form-group mb-0">
                <div class="input-prefix-container">
                    <span class="prefix">$</span>
                    <input type="number" name="price" class="modal-field-input" placeholder="0.00" step="0.01" required>
                </div>
            </div>
        </div>

        <!-- Inventory -->
        <div class="card" id="inventoryCard">
            <h3 class="card-title-sm mb-15">Inventory</h3>
            <div class="info-grid-2">
                <div class="form-group mb-0">
                    <label>SKU (Stock Keeping Unit)</label>
                    <input type="text" name="sku" class="modal-field-input" placeholder="Enter SKU">
                </div>
                <div class="form-group mb-0">
                    <label>Quantity Available</label>
                    <input type="number" name="stock" class="modal-field-input" value="0">
                </div>
            </div>
            <div class="form-group mt-15 mb-0">
                <label class="d-flex align-items-center gap-10">
                    <input type="checkbox" checked>
                    <span>Track quantity</span>
                </label>
            </div>
        </div>

        <!-- Variants -->
        <div class="card">
            <div class="card-header-flex">
                <h3 class="card-title-sm">Variants</h3>
                <button type="button" class="link-primary-sm btn-link" id="addVariantBtn">+ Add options like size or color</button>
            </div>
            
            <div id="variantsContainer" class="mt-15" style="display: none;">
                <!-- Variant options will be added here -->
            </div>
            <button type="button" class="btn-link text-primary fs-14 fw-500 mt-10 d-none align-items-center gap-5" id="addAnotherOptionBtn">
                <i data-lucide="plus-circle" style="width:16px;"></i> Add another option
            </button>
        </div>

        <div class="card" id="variantsTableCard" style="display: none;">
            <div class="card-header-flex mb-15">
                <div>
                    <h3 class="card-title-sm">Variants</h3>
                    <div id="variantCountPlaceholder" class="text-muted-sm"></div>
                </div>
                <div id="bulkEditPlaceholder"></div>
            </div>
            <div id="variantsTableContainer">
                <!-- Table of combinations will be generated here -->
            </div>
        </div>

        <!-- SEO -->
        <div class="card">
            <div class="card-header-flex">
                <h3 class="card-title-sm">Search engine listing</h3>
                <a href="#" id="toggleSeoBtn" class="link-primary-sm">Edit website SEO</a>
            </div>
            <p class="text-muted-sm">Add a title and description to see how this product might appear in a search engine listing</p>
            
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
                        <span class="prefix">.../products/</span>
                        <input type="text" name="custom_url" id="slugInput" class="modal-field-input" placeholder="short-sleeve-t-shirt">
                    </div>
                </div>

                <div class="seo-preview-box">
                    <div class="seo-preview-header">
                        <i data-lucide="globe" class="seo-preview-icon"></i>
                        <span class="seo-preview-site">The Perfect Vape</span>
                    </div>
                    <div class="seo-preview-url">www.theperfectvape.com/products/...</div>
                    <div class="seo-preview-title">Product Title</div>
                    <div class="seo-preview-desc">Product description will appear here...</div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <!-- Status -->
        <div class="card">
            <h3 class="card-title-sm mb-10">Status</h3>
            <select name="status" class="modal-field-input">
                <option value="published">Active</option>
                <option value="draft" selected>Draft</option>
            </select>
            <p class="text-muted-sm mt-10">This product will be hidden from all sales channels while in draft status.</p>
        </div>

        <!-- Organization -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Product organization</h3>
            <div class="form-group mb-15">
                <label>Brand</label>
                <select name="brand_id" class="modal-field-input">
                    <option value="">No Brand</option>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?= $brand['id'] ?>"><?= htmlspecialchars($brand['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-15">
                <label>Collections</label>
                <div class="collection-search-container">
                    <input type="text" id="collectionSearchInput" class="modal-field-input" placeholder="Search collections...">
                    <div id="collectionDropdown" class="search-results-dropdown">
                        <?php foreach ($collections as $collection): ?>
                            <div class="search-result-item" data-id="<?= $collection['id'] ?>" data-name="<?= htmlspecialchars($collection['name']) ?>">
                                <?= htmlspecialchars($collection['name']) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div id="selectedCollectionsContainer" class="selected-tags mt-10"></div>
                <p class="text-muted-sm mt-5">Select one or more collections for this product.</p>
            </div>
            <div class="form-group mb-0">
                <label>Tags</label>
                <div class="tag-input-wrapper mb-10">
                    <input type="text" id="tagInput" class="tag-field-input" placeholder="Add tags">
                </div>
                <div id="selectedTags" class="selected-tags"></div>
            </div>
        </div>
    </div>
</div>

<div class="form-actions-bar">
    <div class="actions-left">
        <a href="<?= BASE_URL ?>/admin/products" class="btn-outline" style="text-decoration: none;">Discard</a>
    </div>
    <div class="actions-right">
        <button type="submit" class="btn btn-primary">Save product</button>
    </div>
</div>
</form>

<?php include __DIR__ . '/partials/media-picker-modal.php'; ?>
<?php include __DIR__ . '/partials/footer.php'; ?>

<!-- Bulk Edit Modal -->
<div id="bulkEditModal" class="modal-overlay" style="display: none;">
    <div class="modal-content-sm">
        <div class="modal-header">
            <h3 id="bulkEditTitle">Edit prices</h3>
            <button type="button" class="close-modal-btn">&times;</button>
        </div>
        <div class="modal-body">
            <p id="bulkEditDescription" class="mb-15">Apply a price to all selected variants</p>
            <div class="form-group">
                <div class="input-prefix-container" id="bulkInputContainer">
                    <span class="prefix" id="bulkInputPrefix">$</span>
                    <input type="number" id="bulkValueInput" class="modal-field-input" placeholder="0.00" step="0.01">
                </div>
            </div>
        </div>
        <div class="modal-footer mt-20">
            <button type="button" class="btn-outline close-modal-btn">Cancel</button>
            <button type="button" class="btn btn-dark" id="applyBulkEdit">Done</button>
        </div>
    </div>
</div>


