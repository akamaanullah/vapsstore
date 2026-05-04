document.addEventListener('DOMContentLoaded', function() {
    // SEO Toggle
    const toggleSeoBtn = document.getElementById('toggleSeoBtn');
    const seoFields = document.getElementById('seoFields');
    if (toggleSeoBtn && seoFields) {
        toggleSeoBtn.addEventListener('click', (e) => {
            e.preventDefault();
            seoFields.classList.toggle('active');
            toggleSeoBtn.textContent = seoFields.classList.contains('active') ? 'Hide website SEO' : 'Edit website SEO';
        });

        // SEO Real-time Preview Logic
        const seoTitleInput = document.querySelector('.seo-title-input');
        const seoDescInput = document.querySelector('.seo-desc-input');
        const seoPreviewTitle = document.querySelector('.seo-preview-title');
        const seoPreviewDesc = document.querySelector('.seo-preview-desc');
        const seoTitleCount = document.querySelector('.seo-title-count');
        const seoDescCount = document.querySelector('.seo-desc-count');
        const collectionTitleInput = document.getElementById('collectionTitleInput');

        if (seoTitleInput && seoPreviewTitle) {
            seoTitleInput.addEventListener('input', function() {
                const val = this.value.trim();
                seoPreviewTitle.textContent = val || (collectionTitleInput?.value || 'Collection Title');
                seoTitleCount.textContent = this.value.length;
            });
        }

        if (seoDescInput && seoPreviewDesc) {
            seoDescInput.addEventListener('input', function() {
                const val = this.value.trim();
                seoPreviewDesc.textContent = val || 'Collection description will appear here...';
                seoDescCount.textContent = this.value.length;
            });
        }

        if (collectionTitleInput && seoTitleInput) {
            collectionTitleInput.addEventListener('input', function() {
                if (!seoTitleInput.value.trim()) {
                    seoPreviewTitle.textContent = this.value || 'Collection Title';
                }
            });
        }
    }

    // Slug Generation
    const collectionTitleInput = document.getElementById('collectionTitleInput');
    const slugInput = document.getElementById('slugInput');
    
    if (collectionTitleInput && slugInput) {
        collectionTitleInput.addEventListener('input', function() {
            const val = this.value.trim();
            if (!slugInput.dataset.manual) {
                slugInput.value = val.toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
        });

        slugInput.addEventListener('input', function() {
            this.dataset.manual = true;
        });
    }

    // Image Preview
    const imageInput = document.getElementById('collectionImageInput');
    const imagePreview = document.getElementById('imagePreview');
    const imagePlaceholder = document.getElementById('imagePlaceholder');

    if (imageInput) {
        // Handle New Image Selection
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = `
                        <div class="media-item" style="margin: 0; height: 180px;">
                            <img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                            <button type="button" class="btn-action-icon remove-img-btn" style="position: absolute; top: 10px; right: 10px; background: white; border: 1px solid var(--border-color); box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <i data-lucide="trash-2"></i>
                            </button>
                        </div>
                    `;
                    imagePreview.style.display = 'grid';
                    imagePlaceholder.style.display = 'none';
                    lucide.createIcons();
                    
                    // Bind remove event to the newly created button
                    bindRemoveEvent();
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Function to bind the remove event
        function bindRemoveEvent() {
            const removeBtn = imagePreview.querySelector('.remove-img-btn');
            const existingImageInput = document.querySelector('input[name="existing_image"]');
            
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    imageInput.value = ''; // Clear file input
                    if (existingImageInput) existingImageInput.value = ''; // Clear database path
                    imagePreview.innerHTML = ''; // Clear preview
                    imagePreview.style.display = 'none';
                    imagePlaceholder.style.display = 'flex';
                });
            }
        }

        // Run once on load to handle existing images (for Edit page)
        bindRemoveEvent();
    }

    // Rich Text Editor
    const rteContent = document.querySelector('.rte-editor-content');
    const descriptionInput = document.getElementById('descriptionInput');
    if (rteContent && descriptionInput) {
        rteContent.addEventListener('input', () => {
            descriptionInput.value = rteContent.innerHTML;
        });

        // Toolbar functionality
        document.querySelectorAll('.rte-toolbar button').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const command = btn.title.toLowerCase();
                document.execCommand(command, false, null);
                rteContent.focus();
            });
        });
    }
});
