<?php 
include 'partials/header.php'; 
?>

<main class="cart-page">
    <div class="container">
        <div class="section-header">
            <h1 class="text-32 fw-bold">Your Shopping Cart</h1>
            <p class="text-muted">Review your selections and proceed to checkout.</p>
        </div>

        <div class="cart-content-grid" id="cartContentGrid">
            <?php if (empty($cart['items'])): ?>
                <div class="empty-cart-full py-80 text-center w-100" style="grid-column: 1 / -1; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #fff; border-radius: 12px; border: 1px solid #eee; box-shadow: 0 5px 15px rgba(0,0,0,0.02);">
                    <div class="empty-cart-icon-wrapper" style="width: 110px; height: 110px; background: #fff5f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 25px;">
                        <i data-lucide="shopping-bag" style="width: 48px; height: 48px; color: #bd0028;"></i>
                    </div>
                    <h2 class="text-28 fw-bold mb-10" style="color: #111;">Your cart is empty</h2>
                    <p class="text-muted mb-35" style="max-width: 420px; line-height: 1.5; font-size: 16px;">Looks like you haven't added anything to your cart yet. Explore our premium collection and find something you love.</p>
                    <a href="<?= BASE_URL ?>/collection" class="btn-checkout-premium" style="width: auto; padding: 16px 45px; text-decoration: none; border-radius: 4px; font-size: 14px;">START SHOPPING</a>
                </div>
            <?php else: ?>
                <div class="cart-main-area">
                    <div class="cart-table-header">
                        <div>Product</div>
                        <div>Price</div>
                        <div>Quantity</div>
                        <div class="text-right">Total</div>
                    </div>

                    <div class="cart-items-list" id="fullCartItems">
                        <?php foreach ($cart['items'] as $item): ?>
                        <div class="cart-row" data-cart-key="<?= $item['product_id'] ?>-<?= $item['variant_id'] ?>">
                            <div class="col-product">
                                <div class="cart-product-info">
                                    <div class="cart-img-box">
                                        <img src="<?= htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                    </div>
                                    <div class="cart-item-details">
                                        <h3><a href="<?= BASE_URL ?>/product/<?= $item['url'] ?>"><?= htmlspecialchars($item['name']) ?></a></h3>
                                        <?php if (!empty($item['variant_name'])): ?>
                                            <span class="variant-tag"><?= htmlspecialchars($item['variant_name']) ?></span>
                                        <?php endif; ?>
                                        <div class="mobile-only mt-10">
                                            <span class="fw-bold">£<?= number_format($item['price'], 2) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-price desktop-only">
                                <span class="text-18 fw-500">£<?= number_format($item['price'], 2) ?></span>
                            </div>
                            <div class="col-qty">
                                <div class="cart-qty-picker">
                                    <button class="cart-qty-btn minus">-</button>
                                    <input type="number" class="cart-qty-input" value="<?= $item['quantity'] ?>" readonly>
                                    <button class="cart-qty-btn plus">+</button>
                                </div>
                            </div>
                            <div class="col-total">
                                <div class="cart-total-wrapper">
                                    <span class="text-18 fw-700">£<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                                    <button class="btn-remove-icon btn-remove-item" title="Remove Item">
                                        <i data-lucide="trash-2" size="18"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="cart-summary-sidebar">
                    <div class="cart-summary-card">
                        <h2 class="summary-title">Order Summary</h2>
                        <div class="summary-list">
                            <div class="summary-item">
                                <span>Subtotal</span>
                                <span class="full-subtotal fw-bold"><?= $cart['formatted_subtotal'] ?></span>
                            </div>
                            <div class="summary-item">
                                <span>Estimated Shipping</span>
                                <span class="text-success">FREE</span>
                            </div>
                            <div class="summary-item">
                                <span>Tax</span>
                                <span>Included</span>
                            </div>
                            <div class="summary-item total">
                                <span>Total</span>
                                <span class="full-total"><?= $cart['formatted_subtotal'] ?></span>
                            </div>
                        </div>
                        
                        <a href="<?= BASE_URL ?>/checkout" class="btn-checkout-premium">Proceed to Checkout</a>
                        
                        <a href="<?= BASE_URL ?>/collection" class="continue-shopping-link">
                            <i data-lucide="arrow-left" size="14"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'partials/footer.php'; ?>
