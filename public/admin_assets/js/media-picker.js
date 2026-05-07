/**
 * Reusable Media Picker Component
 */

class MediaPicker {
    constructor() {
        this.modal = document.getElementById('mediaPickerModal');
        if (!this.modal) return;

        this.grid = document.getElementById('mediaPickerGrid');
        this.searchInput = document.getElementById('mediaPickerSearch');
        this.closeBtn = document.getElementById('mediaPickerClose');
        this.cancelBtn = document.getElementById('mediaPickerCancel');
        this.confirmBtn = document.getElementById('mediaPickerConfirm');
        this.uploadBtn = document.getElementById('mediaPickerUploadBtn');
        this.fileInput = document.getElementById('mediaPickerFileInput');
        this.selectionInfo = document.getElementById('mediaPickerSelectionInfo');
        this.uploadOverlay = document.getElementById('mediaPickerUploadOverlay');
        this.uploadProgress = document.getElementById('mediaPickerUploadProgress');

        this.base_url = window.MEDIA_BASE_URL || '';
        this.multiple = false;
        this.selectedItems = [];
        this.onSelectCallback = null;

        this.initEvents();
    }

    initEvents() {
        // Close modal
        const close = () => this.close();
        this.closeBtn.addEventListener('click', close);
        this.cancelBtn.addEventListener('click', close);
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) close();
        });

        // Search
        let timeout = null;
        this.searchInput.addEventListener('input', (e) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => this.loadMedia(e.target.value), 300);
        });

        // Upload
        this.uploadBtn.addEventListener('click', () => this.fileInput.click());
        this.fileInput.addEventListener('change', (e) => this.handleUpload(e));

        // Confirm
        this.confirmBtn.addEventListener('click', () => {
            if (this.onSelectCallback && this.selectedItems.length > 0) {
                this.onSelectCallback(this.multiple ? this.selectedItems : this.selectedItems[0]);
            }
            this.close();
        });
    }

    open(options = {}) {
        this.multiple = options.multiple || false;
        this.onSelectCallback = options.onSelect || null;
        this.selectedItems = [];
        this.updateSelectionUI();
        
        this.searchInput.value = '';
        this.loadMedia();
        this.modal.classList.add('active');
    }

    close() {
        this.modal.classList.remove('active');
    }

    async loadMedia(query = '') {
        this.grid.innerHTML = '<div class="media-picker-empty">Loading...</div>';
        try {
            const res = await fetch(`${this.base_url}/admin/media/search?q=${encodeURIComponent(query)}`);
            const data = await res.json();
            this.renderGrid(data);
        } catch (e) {
            this.grid.innerHTML = '<div class="media-picker-empty">Failed to load media.</div>';
        }
    }

    renderGrid(items) {
        if (!items || items.length === 0) {
            this.grid.innerHTML = '<div class="media-picker-empty">No media found. Upload something!</div>';
            return;
        }

        this.grid.innerHTML = '';
        items.forEach(item => {
            const el = document.createElement('div');
            el.className = 'picker-item';
            el.dataset.url = item.file_path;
            el.dataset.id = item.id;
            
            // Check if already selected
            if (this.selectedItems.find(s => s.id == item.id)) {
                el.classList.add('selected');
            }

            el.innerHTML = `
                <div class="picker-item-preview" style="background-image:url('${this.base_url}/uploads/media/thumbs/${item.filename}')"></div>
                <div class="picker-item-info">${item.original_name}</div>
                <div class="picker-item-check"><i data-lucide="check"></i></div>
            `;

            el.addEventListener('click', () => this.toggleSelection(item, el));
            this.grid.appendChild(el);
        });

        if (window.lucide) window.lucide.createIcons();
    }

    toggleSelection(item, el) {
        const idx = this.selectedItems.findIndex(s => s.id == item.id);
        
        if (idx > -1) {
            // Deselect
            this.selectedItems.splice(idx, 1);
            el.classList.remove('selected');
        } else {
            // Select
            if (!this.multiple) {
                // Clear others if single select
                this.selectedItems = [];
                document.querySelectorAll('.picker-item.selected').forEach(n => n.classList.remove('selected'));
            }
            this.selectedItems.push(item);
            el.classList.add('selected');
        }
        
        this.updateSelectionUI();
    }

    updateSelectionUI() {
        const count = this.selectedItems.length;
        if (count === 0) {
            this.selectionInfo.textContent = '0 items selected';
            this.confirmBtn.disabled = true;
        } else {
            this.selectionInfo.textContent = `${count} item${count > 1 ? 's' : ''} selected`;
            this.confirmBtn.disabled = false;
        }
    }

    async handleUpload(e) {
        const files = e.target.files;
        if (!files.length) return;

        this.uploadOverlay.classList.add('active');
        this.uploadProgress.style.width = '0%';

        const formData = new FormData();
        for (const file of files) formData.append('files[]', file);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', `${this.base_url}/admin/media/upload`, true);
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (csrfToken) {
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        }

        xhr.upload.addEventListener('progress', (ev) => {
            if (ev.lengthComputable) {
                this.uploadProgress.style.width = Math.round((ev.loaded / ev.total) * 100) + '%';
            }
        });

        xhr.addEventListener('load', () => {
            this.uploadOverlay.classList.remove('active');
            this.fileInput.value = ''; // reset
            try {
                const res = JSON.parse(xhr.responseText);
                if (res.results && res.results.length > 0) {
                    // Reload media and select the newly uploaded ones (simplification: just reload)
                    this.loadMedia();
                }
            } catch (err) {
                console.error("Upload parse error", err);
            }
        });

        xhr.addEventListener('error', () => {
            this.uploadOverlay.classList.remove('active');
            alert('Upload failed');
        });

        xhr.send(formData);
    }
}

// Initialize globally
window.mediaPicker = null;
document.addEventListener('DOMContentLoaded', () => {
    window.mediaPicker = new MediaPicker();
});
