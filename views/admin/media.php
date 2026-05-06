<?php 
$pageTitle = "Media Gallery | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/admin_assets/css/media-gallery.css">

<div class="page-header-container">
    <div class="header-left">
        <h1>Media Gallery</h1>
        <p class="text-muted-sm">Centralized management for all your website images and assets.</p>
    </div>
    <div class="header-actions">
        <div class="search-container">
            <input type="text" id="mediaSearch" placeholder="Search by name..." class="search-input">
        </div>
        <button id="uploadTrigger" class="btn btn-primary">
            <i data-lucide="upload"></i>
            <span>Upload New</span>
        </button>
        <input type="file" id="mediaFileInput" multiple accept="image/*" style="display:none;">
    </div>
</div>

<div class="media-container">
    <div id="mediaGrid" class="media-grid">
        <?php if (empty($media)): ?>
            <div style="grid-column:1/-1; text-align:center; padding:100px 0; color:#94a3b8;">
                <i data-lucide="image" style="width:64px;height:64px;opacity:0.2;display:block;margin:0 auto 16px;"></i>
                <p>No media found. Upload your first image to get started.</p>
            </div>
        <?php else: ?>
            <?php foreach ($media as $item): ?>
                <div class="media-item"
                     data-id="<?= $item['id'] ?>"
                     data-url="<?= BASE_URL . '/' . $item['file_path'] ?>"
                     data-name="<?= htmlspecialchars($item['original_name']) ?>"
                     data-size="<?= round($item['file_size'] / 1024, 2) ?> KB"
                     data-dimensions="<?= $item['dimensions'] ?>">
                    <div class="media-preview"
                         style="background-image:url('<?= BASE_URL ?>/uploads/media/thumbs/<?= $item['filename'] ?>')">
                    </div>
                    <div class="media-info">
                        <span class="media-name"><?= htmlspecialchars($item['original_name']) ?></span>
                    </div>
                    <div class="media-actions">
                        <button class="action-btn copy-url" title="Copy URL"><i data-lucide="copy"></i></button>
                        <button class="action-btn delete-media" title="Delete"><i data-lucide="trash-2"></i></button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Upload Progress Overlay -->
<div id="uploadOverlay" class="upload-overlay" style="display:none;">
    <div class="upload-progress-card">
        <h3>Uploading Media...</h3>
        <div class="progress-bar-container">
            <div id="uploadProgressBar" class="progress-bar"></div>
        </div>
        <p id="uploadStatusText">Converting to WebP and optimizing...</p>
    </div>
</div>

<!-- Asset Detail Modal -->
<div id="mediaModal" class="media-modal-overlay">
    <div class="media-modal-box">
        <div class="media-modal-header">
            <h2 id="modalMediaName">Image Details</h2>
            <button id="modalCloseBtn" class="media-modal-close">&times;</button>
        </div>
        <div class="media-modal-body">
            <div class="media-modal-preview">
                <img id="modalPreviewImg" src="" alt="Preview">
            </div>
            <div class="media-modal-details">
                <div class="detail-group">
                    <label>File URL</label>
                    <div class="copy-input-wrapper">
                        <input type="text" id="modalFileUrl" readonly>
                        <button id="modalCopyBtn" class="btn btn-sm btn-primary">Copy</button>
                    </div>
                </div>
                <div>
                    <div class="info-row"><span>Size</span>      <strong id="modalFileSize">—</strong></div>
                    <div class="info-row"><span>Dimensions</span><strong id="modalFileDim">—</strong></div>
                    <div class="info-row"><span>Format</span>    <strong>WebP (Optimized)</strong></div>
                </div>
                <hr>
                <button class="btn btn-danger" style="width:100%;" id="modalDeleteBtn">
                    <i data-lucide="trash-2"></i> Delete Asset
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Pass PHP constants to JS -->
<script>window.MEDIA_BASE_URL = '<?= BASE_URL ?>';</script>
<script src="<?= BASE_URL ?>/admin_assets/js/media-gallery.js"></script>

<?php include __DIR__ . '/partials/footer.php'; ?>
