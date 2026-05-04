document.addEventListener('DOMContentLoaded', function () {
    console.log('Products JS - Filtering & Pagination Active');

    // 1. Element Selectors
    const searchInput = document.querySelector('.search-input');
    const statusFilter = document.querySelector('.status-dropdown');
    const perPageSelect = document.querySelector('.per-page-select');
    const paginationList = document.querySelector('.pagination');
    
    // Find the product table (Resilient search)
    const allTables = Array.from(document.querySelectorAll('table'));
    const table = allTables.find(t => t.textContent.includes('Price') || t.textContent.includes('Status')) || document.getElementById('productsTable');

    if (!table) return;

    const tableBody = table.querySelector('tbody') || table;
    const originalRows = Array.from(tableBody.querySelectorAll('tr')).filter(tr => tr.querySelector('td'));
    
    let filteredRows = [...originalRows];
    let currentPage = 1;

    // 2. Global Event Handler (Delete actions)
    table.addEventListener('click', function (e) {
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
                }).then((result) => { if (result.isConfirmed) form.submit(); });
            }
        }
    });

    // 3. Filtering Engine
    function filterProducts() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const statusTerm = statusFilter ? statusFilter.value.toLowerCase().trim() : '';

        filteredRows = originalRows.filter((row) => {
            const nameCell = row.querySelector('.product-title-sm') || row.cells[0];
            const nameText = nameCell ? nameCell.textContent.toLowerCase().trim() : '';
            
            const statusBadge = row.querySelector('[class*="badge"]') || row.cells[1];
            const statusText = statusBadge ? statusBadge.textContent.toLowerCase().trim() : '';
            const statusClasses = statusBadge ? statusBadge.className.toLowerCase() : '';

            const matchesSearch = searchTerm === '' || nameText.includes(searchTerm);
            
            let matchesStatus = (statusTerm === '' || statusTerm === 'all status');
            if (!matchesStatus) {
                // Multi-layer matching (Text or Class)
                matchesStatus = (statusText === statusTerm) || 
                                (statusClasses.includes(statusTerm)) ||
                                (statusText.includes(statusTerm));
                
                // Active/Published synonym
                if (!matchesStatus && statusTerm === 'active') {
                    matchesStatus = statusText.includes('pub') || statusClasses.includes('pub') || statusText.includes('active');
                }
            }

            return matchesSearch && matchesStatus;
        });

        currentPage = 1;
        updatePagination();
    }

    // 4. Pagination & Display Logic
    function updatePagination() {
        const perPage = perPageSelect ? parseInt(perPageSelect.value) : 10;
        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / perPage);

        // Reset visibility
        originalRows.forEach(row => { row.style.display = 'none'; });

        // Show page rows
        const start = (currentPage - 1) * perPage;
        const end = start + perPage;

        filteredRows.forEach((row, index) => {
            if (index >= start && index < end) { row.style.display = ''; }
        });

        // Update Counter
        const startElem = document.getElementById('page-start');
        const endElem = document.getElementById('page-end');
        const totalElem = document.getElementById('page-total');
        
        if (startElem) startElem.textContent = (totalRows === 0 ? 0 : start + 1);
        if (endElem) endElem.textContent = Math.min(end, totalRows);
        if (totalElem) totalElem.textContent = totalRows;

        // Render Pagination Links
        if (paginationList) {
            let html = `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a href="#" class="page-link" data-page="prev">&laquo;</a></li>`;
            for (let i = 1; i <= totalPages; i++) {
                html += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a href="#" class="page-link" data-page="${i}">${i}</a></li>`;
            }
            html += `<li class="page-item ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}"><a href="#" class="page-link" data-page="next">&raquo;</a></li>`;
            paginationList.innerHTML = html;

            paginationList.querySelectorAll('.page-link').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const page = e.target.getAttribute('data-page');
                    if (page === 'prev' && currentPage > 1) currentPage--;
                    else if (page === 'next' && currentPage < totalPages) currentPage++;
                    else if (!isNaN(page)) currentPage = parseInt(page);
                    updatePagination();
                });
            });
        }
    }

    // 5. Global Listeners
    if (searchInput) searchInput.addEventListener('input', filterProducts);
    if (statusFilter) statusFilter.addEventListener('change', filterProducts);
    if (perPageSelect) perPageSelect.addEventListener('change', () => { currentPage = 1; updatePagination(); });

    // Initial load
    updatePagination();
    // 6. Delete Confirmation (SweetAlert2)
    const deleteForms = document.querySelectorAll('.delete-product-form');
    deleteForms.forEach(form => {
        const deleteBtn = form.querySelector('.delete-btn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
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
            });
        }
    });
});
