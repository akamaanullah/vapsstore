(function() {
    let activeSectionId = null;
    let selectedProducts = [];
    let allProducts = [];

    // --- Helper Functions ---
    
    function syncCurrentItems() {
        if (!activeSectionId) return;
        const rows = document.querySelectorAll('.section-item-row');
        const section = window.homepageSections.find(s => s.id == activeSectionId);
        if (!section) return;

        // Sync Title and Section Buttons
        const titleInput = document.getElementById('sectionTitleInput');
        if (titleInput) section.title = titleInput.value;

        const btnTextInput = document.getElementById('sectionButtonTextInput');
        if (btnTextInput) section.button_text = btnTextInput.value;

        const btnUrlInput = document.getElementById('sectionButtonUrlInput');
        if (btnUrlInput) section.button_url = btnUrlInput.value;

        section.items = Array.from(rows).map(row => {
            const idx = parseInt(row.dataset.index);
            return {
                id: section.items[idx]?.id || null,
                entity_id: row.dataset.entityId || null,
                entity_type: row.dataset.entityType || null,
                title: row.querySelector('.item-title')?.value,
                content: row.querySelector('.item-content')?.value,
                image_url: row.querySelector('.item-image')?.value,
                button_text: row.querySelector('.item-btn-text')?.value,
                button_url: row.querySelector('.item-url')?.value
            };
        });
    }

    function createItemRow(type, item, index) {
        const div = document.createElement('div');
        div.className = 'section-item-row';
        div.dataset.index = index;
        if (item.entity_id) {
            div.dataset.entityId = item.entity_id;
            div.dataset.entityType = item.entity_type;
        }

        let fields = '';
        if (type !== 'collection_grid') {
            fields += `
                <div class="remove-item" onclick="removeSectionItem(${index})"><i data-lucide="trash-2"></i></div>
            `;
        }

        if (type === 'collection_grid') {
            fields += `
                <div class="selected-product-row" style="display: flex; gap: 15px; align-items: center; padding: 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 8px;">
                    <img src="${item.image_url ? (item.image_url.startsWith('http') ? item.image_url : window.adminBaseUrl + '/public/' + item.image_url) : 'https://placehold.co/50x50?text=P'}" style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover;">
                    <div style="flex: 1;">
                        <div style="font-weight: 600; font-size: 0.875rem; color: #1e293b;">${item.title || 'Product Name'}</div>
                        <div style="font-size: 0.75rem; color: #64748b;">ID: ${item.entity_id}</div>
                    </div>
                    <input type="hidden" class="item-title" value="${item.title || ''}">
                    <input type="hidden" class="item-image" value="${item.image_url || ''}">
                    <input type="hidden" class="item-url" value="${item.button_url || ''}">
                    <div class="remove-item-inline" onclick="removeSectionItem(${index})" style="cursor: pointer; color: #ef4444;"><i data-lucide="x"></i></div>
                </div>
            `;
        } else {
            fields += `
                <div class="form-group mb-10">
                    <label>Title</label>
                    <input type="text" class="modal-field-input item-title" value="${item.title || ''}">
                </div>
                <div class="form-group mb-10">
                    <label>Content</label>
                    <textarea class="modal-field-input item-content" style="height: 80px;">${item.content || ''}</textarea>
                </div>
                <div class="form-group-row">
                    <div class="form-group">
                        <label>Image URL</label>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <img src="${item.image_url || ''}" style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover; background: #eee; border: 1px solid #ddd;" onerror="this.src='https://placehold.co/40x40?text=No+Img'">
                            <input type="text" class="modal-field-input item-image" value="${item.image_url || ''}" oninput="this.previousElementSibling.src=this.value || 'https://placehold.co/40x40?text=No+Img'">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Link/URL</label>
                        <input type="text" class="modal-field-input item-url" value="${item.button_url || ''}">
                    </div>
                </div>
            `;
            if (['hero_slider', 'feature_highlight'].includes(type)) {
                fields += `
                    <div class="form-group mb-10">
                        <label>Button Text</label>
                        <input type="text" class="modal-field-input item-btn-text" value="${item.button_text || ''}">
                    </div>
                `;
            }
        }

        div.innerHTML = fields;
        return div;
    }

    // --- Product Picker Logic ---

    async function fetchProducts(query = '', collectionId = '') {
        try {
            let url = window.adminBaseUrl + '/admin/products/api/search?q=' + encodeURIComponent(query);
            if (collectionId) {
                url = window.adminBaseUrl + '/admin/products/api/by-collection?collection_id=' + collectionId;
            }
            const response = await fetch(url);
            return await response.json();
        } catch (e) {
            console.error('Fetch error:', e);
            return [];
        }
    }

    function renderPickerResults(products) {
        const grid = document.getElementById('pickerResults');
        if (!products || products.length === 0) {
            grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #64748b;">No products found.</div>';
            return;
        }
        grid.innerHTML = products.map(p => {
            const isSelected = selectedProducts.some(sp => sp.id == p.id);
            return `
                <div class="picker-product-card ${isSelected ? 'selected' : ''}" onclick="toggleProductSelection(${p.id}, '${p.name.replace(/'/g, "\\'")}', '${p.featured_image || ''}')">
                    <img src="${p.featured_image ? window.adminBaseUrl + '/public/' + p.featured_image : 'https://placehold.co/100x100?text=No+Img'}">
                    <h4>${p.name}</h4>
                </div>
            `;
        }).join('');
    }

    function renderSelectedItems() {
        const container = document.getElementById('selectedItems');
        const countSpan = document.getElementById('selectedCount');
        countSpan.innerText = selectedProducts.length;
        
        container.innerHTML = selectedProducts.map(p => `
            <div class="selected-item-row">
                <img src="${p.image ? window.adminBaseUrl + '/public/' + p.image : 'https://placehold.co/32x32?text=P'}">
                <span style="flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${p.name}</span>
                <i data-lucide="x" class="remove-selected" onclick="toggleProductSelection(${p.id})"></i>
            </div>
        `).join('');
        if (window.lucide) window.lucide.createIcons();
    }

    window.toggleProductSelection = function(id, name, image) {
        const idx = selectedProducts.findIndex(p => p.id == id);
        if (idx > -1) {
            selectedProducts.splice(idx, 1);
        } else {
            selectedProducts.push({ id, name, image });
        }
        renderSelectedItems();
        // Update grid state if visible
        const cards = document.querySelectorAll('.picker-product-card');
        cards.forEach(card => {
            // Check if card matches ID (bit more robust)
            if (card.getAttribute('onclick').includes(`(${id},`)) {
                card.classList.toggle('selected', idx === -1);
            }
        });
    };

    window.openProductPicker = function() {
        syncCurrentItems(); // Save current title/buttons before switching to picker
        const section = window.homepageSections.find(s => s.id == activeSectionId);
        
        selectedProducts = section.items
            .filter(item => item.entity_type === 'product')
            .map(item => {
                // Strip base URL if present to keep it relative
                let relativeImage = item.image_url || '';
                const searchStr = window.adminBaseUrl + '/public/';
                if (relativeImage.includes(searchStr)) {
                    relativeImage = relativeImage.replace(searchStr, '');
                }
                return { id: item.entity_id, name: item.title, image: relativeImage };
            });
        
        renderSelectedItems();
        document.getElementById('productPicker').style.display = 'block';
        document.getElementById('sectionModal').style.display = 'none'; 
        
        // Reset filters
        document.getElementById('productSearch').value = '';
        document.getElementById('collectionFilter').value = '';
        
        // Initial load
        performSearch('', '');
    };

    async function performSearch(q, colId = '') {
        const grid = document.getElementById('pickerResults');
        grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px;"><i data-lucide="loader" class="spin"></i> Loading...</div>';
        if (window.lucide) window.lucide.createIcons();

        allProducts = await fetchProducts(q, colId);
        renderPickerResults(allProducts);
    }

    // Export to window
    window.editSection = function(id) {
        activeSectionId = id;
        const section = window.homepageSections.find(s => s.id == id);
        if (!section) return;

        document.getElementById('modalTitle').innerText = 'Manage ' + section.type.replace('_', ' ').toUpperCase();
        
        // Show/Hide Section Heading and Buttons based on type
        const titleGroup = document.getElementById('sectionTitleGroup');
        const buttonGroup = document.getElementById('sectionButtonGroup');
        
        // Brand Story and Feature Highlight use item titles, so global heading is confusing
        const needsGlobalHeading = ['collection_grid', 'promo_grid'].includes(section.type);
        const needsGlobalButtons = ['collection_grid'].includes(section.type);
        
        if (titleGroup) titleGroup.style.display = needsGlobalHeading ? 'block' : 'none';
        if (buttonGroup) buttonGroup.style.display = needsGlobalButtons ? 'flex' : 'none';

        // Set Section Title & Buttons
        const titleInput = document.getElementById('sectionTitleInput');
        if (titleInput) titleInput.value = section.title || '';

        const btnTextInput = document.getElementById('sectionButtonTextInput');
        if (btnTextInput) btnTextInput.value = section.button_text || '';

        const btnUrlInput = document.getElementById('sectionButtonUrlInput');
        if (btnUrlInput) btnUrlInput.value = section.button_url || '';

        const container = document.getElementById('itemsContainer');
        container.innerHTML = '';

        const isCollection = section.type === 'collection_grid';
        document.getElementById('addItemBtn').style.display = isCollection ? 'none' : 'block';
        
        // Add "Manage Products" button for collections
        let manageBtn = document.getElementById('manageProductsBtn');
        if (isCollection) {
            if (!manageBtn) {
                manageBtn = document.createElement('button');
                manageBtn.id = 'manageProductsBtn';
                manageBtn.className = 'btn btn-primary mb-20'; 
                manageBtn.style.width = '100%';
                manageBtn.style.background = '#6366f1'; // Premium Indigo
                manageBtn.style.padding = '12px';
                manageBtn.innerHTML = '<i data-lucide="plus-circle"></i> <span style="margin-left: 8px;">Select Products to Display</span>';
                container.before(manageBtn);
                manageBtn.onclick = openProductPicker;
            }
            manageBtn.style.display = 'block';
        } else if (manageBtn) {
            manageBtn.style.display = 'none';
        }

        section.items.forEach((item, index) => {
            container.appendChild(createItemRow(section.type, item, index));
        });

        document.getElementById('sectionModal').style.display = 'flex';
        if (window.lucide) window.lucide.createIcons();
    };

    window.removeSectionItem = function(index) {
        syncCurrentItems();
        const section = window.homepageSections.find(s => s.id == activeSectionId);
        section.items.splice(index, 1);
        window.editSection(activeSectionId);
    };

    window.closeSectionModal = function() {
        document.getElementById('sectionModal').style.display = 'none';
        document.getElementById('sectionModal').style.opacity = '1';
        document.getElementById('sectionModal').style.pointerEvents = 'auto';
        activeSectionId = null;
    };

    window.deleteSection = function(id) {
        window.Swal.fire({
            title: 'Are you sure?',
            text: "This section will be removed from your homepage layout.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const idx = window.homepageSections.findIndex(s => s.id == id);
                if (idx > -1) {
                    window.homepageSections.splice(idx, 1);
                    const card = document.querySelector(`.section-card[data-id="${id}"]`);
                    if (card) card.remove();
                    
                    window.Swal.fire({
                        title: 'Removed!',
                        text: 'Section has been removed from the layout.',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            }
        });
    };

    window.moveSection = function(id, direction) {
        const idx = window.homepageSections.findIndex(s => s.id == id);
        if (idx === -1) return;

        const newIdx = direction === 'up' ? idx - 1 : idx + 1;
        if (newIdx < 0 || newIdx >= window.homepageSections.length) return;

        // Swap in array
        const temp = window.homepageSections[idx];
        window.homepageSections[idx] = window.homepageSections[newIdx];
        window.homepageSections[newIdx] = temp;

        // Re-render the grid to show new order
        renderSectionsGrid();
    };

    function renderSectionsGrid() {
        const grid = document.querySelector('.homepage-sections-grid');
        grid.innerHTML = ''; // Clear and re-render all for consistency
        
        window.homepageSections.forEach(section => {
            const sectionIcons = {
                'hero_slider': 'image',
                'promo_grid': 'layout',
                'feature_highlight': 'star',
                'brand_story': 'book-open',
                'collection_grid': 'layers'
            };
            const sectionNames = {
                'hero_slider': 'Hero Slider',
                'promo_grid': 'Promo Banners',
                'feature_highlight': 'Feature Highlight',
                'brand_story': 'Brand Story',
                'collection_grid': 'Collection Showcase'
            };

            const icon = sectionIcons[section.type] || 'box';
            const name = section.title || sectionNames[section.type] || section.type;
            const card = document.createElement('div');
            card.className = 'section-card';
            card.dataset.id = section.id;
            card.dataset.type = section.type;
            card.innerHTML = `
                <div class="section-card-header">
                    <div class="section-icon">
                        <i data-lucide="${icon}"></i>
                    </div>
                    <div class="section-info">
                        <h3>${name}</h3>
                        <span class="badge badge-outline">${section.items.length} Items</span>
                    </div>
                    <div class="section-card-controls">
                        <button class="control-btn" onclick="moveSection(${section.id}, 'up')" title="Move Up"><i data-lucide="chevron-up"></i></button>
                        <button class="control-btn" onclick="moveSection(${section.id}, 'down')" title="Move Down"><i data-lucide="chevron-down"></i></button>
                        <button class="control-btn delete" onclick="deleteSection(${section.id})" title="Delete Section"><i data-lucide="trash-2"></i></button>
                    </div>
                </div>
                <div class="section-card-actions">
                    <button class="btn btn-outline btn-sm" onclick="editSection(${section.id})">
                        <i data-lucide="edit-2"></i>
                        <span>Manage Content</span>
                    </button>
                </div>
            `;
            grid.appendChild(card);
        });
        if (window.lucide) window.lucide.createIcons();
    }

    window.addNewCollectionSection = function() {
        const tempId = -Math.floor(Math.random() * 100000);
        const newSection = {
            id: tempId,
            type: 'collection_grid',
            entity_type: 'global_home',
            sort_order: window.homepageSections.length,
            items: []
        };
        window.homepageSections.push(newSection);
        renderSectionsGrid();
        window.editSection(tempId);
    };

    // Initialize
    const init = () => {
        // Search listener
        const searchInput = document.getElementById('productSearch');
        const colFilter = document.getElementById('collectionFilter');

        if (searchInput) {
            let timeout;
            searchInput.oninput = (e) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => performSearch(e.target.value, colFilter.value), 300);
            };
        }

        if (colFilter) {
            colFilter.onchange = (e) => {
                performSearch(searchInput.value, e.target.value);
            };
        }

        const closePickerBtn = document.getElementById('closePickerBtn');
        if (closePickerBtn) {
            closePickerBtn.onclick = () => {
                document.getElementById('productPicker').style.display = 'none';
                document.getElementById('sectionModal').style.display = 'flex'; // Show modal again
            };
        }

        const confirmBtn = document.getElementById('confirmSelectionBtn');
        if (confirmBtn) {
            confirmBtn.onclick = () => {
                const section = window.homepageSections.find(s => s.id == activeSectionId);
                section.items = selectedProducts.map(p => ({
                    entity_id: p.id,
                    entity_type: 'product',
                    title: p.name,
                    image_url: p.image || '', // Save relative path only
                    button_url: 'product/' + p.id // Simple URL structure
                }));
                window.editSection(activeSectionId);
                closePickerBtn.click();
            };
        }

        const addBtn = document.getElementById('addItemBtn');
        if (addBtn) {
            addBtn.onclick = () => {
                syncCurrentItems();
                const section = window.homepageSections.find(s => s.id == activeSectionId);
                section.items.push({ title: '', content: '', image_url: '', button_text: '', button_url: '' });
                window.editSection(activeSectionId);
            };
        }

        const saveSecBtn = document.getElementById('saveSectionBtn');
        if (saveSecBtn) {
            saveSecBtn.onclick = () => {
                syncCurrentItems();
                const card = document.querySelector(`.section-card[data-id="${activeSectionId}"]`);
                if (card) {
                    const section = window.homepageSections.find(s => s.id == activeSectionId);
                    const badge = card.querySelector('.badge');
                    if (badge) badge.innerText = section.items.length + ' Items';
                    
                    // Update Title Display on Card
                    const titleH3 = card.querySelector('h3');
                    if (titleH3) {
                        const sectionNames = {
                            'hero_slider': 'Hero Slider',
                            'promo_grid': 'Promo Banners',
                            'feature_highlight': 'Feature Highlight',
                            'brand_story': 'Brand Story',
                            'collection_grid': 'Collection Showcase'
                        };
                        titleH3.innerText = section.title || sectionNames[section.type] || section.type;
                    }
                }
                window.closeSectionModal();
            };
        }

        const saveAllBtn = document.getElementById('saveAllChanges');
        if (saveAllBtn) {
            saveAllBtn.onclick = async function() {
                const btn = this;
                const oldHtml = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<i data-lucide="loader" class="spin"></i> <span>Saving...</span>';
                if (window.lucide) window.lucide.createIcons();

                try {
                    const response = await fetch(window.adminBaseUrl + '/admin/theme/update', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ sections: window.homepageSections })
                    });
                    const result = await response.json();
                    if (result.success) {
                        window.Swal.fire('Success', 'Settings saved!', 'success').then(() => location.reload());
                    } else {
                        alert('Error: ' + result.message);
                    }
                } catch (e) {
                    alert('Error: ' + e.message);
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = oldHtml;
                    if (window.lucide) window.lucide.createIcons();
                }
            };
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
