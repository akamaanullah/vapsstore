document.addEventListener('DOMContentLoaded', function() {
    console.log('Add Blog JS Loaded');

    // Excerpt Toggle
    const toggleExcerptBtn = document.getElementById('toggleExcerptBtn');
    const excerptField = document.getElementById('excerptField');
    
    if (toggleExcerptBtn && excerptField) {
        toggleExcerptBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (excerptField.style.display === 'block') {
                excerptField.style.display = 'none';
                this.textContent = 'Add Excerpt';
            } else {
                excerptField.style.display = 'block';
                this.textContent = 'Hide Excerpt';
            }
        });
    }

    // SEO Toggle
    const toggleSeoBtn = document.getElementById('toggleSeoBtn');
    const seoFields = document.getElementById('seoFields');
    
    if (toggleSeoBtn && seoFields) {
        toggleSeoBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (seoFields.style.display === 'block') {
                seoFields.style.display = 'none';
                this.textContent = 'Edit website SEO';
            } else {
                seoFields.style.display = 'block';
                this.textContent = 'Hide website SEO';
            }
        });
    }

    // Visibility Date Toggle
    const toggleVisibilityDateBtn = document.getElementById('toggleVisibilityDateBtn');
    const visibilityDateField = document.getElementById('visibilityDateField');
    
    if (toggleVisibilityDateBtn && visibilityDateField) {
        toggleVisibilityDateBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (visibilityDateField.style.display === 'block') {
                visibilityDateField.style.display = 'none';
                this.textContent = 'Set visibility date';
            } else {
                visibilityDateField.style.display = 'block';
                this.textContent = 'Clear visibility date';
            }
        });
    }

    // SEO Preview & Character Count Logic
    const seoTitleInput = document.querySelector('.seo-title-input');
    const seoTitleCount = document.querySelector('.seo-title-count');
    const seoPreviewTitle = document.querySelector('.seo-preview-title');

    const seoDescInput = document.querySelector('.seo-desc-input');
    const seoDescCount = document.querySelector('.seo-desc-count');
    const seoPreviewDesc = document.querySelector('.seo-preview-desc');

    if (seoTitleInput) {
        seoTitleInput.addEventListener('input', function() {
            seoTitleCount.textContent = this.value.length;
            seoPreviewTitle.textContent = this.value || 'Blog Post Title';
        });
    }

    if (seoDescInput) {
        seoDescInput.addEventListener('input', function() {
            seoDescCount.textContent = this.value.length;
            seoPreviewDesc.textContent = this.value || 'Blog post description will appear here...';
        });
    }

    // Rich Text Editor Logic
    const formatSelect = document.getElementById('formatSelect');
    if (formatSelect) {
        formatSelect.addEventListener('change', function() {
            document.execCommand('formatBlock', false, this.value);
            // Reset select after formatting
            this.selectedIndex = 0;
        });
    }

    const colorPicker = document.getElementById('colorPicker');
    if (colorPicker) {
        colorPicker.addEventListener('input', function() {
            document.execCommand('foreColor', false, this.value);
            this.previousElementSibling.style.borderBottomColor = this.value;
            this.previousElementSibling.style.color = this.value;
        });
    }

    const bgColorPicker = document.getElementById('bgColorPicker');
    if (bgColorPicker) {
        bgColorPicker.addEventListener('input', function() {
            document.execCommand('hiliteColor', false, this.value);
        });
    }

    const rteButtons = document.querySelectorAll('.rte-toolbar button[data-command]');
    rteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const command = this.getAttribute('data-command');
            
            if (command === 'insertImage') {
                const url = prompt('Enter the image URL:');
                if (url) {
                    document.execCommand('insertImage', false, url);
                }
            } else if (command === 'insertVideo') {
                toastr.info('Video insertion coming soon!');
            } else {
                document.execCommand(command, false, null);
            }
            
            document.getElementById('editorContent').focus();
            updateToolbarState();
        });
    });

    let savedSelection = null;
    function saveSelection() {
        if (window.getSelection) {
            const sel = window.getSelection();
            if (sel.getRangeAt && sel.rangeCount) {
                return sel.getRangeAt(0);
            }
        }
        return null;
    }
    function restoreSelection(range) {
        if (range) {
            if (window.getSelection) {
                const sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    }

    const insertLinkBtn = document.getElementById('insertLinkBtn');
    const linkPopover = document.getElementById('linkPopover');
    const linkInput = document.getElementById('linkInput');
    const applyLinkBtn = document.getElementById('applyLinkBtn');

    if (insertLinkBtn && linkPopover) {
        insertLinkBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (linkPopover.style.display === 'none') {
                savedSelection = saveSelection();
                linkPopover.style.display = 'flex';
                linkInput.focus();
            } else {
                linkPopover.style.display = 'none';
            }
        });
        
        applyLinkBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = linkInput.value.trim();
            linkPopover.style.display = 'none';
            linkInput.value = '';
            if (url) {
                restoreSelection(savedSelection);
                document.execCommand('createLink', false, url);
                updateToolbarState();
            }
        });
    }

    const editor = document.getElementById('editorContent');
    
    function updateToolbarState() {
        if (!editor) return;
        rteButtons.forEach(btn => {
            const command = btn.getAttribute('data-command');
            if (['bold', 'italic', 'underline', 'strikeThrough', 'insertOrderedList', 'insertUnorderedList'].includes(command)) {
                if (document.queryCommandState(command)) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            }
        });

        const formatBlock = document.queryCommandValue('formatBlock');
        if (formatBlock && formatSelect) {
            let value = formatBlock.toLowerCase();
            if (value.includes('h1')) value = 'h1';
            else if (value.includes('h2')) value = 'h2';
            else if (value.includes('h3')) value = 'h3';
            else value = 'p';
            formatSelect.value = value;
        }
    }

    if (editor) {
        editor.addEventListener('keyup', updateToolbarState);
        editor.addEventListener('mouseup', updateToolbarState);
        editor.addEventListener('input', updateToolbarState);
    }

    // Featured Image Upload Logic
    const imageUploadBox = document.getElementById('imageUploadBox');
    const featuredImageInput = document.getElementById('featuredImageInput');
    const imagePreview = document.getElementById('imagePreview');
    const addImageBoxBtn = document.getElementById('addImageBoxBtn');

    if (imageUploadBox && featuredImageInput) {
        // Trigger file input when clicking anywhere in the box
        imageUploadBox.addEventListener('click', function() {
            featuredImageInput.click();
        });

        featuredImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imageUploadBox.classList.add('has-image');
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Save Button Handler
    const saveButtons = document.querySelectorAll('.btn-primary');
    saveButtons.forEach(btn => {
        if(btn.textContent.trim() === 'Save') {
            btn.addEventListener('click', function() {
                toastr.success('Blog post saved successfully!');
            });
        }
    });
});
