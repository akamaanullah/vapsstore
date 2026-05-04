/**
 * Product Detail Page Logic
 * Handles Gallery, Quantity Picker, and Description Tabs
 */

document.addEventListener('DOMContentLoaded', () => {

    // 1. Thumbnail Swiper Initialization
    if (typeof Swiper !== 'undefined' && document.querySelector('.product-thumb-slider')) {
        const thumbSwiper = new Swiper(".product-thumb-slider", {
            slidesPerView: 4,
            spaceBetween: 10,
            navigation: {
                nextEl: ".thumb-next",
                prevEl: ".thumb-prev",
            },
            breakpoints: {
                480: { slidesPerView: 4 },
                768: { slidesPerView: 5 },
            }
        });

        // 2. Main Image Switcher
        const mainImg = document.getElementById('mainProductImage');
        const thumbs = document.querySelectorAll('.thumb-item');

        thumbs.forEach(thumb => {
            const updateImage = () => {
                const newImg = thumb.querySelector('img');
                if (newImg && mainImg) {
                    mainImg.src = newImg.src;
                    thumbs.forEach(t => t.classList.remove('active'));
                    thumb.classList.add('active');
                }
            };

            thumb.addEventListener('click', updateImage);
            thumb.addEventListener('mouseenter', updateImage);
        });
    }

    // 3. Quantity Selector Logic
    const qtyInput = document.getElementById('qtyInput');
    const qtyPlus = document.getElementById('qtyPlus');
    const qtyMinus = document.getElementById('qtyMinus');

    if (qtyInput && qtyPlus && qtyMinus) {
        qtyPlus.addEventListener('click', () => {
            qtyInput.value = parseInt(qtyInput.value) + 1;
        });

        qtyMinus.addEventListener('click', () => {
            const currentVal = parseInt(qtyInput.value);
            if (currentVal > 1) {
                qtyInput.value = currentVal - 1;
            }
        });
    }

    // 4. Description Tabs Logic
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    if (tabBtns.length > 0) {
        tabBtns.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                // Remove active class from all buttons and contents
                tabBtns.forEach(b => b.classList.remove('active'));
                tabContents.forEach(c => {
                    c.classList.remove('active');
                    c.style.display = 'none';
                });

                // Add active class to clicked button and corresponding content
                btn.classList.add('active');
                const targetContent = tabContents[index];
                if (targetContent) {
                    targetContent.classList.add('active');
                    targetContent.style.display = 'block';
                }
            });
        });
    }

    // 5. Review Form Toggle Logic
    const reviewFormContainer = document.getElementById('reviewFormContainer');
    const writeReviewBtn = document.querySelector('.btn-write-review');
    const cancelReviewBtn = document.getElementById('cancelReview');
    const reviewForm = document.getElementById('reviewForm');
    const starRating = document.getElementById('starRating');
    const ratingInput = document.getElementById('ratingInput');

    if (writeReviewBtn && reviewFormContainer) {
        writeReviewBtn.addEventListener('click', () => {
            const isHidden = reviewFormContainer.style.display === 'none';
            reviewFormContainer.style.display = isHidden ? 'block' : 'none';
            if (isHidden) {
                reviewFormContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    }

    if (cancelReviewBtn) {
        cancelReviewBtn.addEventListener('click', () => {
            reviewFormContainer.style.display = 'none';
        });
    }

    // Star Rating Selection
    if (starRating) {
        // Function to get current stars (could be i or svg)
        const getStars = () => starRating.querySelectorAll('i, svg');

        starRating.addEventListener('mouseover', (e) => {
            const star = e.target.closest('i, svg');
            if (star) {
                const val = parseInt(star.getAttribute('data-value'));
                highlightStars(val);
            }
        });

        starRating.addEventListener('mouseleave', () => {
            const currentRating = parseInt(ratingInput.value) || 0;
            highlightStars(currentRating);
        });

        starRating.addEventListener('click', (e) => {
            const star = e.target.closest('i, svg');
            if (star) {
                const val = parseInt(star.getAttribute('data-value'));
                ratingInput.value = val;
                highlightStars(val);
            }
        });

        function highlightStars(count) {
            getStars().forEach((s, idx) => {
                if (idx < count) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        }
    }

    // Review Form Submission
    if (reviewForm) {
        reviewForm.addEventListener('submit', (e) => {
            e.preventDefault();

            if (!ratingInput.value) {
                alert('Please select a rating!');
                return;
            }

            // AJAX Submission Placeholder
            const formData = new FormData(reviewForm);
            console.log('Review Submitted:', Object.fromEntries(formData));

            alert('Thank you! Your review has been submitted for approval.');

            reviewForm.reset();
            ratingInput.value = '';
            highlightStars(0);
            reviewFormContainer.style.display = 'none';
        });
    }

});
