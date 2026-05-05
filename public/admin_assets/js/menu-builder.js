document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('menuItemsContainer');
    const addBtn = document.getElementById('addMenuItemBtn');
    const modal = document.getElementById('menuItemModal');
    const form = document.getElementById('menuItemForm');
    
    let menuItems = window.initialMenuItems || [];
    let editMode = false;
    let editingId = null;

    // Initialize UI
    renderMenu();

    if (addBtn) {
        addBtn.addEventListener('click', () => {
            openModal();
        });
    }

    function openModal(data = null) {
        editMode = !!data;
        editingId = data ? data.id : null;
        
        document.getElementById('modalTitle').innerText = editMode ? 'Edit Menu Item' : 'Add Menu Item';
        document.getElementById('item_title').value = data ? data.title : '';
        document.getElementById('item_link_type').value = data ? data.link_type : 'custom_url';
        document.getElementById('item_link_value').value = data ? data.link_value : '';
        document.getElementById('item_image_url').value = data ? (data.image_url || '') : '';
        
        handleLinkTypeChange();
        modal.style.display = 'flex';
    }

    document.getElementById('closeMenuItemModal').addEventListener('click', () => modal.style.display = 'none');
    document.getElementById('cancelMenuItemBtn').addEventListener('click', () => modal.style.display = 'none');

    document.getElementById('item_link_type').addEventListener('change', handleLinkTypeChange);

    function handleLinkTypeChange() {
        const type = document.getElementById('item_link_type').value;
        const label = document.getElementById('linkValueLabel');
        const promoFields = document.getElementById('promoFields');
        const linkContainer = document.getElementById('linkValueContainer');
        const linkInput = document.getElementById('item_link_value');
        
        promoFields.style.display = (type === 'promo_banner') ? 'block' : 'none';
        linkContainer.style.display = (type === 'no_link') ? 'none' : 'block';
        
        switch(type) {
            case 'collection': label.innerText = 'Select Collection'; break;
            case 'brand': label.innerText = 'Select Brand'; break;
            case 'page': label.innerText = 'Select Page'; break;
            case 'custom_url': label.innerText = 'Link URL'; break;
            case 'mega_menu_column': label.innerText = 'Column Heading (Optional Link)'; break;
            case 'promo_banner': label.innerText = 'Promotion Link'; break;
        }

        // Trigger search for "all" when type changes to help user
        if (['collection', 'brand', 'page'].includes(type) && !linkInput.value) {
            performSearch(type, 'all');
        }
    }

    const searchInput = document.getElementById('item_link_value');
    const resultsBox = document.getElementById('searchResults');
    let searchTimeout = null;

    searchInput.addEventListener('input', function() {
        const type = document.getElementById('item_link_type').value;
        const query = this.value;

        if (!['collection', 'brand', 'page'].includes(type)) {
            resultsBox.style.display = 'none';
            return;
        }

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch(type, query || 'all');
        }, 300);
    });

    // Close results when clicking outside
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
            resultsBox.style.display = 'none';
        }
    });

    function performSearch(type, query) {
        if (!query) {
            resultsBox.style.display = 'none';
            return;
        }

        fetch(`${BASE_URL}/admin/menus/search?type=${type}&q=${query}`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    resultsBox.innerHTML = data.map(item => `
                        <div class="search-result-item" data-url="${item.url}" data-title="${item.title}">
                            <i data-lucide="${type === 'collection' ? 'layers' : (type === 'brand' ? 'tag' : 'file-text')}" class="icon-xs"></i>
                            <span>${item.title}</span>
                        </div>
                    `).join('');
                    resultsBox.style.display = 'block';
                    if (window.lucide) window.lucide.createIcons();

                    // Handle selection
                    resultsBox.querySelectorAll('.search-result-item').forEach(item => {
                        item.onclick = function() {
                            searchInput.value = this.dataset.url;
                            // Optionally update title if empty
                            const titleInput = document.getElementById('item_title');
                            if (!titleInput.value) {
                                titleInput.value = this.dataset.title;
                            }
                            resultsBox.style.display = 'none';
                        };
                    });
                } else {
                    resultsBox.innerHTML = '<div class="p-15 text-muted-sm text-center">No results found</div>';
                    resultsBox.style.display = 'block';
                }
            });
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const type = document.getElementById('item_link_type').value;
        const linkValue = document.getElementById('item_link_value').value.trim();

        // Validation: For Collection, Brand, Page - must be a valid link (starts with / or is full URL)
        if (['collection', 'brand', 'page'].includes(type) && type !== 'no_link') {
            if (!linkValue || (!linkValue.startsWith('/') && !linkValue.startsWith('http'))) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Link',
                    text: `Please select a valid ${type} from the search results or enter a proper URL starting with /`
                });
                return;
            }
        }

        const itemData = {
            id: editMode ? editingId : Date.now(),
            title: document.getElementById('item_title').value,
            link_type: type,
            link_value: type === 'no_link' ? '#' : linkValue,
            image_url: document.getElementById('item_image_url').value,
            children: editMode ? findItem(menuItems, editingId).children || [] : []
        };

        if (editMode) {
            updateItemInTree(menuItems, editingId, itemData);
        } else {
            menuItems.push(itemData);
        }

        modal.style.display = 'none';
        renderMenu();
    });

    function renderMenu() {
        if (menuItems.length === 0) {
            container.innerHTML = '<div class="empty-menu-placeholder"><i data-lucide="list" class="icon-lg text-muted opacity-2"></i><p>This menu is empty. Add your first item below.</p></div>';
        } else {
            container.innerHTML = `<ul class="menu-tree-list" id="mainMenuSortable">${buildHtml(menuItems)}</ul>`;
            initSortable();
        }
        if (window.lucide) window.lucide.createIcons();
    }

    function buildHtml(items) {
        return items.map(item => `
            <li class="menu-item-li" data-id="${item.id}">
                <div class="menu-item-row">
                    <div class="d-flex align-items-center gap-10">
                        <i data-lucide="grip-vertical" class="icon-xs drag-handle text-muted cursor-move"></i>
                        <div class="item-info">
                            <div class="fw-600 fs-14">${item.title}</div>
                            <div class="text-muted-sm fs-11 text-uppercase">${item.link_type}</div>
                        </div>
                    </div>
                    <div class="item-actions">
                        <button type="button" class="btn-action-icon edit-item" data-id="${item.id}"><i data-lucide="pencil"></i></button>
                        <button type="button" class="btn-action-icon text-error delete-item" data-id="${item.id}"><i data-lucide="trash-2"></i></button>
                    </div>
                </div>
                ${item.children && item.children.length > 0 ? `<ul class="menu-tree-list">${buildHtml(item.children)}</ul>` : '<ul class="menu-tree-list"></ul>'}
            </li>
        `).join('');
    }

    function initSortable() {
        const lists = container.querySelectorAll('.menu-tree-list');
        lists.forEach(list => {
            new Sortable(list, {
                group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                handle: '.drag-handle',
                onEnd: function() {
                    // Update the menuItems array based on the new DOM structure
                    menuItems = captureStructure(document.getElementById('mainMenuSortable'));
                    console.log('Structure updated:', menuItems);
                }
            });
        });

        // Re-attach edit/delete events
        container.querySelectorAll('.edit-item').forEach(btn => {
            btn.onclick = () => openModal(findItem(menuItems, btn.dataset.id));
        });
        container.querySelectorAll('.delete-item').forEach(btn => {
            btn.onclick = () => {
                if (confirm('Are you sure you want to delete this item?')) {
                    removeItem(menuItems, btn.dataset.id);
                    renderMenu();
                }
            };
        });
    }

    function captureStructure(ul) {
        const items = [];
        ul.querySelectorAll(':scope > li').forEach(li => {
            const id = li.dataset.id;
            const originalData = findItem(menuItems, id);
            const subUl = li.querySelector(':scope > ul');
            items.push({
                ...originalData,
                children: subUl ? captureStructure(subUl) : []
            });
        });
        return items;
    }

    function findItem(items, id) {
        for (const item of items) {
            if (item.id == id) return item;
            if (item.children) {
                const found = findItem(item.children, id);
                if (found) return found;
            }
        }
        return null;
    }

    function updateItemInTree(items, id, newData) {
        for (let i = 0; i < items.length; i++) {
            if (items[i].id == id) {
                items[i] = { ...items[i], ...newData };
                return true;
            }
            if (items[i].children && updateItemInTree(items[i].children, id, newData)) return true;
        }
        return false;
    }

    function removeItem(items, id) {
        for (let i = 0; i < items.length; i++) {
            if (items[i].id == id) {
                items.splice(i, 1);
                return true;
            }
            if (items[i].children && removeItem(items[i].children, id)) return true;
        }
        return false;
    }

    // Save Logic
    document.getElementById('saveMenuBtn').addEventListener('click', function() {
        const finalStructure = captureStructure(document.getElementById('mainMenuSortable'));
        
        Swal.fire({
            title: 'Saving Menu...',
            didOpen: () => Swal.showLoading()
        });

        fetch(`${BASE_URL}/admin/menus/update/${window.menuId}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ items: finalStructure })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Saved!', 'Menu structure updated successfully.', 'success');
            } else {
                Swal.fire('Error', data.message || 'Failed to save menu.', 'error');
            }
        });
    });
});
