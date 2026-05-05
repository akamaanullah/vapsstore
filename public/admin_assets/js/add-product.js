document.addEventListener('DOMContentLoaded', function() {
    const productForm = document.getElementById('productForm') || document.querySelector('form[action*="/admin/products"]');

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

    // 2. Variants Logic
    const variantsContainer = document.getElementById('variantsContainer');
    const tableCard = document.getElementById('variantsTableCard');
    const tableContainer = document.getElementById('variantsTableContainer');
    const addVariantBtn = document.getElementById('addVariantBtn');
    const addAnotherOptionBtn = document.getElementById('addAnotherOptionBtn');

    function addValueRow(text, container) {
        const valueRow = document.createElement('div');
        valueRow.className = 'value-item-row mb-8';
        valueRow.innerHTML = `
            <div class="drag-handle-sub"><i data-lucide="grip-vertical" class="icon-xs text-muted"></i></div>
            <input type="text" class="modal-field-input variant-value-input" value="${text}">
            <button type="button" class="btn-action-icon delete-btn"><i data-lucide="trash-2"></i></button>
        `;
        container.appendChild(valueRow);
        if (window.lucide) window.lucide.createIcons();
        valueRow.querySelector('.delete-btn').addEventListener('click', () => { valueRow.remove(); generateVariantsTable(); });
        valueRow.querySelector('.variant-value-input').addEventListener('input', generateVariantsTable);
    }

    function addOptionRow() {
        const row = document.createElement('div');
        row.className = 'variant-option-card mb-20';
        row.innerHTML = `
            <div class="option-edit-view">
                <div class="variant-option-inner">
                    <div class="variant-content-area">
                        <div class="form-group mb-15">
                            <label class="fs-13 fw-500">Option name</label>
                            <input type="text" class="modal-field-input option-name-input" placeholder="e.g. Color, Size">
                        </div>
                        <div class="form-group mb-10">
                            <label class="fs-13 fw-500 mb-5 d-block">Option values</label>
                            <div class="values-list-container"></div>
                            <div class="value-input-row mt-10">
                                <input type="text" class="modal-field-input add-value-input" placeholder="Add another value">
                            </div>
                        </div>
                        <div class="variant-card-footer mt-20">
                             <button type="button" class="btn-link text-error fs-14 remove-option-btn">Delete</button>
                             <button type="button" class="btn btn-dark btn-sm done-option-btn">Done</button>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="option-summary-view d-none" style="position: relative; width: 100%; min-height: 45px; align-items: center; padding: 0 15px; background: #fff; border: 1px solid var(--border-color); border-radius: 8px;">
                 <div class="d-flex align-items-center gap-15 w-100">
                     <div class="drag-handle d-flex align-items-center"><i data-lucide="grip-vertical" class="icon-sm text-muted"></i></div>
                     <div class="fw-600 fs-14 summary-name" style="flex: 1;">Option Name</div>
                 </div>
                 <button type="button" class="btn-action-icon edit-option-btn" title="Edit" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"><i data-lucide="pencil"></i></button>
             </div>
        `;
        variantsContainer.appendChild(row);
        const vList = row.querySelector('.values-list-container');
        if (window.lucide) window.lucide.createIcons();

        row.querySelector('.done-option-btn').addEventListener('click', () => {
            const name = row.querySelector('.option-name-input').value.trim();
            const vals = Array.from(vList.querySelectorAll('.variant-value-input')).map(i => i.value.trim()).filter(v => v !== '');
            if (!name || vals.length === 0) return;
            row.querySelector('.summary-name').textContent = name;
            row.querySelector('.option-edit-view').classList.add('d-none');
            row.querySelector('.option-summary-view').classList.remove('d-none');
            row.querySelector('.option-summary-view').classList.add('d-flex');
            generateVariantsTable();
        });
        row.querySelector('.edit-option-btn').addEventListener('click', () => {
            row.querySelector('.option-edit-view').classList.remove('d-none');
            row.querySelector('.option-summary-view').classList.add('d-none');
            row.querySelector('.option-summary-view').classList.remove('d-flex');
        });
        row.querySelector('.add-value-input').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); const val = this.value.trim(); if (val) { addValueRow(val, vList); this.value = ''; } }
        });
        row.querySelector('.remove-option-btn').addEventListener('click', () => { row.remove(); generateVariantsTable(); });
    }

    function generateVariantsTable() {
        const optionRows = variantsContainer.querySelectorAll('.variant-option-card');
        const options = [];
        optionRows.forEach(row => {
            const name = row.querySelector('.option-name-input').value.trim();
            const values = Array.from(row.querySelectorAll('.variant-value-input')).map(i => i.value.trim()).filter(v => v !== '');
            if (name && values.length > 0) options.push(values);
        });
        if (options.length === 0) { if (tableCard) tableCard.style.display = 'none'; return; }
        let combinations = [[]];
        options.forEach(opt => {
            const next = [];
            combinations.forEach(c => opt.forEach(v => next.push([...c, v])));
            combinations = next;
        });
        renderTable(combinations);
    }

    function renderTable(combinations) {
        if (!tableCard || !tableContainer) return;
        tableCard.style.display = 'block';
        const groups = {};
        combinations.forEach(combo => {
            const parent = combo[0];
            if (!groups[parent]) groups[parent] = [];
            groups[parent].push(combo);
        });
        let html = `<table class="variants-custom-table"><thead><tr><th>Variant</th><th style="width: 150px;">Price</th><th style="width: 120px;">Available</th></tr></thead><tbody>`;
        const basePrice = document.querySelector('input[name="price"]')?.value || '0.00';
        const baseStock = document.querySelector('input[name="stock"]')?.value || '0';
        let globalVariantIndex = 0;
        Object.keys(groups).forEach((parentValue, gIndex) => {
            const subVariants = groups[parentValue];
            const groupId = `group-${gIndex}`;
            if (subVariants[0].length > 1) {
                html += `<tr class="variant-parent-row" data-group-target="${groupId}"><td><div class="fs-14 fw-500">${parentValue}</div><div class="text-muted-sm">${subVariants.length} variants <i data-lucide="chevron-down" class="icon-xxs chevron-toggle"></i></div></td><td>$${basePrice}</td><td>Multiple</td></tr>`;
                subVariants.forEach(combo => {
                    const name = combo.join(' / ');
                    html += `<tr class="variant-child-row ${groupId}" style="display: none;"><td><span class="fs-13">${combo.slice(1).join(' / ')}</span><input type="hidden" name="variants[${globalVariantIndex}][name]" value="${name}"></td><td><input type="number" name="variants[${globalVariantIndex}][price]" class="modal-field-input input-sm" value="${basePrice}" step="0.01"></td><td><input type="number" name="variants[${globalVariantIndex}][stock]" class="modal-field-input input-sm" value="${baseStock}"></td></tr>`;
                    globalVariantIndex++;
                });
            } else {
                html += `<tr><td>${parentValue}<input type="hidden" name="variants[${globalVariantIndex}][name]" value="${parentValue}"></td><td><input type="number" name="variants[${globalVariantIndex}][price]" class="modal-field-input input-sm" value="${basePrice}" step="0.01"></td><td><input type="number" name="variants[${globalVariantIndex}][stock]" class="modal-field-input input-sm" value="${baseStock}"></td></tr>`;
                globalVariantIndex++;
            }
        });
        tableContainer.innerHTML = html + `</tbody></table>`;
        if (window.lucide) window.lucide.createIcons();
        tableContainer.querySelectorAll('.variant-parent-row').forEach(row => {
            row.addEventListener('click', function() {
                const gid = this.getAttribute('data-group-target');
                const children = tableContainer.querySelectorAll(`.${gid}`);
                const isHidden = children[0].style.display === 'none';
                children.forEach(c => c.style.display = isHidden ? 'table-row' : 'none');
            });
        });
    }

    // 3. Media Logic
    const mediaUploadArea = document.getElementById('mediaUploadArea');
    const productMediaInput = document.getElementById('productMediaInput');
    const mediaPreviewGrid = document.getElementById('mediaPreviewGrid');
    const mediaPlaceholder = document.querySelector('.media-placeholder');
    let uploadedFiles = [];

    function updateFileInput() {
        if (!productMediaInput) return;
        const dt = new DataTransfer();
        uploadedFiles.forEach(f => { if (f.fileObj) dt.items.add(f.fileObj); });
        productMediaInput.files = dt.files;
    }

    function renderMediaPreviews() {
        if (!mediaPreviewGrid) return;
        if (uploadedFiles.length > 0) {
            if (mediaPlaceholder) mediaPlaceholder.style.display = 'none';
            mediaPreviewGrid.style.display = 'grid';
            mediaPreviewGrid.innerHTML = uploadedFiles.map((file, i) => `
                <div class="media-item" data-id="${i}">
                    <img src="${file.preview || ''}" alt="Preview">
                    ${i === 0 ? '<span class="badge-featured">Featured</span>' : ''}
                    <button type="button" class="btn-remove-media" onclick="window.removeMedia(${i})"><i data-lucide="x"></i></button>
                </div>
            `).join('') + `
                <div class="add-more-media">
                    <i data-lucide="plus-circle"></i><span class="fs-12 mt-5">Add media</span>
                </div>
            `;
            if (window.lucide) window.lucide.createIcons();
            if (window.Sortable) {
                new Sortable(mediaPreviewGrid, {
                    animation: 150, filter: '.add-more-media',
                    onEnd: function () {
                        const newOrder = [];
                        mediaPreviewGrid.querySelectorAll('.media-item').forEach(item => {
                            newOrder.push(uploadedFiles[parseInt(item.getAttribute('data-id'))]);
                        });
                        uploadedFiles = newOrder;
                        renderMediaPreviews();
                        updateFileInput();
                    }
                });
            }
        } else {
            if (mediaPlaceholder) mediaPlaceholder.style.display = 'block';
            mediaPreviewGrid.style.display = 'none';
        }
    }

    window.removeMedia = (index) => { uploadedFiles.splice(index, 1); renderMediaPreviews(); updateFileInput(); };

    if (mediaUploadArea && productMediaInput) {
        mediaUploadArea.addEventListener('click', (e) => { 
            if (e.target !== productMediaInput && !e.target.closest('.btn-remove-media')) productMediaInput.click(); 
        });
        productMediaInput.addEventListener('click', (e) => e.stopPropagation());
        productMediaInput.addEventListener('change', function() {
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => { 
                    uploadedFiles.push({ fileObj: file, preview: e.target.result }); 
                    renderMediaPreviews();
                    updateFileInput();
                };
                reader.readAsDataURL(file);
            });
        });
    }

    // 4. Tags Logic
    const tagsHidden = document.getElementById('tagsHidden');
    const tagInput = document.getElementById('tagInput');
    const tagSelectedDiv = document.getElementById('selectedTags');
    let selectedTagsArr = [];

    function renderTags() {
        if (!tagSelectedDiv) return;
        tagSelectedDiv.innerHTML = selectedTagsArr.map(t => `
            <div class="tag-badge">${t}<span class="remove-tag" data-tag="${t}"><i data-lucide="x" class="icon-xxs"></i></span></div>
        `).join('');
        if (tagsHidden) tagsHidden.value = selectedTagsArr.join(',');
        if (window.lucide) window.lucide.createIcons();
        tagSelectedDiv.querySelectorAll('.remove-tag').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                selectedTagsArr = selectedTagsArr.filter(t => t !== this.getAttribute('data-tag'));
                renderTags();
            });
        });
    }

    function addTag() {
        if (!tagInput) return;
        const inputVal = tagInput.value.trim();
        if (!inputVal) return;

        // Split by comma and add each part as a tag
        const parts = inputVal.split(',').map(p => p.trim()).filter(p => p !== '');
        
        parts.forEach(val => {
            if (val && !selectedTagsArr.includes(val)) {
                selectedTagsArr.push(val);
            }
        });

        renderTags();
        tagInput.value = '';
    }

    if (tagInput) {
        tagInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); addTag(); }
        });
    }

    // 5. RTE Toolbar & Sync Logic
    const editor = document.querySelector('.rte-editor-content');
    const textarea = document.getElementById('descriptionInput');
    const rteToolbar = document.querySelector('.rte-toolbar');

    if (editor && rteToolbar) {
        rteToolbar.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const command = this.dataset.command;
                const value = this.dataset.value || null;

                if (command === 'createLink') {
                    Swal.fire({
                        title: 'Insert Link',
                        input: 'url',
                        inputLabel: 'Enter the link URL',
                        inputPlaceholder: 'https://',
                        inputValue: 'https://',
                        showCancelButton: true,
                        confirmButtonText: 'Insert',
                        confirmButtonColor: '#e16449',
                    }).then((result) => {
                        if (result.isConfirmed && result.value) {
                            document.execCommand(command, false, result.value);
                            if (textarea) textarea.value = editor.innerHTML;
                        }
                    });
                } else {
                    document.execCommand(command, false, value);
                }
                editor.focus();
                if (textarea) textarea.value = editor.innerHTML;
            });
        });

        editor.addEventListener('input', () => {
            if (textarea) textarea.value = editor.innerHTML;
        });

        // If edit mode, load initial content
        if (editor.innerHTML && textarea) {
            textarea.value = editor.innerHTML;
        }
    }

    if (productForm) {
        productForm.addEventListener('submit', function() {
            addTag();
            if (editor && textarea) {
                // Final clean and sync
                textarea.value = editor.innerHTML;
            }
            if (tagsHidden) tagsHidden.value = selectedTagsArr.join(',');
            updateFileInput();
        });
    }

    if (addVariantBtn) addVariantBtn.addEventListener('click', () => {
        variantsContainer.style.display = 'block';
        addVariantBtn.style.display = 'none';
        if (addAnotherOptionBtn) { addAnotherOptionBtn.classList.remove('d-none'); addAnotherOptionBtn.classList.add('d-flex'); }
        addOptionRow();
    });
    if (addAnotherOptionBtn) addAnotherOptionBtn.addEventListener('click', () => addOptionRow());
});
