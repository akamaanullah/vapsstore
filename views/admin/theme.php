<?php 
$pageTitle = "Theme Sections | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Theme Sections</h1>
    <button class="btn btn-primary">Save Changes</button>
</div>

<div class="card">
    <h3 class="card-title-sm mb-20">Homepage Layout</h3>
    <p class="text-muted-sm">Drag and drop sections to reorder your homepage layout.</p>
    
    <div class="vertical-timeline-container mt-20" style="padding-left: 0;">
        <div class="timeline-items">
            <?php 
            $sections = [
                ['name' => 'Hero Slider', 'type' => 'hero_banner', 'icon' => 'image'],
                ['name' => 'Featured Collections', 'type' => 'bento_grid', 'icon' => 'grid'],
                ['name' => 'New Arrivals', 'type' => 'product_carousel', 'icon' => 'layers'],
                ['name' => 'Promotional Banner', 'type' => 'rich_text', 'icon' => 'type'],
                ['name' => 'Customer Testimonials', 'type' => 'reviews_block', 'icon' => 'message-square'],
            ];
            
            foreach ($sections as $section): ?>
            <div class="card mb-10" style="border: 1px solid var(--border-color); cursor: grab; display: flex; align-items: center; gap: 15px; padding: 15px;">
                <i data-lucide="grip-vertical" class="text-muted"></i>
                <div style="background: var(--bg-light); padding: 10px; border-radius: 6px;">
                    <i data-lucide="<?php echo $section['icon']; ?>" class="text-primary" style="width: 20px;"></i>
                </div>
                <div style="flex-grow: 1;">
                    <span class="fw-600 d-block"><?php echo $section['name']; ?></span>
                    <span class="text-muted-xs uppercase"><?php echo $section['type']; ?></span>
                </div>
                <button class="btn-action-icon"><i data-lucide="settings"></i></button>
                <button class="btn-action-icon text-danger"><i data-lucide="trash-2"></i></button>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <button class="btn btn-outline btn-block mt-20">
        <i data-lucide="plus"></i>
        <span>Add Section</span>
    </button>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
