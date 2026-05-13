document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.auth-tab');
    const indicator = document.querySelector('.auth-tab-indicator');
    const slider = document.getElementById('authSlider');
    const sliderContainer = document.querySelector('.auth-slider-container');
    const loginPane = document.getElementById('loginPane');
    const signupPane = document.getElementById('signupPane');

    // Default: Login is active
    if (indicator) {
        indicator.style.width = `50%`;
        indicator.style.left = `0%`;
    }

    // Set initial height
    if (sliderContainer && loginPane) {
        sliderContainer.style.height = `${loginPane.offsetHeight}px`;
    }

    // Handle window resize to adjust height
    window.addEventListener('resize', () => {
        const activeTab = document.querySelector('.auth-tab.active');
        if (activeTab && sliderContainer) {
            const target = activeTab.getAttribute('data-target');
            const activePane = target === 'login' ? loginPane : signupPane;
            if (activePane) {
                sliderContainer.style.height = `${activePane.offsetHeight}px`;
            }
        }
    });

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            tab.classList.add('active');

            const target = tab.getAttribute('data-target');

            if (target === 'login') {
                slider.style.transform = 'translateX(0%)';
                indicator.style.left = '0%';
                if (sliderContainer && loginPane) {
                    sliderContainer.style.height = `${loginPane.offsetHeight}px`;
                }
            } else if (target === 'signup') {
                slider.style.transform = 'translateX(-50%)';
                indicator.style.left = '50%';
                if (sliderContainer && signupPane) {
                    sliderContainer.style.height = `${signupPane.offsetHeight}px`;
                }
            }
        });
    });

    // Optional: Add simple form submission prevention for demo
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');

    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const btn = loginForm.querySelector('button[type="submit"]');
            if (typeof UI !== 'undefined') UI.setLoading(btn, true);
            
            const formData = new FormData(loginForm);

            try {
                const response = await fetch(`${BASE_URL}/api/auth/login`, {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (typeof UI !== 'undefined') UI.setLoading(btn, false);

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Welcome Back!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        window.location.href = data.redirect || `${BASE_URL}/`;
                    }, 1500);
                } else {
                    Swal.fire('Login Failed', data.message, 'error');
                }
            } catch (error) {
                if (typeof UI !== 'undefined') UI.setLoading(btn, false);
                Swal.fire('Error', 'An error occurred. Please try again.', 'error');
                console.error('Login Error:', error);
            }
        });
    }

    if (signupForm) {
        signupForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const btn = signupForm.querySelector('button[type="submit"]');
            const password = signupForm.querySelector('[name="password"]').value;
            const confirm = signupForm.querySelector('[name="confirm_password"]').value;
            
            if(password !== confirm) {
                Swal.fire('Error', "Passwords do not match!", 'error');
                return;
            }
            
            if (typeof UI !== 'undefined') UI.setLoading(btn, true);
            
            const formData = new FormData(signupForm);

            try {
                const response = await fetch(`${BASE_URL}/api/auth/signup`, {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (typeof UI !== 'undefined') UI.setLoading(btn, false);

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Account Created!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        window.location.href = data.redirect || `${BASE_URL}/`;
                    }, 2000);
                } else {
                    Swal.fire('Registration Failed', data.message, 'error');
                }
            } catch (error) {
                if (typeof UI !== 'undefined') UI.setLoading(btn, false);
                Swal.fire('Error', 'An error occurred. Please try again.', 'error');
                console.error('Signup Error:', error);
            }
        });
    }

    // Password Hide/Show Toggle
    const toggleButtons = document.querySelectorAll('.password-toggle-btn');
    toggleButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.previousElementSibling;
            const icon = btn.querySelector('i');
            
            if (input && input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else if (input) {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            if(typeof lucide !== 'undefined') lucide.createIcons();
        });
    });
});
