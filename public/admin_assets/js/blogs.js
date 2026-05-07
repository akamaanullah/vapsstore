document.addEventListener('DOMContentLoaded', function () {
    console.log('Blogs JS - AJAX Pagination Active');

    const blogsContainer = document.getElementById('blogs-list-container');
    if (!blogsContainer) return;

    // --- AJAX Function ---
    async function updateBlogs(url) {
        // Show loading state
        blogsContainer.style.opacity = '0.5';
        blogsContainer.style.pointerEvents = 'none';

        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) throw new Error('Network response was not ok');

            const html = await response.text();
            blogsContainer.innerHTML = html;
            
            // Re-initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Update URL
            window.history.pushState({}, '', url);

        } catch (error) {
            console.error('AJAX Error:', error);
            window.location.href = url;
        } finally {
            blogsContainer.style.opacity = '1';
            blogsContainer.style.pointerEvents = 'auto';
        }
    }

    // --- Event Listeners ---

    // 1. Intercept Pagination Clicks
    blogsContainer.addEventListener('click', function (e) {
        const pageLink = e.target.closest('.page-link');
        if (pageLink && !pageLink.closest('.disabled')) {
            e.preventDefault();
            const url = pageLink.href;
            updateBlogs(url);
        }
    });

    // 2. Intercept Search & Filters (If added in future)
    const searchInput = document.querySelector('.search-input');
    const statusDropdown = document.querySelector('.status-dropdown');

    if (searchInput) {
        let timeout = null;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const search = searchInput.value;
                const status = statusDropdown ? statusDropdown.value : '';
                const url = new URL(window.location.href);
                url.searchParams.set('search', search);
                if (status) url.searchParams.set('status', status);
                updateBlogs(url.toString());
            }, 500);
        });
    }
});
