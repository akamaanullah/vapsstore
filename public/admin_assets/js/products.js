document.addEventListener('DOMContentLoaded', function () {
    console.log('Products JS - AJAX Filtering & Pagination Active');

    const tableContainer = document.getElementById('products-table-container');
    const filterForm = document.querySelector('.filter-form');
    const searchInput = document.querySelector('.search-input');
    
    if (!tableContainer || !filterForm) return;

    // --- AJAX Function ---
    async function updateTable(url) {
        // Show loading state
        tableContainer.style.opacity = '0.5';
        tableContainer.style.pointerEvents = 'none';

        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) throw new Error('Network response was not ok');

            const html = await response.text();
            tableContainer.innerHTML = html;
            
            // Re-initialize Lucide icons for new content
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Update URL without refreshing page
            window.history.pushState({}, '', url);

        } catch (error) {
            console.error('AJAX Error:', error);
            // Fallback: full page reload if AJAX fails
            window.location.href = url;
        } finally {
            tableContainer.style.opacity = '1';
            tableContainer.style.pointerEvents = 'auto';
        }
    }

    // --- Event Listeners ---

    // 1. Intercept Pagination Clicks
    tableContainer.addEventListener('click', function (e) {
        const pageLink = e.target.closest('.page-link');
        if (pageLink && !pageLink.closest('.disabled')) {
            e.preventDefault();
            const url = pageLink.href;
            updateTable(url);
        }
    });

    // 2. Intercept Filter Changes (Selects)
    filterForm.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', function (e) {
            e.preventDefault();
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);
            const url = `${filterForm.action}?${params.toString()}`;
            updateTable(url);
        });
    });

    // 3. Intercept Form Submission (Enter key in search)
    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);
        const url = `${filterForm.action}?${params.toString()}`;
        updateTable(url);
    });

    // 4. Debounced Search Input
    let timeout = null;
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const formData = new FormData(filterForm);
                const params = new URLSearchParams(formData);
                const url = `${filterForm.action}?${params.toString()}`;
                updateTable(url);
            }, 500);
        });
    }

    // 4. Delete Confirmation (Stay active for dynamic content)
    tableContainer.addEventListener('click', function (e) {
        const btn = e.target.closest('.delete-btn');
        if (btn) {
            e.preventDefault();
            const form = btn.closest('form');
            if (form) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e16449',
                    cancelButtonColor: '#a3a3a3',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        }
    });
});
