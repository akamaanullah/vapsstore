<?php 
$pageTitle = "Pages | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Pages</h1>
    
    <div class="header-actions">
        <div class="search-container">
            <input type="text" placeholder="Search pages..." class="search-input">
        </div>
        <a href="<?= BASE_URL ?>/admin/pages/create" class="btn btn-primary btn-add">
            <i data-lucide="plus"></i>
            <span>Add Page</span>
        </a>
    </div>
</div>

<div class="card card-no-padding">
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th class="th-product">Title</th>
                    <th class="th-default">URL Path</th>
                    <th class="th-default">Status</th>
                    <th class="th-action">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $samplePages = [
                    ['title' => 'About Us', 'url' => '/about-us', 'status' => 'Published'],
                    ['title' => 'Privacy Policy', 'url' => '/privacy-policy', 'status' => 'Published'],
                    ['title' => 'Terms of Service', 'url' => '/terms-of-service', 'status' => 'Published'],
                    ['title' => 'Contact Us', 'url' => '/contact', 'status' => 'Draft'],
                ];
                
                foreach ($samplePages as $page): ?>
                <tr>
                    <td class="td-product">
                        <span class="product-name-txt"><?php echo $page['title']; ?></span>
                    </td>
                    <td class="td-default text-muted"><?php echo $page['url']; ?></td>
                    <td class="td-default">
                        <span class="status-badge <?php echo $page['status'] == 'Published' ? 'badge-active' : 'badge-draft'; ?>">
                            <?php echo $page['status']; ?>
                        </span>
                    </td>
                    <td class="td-action">
                        <div class="action-flex">
                            <a href="<?= BASE_URL ?>/admin/pages/edit" class="btn-action-icon edit-btn" title="Edit">
                                <i data-lucide="pencil"></i>
                            </a>
                            <button class="btn-action-icon delete-btn" title="Delete">
                                <i data-lucide="trash-2"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
