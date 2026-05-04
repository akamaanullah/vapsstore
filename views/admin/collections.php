<?php 
$pageTitle = "Collections | Vape Store Admin";
$pageScript = "collections.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Collections</h1>
    <div class="header-actions">
        <div class="search-container">
            <input type="text" placeholder="Search collections..." class="search-input" id="collectionSearch">
        </div>
        <a href="<?= BASE_URL ?>/admin/collections/create" class="btn btn-primary d-flex align-items-center gap-5">
            <i data-lucide="plus" class="icon-sm"></i>
            <span>Create Collection</span>
        </a>
    </div>
</div>

<div class="card card-no-padding">
    <div class="table-responsive">
        <table class="product-table" id="collectionsTable">
            <thead>
                <tr>
                    <th style="padding-left: 20px;">Collection</th>
                    <th>Parent</th>
                    <th>Status</th>
                    <th>URL Path</th>
                    <th class="text-right" style="padding-right: 20px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($collections)): ?>
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 60px 20px; color: var(--text-muted);">
                            <div class="empty-state">
                                <i data-lucide="layers" class="icon-lg mb-10" style="opacity: 0.2;"></i>
                                <p class="m-0 fs-14">No collections found. Create your first collection to organize products.</p>
                            </div>
                        </td>
                    </tr>
                <?php else: foreach ($collections as $col): ?>
                <tr class="collection-row">
                    <td style="padding-left: 20px;">
                        <div class="product-info-flex">
                            <?php if (!empty($col['header_image_url'])): ?>
                                <img src="<?= BASE_URL . '/' . $col['header_image_url'] ?>" class="product-image" style="width: 32px; height: 32px; object-fit: cover; border-radius: 4px;">
                            <?php else: ?>
                                <div class="avatar-sm" style="background: var(--bg-light); border-radius: 4px; display: flex; align-items: center; justify-content: center; width: 32px; height: 32px;">
                                    <i data-lucide="layers" class="icon-xs text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <span class="product-name-txt fw-600"><?= htmlspecialchars($col['name']) ?></span>
                        </div>
                    </td>
                    <td class="text-muted fs-13"><?= $col['parent_name'] ?? '<span style="opacity: 0.5;">—</span>' ?></td>
                    <td>
                        <span class="status-badge <?= $col['is_active'] ? 'badge-active' : 'badge-draft' ?>">
                            <?= $col['is_active'] ? 'Active' : 'Hidden' ?>
                        </span>
                    </td>
                    <td class="text-muted fs-13"><code>/<?= $col['custom_url_path'] ?></code></td>
                    <td class="td-action text-right" style="padding-right: 20px;">
                        <div class="action-flex justify-content-end">
                            <a href="<?= BASE_URL ?>/admin/collections/edit/<?= $col['id'] ?>" class="btn-action-icon edit-btn" title="Edit">
                                <i data-lucide="pencil" class="icon-xs"></i>
                            </a>
                            <form action="<?= BASE_URL ?>/admin/collections/delete/<?= $col['id'] ?>" method="POST" class="delete-collection-form" style="display:inline;">
                                <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
                                <button type="button" class="btn-action-icon delete-btn" title="Delete">
                                    <i data-lucide="trash-2" class="icon-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
