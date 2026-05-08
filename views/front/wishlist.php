<?php
$pageTitle = "My Wishlist | The Perfect Vape";
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
            <!-- Wishlist content will be loaded here via wishlist.js -->
            <div class="wishlist-loading">Loading your wishlist...</div>
        </div>
    </div>
</main>

<script src="js/wishlist.js"></script>

<?php require 'partials/footer.php'; ?>
