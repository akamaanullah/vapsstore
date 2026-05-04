document.addEventListener('DOMContentLoaded', function() {
    console.log('Blogs JS Loaded');

    const deleteBtns = document.querySelectorAll('.delete-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            Swal.fire({
                title: 'Delete Blog?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e16449',
                cancelButtonColor: '#a3a3a3',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    toastr.error('Blog has been deleted.');
                    this.closest('.blog-card').remove();
                }
            });
        });
    });

    const editBtns = document.querySelectorAll('.edit-btn');
    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            toastr.info('Opening blog editor...');
        });
    });
});
