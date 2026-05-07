<?php 
$pageTitle = "Navigation | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <h1 class="m-0">Navigation</h1>
    </div>
    <div class="header-actions">
        <button class="btn btn-primary" id="addMenuBtn">
            <i data-lucide="plus" class="icon-xs"></i> Add Menu
        </button>
    </div>
</div>

<div class="card card-no-padding">
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th class="th-product" style="padding-left: 20px; width: 45%;">Title</th>
                    <th class="th-default" style="width: 25%;">Location (Handle)</th>
                    <th class="th-default" style="width: 15%;">Items Count</th>
                    <th class="th-action text-right" style="width: 15%; padding-right: 20px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($menus)): ?>
                <tr>
                    <td colspan="4" class="text-center py-40 text-muted">
                        No menus found. Click "Add Menu" to create one.
                    </td>
                </tr>
                <?php else: ?>
                    <?php foreach ($menus as $menu): ?>
                    <tr class="align-middle">
                        <td class="td-product" style="padding-left: 20px;">
                            <div class="product-info-flex">
                                <div class="d-flex flex-column">
                                    <a href="<?= BASE_URL ?>/admin/menus/edit/<?= $menu['id'] ?>" class="product-name-txt fw-600"><?= htmlspecialchars($menu['name']) ?></a>
                                    <span class="text-muted-sm mt-2"><?= $menu['id'] == 1 ? 'Primary Menu' : 'Secondary Menu' ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="td-default">
                            <code class="handle-badge"><?= htmlspecialchars($menu['location']) ?></code>
                        </td>
                        <td class="td-default text-muted">-</td>
                        <td class="td-action text-right" style="padding-right: 20px;">
                            <div class="action-flex justify-content-end">
                                <a href="<?= BASE_URL ?>/admin/menus/edit/<?= $menu['id'] ?>" class="btn-action-icon edit-btn" title="Edit Menu"><i data-lucide="pencil" class="icon-xs"></i></a>
                                <button class="btn-action-icon delete-btn text-error delete-menu" data-id="<?= $menu['id'] ?>" title="Delete"><i data-lucide="trash-2" class="icon-xs"></i></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .d-flex { display: flex !important; }
    .flex-column { flex-direction: column !important; }
    .mt-2 { margin-top: 8px !important; }
    .handle-badge {
        background: #f8fafc;
        color: #475569;
        padding: 5px 12px;
        border-radius: 6px;
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        font-size: 12px;
        border: 1px solid #e2e8f0;
        display: inline-block;
    }
    .text-muted-sm {
        color: #94a3b8;
        font-size: 12px;
    }
    .fw-600 { font-weight: 600; }
</style>

<?php include __DIR__ . '/partials/footer.php'; ?>

<script>
    document.getElementById('addMenuBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Create New Menu',
            html: `
                <div class="form-group text-left">
                    <label>Menu Name</label>
                    <input type="text" id="menu_name" class="modal-field-input" placeholder="e.g. Main Menu">
                </div>
                <div class="form-group text-left mt-15">
                    <label>Location Handle (Handle)</label>
                    <input type="text" id="menu_location" class="modal-field-input" placeholder="e.g. header_main">
                    <p class="text-muted-sm mt-5">Used to display this menu in the theme.</p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Create Menu',
            confirmButtonColor: '#e16449',
            preConfirm: () => {
                const name = document.getElementById('menu_name').value;
                const location = document.getElementById('menu_location').value;
                if (!name || !location) {
                    Swal.showValidationMessage('Please enter both name and location handle');
                }
                return { name: name, location: location };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Post to server
                fetch('<?= BASE_URL ?>/admin/menus/store', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(result.value)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '<?= BASE_URL ?>/admin/menus/edit/' + data.id;
                    } else {
                        Swal.fire('Error', data.message || 'Failed to create menu', 'error');
                    }
                });
            }
        });
    });

    // Handle auto-handle generation
    document.addEventListener('input', function(e) {
        if (e.target.id === 'menu_name') {
            const handleInput = document.getElementById('menu_location');
            if (handleInput && (!handleInput.value || handleInput.dataset.auto === 'true')) {
                handleInput.value = e.target.value.toLowerCase().replace(/[^a-z0-9]+/g, '_').replace(/(^_|_$)/g, '');
                handleInput.dataset.auto = 'true';
            }
        }
        if (e.target.id === 'menu_location') {
            e.target.dataset.auto = 'false';
        }
    });

    // Handle Delete Menu
    document.querySelectorAll('.delete-menu').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this! All menu items will also be deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('<?= BASE_URL ?>/admin/menus/delete/' + id, {
                        method: 'GET' // Using GET as per our router configuration for simple deletes
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Menu has been deleted.', 'success').then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Failed to delete menu', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
