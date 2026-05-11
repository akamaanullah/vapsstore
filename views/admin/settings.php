<?php 
$pageTitle = "Settings | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 

// Helper to get setting value safely
$get = function($key) use ($settings) {
    return htmlspecialchars($settings[$key] ?? '');
};

// Image helper for previews
$img = function($key, $default) use ($settings) {
    $val = $settings[$key] ?? '';
    if (empty($val)) return BASE_URL . '/' . $default;
    return (strpos($val, 'http') === 0) ? $val : BASE_URL . '/' . $val;
};
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <h1 class="m-0">Global Settings</h1>
    </div>
    <div class="header-actions">
        <button id="saveSettingsBtn" class="btn btn-primary">
            <i data-lucide="save"></i>
            <span>Save All Changes</span>
        </button>
    </div>
</div>

<div class="form-layout">
    <div class="form-main">
        <!-- Store Details -->
        <div class="card">
            <h3 class="card-title-sm mb-20">Store Details</h3>
            <div class="form-group">
                <label>Store Name</label>
                <input type="text" data-key="store_name" class="modal-field-input setting-input" value="<?= $get('store_name') ?: 'The Perfect Vape' ?>">
            </div>
            <div class="form-group-row">
                <div class="form-group">
                    <label>Store Email</label>
                    <input type="email" data-key="store_email" class="modal-field-input setting-input" value="<?= $get('store_email') ?: 'info@theperfectvape.com' ?>">
                </div>
                <div class="form-group">
                    <label>Store Phone</label>
                    <input type="text" data-key="store_phone" class="modal-field-input setting-input" value="<?= $get('store_phone') ?: '+44 20 7123 4567' ?>">
                </div>
            </div>
            <div class="form-group">
                <label>Store Address</label>
                <input type="text" data-key="store_address" class="modal-field-input setting-input" value="<?= $get('store_address') ?: "15 St Oswald's Street, Liverpool, L13 5SA" ?>">
            </div>
            <div class="form-group mb-0">
                <label>Copyright Text (Footer)</label>
                <input type="text" data-key="footer_copyright" class="modal-field-input setting-input" value="<?= $get('footer_copyright') ?: '© 2025 The Perfect Vape. All Rights Reserved. | Designed, Developed & Managed By Antigravity' ?>">
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="card">
            <h3 class="card-title-sm mb-20">Payment Methods (Logos)</h3>
            <p class="text-muted-sm mb-15">Enter the image paths or URLs for your payment methods. Leave blank to hide.</p>
            <div class="form-group-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <?php for($i=1; $i<=8; $i++): 
                    $key = "payment_logo_$i";
                    $default = "assets/footer/Logos-0" . ($i == 6 ? '7' : ($i == 7 ? '8' : ($i == 8 ? '10' : $i))) . ".png";
                    if ($i >= 6) { // Adjust for the skipped numbers in original files
                        $default = "assets/footer/Logos-" . (sprintf('%02d', $i == 6 ? 7 : ($i == 7 ? 8 : 10))) . ".png";
                    } else {
                        $default = "assets/footer/Logos-0$i.png";
                    }
                ?>
                <div class="form-group mb-0">
                    <label>Logo <?= $i ?></label>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <img src="<?= $settings[$key] ?? BASE_URL . '/' . $default ?>" style="height: 30px; width: 45px; object-fit: contain; background: #333; padding: 2px; border-radius: 4px;" onerror="this.style.display='none'">
                        <input type="text" data-key="<?= $key ?>" class="modal-field-input setting-input" value="<?= $get($key) ?: $default ?>" oninput="this.previousElementSibling.src=this.value.startsWith('http') ? this.value : '<?= BASE_URL ?>/' + this.value; this.previousElementSibling.style.display='block'">
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <!-- Branding -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Branding</h3>
            <div class="form-group">
                <label>Main Store Logo</label>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div style="background: #333; padding: 10px; border-radius: 8px; display: flex; justify-content: center;">
                        <img src="<?= $settings['store_logo'] ?? BASE_URL . '/assets/image/theperfectvape.png' ?>" style="max-height: 40px; max-width: 100%;" onerror="this.src='https://placehold.co/200x50?text=Logo'">
                    </div>
                    <input type="text" data-key="store_logo" class="modal-field-input setting-input" value="<?= $get('store_logo') ?: 'assets/image/theperfectvape.png' ?>" oninput="this.previousElementSibling.firstElementChild.src=this.value.startsWith('http') ? this.value : '<?= BASE_URL ?>/' + this.value">
                </div>
            </div>
            <div class="form-group mb-0">
                <label>Favicon URL</label>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="<?= $img('store_favicon', 'favicon.ico') ?>" style="width: 32px; height: 32px; object-fit: contain; background: #eee; padding: 2px; border-radius: 4px;" onerror="this.src='https://placehold.co/32x32?text=F'">
                    <input type="text" data-key="store_favicon" class="modal-field-input setting-input" value="<?= $get('store_favicon') ?: 'favicon.ico' ?>" oninput="this.previousElementSibling.src=this.value.startsWith('http') ? this.value : '<?= BASE_URL ?>/' + this.value">
                </div>
            </div>
        </div>

        <!-- Global SEO -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Global SEO</h3>
            <div class="form-group">
                <label>Homepage Title</label>
                <input type="text" data-key="seo_home_title" class="modal-field-input setting-input" value="<?= $get('seo_home_title') ?: 'The Perfect Vape | Premium Vaping Supplies' ?>">
            </div>
            <div class="form-group mb-0">
                <label>Meta Description</label>
                <textarea data-key="seo_home_desc" class="modal-field-input setting-input" rows="3"><?= $get('seo_home_desc') ?: 'Find the best vapes, e-liquids, and accessories at The Perfect Vape. Fast shipping and premium quality guaranteed.' ?></textarea>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title-sm mb-15">Currency & Units</h3>
            <div class="form-group">
                <label>Store Currency</label>
                <select data-key="store_currency" class="modal-field-input setting-input">
                    <option value="USD" <?= ($settings['store_currency'] ?? '') == 'USD' ? 'selected' : '' ?>>USD ($)</option>
                    <option value="PKR" <?= ($settings['store_currency'] ?? '') == 'PKR' ? 'selected' : '' ?>>PKR (Rs)</option>
                    <option value="GBP" <?= ($settings['store_currency'] ?? '') == 'GBP' ? 'selected' : '' ?>>GBP (£)</option>
                </select>
            </div>
            <div class="form-group mb-0">
                <label>Weight Unit</label>
                <select data-key="store_weight_unit" class="modal-field-input setting-input">
                    <option value="kg" <?= ($settings['store_weight_unit'] ?? '') == 'kg' ? 'selected' : '' ?>>kg</option>
                    <option value="lb" <?= ($settings['store_weight_unit'] ?? '') == 'lb' ? 'selected' : '' ?>>lb</option>
                </select>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>

<script>
    document.getElementById('saveSettingsBtn').addEventListener('click', async function() {
        const btn = this;
        const oldHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i data-lucide="loader" class="spin"></i> <span>Saving...</span>';
        if (window.lucide) window.lucide.createIcons();

        const data = {};
        document.querySelectorAll('.setting-input').forEach(input => {
            data[input.dataset.key] = input.value;
        });

        try {
            const response = await fetch('<?= BASE_URL ?>/admin/settings/update', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.success) {
                Swal.fire({
                    title: 'Success',
                    text: 'Settings saved successfully!',
                    icon: 'success',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                Swal.fire('Error', result.message || 'Failed to save settings', 'error');
            }
        } catch (e) {
            Swal.fire('Error', e.message, 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = oldHtml;
            if (window.lucide) window.lucide.createIcons();
        }
    });
</script>
