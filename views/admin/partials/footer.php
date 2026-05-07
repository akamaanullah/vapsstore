            </main>
        </div>
    </div>

    <!-- jQuery (Needed for Toastr) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Common JS -->
    <script src="<?= BASE_URL ?>/admin_assets/js/common.js"></script>
    
    <?php if (isset($pageScript)): ?>
    <!-- Page Specific JS -->
    <?php if (is_array($pageScript)): ?>
        <?php foreach ($pageScript as $script): ?>
            <script src="<?= BASE_URL ?>/admin_assets/js/<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php else: ?>
        <script src="<?= BASE_URL ?>/admin_assets/js/<?php echo $pageScript; ?>"></script>
    <?php endif; ?>
    <script>
        // Collection requirement check (Only for Product pages)
        document.querySelector('form#productForm')?.addEventListener('submit', function(e) {
            const collections = document.querySelectorAll('input[name="collection_ids[]"]');
            if (collections.length === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Collection Required',
                    text: 'Please select at least one collection for this product.',
                    confirmButtonColor: '#6f6af8'
                });
            }
        });
    </script>
    <?php endif; ?>
    <!-- Initialize Lucide -->
    <script>
      lucide.createIcons();
    </script>
</body>

</html>
