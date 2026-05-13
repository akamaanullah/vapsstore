<?php
$pageTitle = "Authentication | The Perfect Vape";
require 'partials/header.php';
?>

<main class="auth-page">
    <div class="container">
        <div class="auth-wrapper">
            <div class="auth-box">
                <div class="auth-tabs">
                    <button class="auth-tab active" data-target="login">Login</button>
                    <button class="auth-tab" data-target="signup">Sign Up</button>
                    <div class="auth-tab-indicator"></div>
                </div>

                <div class="auth-slider-container">
                    <div class="auth-slider" id="authSlider">
                        <!-- Login Form -->
                        <div class="auth-form-pane" id="loginPane">
                            <form id="loginForm" class="modern-form auth-form" method="POST">
                                <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
                                <div class="form-header">
                                    <h2>Welcome Back</h2>
                                    <p>Enter your credentials to access your account.</p>
                                </div>
                                <div class="form-group">
                                    <label for="loginEmail">Email Address</label>
                                    <input type="email" id="loginEmail" name="email" placeholder="you@example.com" required>
                                </div>
                                <div class="form-group">
                                    <label for="loginPassword">Password</label>
                                    <div class="password-wrapper">
                                        <input type="password" id="loginPassword" name="password" placeholder="••••••••" required>
                                        <button type="button" class="password-toggle-btn" tabindex="-1">
                                            <i data-lucide="eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-options">
                                    <label class="remember-me">
                                        <input type="checkbox"> Remember me
                                    </label>
                                    <a href="#" class="forgot-password">Forgot Password?</a>
                                </div>
                                <button type="submit" class="btn btn-primary auth-submit-btn">Login</button>
                                
                                <div class="auth-separator">
                                    <span>Or continue with</span>
                                </div>
                                <button type="button" class="btn-social google-btn">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                    </svg>
                                    Google
                                </button>
                            </form>
                        </div>

                        <!-- Sign Up Form -->
                        <div class="auth-form-pane" id="signupPane">
                            <form id="signupForm" class="modern-form auth-form" method="POST">
                                <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
                                <div class="form-header">
                                    <h2>Create Account</h2>
                                    <p>Join us to get exclusive offers and faster checkout.</p>
                                </div>
                                <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                    <div class="form-group">
                                        <label for="signupFname">First Name</label>
                                        <input type="text" id="signupFname" name="fname" placeholder="John" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="signupLname">Last Name</label>
                                        <input type="text" id="signupLname" name="lname" placeholder="Doe" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="signupEmail">Email Address</label>
                                    <input type="email" id="signupEmail" name="email" placeholder="you@example.com" required>
                                </div>
                                <div class="form-group">
                                    <label for="signupPassword">Password</label>
                                    <div class="password-wrapper">
                                        <input type="password" id="signupPassword" name="password" placeholder="••••••••" required>
                                        <button type="button" class="password-toggle-btn" tabindex="-1">
                                            <i data-lucide="eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="signupConfirmPassword">Confirm Password</label>
                                    <div class="password-wrapper">
                                        <input type="password" id="signupConfirmPassword" name="confirm_password" placeholder="••••••••" required>
                                        <button type="button" class="password-toggle-btn" tabindex="-1">
                                            <i data-lucide="eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary auth-submit-btn">Sign Up</button>
                                
                                <div class="auth-separator">
                                    <span>Or continue with</span>
                                </div>
                                <button type="button" class="btn-social google-btn">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                    </svg>
                                    Google
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="<?= BASE_URL ?>/js/auth.js"></script>

<?php require 'partials/footer.php'; ?>
