<?php
$pageTitle = $code . " - " . ($code == 404 ? "Page Not Found" : "Error Occurred");
require 'partials/header.php';

// Map codes to user-friendly messages
$messages = [
    403 => [
        'title' => 'Access Forbidden',
        'desc' => 'Sorry, you don\'t have permission to access this page.',
        'icon' => 'shield-alert'
    ],
    404 => [
        'title' => 'Page Not Found',
        'desc' => 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.',
        'icon' => 'search'
    ],
    500 => [
        'title' => 'Internal Server Error',
        'desc' => 'Something went wrong on our end. Our team has been notified.',
        'icon' => 'server'
    ]
];

$error = $messages[$code] ?? [
    'title' => 'Unexpected Error',
    'desc' => 'An unexpected error occurred. Please try again later.',
    'icon' => 'alert-triangle'
];

// If it's a 500 error and we are in debug mode, we might show more info later
?>

<div class="error-page-container">
    <div class="container">
        <div class="error-content">
            <div class="error-icon-wrapper">
                <i data-lucide="<?= $error['icon'] ?>"></i>
                <span class="error-code-badge"><?= $code ?></span>
            </div>
            
            <h1 class="error-title"><?= $error['title'] ?></h1>
            <p class="error-description"><?= htmlspecialchars($message ?: $error['desc']) ?></p>
            
            <?php if (isset($debug) && $debug && isset($exception)): ?>
                <div class="debug-info">
                    <button class="btn btn-outline btn-sm mb-10" onclick="document.getElementById('stackTrace').style.display = 'block'; this.style.display='none'">
                        View Debug Details
                    </button>
                    <div id="stackTrace" style="display: none; text-align: left;">
                        <pre class="debug-pre"><?= htmlspecialchars($exception->getMessage()) ?> in <?= htmlspecialchars($exception->getFile()) ?>:<?= $exception->getLine() ?></pre>
                        <pre class="debug-pre" style="font-size: 11px;"><?= htmlspecialchars($exception->getTraceAsString()) ?></pre>
                    </div>
                </div>
            <?php endif; ?>

            <div class="error-actions">
                <a href="<?= BASE_URL ?>/" class="btn-error-primary">
                    <i data-lucide="home"></i>
                    <span>Back to Homepage</span>
                </a>
                <a href="javascript:history.back()" class="btn-error-outline">
                    <i data-lucide="arrow-left"></i>
                    <span>Go Back</span>
                </a>
            </div>

            <div class="error-divider">
                <span>OR TRY ONE OF THESE</span>
            </div>

            <div class="suggestion-links">
                <a href="<?= BASE_URL ?>/collections/all">Shop All Products</a>
                <a href="<?= BASE_URL ?>/collections/new-arrivals">New Arrivals</a>
                <a href="<?= BASE_URL ?>/collections/best-sellers">Best Sellers</a>
            </div>
        </div>
    </div>
</div>

<style>
.error-page-container {
    padding: 120px 0;
    text-align: center;
    background: #ffffff;
    min-height: 70vh;
    display: flex;
    align-items: center;
}

.error-content {
    max-width: 650px;
    margin: 0 auto;
}

.error-icon-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 25px;
}

.error-icon-wrapper i {
    width: 70px;
    height: 70px;
    color: #0f172a;
    stroke-width: 1.5;
}

.error-code-badge {
    position: absolute;
    top: -5px;
    right: -15px;
    background: #e16449; /* Theme Primary */
    color: white;
    padding: 2px 10px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
}

.error-title {
    font-size: 48px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 12px;
    letter-spacing: -0.03em;
}

.error-description {
    font-size: 18px;
    color: #64748b;
    margin-bottom: 45px;
    line-height: 1.6;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.error-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
    margin-bottom: 50px;
}

/* Custom Error Buttons to avoid theme conflicts */
.btn-error-primary, .btn-error-outline {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 15px;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-error-primary {
    background: #000000;
    color: #ffffff !important;
}

.btn-error-primary:hover {
    background: #e16449;
    transform: translateY(-2px);
}

.btn-error-outline {
    background: transparent;
    color: #000000 !important;
    border: 2px solid #e2e8f0;
}

.btn-error-outline:hover {
    border-color: #000000;
    background: #f8fafc;
    transform: translateY(-2px);
}

.error-divider {
    position: relative;
    margin: 40px 0 30px;
    text-align: center;
}

.error-divider::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e2e8f0;
    z-index: 1;
}

.error-divider span {
    position: relative;
    background: #ffffff;
    padding: 0 20px;
    font-size: 12px;
    font-weight: 700;
    color: #94a3b8;
    letter-spacing: 0.1em;
    z-index: 2;
}

.suggestion-links {
    display: flex;
    gap: 25px;
    justify-content: center;
    flex-wrap: wrap;
}

.suggestion-links a {
    color: #e16449;
    font-weight: 700;
    text-decoration: none;
    font-size: 14px;
    transition: opacity 0.2s;
}

.suggestion-links a:hover {
    opacity: 0.7;
    text-decoration: underline;
}

.debug-pre {
    background: #1e293b;
    color: #cbd5e1;
    padding: 15px;
    border-radius: 8px;
    font-family: 'Courier New', Courier, monospace;
    font-size: 12px;
    line-height: 1.5;
    text-align: left;
    margin-top: 15px;
    border: 1px solid #334155;
}

@media (max-width: 600px) {
    .error-page-container { padding: 80px 0; }
    .error-title { font-size: 36px; }
    .error-actions { flex-direction: column; width: 100%; max-width: 300px; margin-left: auto; margin-right: auto; }
    .btn-error-primary, .btn-error-outline { justify-content: center; }
    .suggestion-links { gap: 15px; }
}
</style>

<?php require 'partials/footer.php'; ?>
