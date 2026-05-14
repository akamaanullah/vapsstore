<?php
$pageTitle = "Checkout | The Perfect Vape";
$noIndex = true;
require 'partials/header.php';
?>

<main class="checkout-page">
    <div class="container">
        <div class="checkout-wrapper">
            <!-- Left Side: Form Information -->
            <div class="checkout-form-side">
                <nav class="breadcrumb">
                    <a href="index.php">Home</a> / <a href="collection.php">Cart</a> / <span>Checkout</span>
                </nav>

                <form id="checkoutForm" class="modern-form">
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
                    <!-- Contact Information -->
                    <div class="form-section">
                        <div class="section-header">
                            <h3>Contact Information</h3>
                            <?php if (!$userId): ?>
                                <p>Already have an account? <a href="<?= BASE_URL ?>/login">Log in</a></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" placeholder="Email Address" value="<?= htmlspecialchars($userEmail ?? '') ?>" required <?= $userId ? 'readonly style="background: #f9fafb; color: #6b7280; cursor: not-allowed;"' : '' ?>>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="newsletter" name="newsletter">
                            <label for="newsletter">Email me with news and offers</label>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="form-section">
                        <div class="section-header">
                            <h3>Shipping Address</h3>
                        </div>

                        <?php if (!empty($userAddresses)): ?>
                        <div class="billing-container" style="margin-bottom: 24px;">
                            <!-- Option: Saved Address -->
                            <div class="billing-option active" id="opt_saved_shipping" onclick="toggleShippingMode('saved')">
                                <input type="radio" name="shipping_mode" id="mode_saved" value="saved" checked>
                                <label for="mode_saved">Use a saved address</label>
                            </div>
                            
                            <!-- Display for Saved Addresses -->
                            <div id="savedShippingSelect" style="padding: 16px 20px; border-bottom: 1px solid #f3f4f6; background: #fafafa; display: flex; justify-content: space-between; align-items: flex-start;">
                                <div class="selected-address-display" id="selectedAddressDisplay" style="font-size: 14px; line-height: 1.5; color: #374151;">
                                    <!-- Address will be injected here via JS -->
                                </div>
                                <button type="button" onclick="showSavedAddressesModal()" style="background: none; border: 1px solid #d1d5db; border-radius: 6px; padding: 6px 12px; font-size: 12px; font-weight: 600; color: #111827; cursor: pointer; transition: all 0.2s;">Change</button>
                            </div>

                            <!-- Option: New Address -->
                            <div class="billing-option" id="opt_new_shipping" onclick="toggleShippingMode('new')">
                                <input type="radio" name="shipping_mode" id="mode_new" value="new">
                                <label for="mode_new">Use a new address</label>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- The Actual Form Fields (Hidden if 'saved' is active) -->
                        <div id="shippingFormFields" class="<?= !empty($userAddresses) ? 'billing-form-hidden' : '' ?>">
                            <div class="form-grid">
                            <div class="form-group">
                                <input type="text" id="fname" name="fname" placeholder="First Name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="lname" name="lname" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" id="address" name="address" placeholder="Address" required>
                        </div>
                        <div class="form-group">
                            <input type="text" id="apartment" name="apartment" placeholder="Apartment, suite, etc. (optional)">
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <input type="text" id="city" name="city" placeholder="City" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="postal" name="postal" placeholder="Postal Code" required>
                            </div>
                        </div>
                            <div class="form-group">
                                <input type="tel" id="phone" name="phone" placeholder="Phone" required>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <h3>Payment</h3>
                            <p>All transactions are secure and encrypted.</p>
                        </div>
                        <div class="payment-container">
                            <div class="payment-method-header">
                                <span>Pay with Card (Worldpay)</span>
                                <div class="card-icons">
                                    <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa">
                                    <img src="https://img.icons8.com/color/48/000000/mastercard.png" alt="Mastercard">
                                    <img src="https://img.icons8.com/color/48/000000/amex.png" alt="Amex">
                                </div>
                            </div>
                            <div class="payment-method-info">
                                <p>You'll be redirected to Pay with Card (Worldpay) to complete your purchase.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Address Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <h3>Billing address</h3>
                        </div>
                        <div class="billing-container">
                            <div class="billing-option active" onclick="toggleBilling(false)">
                                <input type="radio" name="billing_choice" id="same_address" value="same" checked>
                                <label for="same_address">Same as shipping address</label>
                            </div>
                            <div class="billing-option" onclick="toggleBilling(true)">
                                <input type="radio" name="billing_choice" id="diff_address" value="different">
                                <label for="diff_address">Use a different billing address</label>
                            </div>
                            
                            <!-- Hidden Billing Form -->
                            <div id="billingForm" class="billing-form-hidden">
                                <div class="form-group mt-20">
                                    <select class="modern-select" name="billing_country">
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United States">United States</option>
                                        <option value="Pakistan">Pakistan</option>
                                    </select>
                                </div>
                                <div class="form-grid">
                                    <div class="form-group"><input type="text" name="billing_fname" placeholder="First name (optional)"></div>
                                    <div class="form-group"><input type="text" name="billing_lname" placeholder="Last name"></div>
                                </div>
                                <div class="form-group"><input type="text" name="billing_address" placeholder="Address"></div>
                                <div class="form-group"><input type="text" name="billing_apartment" placeholder="Apartment, suite, etc. (optional)"></div>
                                <div class="form-grid">
                                    <div class="form-group"><input type="text" name="billing_city" placeholder="City"></div>
                                    <div class="form-group"><input type="text" name="billing_postal" placeholder="Postcode"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-footer">
                        <button type="submit" class="btn-pay-now" id="btnPlaceOrder">Pay now</button>
                        <a href="<?= BASE_URL ?>/cart" class="back-to-cart">Return to cart</a>
                    </div>
                </form>
            </div>

            <!-- Right Side: Order Summary -->
            <div class="checkout-summary-side">
                <div class="summary-card">
                    <div class="summary-items" id="checkoutItems">
                        <?php foreach ($cart as $item): ?>
                        <div class="summary-item">
                            <div class="item-img">
                                <img src="<?= htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                <span class="item-qty-badge"><?= $item['quantity'] ?></span>
                            </div>
                            <div class="item-details">
                                <h4 class="item-name"><?= htmlspecialchars($item['name']) ?></h4>
                                <?php if (!empty($item['variant_name'])): ?>
                                    <span class="item-variant" style="font-size: 12px; color: #64748b;"><?= htmlspecialchars($item['variant_name']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="item-price">£<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="summary-totals">
                        <div class="total-row">
                            <span>Subtotal</span>
                            <span id="subtotal">£<?= number_format($subtotal, 2) ?></span>
                        </div>
                        <div class="total-row">
                            <span>Shipping</span>
                            <span>Calculated at next step</span>
                        </div>
                        <div class="total-row grand-total">
                            <span>Total</span>
                            <span class="final-price" id="total">£<?= number_format($subtotal, 2) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Toggle Billing Address Form
    function toggleBilling(isDifferent) {
        const billingForm = document.getElementById('billingForm');
        const options = document.querySelectorAll('.billing-option');
        
        if (isDifferent) {
            billingForm.classList.add('show');
            options[1].classList.add('active');
            options[0].classList.remove('active');
            document.getElementById('diff_address').checked = true;
        } else {
            billingForm.classList.remove('show');
            options[0].classList.add('active');
            options[1].classList.remove('active');
            document.getElementById('same_address').checked = true;
        }
    }
    // Handle Checkout Submission
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const btn = document.getElementById('btnPlaceOrder');
        if (typeof UI !== 'undefined') UI.setLoading(btn, true);

        const formData = new FormData(this);

        fetch(BASE_URL + '/api/checkout/place', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                if (typeof UI !== 'undefined') UI.setLoading(btn, false);
                Swal.fire('Checkout Error', data.message || 'Something went wrong.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof UI !== 'undefined') UI.setLoading(btn, false);
            Swal.fire('Connection Error', 'Failed to place order. Please check your connection.', 'error');
        });
    });

    // Handle Saved Address Selection Auto-Fill
    const userAddresses = <?= !empty($userAddresses) ? json_encode($userAddresses) : '[]' ?>;
    let selectedAddressIndex = 0; // Default to first (which is sorted to be the default one)

    document.addEventListener('DOMContentLoaded', function() {
        const formFields = document.getElementById('shippingFormFields');
        const inputs = formFields ? formFields.querySelectorAll('input') : [];
        const displayBox = document.getElementById('selectedAddressDisplay');
        
        function fillAddressData(index) {
            if (index === null || index === '') {
                ['fname', 'lname', 'address', 'city', 'postal', 'phone'].forEach(f => {
                    const el = document.getElementById(f);
                    if (el) el.value = '';
                });
                const apt = document.getElementById('apartment');
                if (apt) apt.value = '';
                return;
            }

            const addr = userAddresses[index];
            if (!addr) return;

            const mapping = {
                'fname': addr.first_name,
                'lname': addr.last_name,
                'phone': addr.phone,
                'address': addr.street,
                'city': addr.city,
                'postal': addr.zip
            };

            for (const [id, val] of Object.entries(mapping)) {
                const el = document.getElementById(id);
                if (el) el.value = val || '';
            }
            const apt = document.getElementById('apartment');
            if (apt) apt.value = '';

            if (displayBox) {
                displayBox.innerHTML = `
                    <div style="font-weight: 600; color: #111827; margin-bottom: 4px;">${addr.first_name} ${addr.last_name}</div>
                    <div>${addr.street}</div>
                    <div>${addr.city}, ${addr.zip}</div>
                    <div style="margin-top: 4px; color: #6b7280;">${addr.phone}</div>
                `;
            }
        }

        window.selectSavedAddress = function(index) {
            selectedAddressIndex = index;
            fillAddressData(index);
            Swal.close();
            
            if (displayBox) {
                displayBox.parentElement.style.transition = 'background-color 0.3s ease';
                displayBox.parentElement.style.backgroundColor = '#f0fdf4';
                setTimeout(() => displayBox.parentElement.style.backgroundColor = '#fafafa', 500);
            }
        };

        window.showSavedAddressesModal = function() {
            let html = `
                <style>
                    .custom-modal-scroll::-webkit-scrollbar { width: 6px; }
                    .custom-modal-scroll::-webkit-scrollbar-track { background: transparent; }
                    .custom-modal-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
                    .custom-modal-scroll::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
                </style>
                <div class="custom-modal-scroll" style="text-align: left; max-height: 400px; overflow-y: auto; padding-right: 14px; margin-right: -4px;">
            `;
            userAddresses.forEach((addr, i) => {
                const isSelected = i === selectedAddressIndex;
                html += `
                    <div onclick="selectSavedAddress(${i})" style="padding: 16px; border: 2px solid ${isSelected ? '#bd0028' : '#e5e7eb'}; margin-bottom: 12px; border-radius: 8px; cursor: pointer; transition: all 0.2s; background: ${isSelected ? '#fdf2f2' : '#fff'};">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                            <strong style="font-size: 15px; color: #111827;">${addr.first_name} ${addr.last_name}</strong>
                            ${addr.is_default == 1 ? '<span style="background: #e5e7eb; padding: 2px 8px; font-size: 11px; border-radius: 12px; font-weight: 600;">Default</span>' : ''}
                        </div>
                        <div style="font-size: 14px; color: #4b5563; line-height: 1.5;">
                            ${addr.street}<br>
                            ${addr.city}, ${addr.zip}<br>
                            ${addr.phone}
                        </div>
                    </div>
                `;
            });
            html += '</div>';

            Swal.fire({
                title: '<h3 style="font-size: 20px; font-weight: 700; color: #111827; margin: 0; text-align: left;">Your Saved Addresses</h3>',
                html: html,
                showConfirmButton: false,
                showCloseButton: true,
                width: '500px',
                padding: '24px'
            });
        };

        window.toggleShippingMode = function(mode) {
            const savedSelect = document.getElementById('savedShippingSelect');
            if (!savedSelect) return;
            
            document.getElementById('opt_saved_shipping').classList.remove('active');
            document.getElementById('opt_new_shipping').classList.remove('active');

            if (mode === 'saved') {
                document.getElementById('mode_saved').checked = true;
                document.getElementById('opt_saved_shipping').classList.add('active');
                savedSelect.style.display = 'flex';
                formFields.classList.add('billing-form-hidden');
                
                inputs.forEach(i => i.removeAttribute('required'));
                fillAddressData(selectedAddressIndex);
            } else {
                document.getElementById('mode_new').checked = true;
                document.getElementById('opt_new_shipping').classList.add('active');
                savedSelect.style.display = 'none';
                formFields.classList.remove('billing-form-hidden');
                
                inputs.forEach(i => {
                    if(i.id !== 'apartment') i.setAttribute('required', 'true');
                });
                fillAddressData('');
            }
        };

        if (userAddresses.length > 0) {
            toggleShippingMode('saved');
        }
    });
</script>

<?php require 'partials/footer.php'; ?>
