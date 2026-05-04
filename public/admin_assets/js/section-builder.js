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
            handle: '.drag-handle', // Only allow dragging from the move icon
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                // Optional: We can update some hidden index fields if needed, 
                // but standard form submission will follow the new DOM order anyway.
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
                'rich_text': 'Simple Rich Text'
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
            if (container.children.length === 0) {
                container.innerHTML = '<div class="empty-sections-placeholder">...</div>';
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
                    <!-- Items go here -->
                </div>
                <button type="button" class="btn btn-outline btn-sm mt-10 add-sub-item-btn">
                    <i data-lucide="plus" class="icon-xs"></i> Add ${itemLabel}
                </button>
            `;
            
            // If we have existing data, render it
            if (data && data.items) {
                setTimeout(() => {
                    data.items.forEach(item => addSectionItem(type, sectionId, item));
                }, 0);
            }
        } else if (type === 'rich_text') {
            content = `
                <div class="form-group mb-10">
                    <label class="fs-12 fw-600">Section Title (Optional)</label>
                    <input type="text" name="sections[${sectionId}][items][0][title]" class="modal-field-input" value="${data ? (data.items[0]?.title || '') : ''}" placeholder="e.g. Our Philosophy">
                </div>
                <div class="form-group mb-0">
                    <label class="fs-12 fw-600">Rich Content</label>
                    <textarea name="sections[${sectionId}][items][0][content]" class="modal-field-input" rows="6" placeholder="Write your content here...">${data ? (data.items[0]?.content || '') : ''}</textarea>
                </div>
            `;
        } else {
            content = `<p class="text-muted">Fields for ${type} coming soon...</p>`;
        }
        return content;
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
                        <input type="text" name="sections[${sectionId}][items][${itemId}][title]" class="modal-field-input mb-10 fw-600" value="${data ? data.title : ''}" placeholder="Question (e.g. What is the minimum age?)">
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
                            <input type="text" name="sections[${sectionId}][items][${itemId}][title]" class="modal-field-input" value="${data ? data.title : ''}" placeholder="e.g. High-Power Box Mods">
                        </div>
                        <div class="form-group mb-10">
                            <label class="fs-12 fw-600">Background Image URL</label>
                            <input type="text" name="sections[${sectionId}][items][${itemId}][image_url]" class="modal-field-input" value="${data ? data.image_url : ''}" placeholder="assets/product/img.jpg">
                        </div>
                        <div class="form-group mb-10">
                            <label class="fs-12 fw-600">Label (Badge Text)</label>
                            <input type="text" name="sections[${sectionId}][items][${itemId}][button_text]" class="modal-field-input" value="${data ? data.button_text : ''}" placeholder="e.g. Advanced">
                        </div>
                        <div class="form-group mb-10">
                            <label class="fs-12 fw-600">Grid Size (Span)</label>
                            <select name="sections[${sectionId}][items][${itemId}][sort_order]" class="modal-field-input">
                                <option value="1" ${data && data.sort_order == 1 ? 'selected' : ''}>Small (1x1)</option>
                                <option value="2" ${data && data.sort_order == 2 ? 'selected' : ''}>Big (2x2)</option>
                                <option value="3" ${data && data.sort_order == 3 ? 'selected' : ''}>Wide (2x1)</option>
                            </select>
                        </div>
                        <div class="form-group mb-0" style="grid-column: span 2;">
                            <label class="fs-12 fw-600">Description / Content</label>
                            <textarea name="sections[${sectionId}][items][${itemId}][content]" class="modal-field-input" rows="3" placeholder="Describe this bento item...">${data ? data.content : ''}</textarea>
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
                        <label class="fs-12">Icon Name (Lucide)</label>
                        <input type="text" name="sections[${sectionId}][items][${itemId}][image_url]" class="modal-field-input" value="${data ? data.image_url : ''}" placeholder="box, zap, truck, etc.">
                    </div>
                    <div class="form-group mb-10">
                        <label class="fs-12">Title</label>
                        <input type="text" name="sections[${sectionId}][items][${itemId}][title]" class="modal-field-input fw-600" value="${data ? data.title : ''}" placeholder="Service Title">
                    </div>
                    <div class="form-group mb-0">
                        <label class="fs-12">Description</label>
                        <textarea name="sections[${sectionId}][items][${itemId}][content]" class="modal-field-input" rows="2" placeholder="Brief description...">${data ? data.content : ''}</textarea>
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
