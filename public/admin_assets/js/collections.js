document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('collectionSearch');
    const tableRows = document.querySelectorAll('.collection-row');

    // 1. Live Search Logic
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            
            tableRows.forEach(row => {
                const text = row.innerText.toLowerCase();
                if (text.includes(query)) {
                    row.style.setProperty('display', '', 'important');
                } else {
                    row.style.setProperty('display', 'none', 'important');
                }
            });
        });
    }

    // 2. SweetAlert Delete Confirmation
    const deleteForms = document.querySelectorAll('.delete-collection-form');
    deleteForms.forEach(form => {
        const deleteBtn = form.querySelector('.delete-btn');
        deleteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Are you sure?',
                text: "All products will be unlinked from this collection!",
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
    });
});
