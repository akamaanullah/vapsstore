document.addEventListener('DOMContentLoaded', function() {
    console.log('Messages JS Loaded');

    // Modal Elements
    const messageModal = document.getElementById('messageModal');
    const closeModalBtns = [document.getElementById('closeModal'), document.getElementById('closeModalBtn')];
    const modalAvatar = document.getElementById('modalAvatar');
    const modalName = document.getElementById('modalName');
    const modalEmail = document.getElementById('modalEmail');
    const modalSubject = document.getElementById('modalSubject');
    const modalMessage = document.getElementById('modalMessage');
    const modalDate = document.getElementById('modalDate');

    // View Message Action - Using Event Delegation for better performance with filtered rows
    document.querySelector('.product-table tbody').addEventListener('click', function(e) {
        const btn = e.target.closest('.view-message-btn');
        if (btn) {
            const data = btn.dataset;
            
            // Populate Modal
            modalAvatar.textContent = data.avatar;
            modalName.textContent = data.name;
            modalEmail.textContent = data.email;
            modalSubject.textContent = data.subject;
            modalMessage.textContent = data.message;
            modalDate.textContent = data.date;

            // Show Modal
            messageModal.style.display = 'flex';
        }
    });

    // Close Modal Logic
    closeModalBtns.forEach(btn => {
        if (btn) {
            btn.addEventListener('click', () => {
                messageModal.style.display = 'none';
            });
        }
    });

    // Close on overlay click
    if (messageModal) {
        messageModal.addEventListener('click', (e) => {
            if (e.target === messageModal) {
                messageModal.style.display = 'none';
            }
        });
    }

    // Delete Message Action (if any delete buttons are added later, or targeting specific ones)
    const deleteBtns = document.querySelectorAll('.text-danger');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            Swal.fire({
                title: 'Delete Message?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    toastr.success('Message deleted successfully');
                    this.closest('tr').remove();
                    updatePagination();
                }
            });
        });
    });

    // Pagination & Search Logic
    const perPageSelect = document.querySelector('.per-page-select');
    const searchInput = document.querySelector('.search-input');
    const tableRows = document.querySelectorAll('.product-table tbody tr');
    const paginationList = document.querySelector('.pagination');
    const pageStartElem = document.querySelector('.pagination-info span:nth-child(1)');
    const pageEndElem = document.querySelector('.pagination-info span:nth-child(2)');
    const pageTotalElem = document.querySelector('.pagination-info span:nth-child(3)');

    let currentPage = 1;

    function updatePaginationInfo(current, perPage, total) {
        if (!pageStartElem) return;
        const start = total === 0 ? 0 : (current - 1) * perPage + 1;
        const end = Math.min(current * perPage, total);
        pageStartElem.textContent = start;
        pageEndElem.textContent = end;
        pageTotalElem.textContent = total;
    }

    function updatePagination() {
        const query = searchInput ? searchInput.value.toLowerCase() : '';
        const allRows = Array.from(document.querySelectorAll('.product-table tbody tr'));
        
        // Filter rows based on search
        const filteredRows = allRows.filter(row => {
            const text = row.textContent.toLowerCase();
            return text.includes(query);
        });

        const perPage = perPageSelect ? parseInt(perPageSelect.value) : 10;
        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / perPage);

        if (currentPage > totalPages && totalPages > 0) currentPage = totalPages;
        if (totalPages === 0) currentPage = 1;

        // Show/Hide rows
        allRows.forEach(row => row.style.display = 'none');
        const startIdx = (currentPage - 1) * perPage;
        const endIdx = startIdx + perPage;
        
        filteredRows.forEach((row, idx) => {
            if (idx >= startIdx && idx < endIdx) row.style.display = '';
        });

        updatePaginationInfo(currentPage, perPage, totalRows);
        renderPaginationButtons(totalPages);
    }

    function renderPaginationButtons(totalPages) {
        if (!paginationList) return;
        let html = '';
        
        // Prev
        html += `<li class="${currentPage === 1 ? 'disabled' : ''}"><a href="#" data-page="prev">&laquo;</a></li>`;
        
        // Numbers
        for (let i = 1; i <= totalPages; i++) {
            html += `<li class="${i === currentPage ? 'active' : ''}"><a href="#" data-page="${i}">${i}</a></li>`;
        }
        
        // Next
        html += `<li class="${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}"><a href="#" data-page="next">&raquo;</a></li>`;
        
        paginationList.innerHTML = html;

        // Bind events
        paginationList.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = this.getAttribute('data-page');
                if (page === 'prev' && currentPage > 1) currentPage--;
                else if (page === 'next' && currentPage < totalPages) currentPage++;
                else if (!isNaN(page)) currentPage = parseInt(page);
                
                updatePagination();
            });
        });
    }

    if (perPageSelect) perPageSelect.addEventListener('change', () => { currentPage = 1; updatePagination(); });
    if (searchInput) searchInput.addEventListener('input', () => { currentPage = 1; updatePagination(); });

    // Initial run
    updatePagination();
});
