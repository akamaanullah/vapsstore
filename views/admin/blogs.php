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

<div class="blogs-grid">
    <?php if (empty($posts)): ?>
        <div class="empty-state">
            <p>No blog posts found. Create your first one!</p>
        </div>
    <?php else: ?>
        <?php foreach ($posts as $blog): 
            $statusClass = $blog['is_active'] ? 'badge-active' : 'badge-inactive';
            $statusText = $blog['is_active'] ? 'Visible' : 'Hidden';
            $image = $blog['featured_image_url'] ? BASE_URL . '/' . $blog['featured_image_url'] : BASE_URL . '/admin_assets/image/placeholder.png';
            $date = date('M d, Y', strtotime($blog['published_at'] ?? 'now'));
        ?>
        <div class="blog-card">
            <div class="blog-image">
                <img src="<?= $image ?>" alt="Blog Cover">
                <span class="status-badge <?= $statusClass ?> blog-status"><?= $statusText ?></span>
            </div>
            <div class="blog-content">
                <div class="blog-meta">
                    <span class="blog-category"><?= htmlspecialchars($blog['category_name'] ?? 'Uncategorized') ?></span>
                    <span class="blog-date"><?= $date ?></span>
                </div>
                <a href="<?= BASE_URL ?>/admin/blogs/edit/<?= $blog['id'] ?>" class="blog-title-link">
                    <h3 class="blog-title"><?= htmlspecialchars($blog['title']) ?></h3>
                    <i data-lucide="arrow-up-right"></i>
                </a>
                <p class="blog-excerpt"><?= htmlspecialchars($blog['excerpt'] ?? '') ?></p>
                <div class="blog-actions">
                    <a href="<?= BASE_URL ?>/admin/blogs/edit/<?= $blog['id'] ?>" class="btn-action-icon edit-btn" title="Edit Blog">
                        <i data-lucide="pencil"></i>
                    </a>
                    <form action="<?= BASE_URL ?>/admin/blogs/delete/<?= $blog['id'] ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                        <button type="submit" class="btn-action-icon delete-btn" title="Delete Blog">
                            <i data-lucide="trash-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>



