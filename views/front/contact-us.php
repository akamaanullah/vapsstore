<?php
$pageTitle = "Contact Us | The Perfect Vape";
require 'partials/header.php';
?>

<main class="contact-page">
    <!-- Contact Hero/Header with Image -->
    <section class="policy-hero contact-hero">
        <div class="container">
            <nav class="breadcrumb">
                <a href="index.php">Home</a> / <span>Contact Us</span>
            </nav>
            <h1 class="page-title">Get In Touch</h1>
            <p class="page-subtitle">Have questions? Our elite support team is here to assist you.</p>
        </div>
    </section>

    <section class="contact-section">
        <div class="container">
            <div class="contact-form-container">
                <div class="contact-form-panel">
                    <form action="#" class="contact-form" id="contactForm">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="contactName">Full Name</label>
                                <input type="text" id="contactName" name="name" placeholder="John Doe" required>
                            </div>
                            <div class="form-group">
                                <label for="contactEmail">Email Address</label>
                                <input type="email" id="contactEmail" name="email" placeholder="john@example.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contactSubject">Subject</label>
                            <input type="text" id="contactSubject" name="subject" placeholder="How can we help?" required>
                        </div>
                        <div class="form-group">
                            <label for="contactMessage">Message</label>
                            <textarea id="contactMessage" name="message" rows="6" placeholder="Your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn-submit-contact">
                            <span>Send Message</span>
                            <i data-lucide="send"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require 'partials/footer.php'; ?>
