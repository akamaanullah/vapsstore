document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('blogSearchInput');
    const categoryLinks = document.querySelectorAll('#blogCategoryList a');
    const allCards = Array.from(document.querySelectorAll('.listing-grid .blog-card'));
    const emptyState = document.getElementById('blogEmptyState');
    const paginationWrapper = document.getElementById('blogPagination');

    const ITEMS_PER_PAGE = 9;
    let currentPage = 1;
    let currentFilteredCards = [...allCards];

    // Main Filter Function
    const filterBlogs = () => {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const activeCategoryLink = document.querySelector('#blogCategoryList li.active a');
        const activeCategory = activeCategoryLink ? activeCategoryLink.getAttribute('data-filter') : 'all';

        currentFilteredCards = allCards.filter(card => {
            const title = card.querySelector('.blog-title').textContent.toLowerCase();
            const excerpt = card.querySelector('.blog-excerpt').textContent.toLowerCase();
            const category = card.getAttribute('data-category');

            const matchesSearch = title.includes(searchTerm) || excerpt.includes(searchTerm);
            const matchesCategory = activeCategory === 'all' || activeCategory === category;

            return matchesSearch && matchesCategory;
        });

        // Hide all cards initially
        allCards.forEach(card => card.style.display = 'none');

        currentPage = 1; // Reset to first page on filter
        renderPage();
        renderPagination();

        // Show/Hide Empty State
        if (emptyState) {
            emptyState.style.display = currentFilteredCards.length === 0 ? 'block' : 'none';
        }
    };

    // Render specific page
    const renderPage = () => {
        // Hide all first
        allCards.forEach(card => card.style.display = 'none');

        const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
        const endIndex = startIndex + ITEMS_PER_PAGE;
        
        const cardsToShow = currentFilteredCards.slice(startIndex, endIndex);
        cardsToShow.forEach(card => {
            card.style.display = 'block';
        });
    };

    // Render Pagination UI
    const renderPagination = () => {
        if (!paginationWrapper) return;
        
        const totalPages = Math.ceil(currentFilteredCards.length / ITEMS_PER_PAGE);
        
        // If 1 or 0 pages, hide pagination
        if (totalPages <= 1) {
            paginationWrapper.style.display = 'none';
            return;
        }
        
        paginationWrapper.style.display = 'flex';
        paginationWrapper.innerHTML = ''; // clear

        // Prev Button
        paginationWrapper.insertAdjacentHTML('beforeend', `<button class="page-btn" ${currentPage === 1 ? 'disabled' : ''} onclick="changeBlogPage(${currentPage - 1})">PREV</button>`);

        // Page Numbers
        for (let i = 1; i <= totalPages; i++) {
            paginationWrapper.insertAdjacentHTML('beforeend', `
                <button class="page-num ${currentPage === i ? 'active' : ''}" onclick="changeBlogPage(${i})">${i}</button>
            `);
        }

        // Next Button
        paginationWrapper.insertAdjacentHTML('beforeend', `<button class="page-btn" ${currentPage === totalPages ? 'disabled' : ''} onclick="changeBlogPage(${currentPage + 1})">NEXT</button>`);
    };

    // Global function for pagination click
    window.changeBlogPage = (page) => {
        currentPage = page;
        renderPage();
        renderPagination();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // Category click event
    if (categoryLinks) {
        categoryLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                // Remove active class from all
                document.querySelectorAll('#blogCategoryList li').forEach(li => li.classList.remove('active'));
                // Add active class to clicked
                link.parentElement.classList.add('active');
                
                filterBlogs();
            });
        });
    }

    // Search input event
    if (searchInput) {
        searchInput.addEventListener('input', filterBlogs);
    }

    // Initial Render
    filterBlogs();
});
