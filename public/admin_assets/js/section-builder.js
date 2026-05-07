document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('sectionsContainer');
    const addBtn = document.getElementById('addSectionBtn');
    let sectionCount = document.querySelectorAll('.section-item-wrapper').length;

    if (addBtn) {
        addBtn.addEventListener('click', () => {
            showSectionPicker();
        });
    }

    // Initialize Drag & Drop sorting
    if (container) {
        new Sortable(container, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                console.log('Order updated');
            }
        });
    }

    function showSectionPicker() {
        Swal.fire({
            title: 'Select Section Type',
            input: 'select',
            inputOptions: {
                'bento_grid': 'Bento Grid (Masonry)',
                'smoke_section': 'Smoke Section (Expandable Story)',
                'faq': 'FAQ Section',
                'offer_section': 'What We Offer (Icon Cards)',
                'rich_text': 'Rich Text Editor',
                'product_embed': 'Product Embed (Add to Cart Card)'
            },
            inputPlaceholder: 'Choose a section type',
            showCancelButton: true,
            confirmButtonText: 'Add Section',
            confirmButtonColor: '#e16449'
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                addSection(result.value);
            }
        });
    }

    function addSection(type, data = null) {
        const id = sectionCount++;
        const sectionHtml = `
            <div class="section-item-wrapper card mb-15" data-id="${id}" data-type="${type}">
                <div class="section-item-header">
                    <div class="d-flex align-items-center gap-10">
                        <i data-lucide="move" class="icon-xs drag-handle cursor-move"></i>
                        <span class="badge badge-outline">${type.replace('_', ' ').toUpperCase()}</span>
                        <input type="hidden" name="sections[${id}][type]" value="${type}">
                        <input type="hidden" name="sections[${id}][id]" value="${data ? data.id : ''}">
                    </div>
                    <div class="section-actions">
                        <button type="button" class="btn-action-icon text-error remove-section-btn"><i data-lucide="trash-2"></i></button>
                    </div>
                </div>
                <div class="section-item-body">
                    ${getFieldsForType(type, id, data)}
                </div>
            </div>
        `;

        const placeholder = container.querySelector('.empty-sections-placeholder');
        if (placeholder) placeholder.remove();

        container.insertAdjacentHTML('beforeend', sectionHtml);
        if (window.lucide) window.lucide.createIcons();
        
        // Initialize RTE if needed
        if (type === 'rich_text') {
            initRTE(id);
        }

        // Initialize Product Search if needed
        if (type === 'product_embed') {
            initProductSearch(id);
        }

        // Add item button logic
        const addSubItemBtn = container.querySelector(`[data-id="${id}"] .add-sub-item-btn`);
        if (addSubItemBtn) {
            addSubItemBtn.addEventListener('click', () => {
                addSectionItem(type, id);
            });
        }

        // Remove section logic
        container.querySelector(`[data-id="${id}"] .remove-section-btn`).addEventListener('click', function() {
            this.closest('.section-item-wrapper').remove();
            if (container.querySelectorAll('.section-item-wrapper').length === 0) {
                container.innerHTML = '<div class="empty-sections-placeholder"><i data-lucide="layout" class="icon-lg text-muted opacity-2"></i><p>No sections added yet. Click "Add Section" to start building.</p></div>';
                if (window.lucide) window.lucide.createIcons();
            }
        });
    }

    function getFieldsForType(type, sectionId, data) {
        let content = '';
        if (type === 'smoke_section') {
            content = `
                <div class="form-group">
                    <label>Main Title</label>
                    <input type="text" name="sections[${sectionId}][items][0][title]" class="modal-field-input" value="${data ? (data.items[0]?.title || '') : ''}" placeholder="e.g. Explore Our Premium Collections">
                </div>
                <div class="form-group mb-0">
                    <label>Story Content (Expandable)</label>
                    <textarea name="sections[${sectionId}][items][0][content]" class="modal-field-input" rows="5" placeholder="Detailed story content...">${data ? (data.items[0]?.content || '') : ''}</textarea>
                </div>
            `;
        } else if (type === 'bento_grid' || type === 'faq' || type === 'offer_section') {
            const itemLabel = type === 'faq' ? 'FAQ Item' : 'Grid Item';
            content = `
                <div class="items-list-container" id="itemsList_${sectionId}">
                </div>
                <button type="button" class="btn btn-outline btn-sm mt-10 add-sub-item-btn">
                    <i data-lucide="plus" class="icon-xs"></i> Add ${itemLabel}
                </button>
            `;
            
            if (data && data.items) {
                setTimeout(() => {
                    data.items.forEach(item => addSectionItem(type, sectionId, item));
                }, 0);
            }
        } else if (type === 'rich_text') {
            const richContent = data ? (data.items[0]?.content || '') : '';
            content = `
                <div class="form-group mb-10">
                    <label class="fs-12 fw-600">Section Title (Optional)</label>
                    <input type="text" name="sections[${sectionId}][items][0][title]" class="modal-field-input" value="${data ? (data.items[0]?.title || '') : ''}" placeholder="e.g. Our Philosophy">
                </div>
                <div class="form-group mb-0">
                    <label class="fs-12 fw-600">Rich Content</label>
                    <div class="rte-toolbar" data-id="${sectionId}">
                        <button type="button" data-command="bold" title="Bold"><i data-lucide="bold"></i></button>
                        <button type="button" data-command="italic" title="Italic"><i data-lucide="italic"></i></button>
                        <button type="button" data-command="underline" title="Underline"><i data-lucide="underline"></i></button>
                        <button type="button" data-command="insertUnorderedList" title="Bullet List"><i data-lucide="list"></i></button>
                        <button type="button" data-command="insertOrderedList" title="Numbered List"><i data-lucide="list-ordered"></i></button>
                        <button type="button" data-command="createLink" title="Insert Link"><i data-lucide="link"></i></button>
                        <button type="button" data-command="formatBlock" data-value="h2" title="Heading 2"><i data-lucide="heading-2"></i></button>
                        <button type="button" data-command="formatBlock" data-value="h3" title="Heading 3"><i data-lucide="heading-3"></i></button>
                        <button type="button" data-command="removeFormat" title="Clear Formatting"><i data-lucide="remove-formatting"></i></button>
                    </div>
                    <div class="rte-editor-content modal-field-input" id="rte_${sectionId}" contenteditable="true" style="min-height: 200px; padding: 15px; border-top: none; border-top-left-radius: 0; border-top-right-radius: 0;">${richContent}</div>
                    <input type="hidden" name="sections[${sectionId}][items][0][content]" id="rte_input_${sectionId}" value='${richContent}'>
                </div>
            `;
        } else if (type === 'product_embed') {
            const item = data?.items?.[0];
            const productTitle = item?.title || '';
            const productId = item?.entity_id || '';
            const productImage = item?.image_url || '';
            const hasProduct = !!productId;

            content = `
                <div class="product-embed-manager" data-id="${sectionId}">
                    <div class="form-group mb-15" style="position: relative;">
                        <label class="fs-12 fw-600">Embed Product</label>
                        <div class="input-with-icon">
                            <input type="text" class="modal-field-input product-search-input" placeholder="Search by name or SKU...">
                            <i data-lucide="search"></i>
                        </div>
                        <div class="product-search-results" style="display:none;"></div>
                    </div>
                    
                    <div class="selected-product-preview ${hasProduct ? 'has-product' : 'placeholder-empty p-30'}">
                        ${hasProduct ? `
                            <div class="d-flex align-items-center">
                                <div class="product-preview-image-box" style="margin-right: 25px;">
                                    <img src="${getImageUrl(productImage)}" alt="Preview">
                                </div>
                                <div class="flex-grow-1 min-width-0" style="padding-left: 15px;">
                                    <h4 class="m-0 fs-16 res-title text-truncate">${productTitle}</h4>
                                    <p class="m-0 fs-12 text-muted mt-5">Price: $${item?.price || '0.00'}</p>
                                </div>
                                <button type="button" class="btn-remove-product flex-shrink-0" title="Remove Product">
                                    <i data-lucide="x" class="icon-xs"></i>
                                </button>
                                <input type="hidden" name="sections[${sectionId}][items][0][title]" class="product-title-hidden" value="${productTitle}">
                                <input type="hidden" name="sections[${sectionId}][items][0][entity_id]" class="product-id-hidden" value="${productId}">
                                <input type="hidden" name="sections[${sectionId}][items][0][entity_type]" value="product">
                                <input type="hidden" name="sections[${sectionId}][items][0][image_url]" class="product-image-hidden" value="${productImage}">
                                <input type="hidden" name="sections[${sectionId}][items][0][price]" class="product-price-hidden" value="${item?.price || ''}">
                            </div>
                        ` : `
                            <div class="empty-preview-content">
                                <div class="empty-icon-circle">
                                    <i data-lucide="shopping-bag" class="icon-md text-muted"></i>
                                </div>
                                <p class="m-0 fs-13 fw-500">No product selected yet</p>
                                <p class="m-0 fs-11 text-muted mt-5">Search and select a product to embed it here.</p>
                                <input type="hidden" name="sections[${sectionId}][items][0][title]" class="product-title-hidden" value="">
                                <input type="hidden" name="sections[${sectionId}][items][0][entity_id]" class="product-id-hidden" value="">
                                <input type="hidden" name="sections[${sectionId}][items][0][entity_type]" value="product">
                                <input type="hidden" name="sections[${sectionId}][items][0][image_url]" class="product-image-hidden" value="">
                            </div>
                        `}
                    </div>
                </div>
            `;
        }
        return content;
    }

    function initRTE(id) {
        const editor = document.getElementById(`rte_${id}`);
        const hiddenInput = document.getElementById(`rte_input_${id}`);
        const toolbar = document.querySelector(`.rte-toolbar[data-id="${id}"]`);

        if (!editor || !toolbar) return;

        toolbar.querySelectorAll('button').forEach(btn => {
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
                            updateInput();
                        }
                    });
                } else {
                    document.execCommand(command, false, value);
                }
                editor.focus();
                updateInput();
            });
        });

        editor.addEventListener('input', updateInput);
        editor.addEventListener('blur', updateInput);

        function updateInput() {
            hiddenInput.value = editor.innerHTML;
        }
    }

    function getImageUrl(path) {
        if (!path || path === '') return window.BASE_URL + '/admin_assets/image/placeholder.png';
        if (path.startsWith('http')) return path;
        
        // Remove leading slash if exists
        let cleanPath = path.trim();
        if (cleanPath.startsWith('/')) cleanPath = cleanPath.substring(1);
        
        // If BASE_URL already exists in cleanPath, don't add it again
        const baseUrlPath = new URL(window.BASE_URL).pathname;
        if (cleanPath.startsWith(baseUrlPath.substring(1))) {
            return window.BASE_URL + '/' + cleanPath.substring(baseUrlPath.length - (baseUrlPath.endsWith('/') ? 1 : 0));
        }

        return window.BASE_URL + '/' + cleanPath;
    }

    function initProductSearch(sectionId) {
        const wrapper = document.querySelector(`.product-embed-manager[data-id="${sectionId}"]`);
        if (!wrapper) return;

        const input = wrapper.querySelector('.product-search-input');
        const resultsBox = wrapper.querySelector('.product-search-results');
        const previewContainer = wrapper.querySelector('.selected-product-preview');
        
        let timeout = null;

        input.addEventListener('input', () => {
            clearTimeout(timeout);
            const query = input.value.trim();
            if (query.length < 2) {
                resultsBox.style.display = 'none';
                return;
            }

            timeout = setTimeout(() => {
                fetch(`${window.BASE_URL}/admin/menus/search?type=product&q=${query}`)
                    .then(res => res.json())
                    .then(data => {
                        resultsBox.innerHTML = '';
                        if (data.length === 0) {
                            resultsBox.innerHTML = '<div class="p-15 fs-12 text-muted text-center">No products found</div>';
                        } else {
                            data.forEach(item => {
                                const imagePath = getImageUrl(item.featured_image);
                                const div = document.createElement('div');
                                div.className = 'search-result-item cursor-pointer';
                                div.innerHTML = `
                                    <img src="${imagePath}" class="search-result-image" alt="Product">
                                    <div class="search-result-info flex-grow-1">
                                        <div class="res-title">${item.title}</div>
                                        <div class="res-price">$${item.price || '0.00'}</div>
                                    </div>
                                    <i data-lucide="plus-circle" class="icon-xs icon-add"></i>
                                `;
                                div.addEventListener('click', () => {
                                    selectProduct(sectionId, item);
                                    resultsBox.style.display = 'none';
                                    input.value = '';
                                });
                                resultsBox.appendChild(div);
                            });
                            if (window.lucide) window.lucide.createIcons();
                        }
                        resultsBox.style.display = 'block';
                    });
            }, 300);
        });

        // Delegate remove button click
        previewContainer.addEventListener('click', (e) => {
            if (e.target.closest('.btn-remove-product')) {
                removeProduct(sectionId);
            }
        });

        document.addEventListener('click', (e) => {
            if (!wrapper.contains(e.target)) resultsBox.style.display = 'none';
        });
    }

    function selectProduct(sectionId, item) {
        const wrapper = document.querySelector(`.product-embed-manager[data-id="${sectionId}"]`);
        const previewContainer = wrapper.querySelector('.selected-product-preview');
        const imagePath = getImageUrl(item.featured_image);
        const imageValue = item.featured_image || '';

        previewContainer.className = 'selected-product-preview has-product';
        previewContainer.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="product-preview-image-box" style="margin-right: 15px;">
                    <img src="${imagePath}" alt="Preview">
                </div>
                <div class="flex-grow-1 min-width-0" style="padding-left: 15px;">
                    <h4 class="m-0 fs-16 res-title text-truncate">${item.title}</h4>
                    <p class="m-0 fs-12 text-muted mt-5">Price: $${item.price || '0.00'}</p>
                </div>
                <button type="button" class="btn-remove-product flex-shrink-0" title="Remove Product">
                    <i data-lucide="x" class="icon-xs"></i>
                </button>
                <input type="hidden" name="sections[${sectionId}][items][0][title]" class="product-title-hidden" value="${item.title}">
                <input type="hidden" name="sections[${sectionId}][items][0][entity_id]" class="product-id-hidden" value="${item.id}">
                <input type="hidden" name="sections[${sectionId}][items][0][entity_type]" value="product">
                <input type="hidden" name="sections[${sectionId}][items][0][image_url]" class="product-image-hidden" value="${imageValue}">
                <input type="hidden" name="sections[${sectionId}][items][0][price]" class="product-price-hidden" value="${item.price || ''}">
            </div>
        `;
        if (window.lucide) window.lucide.createIcons();
    }

    function removeProduct(sectionId) {
        const wrapper = document.querySelector(`.product-embed-manager[data-id="${sectionId}"]`);
        const previewContainer = wrapper.querySelector('.selected-product-preview');
        
        previewContainer.className = 'selected-product-preview placeholder-empty p-30';
        previewContainer.innerHTML = `
            <div class="empty-preview-content">
                <div class="empty-icon-circle">
                    <i data-lucide="shopping-bag" class="icon-md text-muted"></i>
                </div>
                <p class="m-0 fs-13 fw-500">No product selected yet</p>
                <p class="m-0 fs-11 text-muted mt-5">Search and select a product to embed it here.</p>
                <input type="hidden" name="sections[${sectionId}][items][0][title]" class="product-title-hidden" value="">
                <input type="hidden" name="sections[${sectionId}][items][0][entity_id]" class="product-id-hidden" value="">
                <input type="hidden" name="sections[${sectionId}][items][0][entity_type]" value="product">
                <input type="hidden" name="sections[${sectionId}][items][0][image_url]" class="product-image-hidden" value="">
                <input type="hidden" name="sections[${sectionId}][items][0][price]" class="product-price-hidden" value="">
            </div>
        `;
        if (window.lucide) window.lucide.createIcons();
    }

    function addSectionItem(type, sectionId, data = null) {
        const list = document.getElementById(`itemsList_${sectionId}`);
        const itemId = list.querySelectorAll('.sub-item-row').length;
        let itemHtml = '';

        if (type === 'faq') {
            itemHtml = `
                <div class="sub-item-row">
                    <input type="hidden" name="sections[${sectionId}][items][${itemId}][id]" value="${data ? data.id : ''}">
                    <div class="form-group mb-0">
                        <input type="text" name="sections[${sectionId}][items][${itemId}][title]" class="modal-field-input mb-10 fw-600" value="${data ? data.title : ''}" placeholder="Question">
                        <textarea name="sections[${sectionId}][items][${itemId}][content]" class="modal-field-input" rows="2" placeholder="Answer...">${data ? data.content : ''}</textarea>
                    </div>
                    <button type="button" class="btn-remove-subitem" title="Remove Item"><i data-lucide="x"></i></button>
                </div>
            `;
        } else if (type === 'bento_grid') {
            itemHtml = `
                <div class="sub-item-row">
                    <input type="hidden" name="sections[${sectionId}][items][${itemId}][id]" value="${data ? data.id : ''}">
                    <div class="grid-item-inputs" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group mb-10">
                            <label class="fs-12 fw-600">Title</label>
                            <input type="text" name="sections[${sectionId}][items][${itemId}][title]" class="modal-field-input" value="${data ? data.title : ''}" placeholder="Title">
                        </div>
                        <div class="form-group mb-10">
                            <label class="fs-12 fw-600">Background Image URL</label>
                            <input type="text" name="sections[${sectionId}][items][${itemId}][image_url]" class="modal-field-input" value="${data ? data.image_url : ''}" placeholder="URL">
                        </div>
                        <div class="form-group mb-0" style="grid-column: span 2;">
                            <textarea name="sections[${sectionId}][items][${itemId}][content]" class="modal-field-input" rows="2" placeholder="Content...">${data ? data.content : ''}</textarea>
                        </div>
                    </div>
                    <button type="button" class="btn-remove-subitem" title="Remove Item"><i data-lucide="x"></i></button>
                </div>
            `;
        } else if (type === 'offer_section') {
            itemHtml = `
                <div class="sub-item-row">
                    <input type="hidden" name="sections[${sectionId}][items][${itemId}][id]" value="${data ? data.id : ''}">
                    <div class="form-group mb-10">
                        <input type="text" name="sections[${sectionId}][items][${itemId}][image_url]" class="modal-field-input" value="${data ? data.image_url : ''}" placeholder="Icon name">
                        <input type="text" name="sections[${sectionId}][items][${itemId}][title]" class="modal-field-input fw-600 mt-10" value="${data ? data.title : ''}" placeholder="Title">
                        <textarea name="sections[${sectionId}][items][${itemId}][content]" class="modal-field-input mt-10" rows="2" placeholder="Description...">${data ? data.content : ''}</textarea>
                    </div>
                    <button type="button" class="btn-remove-subitem" title="Remove Item"><i data-lucide="x"></i></button>
                </div>
            `;
        }

        list.insertAdjacentHTML('beforeend', itemHtml);
        if (window.lucide) window.lucide.createIcons();

        list.lastElementChild.querySelector('.btn-remove-subitem').addEventListener('click', function() {
            this.closest('.sub-item-row').remove();
        });
    }

    // Load existing sections if any
    const existingSections = window.initialSectionsData || [];
    existingSections.forEach(sec => addSection(sec.type, sec));
});
