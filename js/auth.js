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
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            // Handle login logic here
            console.log('Login submitted');
            
            // Show a simple visual feedback
            const btn = loginForm.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i data-lucide="loader" class="spin"></i> Logging in...';
            if(typeof lucide !== 'undefined') lucide.createIcons();
            
            setTimeout(() => {
                btn.innerHTML = 'Success!';
                btn.style.backgroundColor = '#28a745'; // success green
                btn.style.color = '#fff';
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style = ''; // reset
                    window.location.href = 'index.php'; // redirect to home
                }, 1000);
            }, 1500);
        });
    }

    if (signupForm) {
        signupForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const password = document.getElementById('signupPassword').value;
            const confirm = document.getElementById('signupConfirmPassword').value;
            
            if(password !== confirm) {
                alert("Passwords do not match!");
                return;
            }
            
            // Handle signup logic here
            console.log('Sign up submitted');
            
            const btn = signupForm.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i data-lucide="loader" class="spin"></i> Creating Account...';
            if(typeof lucide !== 'undefined') lucide.createIcons();
            
            setTimeout(() => {
                btn.innerHTML = 'Account Created!';
                btn.style.backgroundColor = '#28a745'; // success green
                btn.style.color = '#fff';
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style = ''; // reset
                    
                    // Switch back to login
                    const loginTab = document.querySelector('.auth-tab[data-target="login"]');
                    if (loginTab) loginTab.click();
                    
                }, 1000);
            }, 1500);
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
