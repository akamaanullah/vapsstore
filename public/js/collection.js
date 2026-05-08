document.addEventListener('DOMContentLoaded', () => {
    // 1. Mock Data for Products
    const products = [
        { id: 1, name: "SMOK Nord 5 Kit", price: 35.99, category: "pod", brand: "SMOK", image: "assets/product/product-1.jpg", date: "2024-04-01", badge: "" },
        { id: 2, name: "Vaporesso XROS 3", price: 29.50, category: "pod", brand: "Vaporesso", image: "assets/product/product-2.jpg", date: "2024-03-15", badge: "" },
        { id: 3, name: "Voopoo Drag 4 Mod", price: 65.00, category: "advanced", brand: "Voopoo", image: "assets/product/product-3.jpg", date: "2024-02-20", badge: "" },
        { id: 4, name: "GeekVape L200 Classic", price: 79.99, category: "10000-puffs", brand: "GeekVape", image: "assets/product/product-4.jpg", date: "2024-04-10", badge: "" },
        { id: 5, name: "Dinner Lady Lemon Tart", price: 15.99, category: "freebase", brand: "Dinner Lady", image: "assets/product/product-5.jpg", date: "2024-01-10", badge: "" },
        { id: 6, name: "SMOK Novo 5", price: 28.00, category: "600-puffs", brand: "SMOK", image: "assets/product/product-6.jpg", date: "2024-03-25", badge: "" },
        { id: 7, name: "Vaporesso Target 200", price: 55.00, category: "advanced", brand: "Vaporesso", image: "assets/product/product-7.jpg", date: "2024-03-05", badge: "" },
        { id: 8, name: "Nasty Juice Bad Blood", price: 18.50, category: "nic-salts", brand: "Nasty Juice", image: "assets/product/product-8.jpg", date: "2024-04-05", badge: "" },
        { id: 9, name: "Uwell Caliburn G3", price: 32.00, category: "pod", brand: "Uwell", image: "assets/product/product-9.jpg", date: "2024-04-12", badge: "" },
        { id: 10, name: "GeekVape Wenax Q", price: 22.00, category: "pod", brand: "GeekVape", image: "assets/product/product-1.jpg", date: "2024-03-20", badge: "" },
        { id: 11, name: "Voopoo Argus P1", price: 45.00, category: "pod", brand: "Voopoo", image: "assets/product/product-2.jpg", date: "2024-02-15", badge: "" },
        { id: 12, name: "SMOK Mag Solo", price: 49.99, category: "advanced", brand: "SMOK", image: "assets/product/product-3.jpg", date: "2024-03-10", badge: "" },
        { id: 13, name: "Vaporesso Luxe XR Max", price: 42.00, category: "pod", brand: "Vaporesso", image: "assets/product/product-4.jpg", date: "2024-04-15", badge: "" }
    ];

    let filteredProducts = [...products];
    let currentPage = 1;
    let productsPerPage = 12;

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
        renderProducts();
        setupEventListeners();
        lucide.createIcons(); // Initialize Lucide icons
    }

    // 4. Render Products
    function renderProducts() {
        const start = (currentPage - 1) * productsPerPage;
        const end = start + productsPerPage;
        const paginatedItems = filteredProducts.slice(start, end);

        productGrid.innerHTML = '';

        if (paginatedItems.length === 0) {
            productGrid.innerHTML = '<div class="no-products">No products found matching your criteria.</div>';
            pagination.innerHTML = '';
            return;
        }

        paginatedItems.forEach(product => {
            const card = `
                <div class="product-card" data-id="${product.id}">
                    <div class="product-img-wrapper">
                        ${product.badge ? `<span class="badge ${product.badge.toLowerCase()}">${product.badge}</span>` : ''}
                        <img src="${product.image}" alt="${product.name}" loading="lazy">
                        <div class="product-actions">
                            <button class="action-btn" title="Add to Wishlist"><i data-lucide="heart"></i></button>
                            <a href="product-detail.php" class="action-btn" title="Quick View"><i data-lucide="eye"></i></a>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name"><a href="product-detail.php">${product.name}</a></h3>
                        <div class="product-price-container">
                            <span class="old-price">£${(product.price + 10).toFixed(2)}</span>
                            <span class="current-price">£${product.price.toFixed(2)}</span>
                        </div>
                        <button class="btn-buy">Add to Cart</button>
                    </div>
                </div>
            `;
            productGrid.insertAdjacentHTML('beforeend', card);
        });

        lucide.createIcons(); // Re-initialize icons for new cards

        renderPagination();
    }

    // 5. Render Pagination
    function renderPagination() {
        const totalPages = Math.ceil(filteredProducts.length / productsPerPage);
        pagination.innerHTML = '';

        if (totalPages <= 1) return;

        // Previous Button
        pagination.insertAdjacentHTML('beforeend', `<button class="page-btn" ${currentPage === 1 ? 'disabled' : ''} onclick="changePage(${currentPage - 1})">Prev</button>`);

        for (let i = 1; i <= totalPages; i++) {
            pagination.insertAdjacentHTML('beforeend', `
                <div class="page-num ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</div>
            `);
        }

        // Next Button
        pagination.insertAdjacentHTML('beforeend', `<button class="page-btn" ${currentPage === totalPages ? 'disabled' : ''} onclick="changePage(${currentPage + 1})">Next</button>`);
    }

    // 6. Global Function for Pagination (exposed to window for onclick)
    window.changePage = (page) => {
        currentPage = page;
        renderProducts();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // 7. Filtering Logic
    function applyFilters() {
        const selectedCats = Array.from(document.querySelectorAll('input[name="cat"]:checked')).map(el => el.value);
        const selectedBrands = Array.from(document.querySelectorAll('input[name="brand"]:checked')).map(el => el.value);
        const maxPrice = parseInt(priceRange.value);

        filteredProducts = products.filter(product => {
            const catMatch = selectedCats.length === 0 || selectedCats.includes(product.category);
            const brandMatch = selectedBrands.length === 0 || selectedBrands.includes(product.brand);
            const priceMatch = product.price <= maxPrice;
            return catMatch && brandMatch && priceMatch;
        });

        applySorting(); // Sort after filtering
        currentPage = 1;
        renderProducts();
    }

    // 8. Sorting Logic
    function applySorting() {
        const sortValue = sortSelect.value;
        if (sortValue === 'price-low') {
            filteredProducts.sort((a, b) => a.price - b.price);
        } else if (sortValue === 'price-high') {
            filteredProducts.sort((a, b) => b.price - a.price);
        } else if (sortValue === 'newest') {
            filteredProducts.sort((a, b) => new Date(b.date) - new Date(a.date));
        } else {
            // Default sort (ID or something)
            filteredProducts.sort((a, b) => a.id - b.id);
        }
    }

    // 9. Event Listeners
    function setupEventListeners() {
        // Filter Inputs
        document.querySelectorAll('input[name="cat"], input[name="brand"]').forEach(input => {
            input.addEventListener('change', applyFilters);
        });

        // Price Range
        priceRange.addEventListener('input', (e) => {
            priceValue.textContent = `$0 - $${e.target.value}`;
            applyFilters();
        });

        // Sort Select
        sortSelect.addEventListener('change', () => {
            applySorting();
            renderProducts();
        });

        // Per Page Select
        perPageSelect.addEventListener('change', (e) => {
            productsPerPage = parseInt(e.target.value);
            currentPage = 1;
            renderProducts();
        });

        // Clear Filters
        clearFiltersBtn.addEventListener('click', () => {
            document.querySelectorAll('input[type="checkbox"]').forEach(input => input.checked = false);
            priceRange.value = 500;
            priceValue.textContent = "$0 - $500";
            sortSelect.value = 'default';
            applyFilters();
        });

        // Main Widget Accordion Toggle
        document.querySelectorAll('.accordion-trigger').forEach(trigger => {
            trigger.addEventListener('click', () => {
                trigger.parentElement.classList.toggle('active');
            });
        });

        // Sub-category Accordion Toggle
        document.querySelectorAll('.accordion-item').forEach(item => {
            item.addEventListener('click', () => {
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
