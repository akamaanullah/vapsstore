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
    <?php 
    $sampleBlogs = [
        ['id' => 1, 'title' => 'Top 10 E-Liquids of 2026', 'category' => 'Vape News', 'date' => 'Feb 15, 2026', 'status' => 'Visible', 'excerpt' => 'Discover the absolute best e-liquids that have hit the market this year, ranging from sweet fruity blends to classic robust tobaccos that every vaper must try.', 'image' => 'image/Blog-default.png'],
        ['id' => 2, 'title' => 'How to Clean Your Vape Tank', 'category' => 'Tutorials', 'date' => 'Feb 10, 2026', 'status' => 'Visible', 'excerpt' => 'A step-by-step guide to properly disassembling, cleaning, and reassembling your vape tank to ensure maximum flavor and coil longevity.', 'image' => 'image/Blog-default.png'],
        ['id' => 3, 'title' => 'The Future of Pod Systems', 'category' => 'Industry Trends', 'date' => 'Jan 28, 2026', 'status' => 'Hidden', 'excerpt' => 'Pod systems are taking over the market. We analyze the upcoming technologies and battery innovations that will shape the next generation of compact vapes.', 'image' => 'image/Blog-default.png'],
        ['id' => 4, 'title' => 'Nicotine Salts vs Freebase', 'category' => 'Education', 'date' => 'Jan 15, 2026', 'status' => 'Visible', 'excerpt' => 'Confused about which nicotine type is right for you? This comprehensive breakdown explains the chemical differences and throat hit variations.', 'image' => 'image/Blog-default.png'],
        ['id' => 5, 'title' => 'Winter Vape Juice Flavors', 'category' => 'Reviews', 'date' => 'Dec 10, 2025', 'status' => 'Visible', 'excerpt' => 'Cozy up with these seasonal vape flavors. From peppermint mocha to warm vanilla custard, here are our top picks for the colder months.', 'image' => 'image/Blog-default.png'],
        ['id' => 6, 'title' => 'Traveling with Your Vape', 'category' => 'Lifestyle', 'date' => 'Nov 22, 2025', 'status' => 'Visible', 'excerpt' => 'TSA rules, battery safety in the air, and packing tips. Everything you need to know before taking your vape gear on your next vacation.', 'image' => 'image/Blog-default.png'],
    ];

    foreach ($sampleBlogs as $blog): 
        $statusClass = $blog['status'] == 'Visible' ? 'badge-active' : 'badge-inactive';
    ?>
    <div class="blog-card">
        <div class="blog-image">
            <img src="<?php echo $blog['image']; ?>" alt="Blog Cover">
            <span class="status-badge <?php echo $statusClass; ?> blog-status"><?php echo $blog['status']; ?></span>
        </div>
        <div class="blog-content">
            <div class="blog-meta">
                <span class="blog-category"><?php echo $blog['category']; ?></span>
                <span class="blog-date"><?php echo $blog['date']; ?></span>
            </div>
            <a href="<?= BASE_URL ?>/admin/blogs/edit/<?php echo $blog['id']; ?>" class="blog-title-link">
                <h3 class="blog-title"><?php echo $blog['title']; ?></h3>
                <i data-lucide="arrow-up-right"></i>
            </a>
            <p class="blog-excerpt"><?php echo $blog['excerpt']; ?></p>
            <div class="blog-actions">
                <a href="<?= BASE_URL ?>/admin/blogs/edit/<?php echo $blog['id']; ?>" class="btn-action-icon edit-btn" title="Edit Blog">
                    <i data-lucide="pencil"></i>
                </a>
                <button class="btn-action-icon delete-btn" title="Delete Blog">
                    <i data-lucide="trash-2"></i>
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>



