<?php 
$pageTitle = "Navigation | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Navigation</h1>
    <button class="btn btn-primary btn-add">
        <i data-lucide="plus"></i>
        <span>Add Menu</span>
    </button>
</div>

<div class="card card-no-padding">
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th class="th-product">Menu Name</th>
                    <th class="th-default">Location</th>
                    <th class="th-default">Items</th>
                    <th class="th-action">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sampleMenus = [
                    ['name' => 'Main Menu', 'location' => 'Header', 'count' => 6],
                    ['name' => 'Footer Links', 'location' => 'Footer', 'count' => 4],
                    ['name' => 'Mega Menu', 'location' => 'Header (Mega)', 'count' => 12],
                ];
                
                foreach ($sampleMenus as $menu): ?>
                <tr>
                    <td class="td-product">
                        <span class="product-name-txt"><?php echo $menu['name']; ?></span>
                    </td>
                    <td class="td-default text-muted"><?php echo $menu['location']; ?></td>
                    <td class="td-default text-muted"><?php echo $menu['count']; ?> items</td>
                    <td class="td-action">
                        <div class="action-flex">
                            <a href="<?= BASE_URL ?>/admin/menus/edit" class="btn-action-icon edit-btn" title="Edit Menu Items">
                                <i data-lucide="list"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/admin/menus/settings" class="btn-action-icon edit-btn" title="Edit Settings">
                                <i data-lucide="settings"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
