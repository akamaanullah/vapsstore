<?php
require 'partials/header.php';
?>

<main class="checkout-success-page" style="padding: 100px 0; text-align: center;">
    <div class="container">
        <div class="success-card" style="max-width: 600px; margin: 0 auto; background: #fff; padding: 50px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.05);">
            <div class="success-icon" style="width: 80px; height: 80px; background: #10b981; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; font-size: 40px;">
                <i data-lucide="check"></i>
            </div>
            <h1 style="font-size: 32px; color: #1e293b; margin-bottom: 10px;">Thank You for Your Order!</h1>
            <p style="color: #64748b; font-size: 18px; margin-bottom: 30px;">Your order <strong><?= htmlspecialchars($orderNumber) ?></strong> has been placed successfully.</p>
            <p style="color: #64748b; margin-bottom: 40px;">We've sent a confirmation email to your inbox. We'll notify you once your package is on its way.</p>
            
            <div class="success-actions">
                <a href="<?= BASE_URL ?>/" class="btn-primary" style="display: inline-block; padding: 15px 35px; background: #000; color: #fff; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">Continue Shopping</a>
            </div>
        </div>
    </div>
</main>

<?php require 'partials/footer.php'; ?>
