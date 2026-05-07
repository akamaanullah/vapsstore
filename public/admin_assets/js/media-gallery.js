/**
 * Media Gallery - Admin JavaScript
 * All DOM interactions, upload logic, and modal management.
 * BASE_URL is passed from the PHP view via window.MEDIA_BASE_URL
 */

document.addEventListener('DOMContentLoaded', () => {

    const BASE = window.MEDIA_BASE_URL || '';
    const fileInput     = document.getElementById('mediaFileInput');
    const uploadTrigger = document.getElementById('uploadTrigger');
    const uploadOverlay = document.getElementById('uploadOverlay');
    const progressBar   = document.getElementById('uploadProgressBar');
    const statusText    = document.getElementById('uploadStatusText');

    // ── Upload ────────────────────────────────────────────────
    uploadTrigger.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', (e) => {
        const files = e.target.files;
        if (!files.length) return;

        uploadOverlay.style.display = 'flex';
        progressBar.style.width = '0%';

        const formData = new FormData();
        for (const file of files) formData.append('files[]', file);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', BASE + '/admin/media/upload', true);

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (csrfToken) {
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        }

        xhr.upload.addEventListener('progress', (ev) => {
            if (ev.lengthComputable) {
                progressBar.style.width = Math.round((ev.loaded / ev.total) * 100) + '%';
            }
        });

        xhr.addEventListener('load', () => {
            try {
                JSON.parse(xhr.responseText); // validate JSON
                window.location.reload();
            } catch {
                statusText.textContent = 'Upload failed. Please check server logs.';
                setTimeout(() => { uploadOverlay.style.display = 'none'; }, 3000);
            }
        });

        xhr.addEventListener('error', () => {
            statusText.textContent = 'Network error during upload.';
            setTimeout(() => { uploadOverlay.style.display = 'none'; }, 3000);
        });

        xhr.send(formData);
    });

    // ── Modal ─────────────────────────────────────────────────
    const overlay = document.getElementById('mediaModal');
    const previewImg   = document.getElementById('modalPreviewImg');
    const fileUrlInput = document.getElementById('modalFileUrl');
    const modalName    = document.getElementById('modalMediaName');
    const modalSize    = document.getElementById('modalFileSize');
    const modalDim     = document.getElementById('modalFileDim');
    const modalDelBtn  = document.getElementById('modalDeleteBtn');

    function openModal(item) {
        const { url, name, size, dimensions, id } = item.dataset;
        modalName.textContent      = name;
        previewImg.src             = url;
        fileUrlInput.value         = url;
        modalSize.textContent      = size;
        modalDim.textContent       = dimensions;
        modalDelBtn.onclick        = () => deleteMedia(id);
        overlay.classList.add('active');
    }

    function closeModal() {
        overlay.classList.remove('active');
        previewImg.src = '';
    }

    document.getElementById('modalCloseBtn').addEventListener('click', closeModal);
    overlay.addEventListener('click', (e) => { if (e.target === overlay) closeModal(); });

    // Open modal on card click (not action buttons)
    document.querySelectorAll('.media-item').forEach(item => {
        item.addEventListener('click', (e) => {
            if (e.target.closest('.media-actions')) return;
            openModal(item);
        });
    });

    // ── Copy URL (grid button) ────────────────────────────────
    document.querySelectorAll('.copy-url').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            copyToClipboard(btn.closest('.media-item').dataset.url, btn);
        });
    });

    // ── Copy URL (modal button) ───────────────────────────────
    document.getElementById('modalCopyBtn').addEventListener('click', function () {
        copyToClipboard(fileUrlInput.value, this);
    });

    // ── Delete ────────────────────────────────────────────────
    async function deleteMedia(id) {
        const result = await Swal.fire({
            title: 'Delete Asset?',
            text: 'This image will be permanently removed from the server.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it!'
        });
        if (!result.isConfirmed) return;

        try {
            const res  = await fetch(BASE + `/admin/media/delete/${id}`, { method: 'POST' });
            const data = await res.json();
            if (data.success) {
                Swal.fire({
                    title: 'Deleted!', icon: 'success',
                    toast: true, position: 'top-end',
                    showConfirmButton: false, timer: 2500
                });
                closeModal();
                setTimeout(() => window.location.reload(), 600);
            }
        } catch {
            Swal.fire('Error', 'Delete failed. Please try again.', 'error');
        }
    }

    // Grid-level delete buttons
    document.querySelectorAll('.delete-media').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            deleteMedia(btn.closest('.media-item').dataset.id);
        });
    });

});

// ── Clipboard helper ──────────────────────────────────────────
function copyToClipboard(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const orig = btn.innerHTML;
        btn.innerHTML = '<i data-lucide="check"></i>';
        if (window.lucide) window.lucide.createIcons();
        setTimeout(() => {
            btn.innerHTML = orig;
            if (window.lucide) window.lucide.createIcons();
        }, 2000);
    });
}
