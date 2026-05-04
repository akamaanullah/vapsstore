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
        const productTitleInput = document.getElementById('productTitleInput');

        if (seoTitleInput && seoPreviewTitle) {
            seoTitleInput.addEventListener('input', function() {
                const val = this.value.trim();
                seoPreviewTitle.textContent = val || (productTitleInput?.value || 'Product Title');
                seoTitleCount.textContent = this.value.length;
            });
        }

        if (seoDescInput && seoPreviewDesc) {
            seoDescInput.addEventListener('input', function() {
                const val = this.value.trim();
                seoPreviewDesc.textContent = val || 'Product description will appear here...';
                seoDescCount.textContent = this.value.length;
            });
        }

        // Also update SEO title if main product title changes and SEO title is empty
        if (productTitleInput && seoTitleInput) {
            productTitleInput.addEventListener('input', function() {
                if (!seoTitleInput.value.trim()) {
                    seoPreviewTitle.textContent = this.value || 'Product Title';
                }
            });
        }
    }

    // Slug Generation
    const productTitleInput = document.getElementById('productTitleInput');
    const slugInput = document.getElementById('slugInput');
    
    if (productTitleInput && slugInput) {
        productTitleInput.addEventListener('input', function() {
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

    // Variants Logic
    const addVariantBtn = document.getElementById('addVariantBtn');
    const addAnotherOptionBtn = document.getElementById('addAnotherOptionBtn');
    const variantsContainer = document.getElementById('variantsContainer');

    if (addVariantBtn && variantsContainer) {
        addVariantBtn.addEventListener('click', () => {
            variantsContainer.style.display = 'block';
            addVariantBtn.style.display = 'none';
            if (addAnotherOptionBtn) {
                addAnotherOptionBtn.classList.remove('d-none');
                addAnotherOptionBtn.classList.add('d-flex');
            }
            addOptionRow();
        });

        if (addAnotherOptionBtn) {
            addAnotherOptionBtn.addEventListener('click', addOptionRow);
        }

        function addOptionRow() {
            const rowId = Date.now();
            const row = document.createElement('div');
            row.className = 'variant-option-card mb-20';
            row.innerHTML = `
                <div class="option-edit-view">
                    <div class="variant-option-inner">
                        <div class="variant-content-area">
                            <div class="form-group mb-15">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                    <label class="fs-13 fw-500">Option name</label>
                                    <i data-lucide="database" class="icon-xs text-muted"></i>
                                </div>
                                <input type="text" class="modal-field-input option-name-input" placeholder="e.g. Color, Size" value="">
                            </div>
                            
                            <div class="form-group mb-10">
                                <label class="fs-13 fw-500 mb-5 d-block">Option values</label>
                                <div class="values-list-container" id="values-${rowId}">
                                    <!-- Values will be added here -->
                                </div>
                                <div class="value-input-row mt-10">
                                    <div class="drag-handle-sub" style="visibility: hidden;">
                                        <i data-lucide="grip-vertical" class="icon-xs text-muted"></i>
                                    </div>
                                    <input type="text" class="modal-field-input add-value-input" placeholder="Add another value">
                                    <div class="action-placeholder" style="width: 32px;"></div>
                                </div>
                            </div>

                            <div class="variant-card-footer mt-20">
                                <button type="button" class="btn-link text-error fs-14 remove-option-btn">Delete</button>
                                <button type="button" class="btn btn-dark btn-sm done-option-btn">Done</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="option-summary-view d-none" style="position: relative; width: 100%; min-height: 45px; display: flex; align-items: center; padding: 0 15px; background: #fff; border: 1px solid var(--border-color); border-radius: 8px;">
                    <div class="d-flex align-items-center gap-15 w-100">
                        <div class="drag-handle d-flex align-items-center">
                            <i data-lucide="grip-vertical" class="icon-sm text-muted"></i>
                        </div>
                        <div class="fw-600 fs-14 summary-name" style="flex: 1; display: flex; align-items: center; line-height: 1;">Option Name</div>
                        <div style="width: 40px;"></div> <!-- Spacer for absolute icon -->
                    </div>
                    <button type="button" class="btn-action-icon edit-option-btn" title="Edit" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="pencil"></i>
                    </button>
                </div>
            `;
            variantsContainer.appendChild(row);

            if (window.lucide) window.lucide.createIcons();

            const editView = row.querySelector('.option-edit-view');
            const summaryView = row.querySelector('.option-summary-view');
            const nameInput = row.querySelector('.option-name-input');
            const valuesList = row.querySelector('.values-list-container');
            const addValueInput = row.querySelector('.add-value-input');

            // Done Button
            row.querySelector('.done-option-btn').addEventListener('click', () => {
                const name = nameInput.value.trim();
                const values = Array.from(valuesList.querySelectorAll('.variant-value-input'))
                                    .map(input => input.value.trim())
                                    .filter(val => val !== '');

                if (!name || values.length === 0) {
                    alert('Please enter an option name and at least one value.');
                    return;
                }

                row.querySelector('.summary-name').textContent = name;
                
                editView.classList.add('d-none');
                summaryView.classList.remove('d-none');
                summaryView.classList.add('d-flex');
                
                if (window.lucide) window.lucide.createIcons();
                generateVariantsTable();
            });

            // Edit Button
            row.querySelector('.edit-option-btn').addEventListener('click', () => {
                editView.classList.remove('d-none');
                summaryView.classList.add('d-none');
                summaryView.classList.remove('d-flex');
            });

            if (window.Sortable) {
                new Sortable(valuesList, {
                    handle: '.drag-handle-sub',
                    animation: 150,
                    ghostClass: 'sortable-ghost'
                });
            }

            addValueInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const val = this.value.trim();
                    if (val) {
                        addValueRow(val, valuesList);
                        this.value = '';
                    }
                }
            });

            row.querySelector('.remove-option-btn').addEventListener('click', () => {
                row.remove();
                checkEmptyVariants();
                generateVariantsTable();
            });
        }

        function addValueRow(text, container) {
            const valueRow = document.createElement('div');
            valueRow.className = 'value-item-row mb-8';
            valueRow.innerHTML = `
                <div class="drag-handle-sub">
                    <i data-lucide="grip-vertical" class="icon-xs text-muted"></i>
                </div>
                <input type="text" class="modal-field-input variant-value-input" value="${text}">
                <button type="button" class="btn-action-icon delete-btn">
                    <i data-lucide="trash-2"></i>
                </button>
            `;
            container.appendChild(valueRow);
            
            if (window.lucide) window.lucide.createIcons();

            valueRow.querySelector('.delete-btn').addEventListener('click', () => {
                valueRow.remove();
                generateVariantsTable();
            });

            valueRow.querySelector('.variant-value-input').addEventListener('input', generateVariantsTable);
        }

        function generateVariantsTable() {
            const optionRows = variantsContainer.querySelectorAll('.variant-option-card');
            const options = [];

            optionRows.forEach(row => {
                const name = row.querySelector('.modal-field-input').value.trim();
                const values = Array.from(row.querySelectorAll('.values-list-container .modal-field-input'))
                                    .map(input => input.value.trim())
                                    .filter(val => val !== '');
                
                if (name && values.length > 0) {
                    options.push(values);
                }
            });

            if (options.length === 0) {
                document.getElementById('variantsTableCard').style.display = 'none';
                return;
            }

            // Cartesian Product
            const combinations = options.reduce((a, b) => a.flatMap(d => b.map(e => [d, e].flat())));
            const finalCombinations = Array.isArray(combinations[0]) ? combinations : combinations.map(c => [c]);

            renderTable(finalCombinations);
        }

        function renderTable(combinations) {
            const tableCard = document.getElementById('variantsTableCard');
            const tableContainer = document.getElementById('variantsTableContainer');
            const countPlaceholder = document.getElementById('variantCountPlaceholder');
            const bulkPlaceholder = document.getElementById('bulkEditPlaceholder');
            tableCard.style.display = 'block';

            const groups = {};
            combinations.forEach(combo => {
                const parent = combo[0];
                if (!groups[parent]) groups[parent] = [];
                groups[parent].push(combo);
            });

            // Update Header
            countPlaceholder.textContent = `${combinations.length} variants`;
            bulkPlaceholder.innerHTML = `
                <div style="position: relative; display: none;" id="bulkEditContainer">
                    <button type="button" class="btn btn-outline btn-sm d-flex align-items-center gap-5" id="bulkEditBtn" style="border-radius: 6px; padding: 4px 10px; font-size: 13px;">
                        Bulk edit <i data-lucide="chevron-down" class="icon-xxs"></i>
                    </button>
                    <div class="dropdown-menu-custom" id="bulkEditDropdown" style="right: 0; left: auto; top: calc(100% + 5px);">
                        <div class="dropdown-item-custom" data-action="price">Edit prices</div>
                        <div class="dropdown-item-custom" data-action="quantity">Edit quantities</div>
                    </div>
                </div>
            `;

            let html = `
                <table class="variants-custom-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;"><input type="checkbox" class="form-check-input select-all-variants"></th>
                            <th>Variant</th>
                            <th style="width: 150px;">Price</th>
                            <th style="width: 120px;">Available</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            Object.keys(groups).forEach((parentValue, index) => {
                const subVariants = groups[parentValue];
                const groupId = `group-${index}`;
                
                if (subVariants[0].length > 1) {
                    html += `
                        <tr class="variant-parent-row" data-group-target="${groupId}" style="cursor: pointer;">
                            <td><input type="checkbox" class="form-check-input group-checkbox" data-group="${groupId}"></td>
                            <td>
                                <div>
                                    <div class="fs-14 fw-500">${parentValue}</div>
                                    <div class="text-muted-sm">${subVariants.length} variants <i data-lucide="chevron-down" class="icon-xxs chevron-toggle" style="transform: rotate(-90deg);"></i></div>
                                </div>
                            </td>
                            <td>
                                <div class="input-prefix-container">
                                    <span class="prefix">$</span>
                                    <input type="number" class="modal-field-input input-sm parent-price" placeholder="10.99" step="0.01">
                                </div>
                            </td>
                            <td>
                                <div class="inventory-badge-placeholder">20</div>
                            </td>
                        </tr>
                    `;

                        const basePrice = document.querySelector('input[name="price"]').value || '0.00';
                        const baseStock = document.querySelector('input[name="stock"]').value || '0';

                        subVariants.forEach(combo => {
                            const subName = combo.slice(1).join(' / ');
                            const fullVariantName = combo.join(' / ');
                            html += `
                                <tr class="variant-child-row ${groupId}" style="display: none;">
                                    <td style="padding-left: 30px;"><input type="checkbox" class="form-check-input variant-checkbox" data-group="${groupId}"></td>
                                    <td>
                                        <span class="fs-13">${subName}</span>
                                        <input type="hidden" name="variants[${index}][name]" value="${fullVariantName}">
                                    </td>
                                    <td>
                                        <div class="input-prefix-container">
                                            <span class="prefix">$</span>
                                            <input type="number" name="variants[${index}][price]" class="modal-field-input input-sm variant-price-input" value="${basePrice}" step="0.01">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" name="variants[${index}][stock]" class="modal-field-input input-sm variant-qty-input" value="${baseStock}">
                                    </td>
                                </tr>
                            `;
                        });
                } else {
                    const basePrice = document.querySelector('input[name="price"]').value || '0.00';
                    const baseStock = document.querySelector('input[name="stock"]').value || '0';

                    html += `
                        <tr>
                            <td><input type="checkbox" class="form-check-input variant-checkbox"></td>
                            <td>
                                <span class="fs-14">${parentValue}</span>
                                <input type="hidden" name="variants[${index}][name]" value="${parentValue}">
                            </td>
                            <td>
                                <div class="input-prefix-container">
                                    <span class="prefix">$</span>
                                    <input type="number" name="variants[${index}][price]" class="modal-field-input input-sm variant-price-input" value="${basePrice}" step="0.01">
                                </div>
                            </td>
                            <td>
                                <input type="number" name="variants[${index}][stock]" class="modal-field-input input-sm variant-qty-input" value="${baseStock}">
                            </td>
                        </tr>
                    `;
                }
            });

            html += `</tbody></table>`;
            tableContainer.innerHTML = html;
            if (window.lucide) window.lucide.createIcons();

            // Toggle logic
            tableContainer.querySelectorAll('.variant-parent-row').forEach(row => {
                row.addEventListener('click', function(e) {
                    if (e.target.tagName === 'INPUT') return;
                    const gid = this.getAttribute('data-group-target');
                    const children = tableContainer.querySelectorAll(`.${gid}`);
                    const chevron = this.querySelector('.chevron-toggle');
                    const isHidden = children[0].style.display === 'none';
                    children.forEach(c => c.style.display = isHidden ? 'table-row' : 'none');
                    if (chevron) chevron.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(-90deg)';
                });
            });

            // Select All logic
            const selectAll = tableContainer.querySelector('.select-all-variants');
            selectAll.addEventListener('change', function() {
                tableContainer.querySelectorAll('.form-check-input').forEach(cb => cb.checked = this.checked);
                updateBulkEditVisibility();
            });

            // Group Select logic
            tableContainer.querySelectorAll('.group-checkbox').forEach(gcb => {
                gcb.addEventListener('change', function() {
                    const gid = this.getAttribute('data-group');
                    tableContainer.querySelectorAll(`.${gid} .variant-checkbox`).forEach(vcb => vcb.checked = this.checked);
                    updateBulkEditVisibility();
                });
            });

            // Individual logic
            tableContainer.querySelectorAll('.variant-checkbox').forEach(vcb => {
                vcb.addEventListener('change', updateBulkEditVisibility);
            });

            function updateBulkEditVisibility() {
                const bulkEditContainer = document.getElementById('bulkEditContainer');
                const anyChecked = tableContainer.querySelectorAll('.variant-checkbox:checked').length > 0;
                bulkEditContainer.style.display = anyChecked ? 'block' : 'none';
            }

            // Bulk Edit Dropdown
            const bulkBtn = document.getElementById('bulkEditBtn');
            const bulkDropdown = document.getElementById('bulkEditDropdown');
            bulkBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                bulkDropdown.classList.toggle('show');
            });

            document.addEventListener('click', () => bulkDropdown.classList.remove('show'));

            // Bulk Edit Actions
            const modal = document.getElementById('bulkEditModal');
            bulkDropdown.querySelectorAll('.dropdown-item-custom').forEach(item => {
                item.addEventListener('click', function() {
                    const action = this.getAttribute('data-action');
                    const title = document.getElementById('bulkEditTitle');
                    const desc = document.getElementById('bulkEditDescription');
                    const prefix = document.getElementById('bulkInputPrefix');
                    const input = document.getElementById('bulkValueInput');

                    if (action === 'price') {
                        title.textContent = 'Edit prices';
                        desc.textContent = 'Apply a price to all selected variants';
                        prefix.style.display = 'block';
                        input.placeholder = '0.00';
                        input.setAttribute('step', '0.01');
                    } else {
                        title.textContent = 'Edit quantities';
                        desc.textContent = 'Apply a quantity to all selected variants';
                        prefix.style.display = 'none';
                        input.placeholder = '0';
                        input.setAttribute('step', '1');
                    }
                    modal.style.display = 'flex';
                    modal.setAttribute('data-action', action);
                });
            });
        }

        // Modal Close logic
        document.querySelectorAll('.close-modal-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('bulkEditModal').style.display = 'none';
            });
        });

        // Apply Bulk Edit logic
        document.getElementById('applyBulkEdit').addEventListener('click', () => {
            const modal = document.getElementById('bulkEditModal');
            const action = modal.getAttribute('data-action');
            const val = document.getElementById('bulkValueInput').value;
            const tableContainer = document.getElementById('variantsTableContainer');
            
            const selectedVariants = tableContainer.querySelectorAll('.variant-checkbox:checked');
            
            selectedVariants.forEach(cb => {
                const row = cb.closest('tr');
                if (action === 'price') {
                    row.querySelector('.variant-price-input').value = val;
                } else {
                    row.querySelector('.variant-qty-input').value = val;
                }
            });

            modal.style.display = 'none';
        });

        function checkEmptyVariants() {
            if (variantsContainer.children.length === 0) {
                addVariantBtn.style.display = 'block';
                variantsContainer.style.display = 'none';
                if (addAnotherOptionBtn) {
                    addAnotherOptionBtn.classList.add('d-none');
                    addAnotherOptionBtn.classList.remove('d-flex');
                }
                document.getElementById('variantsTableCard').style.display = 'none';
            }
        }

        // Collections & Tags Logic
        const allCollections = ['Best Sellers', 'New Arrivals', 'Summer Sale', 'Disposable Vapes', 'E-Liquids', 'Starter Kits', 'Pod Systems', 'Replacement Coils'];
        const selectedCollectionsArr = [];
        const selectedTagsArr = [];

        const colSearch = document.getElementById('collectionSearch');
        const colDropdown = document.getElementById('collectionDropdown');
        const colSelectedDiv = document.getElementById('selectedCollections');

        const tagInput = document.getElementById('tagInput');
        const tagSelectedDiv = document.getElementById('selectedTags');

        if (colSearch && colDropdown && colSelectedDiv) {
            colSearch.addEventListener('input', function() {
                const val = this.value.toLowerCase();
                if (!val) {
                    colDropdown.classList.remove('show');
                    return;
                }

                const matches = allCollections.filter(c => 
                    c.toLowerCase().includes(val) && !selectedCollectionsArr.includes(c)
                );

                if (matches.length > 0) {
                    colDropdown.innerHTML = matches.map(m => `<div class="dropdown-item-custom" data-value="${m}">${m}</div>`).join('');
                    colDropdown.classList.add('show');
                } else {
                    colDropdown.classList.remove('show');
                }
            });

            colDropdown.addEventListener('click', function(e) {
                if (e.target.classList.contains('dropdown-item-custom')) {
                    addCollection(e.target.getAttribute('data-value'));
                    colSearch.value = '';
                    colDropdown.classList.remove('show');
                }
            });
            
            document.addEventListener('click', function(e) {
                if (colSearch && !colSearch.contains(e.target) && !colDropdown.contains(e.target)) {
                    colDropdown.classList.remove('show');
                }
            });
        }
    }

    // Media Upload Logic
    const mediaUploadArea = document.getElementById('mediaUploadArea');
    const productMediaInput = document.getElementById('productMediaInput');
    const mediaPreviewGrid = document.getElementById('mediaPreviewGrid');
    const mediaPlaceholder = document.querySelector('.media-placeholder');
    let uploadedFiles = [];

    if (mediaUploadArea && productMediaInput) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            mediaUploadArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            mediaUploadArea.addEventListener(eventName, () => mediaUploadArea.classList.add('drag-over'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            mediaUploadArea.addEventListener(eventName, () => mediaUploadArea.classList.remove('drag-over'), false);
        });

        mediaUploadArea.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            handleFiles(files);
        }, false);

        productMediaInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        let mediaSortable = null;

        function handleFiles(files) {
            const filesArray = Array.from(files);
            
            // Read files and store their previews
            filesArray.forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    file.preview = e.target.result;
                    uploadedFiles.push(file);
                    renderMediaPreviews();
                };
                reader.readAsDataURL(file);
            });
        }

        function renderMediaPreviews() {
            if (uploadedFiles.length > 0) {
                mediaPlaceholder.style.display = 'none';
                mediaPreviewGrid.style.display = 'grid';
                mediaUploadArea.style.padding = '15px';
                mediaUploadArea.style.minHeight = 'auto';
                mediaUploadArea.style.borderStyle = 'solid';
                
                mediaPreviewGrid.innerHTML = '';
                
                uploadedFiles.forEach((file, index) => {
                    const mediaItem = document.createElement('div');
                    mediaItem.className = 'media-item';
                    mediaItem.setAttribute('data-id', index);
                    
                    mediaItem.innerHTML = `
                        <img src="${file.preview || ''}" alt="Preview">
                        ${index === 0 ? '<span class="badge-featured">Featured</span>' : ''}
                        <button class="btn-remove-media">
                            <i data-lucide="x"></i>
                        </button>
                    `;
                    
                    if (window.lucide) window.lucide.createIcons();

                    mediaItem.querySelector('.btn-remove-media').onclick = (ev) => {
                        ev.stopPropagation();
                        uploadedFiles.splice(index, 1);
                        renderMediaPreviews();
                    };
                    
                    mediaPreviewGrid.appendChild(mediaItem);
                });

                const addMore = document.createElement('div');
                addMore.className = 'add-more-media';
                addMore.innerHTML = `
                    <i data-lucide="plus-circle" class="text-muted" style="width: 20px; height: 20px;"></i>
                    <span class="fs-12 fw-500 text-muted mt-5">Add media</span>
                `;
                addMore.onclick = (ev) => {
                    ev.preventDefault();
                    productMediaInput.click();
                };
                mediaPreviewGrid.appendChild(addMore);

                if (window.lucide) window.lucide.createIcons();

                if (window.Sortable && !mediaSortable) {
                    mediaSortable = new Sortable(mediaPreviewGrid, {
                        animation: 150,
                        filter: '.add-more-media',
                        onEnd: function () {
                            const newOrder = [];
                            const items = mediaPreviewGrid.querySelectorAll('.media-item');
                            items.forEach(item => {
                                const oldIndex = parseInt(item.getAttribute('data-id'));
                                newOrder.push(uploadedFiles[oldIndex]);
                            });
                            uploadedFiles = newOrder;
                            renderMediaPreviews();
                        }
                    });
                }
            } else {
                mediaPlaceholder.style.display = 'block';
                mediaPreviewGrid.style.display = 'none';
                mediaUploadArea.style.padding = '30px';
                mediaUploadArea.style.minHeight = '200px';
                mediaUploadArea.style.borderStyle = 'dashed';
                if (mediaSortable) {
                    mediaSortable.destroy();
                    mediaSortable = null;
                }
            }
        }
    }
});
