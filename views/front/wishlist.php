<?php
$pageTitle = "My Wishlist | The Perfect Vape";
$noIndex = true;
require 'partials/header.php';
?>

<main class="wishlist-page">
    <div class="container">
        <!-- Breadcrumbs -->
        <nav class="breadcrumb">
            <a href="index.php">Home</a> / <span>Wishlist</span>
        </nav>

        <header class="page-header">
            <h1 class="page-title">My Wishlist</h1>
            <p class="page-subtitle">Keep track of the products you love. Add them to your cart whenever you're ready.</p>
        </header>

        <div id="wishlistContainer">
            <?php if (empty($items)): ?>
                <div class="empty-wishlist">
                    <i data-lucide="heart-off"></i>
                    <h2>Your wishlist is empty</h2>
                    <p>You haven't added any products to your wishlist yet.</p>
                    <a href="<?= BASE_URL ?>/collection" class="btn-continue">Continue Shopping</a>
                </div>
            <?php else: ?>
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
                            <?php foreach ($items as $item): ?>
                                <tr class="wishlist-row" id="item-<?= $item['id'] ?>">
                                    <td class="product-cell">
                                        <div class="product-item-meta">
                                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                            <a href="<?= BASE_URL ?>/product/<?= $item['url'] ?>"><?= htmlspecialchars($item['name']) ?></a>
                                        </div>
                                    </td>
                                    <td class="price-cell">£<?= number_format($item['price'], 2) ?></td>
                                    <td class="stock-cell">
                                        <span class="stock-badge <?= $item['stock'] === 'In Stock' ? 'in-stock' : 'out-stock' ?>"><?= $item['stock'] ?></span>
                                    </td>
                                    <td class="action-cell">
                                        <button class="btn-wishlist-cart" <?= $item['stock'] !== 'In Stock' ? 'disabled' : '' ?> data-id="<?= $item['id'] ?>">
                                            Add to Cart
                                        </button>
                                    </td>
                                    <td class="remove-cell">
                                        <button class="btn-remove-wishlist" onclick="removeFromWishlistServer(<?= $item['id'] ?>)">
                                            <i data-lucide="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="wishlist-actions">
                    <button class="btn-clear-wishlist" onclick="clearAllWishlistServer()">Clear All Wishlist</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>


<?php require 'partials/footer.php'; ?>
