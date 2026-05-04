document.addEventListener('DOMContentLoaded', function() {
    console.log('Customer Detail JS Loaded');

    // Handle Tag Deletion
    const tags = document.querySelectorAll('.tag i');
    tags.forEach(icon => {
        icon.addEventListener('click', function() {
            const tag = this.parentElement;
            tag.style.opacity = '0';
            setTimeout(() => {
                tag.remove();
                toastr.success('Tag removed successfully');
            }, 300);
        });
    });

    // Handle Save Note
    const saveNoteBtn = document.querySelector('.btn-outline.btn-sm.mt-10');
    if (saveNoteBtn) {
        saveNoteBtn.addEventListener('click', function() {
            const noteArea = document.querySelector('textarea');
            if (noteArea.value.trim() !== '') {
                toastr.success('Note saved successfully');
                // Here you would typically send an AJAX request to save the note
            } else {
                toastr.warning('Please enter a note first');
            }
        });
    }

    // Handle Send Email
    const sendEmailBtn = document.querySelector('.btn-outline i[data-lucide="mail"]').parentElement;
    if (sendEmailBtn) {
        sendEmailBtn.addEventListener('click', function() {
            toastr.info('Opening email composer for Alice Johnson...');
        });
    }
});
