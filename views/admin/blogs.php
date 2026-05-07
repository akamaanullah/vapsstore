<?php 
$pageTitle = "Blogs | Vape Store Admin";
$pageScript = "blogs.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Blogs</h1>
    
    <div class="header-actions">
        <div class="search-container">
            <input type="text" placeholder="Search blogs..." class="search-input">
        </div>
        <select class="status-dropdown">
            <option>All status</option>
            <option>Visible</option>
            <option>Hidden</option>
        </select>
        <a href="<?= BASE_URL ?>/admin/blogs/create" class="btn btn-primary btn-add" style="text-decoration: none;">
            <i data-lucide="plus"></i>
            <span>Add Blog</span>
        </a>
    </div>
</div>

<div id="blogs-list-container">
    <?php include __DIR__ . '/partials/blogs-list.php'; ?>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>



