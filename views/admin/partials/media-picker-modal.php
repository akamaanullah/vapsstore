<!-- Media Picker Modal Partial -->
<link rel="stylesheet" href="<?= BASE_URL ?>/admin_assets/css/media-picker.css">

<div id="mediaPickerModal" class="media-picker-overlay">
    <div class="media-picker-box">
        
        <!-- Header -->
        <div class="media-picker-header">
            <div class="media-picker-header-left">
                <h2>Select Media</h2>
                <input type="text" id="mediaPickerSearch" class="media-picker-search" placeholder="Search images...">
            </div>
            <div class="media-picker-actions">
                <button id="mediaPickerUploadBtn" class="btn btn-outline btn-sm">
                    <i data-lucide="upload"></i> Upload
                </button>
                <input type="file" id="mediaPickerFileInput" multiple accept="image/*" style="display:none;">
                <button id="mediaPickerClose" class="media-picker-close">&times;</button>
            </div>
        </div>

        <!-- Body (Grid) -->
        <div id="mediaPickerGrid" class="media-picker-body media-picker-grid">
            <!-- Items injected by JS -->
        </div>

        <!-- Footer -->
        <div class="media-picker-footer">
            <div id="mediaPickerSelectionInfo" class="media-picker-selection-info">0 items selected</div>
            <div style="display:flex; gap:10px;">
                <button id="mediaPickerCancel" class="btn btn-outline">Cancel</button>
                <button id="mediaPickerConfirm" class="btn btn-primary" disabled>Confirm Selection</button>
            </div>
        </div>

        <!-- Upload Progress Overlay (Internal) -->
        <div id="mediaPickerUploadOverlay" class="picker-upload-overlay">
            <h4 style="margin-bottom:10px; color:#1e293b;">Uploading...</h4>
            <div style="width:250px; height:8px; background:#e2e8f0; border-radius:4px; overflow:hidden;">
                <div id="mediaPickerUploadProgress" style="height:100%; width:0%; background:var(--primary-color); transition:width 0.2s;"></div>
            </div>
        </div>
        
    </div>
</div>

<script>
    if (!window.MEDIA_BASE_URL) window.MEDIA_BASE_URL = '<?= BASE_URL ?>';
</script>
<script src="<?= BASE_URL ?>/admin_assets/js/media-picker.js"></script>
