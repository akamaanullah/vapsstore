document.addEventListener('DOMContentLoaded', () => {
    // 1. Get Data from LocalStorage
    let wishlistItems = JSON.parse(localStorage.getItem('wishlist')) || [];

    const container = document.getElementById('wishlistContainer');

    // 2. Render Wishlist
    function renderWishlist() {
        // Refresh items from storage to be sure
        wishlistItems = JSON.parse(localStorage.getItem('wishlist')) || [];

        if (wishlistItems.length === 0) {
            container.innerHTML = `
                <div class="empty-wishlist">
                    <i data-lucide="heart-off"></i>
                    <h2>Your wishlist is empty</h2>
                    <p>You haven't added any products to your wishlist yet.</p>
                    <a href="collection.php" class="btn-continue">Continue Shopping</a>
                </div>
            `;
            if (typeof lucide !== 'undefined') lucide.createIcons();
            return;
        }

        let html = `
            <div class="wishlist-table-container">
                <table class="wishlist-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Stock Status</th>
                            <th>Action</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        wishlistItems.forEach(item => {
            html += `
                <tr id="item-${item.id}">
                    <td class="product-cell">
                        <div class="product-item-meta">
                            <img src="${item.image}" alt="${item.name}">
                            <a href="product-detail.php">${item.name}</a>
                        </div>
                    </td>
                    <td class="price-cell">£${item.price.toFixed(2)}</td>
                    <td class="stock-cell">
                        <span class="stock-badge ${item.stock === 'In Stock' ? 'in-stock' : 'out-stock'}">${item.stock}</span>
                    </td>
                    <td class="action-cell">
                        <button class="btn-wishlist-cart" ${item.stock !== 'In Stock' ? 'disabled' : ''}>
                            Add to Cart
                        </button>
                    </td>
                    <td class="remove-cell">
                        <button class="btn-remove-wishlist" onclick="removeFromWishlist('${item.id}')">
                            <i data-lucide="trash-2"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        html += `
                    </tbody>
                </table>
            </div>
            <div class="wishlist-actions">
                <button class="btn-clear-wishlist" onclick="clearAllWishlist()">Clear All Wishlist</button>
            </div>
        `;

        container.innerHTML = html;
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    // 3. Global functions for buttons
    window.removeFromWishlist = (id) => {
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        wishlist = wishlist.filter(item => item.id != id);
        localStorage.setItem('wishlist', JSON.stringify(wishlist));

        // Update header badge if main.js functions are global (or just rely on refresh)
        if (typeof updateWishlistBadge === 'function') updateWishlistBadge();

        renderWishlist();
    };

    window.clearAllWishlist = () => {
        localStorage.removeItem('wishlist');
        if (typeof updateWishlistBadge === 'function') updateWishlistBadge();
        renderWishlist();
    };

    renderWishlist();
});
