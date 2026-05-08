<footer class="footer">
    <div class="container">
        <div class="footer-main-grid">
            <!-- Left Content -->
            <div class="footer-content-left">
                <div class="footer-warning-section mb-40">
                    <h1 class="footer-large-title mb-20">You Have To Be Over 18 <br>To Purchase</h1>
                    <p class="footer-description text-14 text-muted">
                        Vape kits might contain nicotine, which is addictive. These vaping devices are designed for
                        individuals aged 18 or above. They are unsuitable for people who are allergic/sensitive to
                        nicotine, pregnant or breastfeeding women, those with unstable heart conditions, and individuals
                        who should avoid nicotine for medical reasons, as they could pose health risks. Make sure to
                        keep vape kits or disposable vapes out of the reach of children.
                    </p>
                </div>

                <div class="footer-links-grid mb-40">
                    <?php 
                    use App\Helpers\NavigationHelper;
                    NavigationHelper::renderFooterColumn('footer_menu', 'Quick Links'); 
                    ?>
                    <div class="link-col">
                        <h4>Policies</h4>
                        <ul>
                            <li><a href="<?= BASE_URL ?>/shipping-policy">Shipping Policy</a></li>
                            <li><a href="<?= BASE_URL ?>/refund-policy">Refund Policy</a></li>
                            <li><a href="<?= BASE_URL ?>/return-policy">Return Policy</a></li>
                            <li><a href="<?= BASE_URL ?>/privacy-policy">Privacy Policy</a></li>
                            <li><a href="<?= BASE_URL ?>/fda-disclaimer">FDA Disclaimer</a></li>
                            <li><a href="<?= BASE_URL ?>/terms-and-conditions">Terms & Conditions</a></li>
                        </ul>
                    </div>
                    <div class="link-col">
                        <h4>Contact Us</h4>
                        <ul>
                            <li><a href="mailto:info@theperfectvape.com">info@theperfectvape.com</a></li>
                            <li><a href="tel:+442071234567">+44 20 7123 4567</a></li>
                            <li>15 St Oswald's Street, Liverpool, L13 5SA</li>
                        </ul>
                    </div>
                </div>

                <div class="footer-bottom-bar">
                    <p class="text-12 text-muted mb-15">© 2025 The Perfect Vape. All Rights Reserved. | Designed,
                        Developed & Managed By Antigravity</p>
                    <div class="payment-methods">
                        <img src="<?= BASE_URL ?>/assets/footer/Logos-01.png" alt="Payment">
                        <img src="<?= BASE_URL ?>/assets/footer/Logos-02.png" alt="Payment">
                        <img src="<?= BASE_URL ?>/assets/footer/Logos-03.png" alt="Payment">
                        <img src="<?= BASE_URL ?>/assets/footer/Logos-04.png" alt="Payment">
                        <img src="<?= BASE_URL ?>/assets/footer/Logos-05.png" alt="Payment">
                        <img src="<?= BASE_URL ?>/assets/footer/Logos-07.png" alt="Payment">
                        <img src="<?= BASE_URL ?>/assets/footer/Logos-08.png" alt="Payment">
                        <img src="<?= BASE_URL ?>/assets/footer/Logos-10.png" alt="Payment">
                    </div>
                </div>
            </div>

            <!-- Right Branding Image -->
            <div class="footer-content-right">
                <div class="footer-branding-card">
                    <img src="<?= BASE_URL ?>/assets/footer/branding.jpg" alt="Branding" class="footer-brand-img">
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script src="<?= BASE_URL ?>/js/cart.js"></script>
<script src="<?= BASE_URL ?>/js/main.js"></script>
</body>

</html>