<?php 
$pageTitle = "Add Page | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/pages" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Add Page</h1>
    </div>
</div>

<div class="form-layout">
    <div class="form-main">
        <div class="card">
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="modal-field-input" placeholder="e.g. About Us">
            </div>
            <div class="form-group mb-0">
                <label>Content</label>
                <div class="rich-text-editor" style="min-height: 300px; border: 1px solid var(--border-color); border-radius: 8px; padding: 15px;">
                    <p class="text-muted">Editor placeholder...</p>
                </div>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title-sm mb-15">Search engine listing</h3>
            <div class="form-group">
                <label>URL handle</label>
                <input type="text" class="modal-field-input" placeholder="about-us">
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <div class="card">
            <h3 class="card-title-sm mb-10">Visibility</h3>
            <select class="modal-field-input">
                <option value="visible">Visible</option>
                <option value="hidden">Hidden</option>
            </select>
        </div>
    </div>
</div>

<div class="form-actions-bar">
    <div class="actions-left">
        <a href="<?= BASE_URL ?>/admin/pages" class="btn-outline" style="text-decoration: none;">Discard</a>
    </div>
    <div class="actions-right">
        <button class="btn btn-primary">Save Page</button>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
