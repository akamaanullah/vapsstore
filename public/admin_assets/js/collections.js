document.addEventListener('DOMContentLoaded', function() {
    console.log('Collections JS Loaded');

    // Delete confirmation
    const deleteBtns = document.querySelectorAll('.delete-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            Swal.fire({
                title: 'Delete Collection?',
                text: "Products in this collection will not be deleted, they will just lose their category.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e16449',
                cancelButtonColor: '#a3a3a3',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    toastr.error('Collection has been deleted.');
                    this.closest('tr').remove();
                    updatePagination(); // refresh pagination if needed
                }
            });
        });
    });

    // Edit button trigger
    const editBtns = document.querySelectorAll('.edit-btn');
    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            toastr.info('Edit mode opened for collection.');
        });
    });

    // Pagination & Per Page Logic
    const perPageSelect = document.querySelector('.per-page-select');
    const tableRows = document.querySelectorAll('.product-table tbody tr');
    const paginationList = document.querySelector('.pagination');
    const pageStartElem = document.getElementById('page-start');
    const pageEndElem = document.getElementById('page-end');
    const pageTotalElem = document.getElementById('page-total');

    function updatePaginationInfo(currentPage, perPage, totalRows) {
        if (!pageStartElem || !pageEndElem || !pageTotalElem) return;
        const start = totalRows === 0 ? 0 : (currentPage - 1) * perPage + 1;
        const end = Math.min(currentPage * perPage, totalRows);
        pageStartElem.textContent = start;
        pageEndElem.textContent = end;
        pageTotalElem.textContent = totalRows;
    }

    function updatePagination() {
        if (!perPageSelect || !tableRows.length || !paginationList) return;
        
        const currentRows = Array.from(document.querySelectorAll('.product-table tbody tr')); // re-query incase of delete
        const perPage = parseInt(perPageSelect.value);
        const totalRows = currentRows.length;
        const totalPages = Math.ceil(totalRows / perPage);
        
        // Initial render: show first page
        currentRows.forEach((row, index) => {
            if (index < perPage) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        updatePaginationInfo(1, perPage, totalRows);

        // Generate pagination links
        let html = '';
        html += `<li class="page-item disabled"><a href="#" class="page-link" data-page="prev">&laquo;</a></li>`;
        for (let i = 1; i <= totalPages; i++) {
            html += `<li class="page-item ${i === 1 ? 'active' : ''}"><a href="#" class="page-link" data-page="${i}">${i}</a></li>`;
        }
        html += `<li class="page-item ${totalPages <= 1 ? 'disabled' : ''}"><a href="#" class="page-link" data-page="next">&raquo;</a></li>`;
        
        paginationList.innerHTML = html;
        bindPaginationEvents(perPage, totalPages, totalRows, currentRows);
    }

    function bindPaginationEvents(perPage, totalPages, totalRows, currentRows) {
        let currentPage = 1;
        const pageLinks = paginationList.querySelectorAll('.page-link');
        
        pageLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                if (this.parentElement.classList.contains('disabled') || this.parentElement.classList.contains('active')) return;
                
                const page = this.getAttribute('data-page');
                if (page === 'prev') currentPage--;
                else if (page === 'next') currentPage++;
                else currentPage = parseInt(page);

                // Update visible rows
                const start = (currentPage - 1) * perPage;
                const end = start + perPage;
                
                currentRows.forEach((row, index) => {
                    if (index >= start && index < end) row.style.display = '';
                    else row.style.display = 'none';
                });

                updatePaginationInfo(currentPage, perPage, totalRows);

                // Update active states
                paginationList.querySelectorAll('.page-item').forEach(item => item.classList.remove('active'));
                const newActive = paginationList.querySelector(`[data-page="${currentPage}"]`).parentElement;
                newActive.classList.add('active');

                // Update prev/next disabled states
                paginationList.querySelector('[data-page="prev"]').parentElement.classList.toggle('disabled', currentPage === 1);
                paginationList.querySelector('[data-page="next"]').parentElement.classList.toggle('disabled', currentPage === totalPages);
            });
        });
    }

    if (perPageSelect) {
        perPageSelect.addEventListener('change', updatePagination);
        updatePagination(); // Run on load
    }
});
