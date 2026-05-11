document.addEventListener('DOMContentLoaded', () => {
    // 1. Initial State
    let currentPage = 1;
    let productsPerPage = 12;
    let currentCollectionId = document.body.dataset.collectionId || null;

    // 2. DOM Elements
    const productGrid = document.getElementById('productGrid');
    const pagination = document.getElementById('pagination');
    const priceRange = document.getElementById('priceRange');
    const priceValue = document.getElementById('priceValue');
    const sortSelect = document.getElementById('sortSelect');
    const perPageSelect = document.getElementById('perPageSelect');
    const clearFiltersBtn = document.getElementById('clearFilters');

    // Sidebar Toggle Elements
    const sidebar = document.getElementById('collectionSidebar');
    const openFiltersBtn = document.getElementById('openFilters');
    const closeFiltersBtn = document.getElementById('closeFilters');

    // 3. Initialize
    function init() {
        // Parse URL parameters for initial filters
        parseUrlParams();
        fetchProducts(true); // Initial load (skip history push)
        setupEventListeners();
        if (typeof lucide !== 'undefined') lucide.createIcons();

        // Handle browser back/forward buttons
        window.addEventListener('popstate', (e) => {
            if (e.state) {
                parseUrlParams();
                fetchProducts(true);
            }
        });
    }

    function updateUrlParams() {
        const selectedCats = Array.from(document.querySelectorAll('.category-accordion input[type="checkbox"]:checked')).map(el => el.dataset.slug);
        const selectedBrands = Array.from(document.querySelectorAll('input[name="brand"]:checked')).map(el => el.dataset.slug);
        
        let filterParts = [];
        
        if (selectedCats.length > 0) filterParts.push(`category:${selectedCats.join('+')}`);
        if (selectedBrands.length > 0) filterParts.push(`brand:${selectedBrands.join('+')}`);
        if (priceRange.value != 500) filterParts.push(`max_price:${priceRange.value}`);
        if (sortSelect.value !== 'newest') filterParts.push(`sort:${sortSelect.value}`);
        if (currentPage > 1) filterParts.push(`page:${currentPage}`);
        if (perPageSelect.value != 12) filterParts.push(`per_page:${perPageSelect.value}`);

        // Construct Path-based URL (No ? and No %2C)
        let baseUrl = window.location.pathname.split('/filters/')[0];
        let newUrl = baseUrl;
        
        if (filterParts.length > 0) {
            newUrl += `/filters/${filterParts.join('/')}`;
        }

        window.history.pushState({ path: newUrl }, '', newUrl);
    }

    function parseUrlParams() {
        // Handle Path-based parameters
        const path = window.location.pathname;
        if (!path.includes('/filters/')) {
            // Also check query params for backward compatibility
            parseQueryString();
            return;
        }

        const filterString = path.split('/filters/')[1];
        const segments = filterString.split('/');
        
        segments.forEach(segment => {
            const [key, value] = segment.split(':');
            if (!key || !value) return;

            if (key === 'category') {
                const slugs = value.split('+');
                document.querySelectorAll('.category-accordion input[type="checkbox"]').forEach(input => {
                    input.checked = slugs.includes(input.dataset.slug);
                });
            } else if (key === 'brand') {
                const slugs = value.split('+');
                document.querySelectorAll('input[name="brand"]').forEach(input => {
                    input.checked = slugs.includes(input.dataset.slug);
                });
            } else if (key === 'max_price') {
                priceRange.value = value;
                priceValue.textContent = `£0 - £${priceRange.value}`;
            } else if (key === 'sort') {
                sortSelect.value = value;
            } else if (key === 'page') {
                currentPage = parseInt(value);
            } else if (key === 'per_page') {
                perPageSelect.value = value;
            }
        });
    }

    function parseQueryString() {
        const params = new URLSearchParams(window.location.search);
        // ... (existing query param parsing for safety)
        if (params.has('category')) {
            const slugs = params.get('category').split(/[,+]/); // Handle both , and +
            document.querySelectorAll('.category-accordion input[type="checkbox"]').forEach(input => {
                input.checked = slugs.includes(input.dataset.slug);
            });
        }
        // ... (similar for others if needed, but we prefer path now)
    }



    // 4. Fetch Products via AJAX
    async function fetchProducts(skipPush = false) {
        // Show loading state
        const loaderHtml = '<div class="product-loader-overlay"><div class="spinner-custom"></div></div>';
        if (!productGrid.querySelector('.product-loader-overlay')) {
            productGrid.insertAdjacentHTML('afterbegin', loaderHtml);
        }
        productGrid.classList.add('is-loading');

        if (!skipPush) updateUrlParams();

        // Collect filters for API
        const selectedCats = Array.from(document.querySelectorAll('.category-accordion input[type="checkbox"]:checked')).map(el => el.value);
        const selectedBrands = Array.from(document.querySelectorAll('input[name="brand"]:checked')).map(el => el.value);
        const maxPrice = priceRange.value;
        const sort = sortSelect.value;
        const perPage = perPageSelect ? perPageSelect.value : 12;

        // API URL
        let url = `${BASE_URL}/api/collection/search?page=${currentPage}&per_page=${perPage}&sort=${sort}&max_price=${maxPrice}&min_price=0`;
        
        let catParams = [...selectedCats];
        if (currentCollectionId && !catParams.includes(currentCollectionId)) {
            // Include collection scope
            catParams.unshift(currentCollectionId);
        }

        if (catParams.length > 0) url += `&category=${catParams.join(',')}`;
        if (selectedBrands.length > 0) url += `&brand=${selectedBrands.join(',')}`;


        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error('Network response was not ok');
            const result = await response.json();

            if (result.status === 'success') {
                // Smooth transition
                productGrid.style.opacity = '0';
                setTimeout(() => {
                    productGrid.innerHTML = result.html;
                    renderPagination(result.pagination);
                    productGrid.style.opacity = '1';
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                }, 200);
            }
        } catch (error) {
            console.error('Fetch error:', error);
            productGrid.innerHTML = '<div class="no-products">Error loading products. Please try again.</div>';
        } finally {
            setTimeout(() => {
                productGrid.classList.remove('is-loading');
                const overlay = productGrid.querySelector('.product-loader-overlay');
                if (overlay) overlay.remove();
            }, 300);
        }
    }

    // 5. Render Pagination
    function renderPagination(data) {
        const totalPages = data.last_page;
        pagination.innerHTML = '';

        if (totalPages <= 1) return;

        // Previous Button
        const prevBtn = document.createElement('button');
        prevBtn.className = 'page-btn';
        prevBtn.innerHTML = '<i data-lucide="chevron-left" class="icon-xs"></i>';
        prevBtn.disabled = data.current_page === 1;
        prevBtn.onclick = () => changePage(data.current_page - 1);
        pagination.appendChild(prevBtn);

        // Dynamic page ranges for better scalability
        let start = Math.max(1, data.current_page - 2);
        let end = Math.min(totalPages, start + 4);
        if (end === totalPages) start = Math.max(1, end - 4);

        if (start > 1) {
            addPageLink(1);
            if (start > 2) pagination.appendChild(createDots());
        }

        for (let i = start; i <= end; i++) {
            addPageLink(i, i === data.current_page);
        }

        if (end < totalPages) {
            if (end < totalPages - 1) pagination.appendChild(createDots());
            addPageLink(totalPages);
        }

        // Next Button
        const nextBtn = document.createElement('button');
        nextBtn.className = 'page-btn';
        nextBtn.innerHTML = '<i data-lucide="chevron-right" class="icon-xs"></i>';
        nextBtn.disabled = data.current_page === totalPages;
        nextBtn.onclick = () => changePage(data.current_page + 1);
        pagination.appendChild(nextBtn);
        
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function addPageLink(num, active = false) {
        const pageNum = document.createElement('div');
        pageNum.className = `page-num ${active ? 'active' : ''}`;
        pageNum.textContent = num;
        pageNum.onclick = () => changePage(num);
        pagination.appendChild(pageNum);
    }

    function createDots() {
        const dots = document.createElement('span');
        dots.className = 'pagination-dots';
        dots.textContent = '...';
        return dots;
    }

    function changePage(page) {
        if (currentPage === page) return;
        currentPage = page;
        fetchProducts();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // 6. Event Listeners
    function setupEventListeners() {
        // Filter Inputs
        document.querySelectorAll('.filter-checkbox').forEach(input => {
            input.addEventListener('change', () => {
                currentPage = 1;
                fetchProducts();
            });
        });

        // Parent-Child Checkbox Sync
        document.querySelectorAll('.has-children > .accordion-item input[type="checkbox"]').forEach(parentInput => {
            parentInput.addEventListener('change', (e) => {
                const subCats = parentInput.closest('.has-children').querySelectorAll('.sub-categories input[type="checkbox"]');
                subCats.forEach(childInput => {
                    childInput.checked = parentInput.checked;
                });
                // No need to call fetchProducts here, the change listener on .filter-checkbox handles it
            });
        });

        // Price Range
        priceRange.addEventListener('input', (e) => {
            priceValue.textContent = `£0 - £${e.target.value}`;
        });
        
        priceRange.addEventListener('change', () => {
            currentPage = 1;
            fetchProducts();
        });

        // Sort Select
        sortSelect.addEventListener('change', () => {
            currentPage = 1;
            fetchProducts();
        });

        // Per Page Select
        if (perPageSelect) {
            perPageSelect.addEventListener('change', () => {
                currentPage = 1;
                fetchProducts();
            });
        }

        // Clear Filters
        clearFiltersBtn.addEventListener('click', () => {
            document.querySelectorAll('.filter-checkbox').forEach(input => input.checked = false);
            priceRange.value = 500;
            priceValue.textContent = "£0 - £500";
            sortSelect.value = 'newest';
            currentPage = 1;
            fetchProducts();
        });

        // Accordion Toggles
        document.querySelectorAll('.accordion-trigger').forEach(trigger => {
            trigger.addEventListener('click', () => {
                trigger.parentElement.classList.toggle('active');
            });
        });

        document.querySelectorAll('.accordion-item').forEach(item => {
            item.addEventListener('click', (e) => {
                if (e.target.tagName === 'INPUT' || e.target.closest('label') || e.target.closest('.cat-check-label')) {
                    return;
                }
                item.parentElement.classList.toggle('active');
            });
        });

        // Mobile Sidebar Toggle
        if (openFiltersBtn) {
            openFiltersBtn.addEventListener('click', () => sidebar.classList.add('active'));
        }
        if (closeFiltersBtn) {
            closeFiltersBtn.addEventListener('click', () => sidebar.classList.remove('active'));
        }
    }

    init();
});
