<?php 
$pageTitle = "Settings | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Settings</h1>
    <button class="btn btn-primary">Save Changes</button>
</div>

<div class="form-layout">
    <div class="form-main">
        <div class="card">
            <h3 class="card-title-sm mb-20">Store Details</h3>
            <div class="form-group">
                <label>Store Name</label>
                <input type="text" class="modal-field-input" value="The Perfect Vape">
            </div>
            <div class="form-group">
                <label>Store Email</label>
                <input type="email" class="modal-field-input" value="contact@theperfectvape.com">
            </div>
            <div class="form-group mb-0">
                <label>Store Phone</label>
                <input type="text" class="modal-field-input" value="+1 (555) 000-0000">
            </div>
        </div>

        <div class="card">
            <h3 class="card-title-sm mb-20">Global SEO</h3>
            <div class="form-group">
                <label>Homepage Title</label>
                <input type="text" class="modal-field-input" value="The Perfect Vape | Premium Vaping Supplies">
            </div>
            <div class="form-group mb-0">
                <label>Homepage Meta Description</label>
                <textarea class="modal-field-input" rows="3">Find the best vapes, e-liquids, and accessories at The Perfect Vape. Fast shipping and premium quality guaranteed.</textarea>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <div class="card">
            <h3 class="card-title-sm mb-15">Currency & Units</h3>
            <div class="form-group">
                <label>Store Currency</label>
                <select class="modal-field-input">
                    <option selected>USD ($)</option>
                    <option>PKR (Rs)</option>
                    <option>GBP (£)</option>
                </select>
            </div>
            <div class="form-group mb-0">
                <label>Weight Unit</label>
                <select class="modal-field-input">
                    <option selected>kg</option>
                    <option>lb</option>
                </select>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
