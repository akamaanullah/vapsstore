<?php ob_start(); ?>

<div class="account-addresses">
    <div class="welcome-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div>
            <h2>My Addresses</h2>
            <p>Manage your shipping addresses for a faster checkout experience.</p>
        </div>
        <button class="btn btn-primary" id="toggleAddressForm">
            <i data-lucide="plus"></i> Add New Address
        </button>
    </div>

    <!-- Add Address Form -->
    <div id="addressFormWrapper" class="address-form-container" style="display: none;">
        <h3>Add New Address</h3>
        <form id="addAddressForm" class="modern-form">
            <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
            <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" required>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" required>
                </div>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="phone" required>
            </div>
            <div class="form-group">
                <label>Street Address</label>
                <input type="text" name="street" placeholder="House number and street name" required>
            </div>
            <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" required>
                </div>
                <div class="form-group">
                    <label>Postal Code / ZIP</label>
                    <input type="text" name="zip" required>
                </div>
            </div>
            <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>State / Region</label>
                    <input type="text" name="state">
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" name="country" value="United Kingdom" required>
                </div>
            </div>
            <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-top: 10px;">
                <input type="checkbox" name="is_default" id="is_default" style="width: auto; height: auto;">
                <label for="is_default" style="margin: 0; text-transform: none; font-weight: 500;">Set as default address</label>
            </div>
            <div class="form-footer" style="display: flex; gap: 15px; margin-top: 25px;">
                <button type="submit" class="btn btn-primary" id="saveAddressBtn">Save Address</button>
                <button type="button" class="btn btn-outline" id="cancelAddressBtn">Cancel</button>
            </div>
        </form>
    </div>

    <!-- Address List -->
    <div class="address-grid">
        <?php if (empty($addresses)): ?>
            <div class="empty-orders-state" style="grid-column: 1/-1;">
                <div class="empty-icon">
                    <i data-lucide="map-pin"></i>
                </div>
                <p>No addresses saved yet.</p>
            </div>
        <?php else: ?>
            <?php foreach ($addresses as $address): ?>
                <div class="address-card">
                    <?php if ($address['is_default']): ?>
                        <span class="default-badge">Default</span>
                    <?php endif; ?>
                    
                    <h4><?= htmlspecialchars($address['first_name'] . ' ' . $address['last_name']) ?></h4>
                    <p><?= htmlspecialchars($address['street']) ?></p>
                    <p><?= htmlspecialchars($address['city']) ?>, <?= htmlspecialchars($address['zip']) ?></p>
                    <p><?= htmlspecialchars($address['country']) ?></p>
                    <div class="address-phone">
                        <i data-lucide="phone"></i> <?= htmlspecialchars($address['phone']) ?>
                    </div>
                    
                    <div class="address-actions">
                        <?php if (!$address['is_default']): ?>
                            <button onclick="setDefaultAddress(<?= $address['id'] ?>)" class="address-action-btn btn-set-default">Set as Default</button>
                        <?php endif; ?>
                        <button onclick="deleteAddress(<?= $address['id'] ?>)" class="address-action-btn btn-delete-address">Delete</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('toggleAddressForm');
    const formWrapper = document.getElementById('addressFormWrapper');
    const cancelBtn = document.getElementById('cancelAddressBtn');
    const form = document.getElementById('addAddressForm');

    toggleBtn?.addEventListener('click', () => {
        formWrapper.style.display = 'block';
        toggleBtn.style.display = 'none';
        formWrapper.scrollIntoView({ behavior: 'smooth' });
    });

    cancelBtn?.addEventListener('click', () => {
        formWrapper.style.display = 'none';
        toggleBtn.style.display = 'inline-flex';
    });

    form?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = document.getElementById('saveAddressBtn');
        if (typeof UI !== 'undefined') UI.setLoading(btn, true);

        const formData = new FormData(form);
        try {
            const response = await fetch(`${BASE_URL}/api/account/address/add`, {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true
                });
                setTimeout(() => window.location.reload(), 1000);
            } else {
                Swal.fire('Error!', data.message, 'error');
                if (typeof UI !== 'undefined') UI.setLoading(btn, false);
            }
        } catch (error) {
            Swal.fire('Error!', 'Something went wrong!', 'error');
            if (typeof UI !== 'undefined') UI.setLoading(btn, false);
        }
    });
});

async function deleteAddress(id) {
    const result = await Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#bd0028',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it!'
    });

    if (!result.isConfirmed) return;
    
    try {
        const formData = new FormData();
        formData.append('id', id);
        
        const response = await fetch(`${BASE_URL}/api/account/address/delete`, {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            });
            setTimeout(() => window.location.reload(), 1500);
        }
    } catch (error) {
        Swal.fire('Error!', 'Failed to delete address.', 'error');
    }
}

async function setDefaultAddress(id) {
    try {
        const formData = new FormData();
        formData.append('id', id);
        
        const response = await fetch(`${BASE_URL}/api/account/address/default`, {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false,
                position: 'top-end',
                toast: true
            });
            setTimeout(() => window.location.reload(), 1000);
        }
    } catch (error) {
        Swal.fire('Error!', 'Failed to update default address.', 'error');
    }
}
</script>

<?php 
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
