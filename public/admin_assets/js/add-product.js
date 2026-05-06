document.addEventListener('DOMContentLoaded', function() {
    const productForm = document.getElementById('productForm') || document.querySelector('form[action*="/admin/products"]');

    // 1. SEO Logic
    const toggleSeoBtn = document.getElementById('toggleSeoBtn');
    const seoFields = document.getElementById('seoFields');
    const seoTitleInput = document.querySelector('.seo-title-input');
    const seoDescInput = document.querySelector('.seo-desc-input');
    const slugInput = document.getElementById('slugInput');
    const productTitleInput = document.getElementById('productTitleInput');

    const previewTitle = document.querySelector('.seo-preview-title');
    const previewDesc = document.querySelector('.seo-preview-desc');
    const previewUrl = document.querySelector('.seo-preview-url');
    const seoTitleCount = document.querySelector('.seo-title-count');
    const seoDescCount = document.querySelector('.seo-desc-count');

    if (toggleSeoBtn && seoFields) {
        toggleSeoBtn.addEventListener('click', (e) => {
            e.preventDefault();
            seoFields.classList.toggle('active');
            toggleSeoBtn.textContent = seoFields.classList.contains('active') ? 'Hide website SEO' : 'Edit website SEO';
        });
    }

    function updateSeoPreview() {
        const title = (seoTitleInput && seoTitleInput.value) || (productTitleInput && productTitleInput.value) || 'Product Title';
        const desc = (seoDescInput && seoDescInput.value) || 'Product description will appear here...';
        const slug = (slugInput && slugInput.value) || (productTitleInput && productTitleInput.value ? productTitleInput.value.toLowerCase().replace(/[^a-z0-9]+/g, '-') : 'product-url');

        if (previewTitle) previewTitle.textContent = title;
        if (previewDesc) previewDesc.textContent = desc;
        if (previewUrl) previewUrl.textContent = `www.theperfectvape.com/products/${slug}`;
        
        if (seoTitleCount && seoTitleInput) seoTitleCount.textContent = seoTitleInput.value.length;
        if (seoDescCount && seoDescInput) seoDescCount.textContent = seoDescInput.value.length;
    }

    [seoTitleInput, seoDescInput, slugInput, productTitleInput].forEach(el => {
        if (el) el.addEventListener('input', updateSeoPreview);
    });
    updateSeoPreview();

    // 2. Variants Logic
    const variantsContainer = document.getElementById('variantsContainer');
    const tableCard = document.getElementById('variantsTableCard');
    const tableContainer = document.getElementById('variantsTableContainer');
    const addVariantBtn = document.getElementById('addVariantBtn');
    const addAnotherOptionBtn = document.getElementById('addAnotherOptionBtn');
    const inventoryCard = document.getElementById('inventoryCard');

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

    function addOptionRow(initialName = '', initialValues = []) {
        const row = document.createElement('div');
        row.className = 'variant-option-card mb-20';
        row.innerHTML = `
            <div class="option-edit-view ${initialName ? 'd-none' : ''}">
                <div class="variant-option-inner">
                    <div class="variant-content-area">
                        <div class="form-group mb-15">
                            <label class="fs-13 fw-500">Option name</label>
                            <input type="text" class="modal-field-input option-name-input" placeholder="e.g. Color, Size" value="${initialName}">
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
             <div class="option-summary-view ${initialName ? 'd-flex' : 'd-none'}" style="position: relative; width: 100%; min-height: 45px; align-items: center; padding: 0 15px; background: #fff; border: 1px solid var(--border-color); border-radius: 8px;">
                 <div class="d-flex align-items-center gap-15 w-100">
                     <div class="drag-handle d-flex align-items-center"><i data-lucide="grip-vertical" class="icon-sm text-muted"></i></div>
                     <div class="fw-600 fs-14 summary-name" style="flex: 1;">${initialName || 'Option Name'}</div>
                 </div>
                 <button type="button" class="btn-action-icon edit-option-btn" title="Edit" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"><i data-lucide="pencil"></i></button>
             </div>
        `;
        variantsContainer.appendChild(row);
        const vList = row.querySelector('.values-list-container');
        if (initialValues.length > 0) initialValues.forEach(val => addValueRow(val, vList));
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
        const optionsData = [];
        optionRows.forEach(row => {
            const name = row.querySelector('.option-name-input').value.trim();
            const values = Array.from(row.querySelectorAll('.variant-value-input')).map(i => i.value.trim()).filter(v => v !== '');
            if (name && values.length > 0) optionsData.push({ name, values });
        });
        if (optionsData.length === 0) { 
            if (tableCard) tableCard.style.display = 'none'; 
            return; 
        }
        let combinations = [[]];
        optionsData.forEach(opt => {
            const next = [];
            combinations.forEach(c => {
                opt.values.forEach(v => {
                    next.push([...c, v]);
                });
            });
            combinations = next;
        });
        renderTable(combinations);
    }

    function renderTable(combinations) {
        if (!tableCard || !tableContainer) return;
        tableCard.style.display = 'block';

        // PRODUCTION FEATURE: Preserve currently typed values before clearing the table
        const currentData = {};
        tableContainer.querySelectorAll('tbody tr').forEach(tr => {
            const nameInput = tr.querySelector('input[name*="[name]"]');
            if (nameInput) {
                const name = nameInput.value;
                const price = tr.querySelector('input[name*="[price]"]')?.value;
                const stock = tr.querySelector('input[name*="[stock]"]')?.value;
                const id = tr.querySelector('input[name*="[id]"]')?.value;
                currentData[name] = { price, stock, id };
            }
        });

        // Fallback to DB data if it exists (for edit page)
        const dbData = JSON.parse(document.getElementById('existingVariantsData')?.textContent || '[]');
        dbData.forEach(v => {
            if (!currentData[v.variant_name]) {
                currentData[v.variant_name] = { price: v.price, stock: v.stock_quantity, id: v.id };
            }
        });

        const groups = {};
        combinations.forEach(combo => {
            const parent = combo[0];
            if (!groups[parent]) groups[parent] = [];
            groups[parent].push(combo);
        });

        let html = `
            <table class="variants-custom-table">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" id="selectAllVariants"></th>
                        <th>Variant</th>
                        <th style="width: 150px;">Price</th>
                        <th style="width: 120px;">Available</th>
                    </tr>
                </thead>
                <tbody>`;

        const basePrice = document.querySelector('input[name="price"]')?.value || '0.00';
        const baseStock = document.querySelector('input[name="stock"]')?.value || '0';
        let globalVariantIndex = 0;

        Object.keys(groups).forEach((parentValue, gIndex) => {
            const subVariants = groups[parentValue];
            const groupId = `group-${gIndex}`;

            if (subVariants[0].length > 1) {
                // Parent row
                html += `
                    <tr class="variant-parent-row" data-group-target="${groupId}">
                        <td><input type="checkbox" class="group-checkbox" data-group="${groupId}"></td>
                        <td style="cursor: pointer;" class="toggle-group" data-group="${groupId}">
                            <div class="fs-14 fw-500">${parentValue}</div>
                            <div class="text-muted-sm">${subVariants.length} variants <i data-lucide="chevron-down" class="icon-xxs chevron-toggle"></i></div>
                        </td>
                        <td><span class="text-muted-sm fw-500">Multiple</span></td>
                        <td><span class="text-muted-sm fw-500">Multiple</span></td>
                    </tr>`;

                subVariants.forEach(combo => {
                    const name = combo.join(' / ');
                    const preserved = currentData[name] || {};
                    const price = preserved.price || basePrice;
                    const stock = preserved.stock !== undefined ? preserved.stock : baseStock;
                    const id = preserved.id || '';

                    html += `
                        <tr class="variant-child-row ${groupId}" style="display: none;">
                            <td><input type="checkbox" class="variant-checkbox" data-group="${groupId}"></td>
                            <td>
                                <span class="fs-13">${combo.slice(1).join(' / ')}</span>
                                <input type="hidden" name="variants[${globalVariantIndex}][id]" value="${id}">
                                <input type="hidden" name="variants[${globalVariantIndex}][name]" value="${name}">
                            </td>
                            <td>
                                <div class="input-prefix-container">
                                    <span class="prefix">$</span>
                                    <input type="number" name="variants[${globalVariantIndex}][price]" class="modal-field-input input-sm" value="${price}" step="0.01">
                                </div>
                            </td>
                            <td><input type="number" name="variants[${globalVariantIndex}][stock]" class="modal-field-input input-sm" value="${stock}"></td>
                        </tr>`;
                    globalVariantIndex++;
                });
            } else {
                // Simple row (no nesting)
                const name = parentValue;
                const preserved = currentData[name] || {};
                const price = preserved.price || basePrice;
                const stock = preserved.stock !== undefined ? preserved.stock : baseStock;
                const id = preserved.id || '';

                html += `
                    <tr>
                        <td><input type="checkbox" class="variant-checkbox"></td>
                        <td>
                            ${name}
                            <input type="hidden" name="variants[${globalVariantIndex}][id]" value="${id}">
                            <input type="hidden" name="variants[${globalVariantIndex}][name]" value="${name}">
                        </td>
                        <td>
                            <div class="input-prefix-container">
                                <span class="prefix">$</span>
                                <input type="number" name="variants[${globalVariantIndex}][price]" class="modal-field-input input-sm" value="${price}" step="0.01">
                            </div>
                        </td>
                        <td><input type="number" name="variants[${globalVariantIndex}][stock]" class="modal-field-input input-sm" value="${stock}"></td>
                    </tr>`;
                globalVariantIndex++;
            }
        });

        tableContainer.innerHTML = html + `</tbody></table>`;
        if (window.lucide) window.lucide.createIcons();

        // Bind events
        initTableEvents();
    }

    function updateBulkUI() {
        const currentTable = document.getElementById('variantsTableContainer');
        const bulkPlaceholder = document.getElementById('bulkEditPlaceholder');
        if (!currentTable || !bulkPlaceholder) return;

        const selectedCount = currentTable.querySelectorAll('.variant-checkbox:checked').length;
        if (selectedCount > 0) {
            bulkPlaceholder.innerHTML = `
                <div class="bulk-edit-bar">
                    <span class="selected-count">${selectedCount} selected</span>
                    <div class="dropdown">
                        <button type="button" class="btn btn-dark btn-sm d-flex align-items-center gap-5" id="bulkEditBtn">
                            Bulk edit <i data-lucide="chevron-down" class="icon-xxs"></i>
                        </button>
                        <div class="dropdown-menu-custom" id="bulkDropdown">
                            <div class="dropdown-item-custom" data-action="price">
                                <i data-lucide="dollar-sign" class="icon-xxs"></i> Edit prices
                            </div>
                            <div class="dropdown-item-custom" data-action="stock">
                                <i data-lucide="layers" class="icon-xxs"></i> Edit quantities
                            </div>
                        </div>
                    </div>
                </div>
            `;
            if (window.lucide) window.lucide.createIcons();
            
            const bulkBtn = document.getElementById('bulkEditBtn');
            const bulkDropdown = document.getElementById('bulkDropdown');
            
            bulkBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                bulkDropdown.classList.toggle('show');
            });

            document.addEventListener('click', () => { if(bulkDropdown) bulkDropdown.classList.remove('show'); }, { once: true });

            bulkDropdown.querySelectorAll('.dropdown-item-custom').forEach(item => {
                item.addEventListener('click', function() {
                    const action = this.getAttribute('data-action');
                    openBulkModal(action);
                });
            });
        } else {
            bulkPlaceholder.innerHTML = '';
        }
    }

    function openBulkModal(action) {
        const modal = document.getElementById('bulkEditModal');
        const title = document.getElementById('bulkEditTitle');
        const desc = document.getElementById('bulkEditDescription');
        const prefix = document.getElementById('bulkInputPrefix');
        const input = document.getElementById('bulkValueInput');

        if (!modal) return;

        if (action === 'price') {
            title.textContent = 'Edit prices';
            desc.textContent = 'Apply a price to all selected variants';
            prefix.style.display = 'flex';
            input.type = 'number';
            input.step = '0.01';
            input.placeholder = '0.00';
            input.value = '';
        } else {
            title.textContent = 'Edit quantities';
            desc.textContent = 'Apply a quantity to all selected variants';
            prefix.style.display = 'none';
            input.type = 'number';
            input.step = '1';
            input.placeholder = '0';
            input.value = '';
        }

        modal.style.display = 'flex';
        modal.setAttribute('data-action', action);
    }

    // Initialize Modal Handlers once
    const applyBulkBtn = document.getElementById('applyBulkEdit');
    if (applyBulkBtn) {
        applyBulkBtn.addEventListener('click', () => {
            const modal = document.getElementById('bulkEditModal');
            const action = modal.getAttribute('data-action');
            const val = document.getElementById('bulkValueInput').value;
            const currentTable = document.getElementById('variantsTableContainer');
            const selectedVariants = currentTable.querySelectorAll('.variant-checkbox:checked');

            if (val === '') return;

            selectedVariants.forEach(cb => {
                const row = cb.closest('tr');
                if (action === 'price') {
                    const priceInput = row.querySelector('input[name*="[price]"]');
                    if (priceInput) priceInput.value = val;
                } else {
                    const stockInput = row.querySelector('input[name*="[stock]"]');
                    if (stockInput) stockInput.value = val;
                }
            });

            modal.style.display = 'none';
        });
    }

    document.querySelectorAll('.close-modal-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = document.getElementById('bulkEditModal');
            if (modal) modal.style.display = 'none';
        });
    });

    function initTableEvents() {
        const currentTable = document.getElementById('variantsTableContainer');
        if (!currentTable) return;

        const selectAll = document.getElementById('selectAllVariants');
        const checkboxes = currentTable.querySelectorAll('.variant-checkbox');
        const groupCheckboxes = currentTable.querySelectorAll('.group-checkbox');

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const checked = this.checked;
                checkboxes.forEach(cb => cb.checked = checked);
                groupCheckboxes.forEach(cb => cb.checked = checked);
                updateBulkUI();
            });
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateBulkUI);
        });

        groupCheckboxes.forEach(gcb => {
            gcb.addEventListener('change', function() {
                const gid = this.getAttribute('data-group');
                const checked = this.checked;
                currentTable.querySelectorAll(`.variant-checkbox[data-group="${gid}"]`).forEach(cb => {
                    cb.checked = checked;
                });
                updateBulkUI();
            });
        });

        currentTable.querySelectorAll('.toggle-group').forEach(btn => {
            btn.addEventListener('click', function() {
                const gid = this.getAttribute('data-group');
                const children = currentTable.querySelectorAll(`.${gid}`);
                const isHidden = children[0].style.display === 'none';
                children.forEach(c => c.style.display = isHidden ? 'table-row' : 'none');
                this.querySelector('.chevron-toggle').style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
            });
        });
    }

    // 3. Media Logic
    const mediaPreviewGrid = document.getElementById('mediaPreviewGrid');
    const mediaPlaceholder = document.getElementById('mediaPlaceholder');
    const openMediaPickerBtn = document.getElementById('openMediaPickerBtn');
    const urlsContainer = document.getElementById('productMediaUrlsContainer');
    let uploadedMedia = []; 

    function updateHiddenInputs() {
        if (!urlsContainer) return;
        urlsContainer.innerHTML = '';
        uploadedMedia.forEach(url => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'image_urls[]';
            input.value = url;
            urlsContainer.appendChild(input);
        });
    }

    function updateFeaturedBadge() {
        if (!mediaPreviewGrid) return;
        // Remove all existing badges
        mediaPreviewGrid.querySelectorAll('.badge-featured').forEach(b => b.remove());
        // Add to first item
        const firstItem = mediaPreviewGrid.querySelector('.media-item');
        if (firstItem) {
            const badge = document.createElement('span');
            badge.className = 'badge-featured';
            badge.textContent = 'Featured';
            firstItem.appendChild(badge);
        }
    }

    function renderMediaPreviews() {
        if (!mediaPreviewGrid) return;
        
        const newItems = mediaPreviewGrid.querySelectorAll('.new-media-item, .add-more-media');
        newItems.forEach(item => item.remove());

        const existingCount = mediaPreviewGrid.querySelectorAll('.media-item:not(.new-media-item)').length;

        if (uploadedMedia.length > 0 || existingCount > 0) {
            if (mediaPlaceholder) mediaPlaceholder.style.display = 'none';
            mediaPreviewGrid.style.display = 'grid';
            
            const newHtml = uploadedMedia.map((url, i) => `
                <div class="media-item new-media-item" data-new-id="${i}">
                    <img src="${window.MEDIA_BASE_URL + '/' + url}" alt="Preview">
                    <button type="button" class="btn-remove-media" onclick="window.removeNewMedia(${i})"><i data-lucide="x"></i></button>
                </div>
            `).join('') + `
                <div class="add-more-media" id="addMoreMediaBtn">
                    <i data-lucide="plus-circle"></i><span class="fs-12 mt-5">Add media</span>
                </div>
            `;
            
            mediaPreviewGrid.insertAdjacentHTML('beforeend', newHtml);
            if (window.lucide) window.lucide.createIcons();
            
            const addBtn = document.getElementById('addMoreMediaBtn');
            if (addBtn) addBtn.addEventListener('click', openPicker);

            if (window.Sortable && !mediaPreviewGrid.sortableInstance) {
                mediaPreviewGrid.sortableInstance = new Sortable(mediaPreviewGrid, {
                    animation: 150, filter: '.add-more-media'
                });
            }
            updateFeaturedBadge();
        } else {
            if (mediaPlaceholder) mediaPlaceholder.style.display = 'block';
            mediaPreviewGrid.style.display = 'none';
        }
    }

    window.removeNewMedia = (index) => { 
        uploadedMedia.splice(index, 1); 
        renderMediaPreviews(); 
        updateHiddenInputs(); 
    };

    window.removeExistingMedia = (btn) => {
        btn.closest('.media-item').remove();
        renderMediaPreviews();
    };

    function openPicker() {
        if (window.mediaPicker) {
            window.mediaPicker.open({
                multiple: true,
                onSelect: (items) => {
                    const newUrls = Array.isArray(items) ? items.map(i => i.file_path) : [items.file_path];
                    uploadedMedia = [...uploadedMedia, ...newUrls];
                    renderMediaPreviews();
                    updateHiddenInputs();
                }
            });
        }
    }

    if (openMediaPickerBtn) openMediaPickerBtn.addEventListener('click', openPicker);
    
    const existingAddBtn = document.getElementById('addMoreMediaBtn');
    if (existingAddBtn) existingAddBtn.addEventListener('click', openPicker);

    if (mediaPreviewGrid && window.Sortable) {
        mediaPreviewGrid.sortableInstance = new Sortable(mediaPreviewGrid, {
            animation: 150, 
            filter: '.add-more-media',
            onEnd: () => {
                updateFeaturedBadge();
                updateHiddenInputs();
            }
        });
    }

    // 4. Tags Logic
    const tagsHidden = document.getElementById('tagsHidden');
    const tagInput = document.getElementById('tagInput');
    const tagSelectedDiv = document.getElementById('selectedTags');
    let selectedTagsArr = (tagsHidden && tagsHidden.value) ? tagsHidden.value.split(',').map(t => t.trim()).filter(t => t !== '') : [];

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
        const parts = inputVal.split(',').map(p => p.trim()).filter(p => p !== '');
        parts.forEach(val => {
            if (val && !selectedTagsArr.includes(val)) selectedTagsArr.push(val);
        });
        renderTags();
        tagInput.value = '';
    }

    if (tagInput) {
        tagInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); addTag(); }
        });
    }
    if (selectedTagsArr.length > 0) renderTags();

    // 5. RTE Toolbar & Sync Logic
    const editor = document.querySelector('.rte-editor-content');
    const textarea = document.getElementById('descriptionInput');
    const rteToolbar = document.querySelector('.rte-toolbar');

    if (editor && rteToolbar) {
        rteToolbar.addEventListener('click', (e) => {
            const btn = e.target.closest('button');
            if (!btn) return;
            const action = btn.getAttribute('title')?.toLowerCase();
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
        editor.addEventListener('input', () => { if (textarea) textarea.value = editor.innerHTML; });
        if (editor.innerHTML && textarea) textarea.value = editor.innerHTML;
    }

    // 6. Collection Search & Select
    const colSearchInput = document.getElementById('collectionSearchInput');
    const colDropdown = document.getElementById('collectionDropdown');
    const selectedColsContainer = document.getElementById('selectedCollectionsContainer');

    if (colSearchInput && colDropdown && selectedColsContainer) {
        colSearchInput.addEventListener('focus', () => colDropdown.classList.add('active'));
        
        colSearchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const items = colDropdown.querySelectorAll('.search-result-item');
            let hasResults = false;
            
            items.forEach(item => {
                const name = item.textContent.trim().toLowerCase();
                if (name.includes(query)) {
                    item.style.display = 'block';
                    hasResults = true;
                } else {
                    item.style.display = 'none';
                }
            });
            
            colDropdown.classList.toggle('active', hasResults);
        });

        document.addEventListener('click', (e) => {
            if (!colSearchInput.contains(e.target) && !colDropdown.contains(e.target)) {
                colDropdown.classList.remove('active');
            }
        });

        colDropdown.addEventListener('click', (e) => {
            const item = e.target.closest('.search-result-item');
            if (!item) return;

            const id = item.getAttribute('data-id');
            const name = item.getAttribute('data-name');

            // Check if already selected
            if (selectedColsContainer.querySelector(`[data-id="${id}"]`)) {
                colSearchInput.value = '';
                colDropdown.classList.remove('active');
                return;
            }

            const badge = document.createElement('div');
            badge.className = 'tag-badge';
            badge.setAttribute('data-id', id);
            badge.innerHTML = `
                ${name}
                <span class="remove-collection" data-id="${id}"><i data-lucide="x" class="icon-xxs"></i></span>
                <input type="hidden" name="collection_ids[]" value="${id}">
            `;
            selectedColsContainer.appendChild(badge);
            
            if (window.lucide) window.lucide.createIcons();
            colSearchInput.value = '';
            colDropdown.classList.remove('active');
        });

        selectedColsContainer.addEventListener('click', (e) => {
            const removeBtn = e.target.closest('.remove-collection');
            if (removeBtn) {
                removeBtn.closest('.tag-badge').remove();
            }
        });
    }

    if (productForm) {
        productForm.addEventListener('submit', function(e) {
            addTag();
            if (editor && textarea) textarea.value = editor.innerHTML;
            if (tagsHidden) tagsHidden.value = selectedTagsArr.join(',');
            
            // Unified Image Sync: Send ALL images in order as product_images[]
            const orderedInputsContainer = document.createElement('div');
            orderedInputsContainer.style.display = 'none';
            mediaPreviewGrid.querySelectorAll('.media-item').forEach(item => {
                let url = '';
                const existingInput = item.querySelector('input[name="existing_images[]"]');
                if (existingInput) {
                    url = existingInput.value;
                } else {
                    const newId = item.getAttribute('data-new-id');
                    url = uploadedMedia[newId];
                }

                if (url) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'product_images[]';
                    input.value = url;
                    orderedInputsContainer.appendChild(input);
                }
            });

            // Clean out old containers/inputs before appending new ones
            if (urlsContainer) urlsContainer.innerHTML = '';
            mediaPreviewGrid.querySelectorAll('input[name="existing_images[]"]').forEach(i => i.remove());
            
            // Option Names Metadata
            const optionRows = variantsContainer.querySelectorAll('.variant-option-card');
            optionRows.forEach(row => {
                const name = row.querySelector('.option-name-input').value.trim();
                if (name) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'option_names[]';
                    hidden.value = name;
                    orderedInputsContainer.appendChild(hidden);
                }
            });

            this.appendChild(orderedInputsContainer);
        });
    }

    // Variants Hydration
    const existingOptions = JSON.parse(document.getElementById('existingOptionsData')?.textContent || '[]');
    if (existingOptions.length > 0 && variantsContainer) {
        variantsContainer.style.display = 'block';
        if (addVariantBtn) addVariantBtn.style.display = 'none';
        if (addAnotherOptionBtn) { addAnotherOptionBtn.classList.remove('d-none'); addAnotherOptionBtn.classList.add('d-flex'); }
        existingOptions.forEach(opt => addOptionRow(opt.name, opt.values));
        generateVariantsTable();
    }
    if (addVariantBtn) addVariantBtn.addEventListener('click', () => {
        variantsContainer.style.display = 'block';
        addVariantBtn.style.display = 'none';
        if (addAnotherOptionBtn) { addAnotherOptionBtn.classList.remove('d-none'); addAnotherOptionBtn.classList.add('d-flex'); }
        addOptionRow();
    });
    if (addAnotherOptionBtn) addAnotherOptionBtn.addEventListener('click', () => addOptionRow());
});
