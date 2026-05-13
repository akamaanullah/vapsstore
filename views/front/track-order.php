<?php 
$pageTitle = "Track Your Order | The Perfect Vape";
include __DIR__ . '/partials/header.php'; 
?>

<div class="account-page" style="padding: 100px 0; background: #f8f9fa;">
    <div class="container">
        <div class="auth-wrapper" style="max-width: 500px; margin: 0 auto;">
            <div class="account-card" style="padding: 50px;">
                <div class="welcome-header text-center" style="margin-bottom: 35px;">
                    <h2 style="font-size: 32px; font-weight: 800; color: #111827; margin-bottom: 10px;">Track Order</h2>
                    <p style="color: #6b7280; font-size: 16px;">Check the status of your delivery</p>
                </div>


                <form action="<?= BASE_URL ?>/track-order/status" method="GET" class="modern-form">
                    <div class="form-group">
                        <label>Order Number</label>
                        <input type="text" name="order" placeholder="e.g. ORD-2026-0001" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="The email used at checkout" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100" style="margin-top: 10px;">
                        Track Order <i data-lucide="arrow-right" style="width: 18px; height: 18px; margin-left: 10px;"></i>
                    </button>
                </form>

                <div style="margin-top: 35px; padding-top: 25px; border-top: 1px solid #f3f4f6; text-align: center;">
                    <p style="font-size: 14px; color: #6b7280; line-height: 1.6;">
                        Can't find your order number? <br>
                        Check your order confirmation email.
                    </p>
                </div>
            </div>
            
            <div class="text-center" style="margin-top: 30px;">
                <a href="<?= BASE_URL ?>/collection" class="btn-link" style="color: #6b7280; font-weight: 600; font-size: 14px;">
                    &larr; Return to Shopping
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    <?php if (isset($_SESSION['flash']['error'])): ?>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '<?= $_SESSION['flash']['error']; unset($_SESSION['flash']['error']); ?>',
        confirmButtonColor: '#bd0028'
    });
    <?php endif; ?>
});
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>
