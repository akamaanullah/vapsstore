<?php 
$pageTitle = "Edit Product | Vape Store Admin";
$pageScript = "edit-product.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/products" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Edit: <?= htmlspecialchars($product['name']) ?></h1>
    </div>
    <div class="header-actions">
        <form action="<?= BASE_URL ?>/admin/products/delete/<?= $product['id'] ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product? This cannot be undone.')">
            <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
            <button type="submit" class="btn btn-outline text-error">Delete product</button>
        </form>
    </div>
</div>

<form id="productForm" action="<?= BASE_URL ?>/admin/products/update/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
<div class="form-layout">
    <div class="form-main">
        <!-- Title & Description -->
        <div class="card">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="name" id="productTitleInput" class="modal-field-input" value="<?= htmlspecialchars($product['name']) ?>" placeholder="Short Sleeve T-Shirt" required>
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
                    <div class="rte-editor-content" contenteditable="true" data-placeholder="Add a detailed description for your product..."><?= $product['long_desc'] ?></div>
                    <textarea name="description" id="descriptionInput" style="display: none;"><?= htmlspecialchars($product['long_desc'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Media -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Media</h3>
            <div class="media-upload-area" id="mediaUploadArea">
                <input type="file" name="images[]" id="productMediaInput" multiple accept="image/*" style="display: none;">
                
                <?php if (!empty($product['images'])): ?>
                <div class="media-preview-grid" id="mediaPreviewGrid" style="display: grid;">
                    <?php foreach ($product['images'] as $image): 
                        $imgUrl = (strpos($image['image_url'], '/') === 0) 
                                  ? BASE_URL . $image['image_url'] 
                                  : BASE_URL . '/' . $image['image_url'];
                    ?>
                    <div class="media-item">
                        <img src="<?= $imgUrl ?>" alt="Product image">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="media-placeholder">
                    <i data-lucide="upload-cloud" class="icon-lg text-muted"></i>
                    <p class="mt-10 mb-5 fw-600">Click to upload or drag and drop</p>
                    <p class="text-muted-sm m-0">PNG, JPG, GIF up to 10MB</p>
                    <button type="button" class="btn btn-outline btn-sm mt-15">Add Media</button>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pricing -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Pricing</h3>
            <div class="form-group mb-0">
                <div class="input-prefix-container">
                    <span class="prefix">$</span>
                    <input type="number" name="price" class="modal-field-input" value="<?= htmlspecialchars($product['base_price']) ?>" placeholder="0.00" step="0.01" required>
                </div>
            </div>
        </div>

        <!-- Variants Management -->
        <div class="card">
            <div class="card-header-flex">
                <h3 class="card-title-sm">Variants</h3>
                <button type="button" class="link-primary-sm btn-link" id="addVariantBtn">+ Add options like size or color</button>
            </div>
            
            <div id="variantsContainer" class="mt-15" style="display: <?= !empty($product['variants']) ? 'block' : 'none' ?>;">
                <!-- Variant options will be populated by JS -->
            </div>
            <button type="button" class="btn-link text-primary fs-14 fw-500 mt-10 d-none align-items-center gap-5" id="addAnotherOptionBtn">
                <i data-lucide="plus-circle" style="width:16px;"></i> Add another option
            </button>
        </div>

        <div class="card" id="variantsTableCard" style="display: <?= !empty($product['variants']) ? 'block' : 'none' ?>;">
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

        <!-- Hidden Data for JS Hydration -->
        <script id="existingVariantsData" type="application/json">
            <?= json_encode($product['variants'] ?? []) ?>
        </script>
        <script id="existingOptionsData" type="application/json">
            <?= json_encode($product['options'] ?? []) ?>
        </script>
        

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
                    <input type="text" name="seo_title" class="modal-field-input seo-title-input" value="<?= htmlspecialchars($product['seo_title'] ?? '') ?>" placeholder="Enter page title" maxlength="70">
                    <div class="char-counter"><span class="seo-title-count"><?= strlen($product['seo_title'] ?? '') ?></span> of 70 characters used</div>
                </div>
                
                <div class="form-group">
                    <label>Meta description</label>
                    <textarea name="seo_description" class="modal-field-input seo-desc-input" rows="4" placeholder="Enter meta description" maxlength="320"><?= htmlspecialchars($product['seo_description'] ?? '') ?></textarea>
                    <div class="char-counter"><span class="seo-desc-count"><?= strlen($product['seo_description'] ?? '') ?></span> of 320 characters used</div>
                </div>

                <div class="form-group">
                    <label>URL handle</label>
                    <div class="input-prefix-container">
                        <span class="prefix">.../products/</span>
                        <input type="text" name="custom_url" id="slugInput" class="modal-field-input" value="<?= htmlspecialchars($product['custom_url']) ?>" placeholder="short-sleeve-t-shirt">
                    </div>
                </div>

                <div class="seo-preview-box">
                    <div class="seo-preview-header">
                        <i data-lucide="globe" class="seo-preview-icon"></i>
                        <span class="seo-preview-site">The Perfect Vape</span>
                    </div>
                    <div class="seo-preview-url">www.theperfectvape.com/products/<?= htmlspecialchars($product['custom_url']) ?></div>
                    <div class="seo-preview-title"><?= htmlspecialchars($product['seo_title'] ?: $product['name']) ?></div>
                    <div class="seo-preview-desc"><?= htmlspecialchars($product['seo_description'] ?: 'Product description will appear here...') ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <!-- Status -->
        <div class="card">
            <h3 class="card-title-sm mb-10">Status</h3>
            <select name="status" class="modal-field-input">
                <option value="published" <?= $product['status'] === 'published' ? 'selected' : '' ?>>Active</option>
                <option value="draft" <?= $product['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                <option value="archived" <?= $product['status'] === 'archived' ? 'selected' : '' ?>>Archived</option>
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
                        <option value="<?= $brand['id'] ?>" <?= $brand['id'] == $product['brand_id'] ? 'selected' : '' ?>><?= htmlspecialchars($brand['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-15">
                <label>Collections</label>
                <div class="collections-check-list" style="max-height: 150px; overflow-y: auto; border: 1px solid #eee; padding: 10px; border-radius: 8px;">
                    <?php foreach ($collections as $collection): ?>
                        <label class="d-flex align-items-center gap-10 mb-5 pointer">
                            <input type="checkbox" name="collection_ids[]" value="<?= $collection['id'] ?>" <?= in_array($collection['id'], $product['collection_ids']) ? 'checked' : '' ?>>
                            <span class="fs-14"><?= htmlspecialchars($collection['name']) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
                <p class="text-muted-sm mt-5">Select one or more collections for this product.</p>
            </div>
            <div class="form-group mb-0">
                <label>Tags</label>
                <div class="tag-input-wrapper mb-10">
                    <input type="text" id="tagInput" class="tag-field-input" placeholder="Add tags" value="<?= htmlspecialchars($product['tags'] ?? '') ?>">
                </div>
                <input type="hidden" name="tags" id="tagsHidden" value="<?= htmlspecialchars($product['tags'] ?? '') ?>">
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

<?php include __DIR__ . '/partials/footer.php'; ?>
