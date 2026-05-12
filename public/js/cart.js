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

    // 2. Cart State
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // 3. Open/Close Sidebar
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

    // 4. Update Header Badge
    const updateCartBadge = () => {
        const totalQty = cart.reduce((total, item) => total + item.quantity, 0);
        cartBadge.forEach(badge => {
            if (totalQty > 0) {
                badge.textContent = totalQty;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        });
    };

    // Helper: Generate a unique cart key for an item (variant-aware)
    const getCartKey = (item) => {
        return item.variant_id ? `${item.id}-${item.variant_id}` : String(item.id);
    };

    // 5. Render Cart Items
    const renderCart = () => {
        if (cart.length === 0) {
            cartItemsList.innerHTML = `
                <div class="empty-cart-msg">
                    <i data-lucide="shopping-cart"></i>
                    <p>Your cart is empty</p>
                    <a href="${BASE_URL}/collection" class="btn-shop-now">Shop Our Collection</a>
                </div>
            `;
            cartFooter.style.display = 'none';
            lucide.createIcons();
            return;
        }

        cartFooter.style.display = 'block';
        cartItemsList.innerHTML = '';

        let subtotal = 0;

        cart.forEach(item => {
            subtotal += item.price * item.quantity;
            const cartKey = getCartKey(item);
            const itemHTML = `
                <div class="cart-item" data-cart-key="${cartKey}">
                    <div class="cart-item-img">
                        <img src="${item.image}" alt="${item.name}">
                    </div>
                    <div class="cart-item-info">
                        <a href="${BASE_URL}/product/${item.url || item.id}" class="cart-item-name">${item.name}</a>
                        <span class="cart-item-price">£${item.price.toFixed(2)}</span>
                        ${item.variant_name ? `<span class="cart-item-variant">${item.variant_name}</span>` : ''}
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
            cartItemsList.insertAdjacentHTML('beforeend', itemHTML);
        });

        cartTotalAmount.textContent = `£${subtotal.toFixed(2)}`;
        lucide.createIcons();
    };

    // 6. Add to Cart Logic (Variant-Aware)
    const addToCart = (product) => {
        const cartKey = getCartKey(product);

        const existingItem = cart.find(item => getCartKey(item) === cartKey);
        if (existingItem) {
            existingItem.quantity += product.quantity || 1;
        } else {
            cart.push({
                ...product,
                quantity: product.quantity || 1
            });
        }
        saveCart();
        renderCart();
        updateCartBadge();
        openCart();
    };

    const saveCart = () => {
        localStorage.setItem('cart', JSON.stringify(cart));
    };

    // 7. Event Delegation for Cart Actions (+, -, Remove)
    cartItemsList.addEventListener('click', (e) => {
        const itemRow = e.target.closest('.cart-item');
        if (!itemRow) return;
        const cartKey = itemRow.dataset.cartKey;
        const itemIndex = cart.findIndex(item => getCartKey(item) === cartKey);
        if (itemIndex === -1) return;

        if (e.target.classList.contains('plus')) {
            cart[itemIndex].quantity++;
        } else if (e.target.classList.contains('minus')) {
            if (cart[itemIndex].quantity > 1) {
                cart[itemIndex].quantity--;
            } else {
                cart.splice(itemIndex, 1);
            }
        } else if (e.target.classList.contains('btn-remove-item')) {
            cart.splice(itemIndex, 1);
        }

        saveCart();
        renderCart();
        updateCartBadge();
    });

    // 8. Global Listener for "Add to Cart" buttons
    document.addEventListener('click', (e) => {
        const addBtn = e.target.closest('.btn-buy, .btn-add-to-cart, .btn-buy-now');
        if (addBtn) {
            e.preventDefault();

            const card = addBtn.closest('.product-card');
            const slimCard = addBtn.closest('.product-embed-slim');
            const detailPage = document.querySelector('.product-detail-page');
            let product = {};

            if (card) {
                // Product Card (Collection/Home page)
                const nameEl = card.querySelector('.product-name a') || card.querySelector('.product-name') || card.querySelector('h3');
                const priceEl = card.querySelector('.current-price') || card.querySelector('.product-price');
                const imgEl = card.querySelector('.product-img-wrapper img') || card.querySelector('img');

                if (!nameEl || !priceEl) {
                    console.error("Product name or price element not found in card", card);
                    return;
                }

                product = {
                    id: card.dataset.id,
                    name: nameEl.textContent.trim(),
                    price: parseFloat(priceEl.textContent.replace(/[^\d.]/g, '')),
                    image: imgEl ? imgEl.src : 'assets/image/placeholder.jpg',
                    url: nameEl.getAttribute('href')?.split('/').pop() || card.dataset.id,
                    quantity: 1
                };
            } else if (slimCard) {
                // Slim Product Embed (Blog/Page)
                const titleEl = slimCard.querySelector('.slim-title a');
                const priceEl = slimCard.querySelector('.slim-price');
                const imgEl = slimCard.querySelector('.slim-img img');
                const qtyInput = slimCard.querySelector('.qty-input');
                const variantSelect = slimCard.querySelector('.slim-variant-select');

                let variantId = null;
                let variantName = null;

                if (variantSelect) {
                    variantId = variantSelect.value;
                    variantName = variantSelect.options[variantSelect.selectedIndex].text;
                }

                product = {
                    id: slimCard.dataset.productId,
                    name: titleEl.textContent.trim(),
                    price: parseFloat(priceEl.textContent.replace(/[^\d.]/g, '')),
                    image: imgEl ? imgEl.src : 'assets/image/placeholder.jpg',
                    url: titleEl.getAttribute('href')?.split('/').pop() || slimCard.dataset.productId,
                    quantity: qtyInput ? parseInt(qtyInput.value) : 1,
                    variant_id: variantId,
                    variant_name: variantName
                };
            } else if (detailPage) {
                // Product Detail Page
                const qtyInput = document.getElementById('qtyInput');
                const titleEl = document.querySelector('.product-title');
                const priceEl = document.querySelector('.detail-current-price');
                const imgEl = document.querySelector('#mainProductImage');
                const variantSelect = document.getElementById('variantSelect');

                if (!titleEl || !priceEl) return;

                let variantId = null;
                let variantName = null;

                if (variantSelect) {
                    variantId = variantSelect.value;
                    variantName = variantSelect.options[variantSelect.selectedIndex].text;
                }

                product = {
                    id: detailPage.dataset.productId,
                    name: titleEl.textContent.trim(),
                    price: parseFloat(priceEl.textContent.replace(/[^\d.]/g, '')),
                    image: imgEl ? imgEl.src : 'assets/image/placeholder.jpg',
                    url: window.location.pathname.split('/').pop(),
                    quantity: qtyInput ? parseInt(qtyInput.value) : 1,
                    variant_id: variantId,
                    variant_name: variantName
                };
            } else {
                return;
            }

            addToCart(product);

            // Redirect if it was a Buy It Now button
            if (addBtn.classList.contains('btn-buy-now') || addBtn.id === 'buyNowDetail') {
                window.location.href = `${BASE_URL}/checkout`;
            }
        }
    });

    // Initial Load
    renderCart();
    updateCartBadge();
});
