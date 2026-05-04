document.addEventListener('DOMContentLoaded', function() {
    const collectionForm = document.querySelector('form[action*="/admin/collections"]');

    // 1. SEO Toggle
    const toggleSeoBtn = document.getElementById('toggleSeoBtn');
    const seoFields = document.getElementById('seoFields');
    if (toggleSeoBtn && seoFields) {
        toggleSeoBtn.addEventListener('click', (e) => {
            e.preventDefault();
            seoFields.classList.toggle('active');
            toggleSeoBtn.textContent = seoFields.classList.contains('active') ? 'Hide website SEO' : 'Edit website SEO';
        });
    }

    // 2. RTE Toolbar & Sync Logic
    const editor = document.querySelector('.rte-editor-content');
    const textarea = document.getElementById('descriptionInput');
    const rteToolbar = document.querySelector('.rte-toolbar');

    if (editor && rteToolbar) {
        rteToolbar.addEventListener('click', (e) => {
            const btn = e.target.closest('button');
            if (!btn) return;
            
            const action = btn.getAttribute('title').toLowerCase();
            e.preventDefault();
            editor.focus();

            if (action === 'bold') document.execCommand('bold', false, null);
            if (action === 'italic') document.execCommand('italic', false, null);
            if (action === 'list') document.execCommand('insertUnorderedList', false, null);
            if (action === 'link') {
                const url = prompt('Enter the link URL:');
                if (url) document.execCommand('createLink', false, url);
            }
            if (textarea) textarea.value = editor.innerHTML;
        });

        const headingSelect = rteToolbar.querySelector('.rte-select-clean');
        if (headingSelect) {
            headingSelect.addEventListener('change', function() {
                const val = this.value;
                editor.focus();
                if (val === 'Heading 1') document.execCommand('formatBlock', false, '<h1>');
                else if (val === 'Heading 2') document.execCommand('formatBlock', false, '<h2>');
                else document.execCommand('formatBlock', false, '<p>');
                this.selectedIndex = 0;
                if (textarea) textarea.value = editor.innerHTML;
            });
        }

        editor.addEventListener('input', () => {
            if (textarea) textarea.value = editor.innerHTML;
        });
    }

    // 3. Single Image Preview Logic
    const collectionImageInput = document.getElementById('collectionImageInput');
    const imagePreview = document.getElementById('imagePreview');
    const imagePlaceholder = document.getElementById('imagePlaceholder');

    if (collectionImageInput && imagePreview) {
        collectionImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePlaceholder.style.display = 'none';
                    imagePreview.style.display = 'grid';
                    imagePreview.innerHTML = `
                        <div class="media-item">
                            <img src="${e.target.result}" alt="Preview" style="max-height: 200px; width: 100%; object-fit: contain;">
                            <button type="button" class="btn-remove-media" id="removeCollectionImage"><i data-lucide="x"></i></button>
                        </div>
                    `;
                    if (window.lucide) window.lucide.createIcons();
                    
                    document.getElementById('removeCollectionImage').addEventListener('click', () => {
                        collectionImageInput.value = '';
                        imagePreview.style.display = 'none';
                        imagePlaceholder.style.display = 'block';
                    });
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // 4. Slug Generator
    const titleInput = document.getElementById('collectionTitleInput');
    const slugInput = document.getElementById('slugInput');
    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function() {
            if (!slugInput.dataset.manual) {
                slugInput.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            }
        });
        slugInput.addEventListener('input', () => slugInput.dataset.manual = true);
    }

    if (collectionForm) {
        collectionForm.addEventListener('submit', () => {
            if (editor && textarea) textarea.value = editor.innerHTML;
        });
    }

    // 5. Delete Collection Confirmation
    const deleteBtn = document.getElementById('deleteCollectionBtn');
    const deleteForm = document.getElementById('deleteCollectionForm');
    if (deleteBtn && deleteForm) {
        deleteBtn.addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "All products will be unlinked from this collection!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e16449',
                cancelButtonColor: '#a3a3a3',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteForm.submit();
                }
            });
        });
    }
});
