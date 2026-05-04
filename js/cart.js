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
        document.body.style.overflow = 'hidden'; // Prevent scroll
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

    // 5. Render Cart Items
    const renderCart = () => {
        if (cart.length === 0) {
            cartItemsList.innerHTML = `
                <div class="empty-cart-msg">
                    <i data-lucide="shopping-cart"></i>
                    <p>Your cart is empty</p>
                    <a href="collection.php" class="btn-shop-now">Shop Our Collection</a>
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
            const itemHTML = `
                <div class="cart-item" data-id="${item.id}">
                    <div class="cart-item-img">
                        <img src="${item.image}" alt="${item.name}">
                    </div>
                    <div class="cart-item-info">
                        <a href="product-detail.php" class="cart-item-name">${item.name}</a>
                        <span class="cart-item-price">£${item.price.toFixed(2)}</span>
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

    // 6. Add to Cart Logic
    const addToCart = (product) => {
        const existingItem = cart.find(item => item.id === product.id);
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
    };

    const saveCart = () => {
        localStorage.setItem('cart', JSON.stringify(cart));
    };

    // 7. Event Delegation for Cart Actions (+, -, Remove)
    cartItemsList.addEventListener('click', (e) => {
        const itemRow = e.target.closest('.cart-item');
        if (!itemRow) return;
        const id = itemRow.dataset.id;
        const itemIndex = cart.findIndex(item => item.id === id);

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

            // Determine source (Card or Detail Page)
            const card = addBtn.closest('.product-card');
            let product = {};

            if (card) {
                const nameEl = card.querySelector('.product-name a') || card.querySelector('.product-name') || card.querySelector('h3');
                const priceEl = card.querySelector('.current-price') || card.querySelector('.product-price');
                const imgEl = card.querySelector('.product-img-wrapper img') || card.querySelector('img');

                if (!nameEl || !priceEl) {
                    console.error("Product name or price element not found in card", card);
                    return;
                }

                product = {
                    id: card.dataset.id || nameEl.textContent.trim().toLowerCase().replace(/\s+/g, '-'),
                    name: nameEl.textContent.trim(),
                    price: parseFloat(priceEl.textContent.replace(/[^\d.]/g, '')),
                    image: imgEl ? imgEl.src : 'assets/image/placeholder.jpg',
                    quantity: 1
                };
            } else if (document.querySelector('.product-detail-page')) {
                // Detail Page
                const qtyInput = document.getElementById('qtyInput');
                const titleEl = document.querySelector('.product-title');
                const priceEl = document.querySelector('.detail-current-price');
                const imgEl = document.querySelector('#mainProductImage');

                if (!titleEl || !priceEl) return;

                product = {
                    id: "main-prod-1",
                    name: titleEl.textContent.trim(),
                    price: parseFloat(priceEl.textContent.replace(/[^\d.]/g, '')),
                    image: imgEl ? imgEl.src : 'assets/image/placeholder.jpg',
                    quantity: qtyInput ? parseInt(qtyInput.value) : 1
                };
            } else {
                return;
            }

            addToCart(product);

            // Redirect if it was a Buy It Now button
            if (addBtn.classList.contains('btn-buy-now') || addBtn.id === 'buyNowDetail') {
                window.location.href = 'checkout.php';
            }
        }
    });

    // Initial Load
    renderCart();
    updateCartBadge();
});
