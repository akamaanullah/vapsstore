document.addEventListener('DOMContentLoaded', () => {
    // 1. DOM Elements
    const cartToggle = document.getElementById('cartToggle');
    const cartClose = document.getElementById('cartClose');
    const cartSidebar = document.getElementById('cartSidebar');
    const cartOverlay = document.getElementById('cartOverlay');
    const cartItemsList = document.getElementById('cartItemsList');
    const cartFooter = document.getElementById('cartFooter');
    const cartTotalAmount = document.querySelector('.total-amount');
    const cartBadge = document.querySelectorAll('.cart-count');

    // 2. Open/Close Sidebar
    const openCart = () => {
        cartSidebar.classList.add('open');
        cartOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    };

    const closeCart = () => {
        cartSidebar.classList.remove('open');
        cartOverlay.classList.remove('show');
        document.body.style.overflow = '';
    };

    if (cartToggle) cartToggle.addEventListener('click', openCart);
    if (cartClose) cartClose.addEventListener('click', closeCart);
    if (cartOverlay) cartOverlay.addEventListener('click', closeCart);

    // 3. API & Security Helpers
    const escapeHtml = (unsafe) => {
        if (!unsafe) return '';
        return String(unsafe)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    };

    const apiCall = async (endpoint, method = 'GET', body = null) => {
        const options = {
            method: method,
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            }
        };

        if (body) {
            options.body = new FormData();
            for (const key in body) {
                options.body.append(key, body[key]);
            }
            // Include CSRF in body too for safety
            options.body.append('csrf_token', CSRF_TOKEN);
        }

        try {
            const response = await fetch(`${BASE_URL}${endpoint}`, options);
            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'API Error');
            return data;
        } catch (error) {
            console.error('Cart API Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Cart Error',
                text: error.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            return null;
        }
    };

    // 4. Update UI Centrally
    const updateUI = (cartData) => {
        if (!cartData) return;

        // Update Badge
        cartBadge.forEach(badge => {
            if (cartData.count > 0) {
                badge.textContent = cartData.count;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        });

        // Update Sidebar Items
        if (cartData.items.length === 0) {
            cartItemsList.innerHTML = `
                <div class="empty-cart-msg">
                    <i data-lucide="shopping-cart"></i>
                    <p>Your cart is empty</p>
                    <a href="${BASE_URL}/collection" class="btn-shop-now">Shop Our Collection</a>
                </div>
            `;
            cartFooter.style.display = 'none';

            // Handle Full Cart Page Empty State
            const fullGrid = document.getElementById('cartContentGrid');
            if (fullGrid) {
                fullGrid.innerHTML = `
                    <div class="empty-cart-full py-80 text-center w-100" style="grid-column: 1 / -1; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #fff; border-radius: 12px; border: 1px solid #eee; box-shadow: 0 5px 15px rgba(0,0,0,0.02);padding: 30px;">
                        <div class="empty-cart-icon-wrapper" style="width: 110px; height: 110px; background: #fff5f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 25px;">
                            <i data-lucide="shopping-bag" style="width: 48px; height: 48px; color: #bd0028;"></i>
                        </div>
                        <h2 class="text-28 fw-bold mb-10" style="color: #111;">Your cart is empty</h2>
                        <p class="text-muted mb-35" style="max-width: 420px; text-align: center; line-height: 1.5; font-size: 16px; margin-bottom: 20px;">Looks like you haven't added anything to your cart yet. Explore our premium collection and find something you love.</p>
                        <a href="${BASE_URL}/collection" class="btn-checkout-premium" style="width: auto; padding: 16px 45px; text-decoration: none; border-radius: 4px; font-size: 14px;">START SHOPPING</a>
                    </div>
                `;
                if (typeof lucide !== 'undefined') lucide.createIcons();
            }
        } else {
            cartFooter.style.display = 'block';
            cartItemsList.innerHTML = '';
            
            // Full Cart Page Items
            const fullCartItems = document.getElementById('fullCartItems');
            if (fullCartItems) fullCartItems.innerHTML = '';

            // Checkout Page Items
            const checkoutItems = document.getElementById('checkoutItems');
            if (checkoutItems) checkoutItems.innerHTML = '';

            cartData.items.forEach(item => {
                const cartKey = `${item.product_id}-${item.variant_id}`;
                const sidebarHTML = `
                    <div class="cart-item" data-cart-key="${cartKey}">
                        <div class="cart-item-img">
                            <img src="${escapeHtml(item.image)}" alt="${escapeHtml(item.name)}">
                        </div>
                        <div class="cart-item-info">
                            <a href="${BASE_URL}/product/${escapeHtml(item.url || item.product_id)}" class="cart-item-name">${escapeHtml(item.name)}</a>
                            <span class="cart-item-price">£${parseFloat(item.price).toFixed(2)}</span>
                            ${item.variant_name ? `<span class="cart-item-variant">${escapeHtml(item.variant_name)}</span>` : ''}
                            <div class="cart-item-controls">
                                <div class="cart-qty-toggle">
                                    <button class="cart-qty-btn minus">-</button>
                                    <input type="number" class="cart-qty-input" value="${item.quantity}" readonly>
                                    <button class="cart-qty-btn plus">+</button>
                                </div>
                                <button class="btn-remove-item">Remove</button>
                            </div>
                        </div>
                    </div>
                `;
                cartItemsList.insertAdjacentHTML('beforeend', sidebarHTML);

                if (fullCartItems) {
                    const rowHTML = `
                        <div class="cart-row" data-cart-key="${cartKey}">
                            <div class="col-product">
                                <div class="cart-product-info">
                                    <div class="cart-img-box">
                                        <img src="${escapeHtml(item.image)}" alt="${escapeHtml(item.name)}">
                                    </div>
                                    <div class="cart-item-details">
                                        <h3><a href="${BASE_URL}/product/${escapeHtml(item.url || item.product_id)}">${escapeHtml(item.name)}</a></h3>
                                        ${item.variant_name ? `<span class="variant-tag">${escapeHtml(item.variant_name)}</span>` : ''}
                                    </div>
                                </div>
                            </div>
                            <div class="col-price desktop-only">
                                <span class="text-18 fw-500">£${parseFloat(item.price).toFixed(2)}</span>
                            </div>
                            <div class="col-qty">
                                <div class="cart-qty-picker">
                                    <button class="cart-qty-btn minus">-</button>
                                    <input type="number" class="cart-qty-input" value="${item.quantity}" readonly>
                                    <button class="cart-qty-btn plus">+</button>
                                </div>
                            </div>
                            <div class="col-total">
                                <div class="cart-total-wrapper">
                                    <span class="text-18 fw-700">£${(parseFloat(item.price) * item.quantity).toFixed(2)}</span>
                                    <button class="btn-remove-icon btn-remove-item" title="Remove Item">
                                        <i data-lucide="trash-2" size="18"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    fullCartItems.insertAdjacentHTML('beforeend', rowHTML);
                }

                // Checkout Page Summary Item
                if (checkoutItems) {
                    const summaryHTML = `
                        <div class="summary-item">
                            <div class="item-img">
                                <img src="${escapeHtml(item.image)}" alt="${escapeHtml(item.name)}">
                                <span class="item-qty-badge">${item.quantity}</span>
                            </div>
                            <div class="item-details">
                                <h4 class="item-name">${escapeHtml(item.name)}</h4>
                                ${item.variant_name ? `<span class="item-variant" style="font-size: 12px; color: #64748b;">${escapeHtml(item.variant_name)}</span>` : ''}
                            </div>
                            <div class="item-price">£${(parseFloat(item.price) * item.quantity).toFixed(2)}</div>
                        </div>
                    `;
                    checkoutItems.insertAdjacentHTML('beforeend', summaryHTML);
                }
            });

            cartTotalAmount.textContent = cartData.formatted_subtotal;
            
            // Full Cart Summary
            const fullSubtotal = document.querySelector('.full-subtotal');
            const fullTotal = document.querySelector('.full-total');
            if (fullSubtotal) fullSubtotal.textContent = cartData.formatted_subtotal;
            if (fullTotal) fullTotal.textContent = cartData.formatted_subtotal;

            // Update Totals on Checkout Page
            const checkoutSubtotal = document.getElementById('subtotal');
            const checkoutTotal = document.getElementById('total');
            if (checkoutSubtotal) checkoutSubtotal.textContent = cartData.formatted_subtotal;
            if (checkoutTotal) checkoutTotal.textContent = cartData.formatted_subtotal;
        }
        
        lucide.createIcons();
    };

    // 5. Actions
    const addToCart = async (productId, variantId, quantity = 1, silent = false) => {
        const data = await apiCall('/api/cart/add', 'POST', {
            product_id: productId,
            variant_id: variantId || 0,
            quantity: quantity
        });

        if (data && data.success) {
            updateUI(data.cart);
            // Don't open sidebar if we are already on the cart page
            if (!silent && !window.location.pathname.includes('/cart')) openCart();
        }
        return data;
    };

    const updateQuantity = async (cartKey, quantity) => {
        const data = await apiCall('/api/cart/update', 'POST', {
            cart_key: cartKey,
            quantity: quantity
        });
        if (data && data.success) updateUI(data.cart);
    };

    const removeFromCart = async (cartKey) => {
        const data = await apiCall('/api/cart/remove', 'POST', {
            cart_key: cartKey
        });
        if (data && data.success) updateUI(data.cart);
    };

    // 6. Event Listeners
    const handleCartClick = (e) => {
        const itemRow = e.target.closest('.cart-item, .cart-row');
        if (!itemRow) return;
        const cartKey = itemRow.dataset.cartKey;
        const qtyInput = itemRow.querySelector('.cart-qty-input');
        let currentQty = parseInt(qtyInput.value);

        if (e.target.classList.contains('plus')) {
            updateQuantity(cartKey, currentQty + 1);
        } else if (e.target.classList.contains('minus')) {
            if (currentQty > 1) {
                updateQuantity(cartKey, currentQty - 1);
            } else {
                removeFromCart(cartKey);
            }
        } else if (e.target.closest('.btn-remove-item')) {
            removeFromCart(cartKey);
        }
    };

    if (cartItemsList) cartItemsList.addEventListener('click', handleCartClick);
    const fullCartItemsContainer = document.getElementById('fullCartItems');
    if (fullCartItemsContainer) fullCartItemsContainer.addEventListener('click', handleCartClick);

    document.addEventListener('click', (e) => {
        const addBtn = e.target.closest('.btn-buy, .btn-add-to-cart, .btn-buy-now, .btn-wishlist-cart');
        if (addBtn) {
            e.preventDefault();

            const card = addBtn.closest('.product-card');
            const slimCard = addBtn.closest('.product-embed-slim');
            const detailPage = document.querySelector('.product-detail-page');
            const wishlistRow = addBtn.closest('.wishlist-row');
            
            let productId, variantId, quantity;

            if (card) {
                productId = card.dataset.id;
                variantId = 0; // Will be resolved to default by server
                quantity = 1;
            } else if (slimCard) {
                productId = slimCard.dataset.productId;
                variantId = slimCard.querySelector('.slim-variant-select')?.value || 0;
                quantity = slimCard.querySelector('.qty-input')?.value || 1;
            } else if (detailPage) {
                productId = detailPage.dataset.productId;
                variantId = document.getElementById('variantSelect')?.value || 0;
                quantity = document.getElementById('qtyInput')?.value || 1;
            } else if (wishlistRow || addBtn.classList.contains('btn-wishlist-cart')) {
                productId = addBtn.dataset.id;
                variantId = 0; // Use default variant
                quantity = 1;
            } else {
                return;
            }

            const isBuyNow = addBtn.classList.contains('btn-buy-now') || addBtn.id === 'buyNowDetail';
            
            if (typeof UI !== 'undefined') UI.setLoading(addBtn, true);

            addToCart(productId, variantId, quantity, isBuyNow).then((data) => {
                if (typeof UI !== 'undefined') UI.setLoading(addBtn, false);
                
                if (isBuyNow && data && data.success) {
                    window.location.href = `${BASE_URL}/checkout`;
                } else if (data && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added!',
                        text: data.message || 'Item added to cart',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        }
    });

    // 7. Initialize
    const initCart = async () => {
        // Migration: If there's an old localStorage cart, we could sync it once,
        // but for "proper production ready" it's better to just start fresh or 
        // provide a one-time migration. For now, we fetch from server.
        const data = await apiCall('/api/cart');
        if (data) updateUI(data);
    };

    initCart();
});
