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
                            <p>Already have an account? <a href="#">Log in</a></p>
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" placeholder="Email Address" required>
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
</script>

<?php require 'partials/footer.php'; ?>
