document.addEventListener('DOMContentLoaded', () => {
    console.log('Main JS Initialized');

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    const toggleBtn = document.getElementById('mobileMenuToggle');
    const closeBtn = document.getElementById('mobileMenuClose');
    const sidebar = document.querySelector('.nav-bottom');

    if (toggleBtn && sidebar) {
        toggleBtn.onclick = (e) => {
            e.stopPropagation();
            sidebar.classList.add('active');
            document.body.classList.add('no-scroll');
        };
    }

    if (closeBtn && sidebar) {
        closeBtn.onclick = (e) => {
            e.stopPropagation();
            sidebar.classList.remove('active');
            document.body.classList.remove('no-scroll');
        };
    }

    // Close on outside click
    document.onclick = (e) => {
        if (sidebar && sidebar.classList.contains('active')) {
            if (!sidebar.contains(e.target) && e.target !== toggleBtn) {
                sidebar.classList.remove('active');
                document.body.classList.remove('no-scroll');
            }
        }
    };

    // Mobile Navigation Accordion Toggle
    const navItems = document.querySelectorAll('.nav-item.has-dropdown, .nav-item.has-mega');
    navItems.forEach(item => {
        const link = item.querySelector('.nav-link');
        link.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                e.preventDefault(); // Prevent navigation on first click for mobile
                
                // Toggle active class
                const isActive = item.classList.contains('active');
                
                // Close others
                navItems.forEach(other => other.classList.remove('active'));
                
                if (!isActive) {
                    item.classList.add('active');
                }
            }
        });
    });

    // High-Performance Sticky Header using IntersectionObserver
    const header = document.querySelector('.header');
    const sentinel = document.getElementById('scroll-sentinel');

    if (sentinel && header) {
        const observer = new IntersectionObserver((entries) => {
            // When sentinel is NOT intersecting (scrolled down), add sticky
            if (!entries[0].isIntersecting) {
                header.classList.add('sticky');
            } else {
                header.classList.remove('sticky');
            }
        }, {
            root: null,
            threshold: 0,
            rootMargin: '50px 0px 0px 0px' // Triggers 50px down
        });
        observer.observe(sentinel);
    }

    // Initialize Swiper Hero Slider
    if (typeof Swiper !== 'undefined') {
        const swiper = new Swiper(".hero-swiper", {
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            effect: "fade",
            fadeEffect: {
                crossFade: true
            }
        });
    }

    // Initialize Product Card Sliders (supports multiple instances)
    if (typeof Swiper !== 'undefined') {
        document.querySelectorAll('.product-swiper').forEach(el => {
            new Swiper(el, {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                grabCursor: true,
                pagination: {
                    el: el.querySelector('.swiper-pagination'),
                    clickable: true,
                    dynamicBullets: true,
                },
                navigation: {
                    nextEl: el.querySelector('.swiper-button-next'),
                    prevEl: el.querySelector('.swiper-button-prev'),
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 30,
                    },
                }
            });
        });
    }

    // Initialize Brands Showcase Slider
    if (typeof Swiper !== 'undefined') {
        new Swiper(".brands-swiper", {
            slidesPerView: 2,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: { slidesPerView: 3 },
                768: { slidesPerView: 4 },
                1024: { slidesPerView: 6 },
            }
        });
    }

    // Initialize Testimonials Slider
    if (typeof Swiper !== 'undefined') {
        new Swiper(".testimonials-swiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
            pagination: {
                el: ".testimonials-swiper .swiper-pagination",
                clickable: true,
            },
        });
    }
    // FAQ Accordion Logic
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        question.addEventListener('click', () => {
            // Close other items
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                }
            });
            // Toggle current item
            item.classList.toggle('active');
        });
    });

    // Brand Story Toggle Logic
    const storyBtn = document.getElementById('toggleStoryBtn');
    const moreText = document.getElementById('moreText');
    if (storyBtn && moreText) {
        storyBtn.addEventListener('click', () => {
            const isHidden = moreText.style.display === 'none' || moreText.style.display === '';
            moreText.style.display = isHidden ? 'inline' : 'none';
            storyBtn.innerHTML = isHidden ?
                'Show Less <i data-lucide="chevron-up"></i>' :
                'Read Our Story <i data-lucide="chevron-down"></i>';
            storyBtn.classList.toggle('active');
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    }
    // --- Global Wishlist Logic ---
    const updateWishlistBadge = () => {
        const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const badges = document.querySelectorAll('.wishlist-count');
        badges.forEach(badge => {
            badge.textContent = wishlist.length;
            badge.style.display = wishlist.length > 0 ? 'flex' : 'none';
        });

        // Sync active class on all wishlist buttons
        document.querySelectorAll('.product-card').forEach(card => {
            const btn = card.querySelector('.action-btn[title*="Wishlist"]');
            if (btn) {
                const id = card.dataset.id;
                const isInWishlist = wishlist.some(item => item.id == id);
                if (isInWishlist) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            }
        });

        // Sync active class for detail page wishlist button
        const detailBtn = document.querySelector('.detail-wishlist-btn');
        if (detailBtn) {
            const id = detailBtn.dataset.id;
            const isInWishlist = wishlist.some(item => item.id == id);
            detailBtn.classList.toggle('active', isInWishlist);
        }
    };

    const addToWishlist = (product) => {
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        // Check if already exists
        if (!wishlist.find(item => item.id === product.id)) {
            wishlist.push(product);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            updateWishlistBadge();
            // Optional: Simple alert or toast
            // alert(`${product.name} added to wishlist!`);
        } else {
            // Optional: Remove if already exists (toggle behavior)
            wishlist = wishlist.filter(item => item.id !== product.id);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            updateWishlistBadge();
        }
    };

    // Global Event Delegation for Wishlist Buttons
    document.addEventListener('click', (e) => {
        const wishlistBtn = e.target.closest('.action-btn[title*="Wishlist"]');
        if (wishlistBtn) {
            e.preventDefault();
            const card = wishlistBtn.closest('.product-card');
            if (card) {
                // Robust selectors for different card structures
                const nameEl = card.querySelector('.product-name a') || card.querySelector('.product-name');
                const priceEl = card.querySelector('.current-price');
                const imgEl = card.querySelector('img');

                if (nameEl && priceEl && imgEl) {
                    const product = {
                        id: card.dataset.id || Math.random().toString(36).substr(2, 9),
                        name: nameEl.textContent.trim(),
                        price: parseFloat(priceEl.textContent.replace(/[^\d.]/g, '')),
                        image: imgEl.src,
                        stock: "In Stock"
                    };
                    addToWishlist(product);

                    // Toggle active class for visual feedback
                    wishlistBtn.classList.toggle('active');
                }
            }
        }

        // Handle Product Detail Page Wishlist Button
        const detailWishlistBtn = e.target.closest('.detail-wishlist-btn');
        if (detailWishlistBtn) {
            e.preventDefault();
            const product = {
                id: detailWishlistBtn.dataset.id,
                name: document.querySelector('.product-title').textContent.trim(),
                price: parseFloat(document.querySelector('.detail-current-price').textContent.replace(/[^\d.]/g, '')),
                image: document.querySelector('#mainProductImage').src,
                stock: "In Stock"
            };
            addToWishlist(product);
            detailWishlistBtn.classList.toggle('active');
        }
    });

    // Initial Badge Update
    updateWishlistBadge();
});
