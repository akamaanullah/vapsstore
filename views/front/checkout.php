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
                    <!-- Contact Information -->
                    <div class="form-section">
                        <div class="section-header">
                            <h3>Contact Information</h3>
                            <p>Already have an account? <a href="#">Log in</a></p>
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" placeholder="Email Address" required>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="newsletter">
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
                                <input type="text" id="fname" placeholder="First Name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="lname" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" id="address" placeholder="Address" required>
                        </div>
                        <div class="form-group">
                            <input type="text" id="apartment" placeholder="Apartment, suite, etc. (optional)">
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <input type="text" id="city" placeholder="City" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="postal" placeholder="Postal Code" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="tel" id="phone" placeholder="Phone" required>
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
                                    <img src="https://cdn-icons-png.flaticon.com/512/349/349221.png" alt="Visa">
                                    <img src="https://cdn-icons-png.flaticon.com/512/349/349228.png" alt="Mastercard">
                                    <img src="https://cdn-icons-png.flaticon.com/512/349/349230.png" alt="Amex">
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
                                <input type="radio" name="billing_choice" id="same_address" checked>
                                <label for="same_address">Same as shipping address</label>
                            </div>
                            <div class="billing-option" onclick="toggleBilling(true)">
                                <input type="radio" name="billing_choice" id="diff_address">
                                <label for="diff_address">Use a different billing address</label>
                            </div>
                            
                            <!-- Hidden Billing Form -->
                            <div id="billingForm" class="billing-form-hidden">
                                <div class="form-group mt-20">
                                    <select class="modern-select">
                                        <option>United Kingdom</option>
                                        <option>United States</option>
                                        <option>Pakistan</option>
                                    </select>
                                </div>
                                <div class="form-grid">
                                    <div class="form-group"><input type="text" placeholder="First name (optional)"></div>
                                    <div class="form-group"><input type="text" placeholder="Last name"></div>
                                </div>
                                <div class="form-group"><input type="text" placeholder="Address"></div>
                                <div class="form-group"><input type="text" placeholder="Apartment, suite, etc. (optional)"></div>
                                <div class="form-grid">
                                    <div class="form-group"><input type="text" placeholder="City"></div>
                                    <div class="form-group"><input type="text" placeholder="Postcode"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-footer">
                        <button type="submit" class="btn-pay-now">Pay now</button>
                        <a href="collection.php" class="back-to-cart">Return to cart</a>
                    </div>
                </form>
            </div>

            <!-- Right Side: Order Summary -->
            <div class="checkout-summary-side">
                <div class="summary-card">
                    <div class="summary-items" id="checkoutItems">
                        <!-- Items will be loaded from localStorage -->
                    </div>



                    <div class="summary-totals">
                        <div class="total-row">
                            <span>Subtotal</span>
                            <span id="subtotal">£0.00</span>
                        </div>
                        <div class="total-row">
                            <span>Shipping</span>
                            <span>Calculated at next step</span>
                        </div>
                        <div class="total-row grand-total">
                            <span>Total</span>
                            <span class="final-price" id="total">£0.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Checkout specific logic to load cart items
    document.addEventListener('DOMContentLoaded', function() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const checkoutItems = document.getElementById('checkoutItems');
        const subtotalEl = document.getElementById('subtotal');
        const totalEl = document.getElementById('total');

        if (cart.length === 0) {
            window.location.href = 'collection.php';
            return;
        }

        let total = 0;
        checkoutItems.innerHTML = cart.map(item => {
            total += item.price * item.quantity;
            return `
                <div class="summary-item">
                    <div class="item-img">
                        <img src="${item.image}" alt="${item.name}">
                        <span class="item-qty-badge">${item.quantity}</span>
                    </div>
                    <div class="item-details">
                        <h4 class="item-name">${item.name}</h4>
                        ${item.variant_name ? `<span class="item-variant" style="font-size: 12px; color: #64748b;">${item.variant_name}</span>` : ''}
                    </div>
                    <div class="item-price">£${(item.price * item.quantity).toFixed(2)}</div>
                </div>
            `;
        }).join('');

        subtotalEl.innerText = `£${total.toFixed(2)}`;
        totalEl.innerText = `£${total.toFixed(2)}`;
    });

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
</script>

<?php require 'partials/footer.php'; ?>
