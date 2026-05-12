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
    const submitReviewForm = document.getElementById('submitReviewForm');
    if (submitReviewForm) {
        submitReviewForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // AJAX Submission
            const formData = new FormData(submitReviewForm);
            
            fetch(BASE_URL + '/api/review/submit', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message in UI
                    const formWrapper = submitReviewForm.closest('.form-wrapper');
                    if (formWrapper) {
                        formWrapper.innerHTML = `
                            <div class="review-success-msg" style="text-align:center; padding: 40px 0;">
                                <i data-lucide="check-circle" style="width: 60px; height: 60px; color: #28a745; margin-bottom: 20px;"></i>
                                <h3 class="fs-24 mb-10">Thank You!</h3>
                                <p class="color-gray">${data.message}</p>
                            </div>
                        `;
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                    }
                } else {
                    alert(data.message || 'Something went wrong. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    }

    const variantSelect = document.getElementById('variantSelect');
    const optionSelects = document.querySelectorAll('.variant-option-select');
    const displayPrice = document.getElementById('displayPrice');
    const comparePriceContainer = document.getElementById('comparePriceContainer');
    const displayComparePrice = document.getElementById('displayComparePrice');
    const displaySalePercentage = document.getElementById('displaySalePercentage');

    function updateVariantFromOptions() {
        if (!optionSelects.length || !variantSelect) return;

        // 1. Construct the combined name string: "val1 / val2 / val3"
        const selectedValues = Array.from(optionSelects)
            .sort((a, b) => a.dataset.optionIndex - b.dataset.optionIndex)
            .map(select => select.value);
        
        const targetName = selectedValues.join(' / ');

        // 2. Find the hidden option that matches this name
        const options = Array.from(variantSelect.options);
        const matchingOption = options.find(opt => opt.dataset.name === targetName);

        if (matchingOption) {
            variantSelect.value = matchingOption.value;
            // Manually trigger change to update prices
            variantSelect.dispatchEvent(new Event('change'));
        }
    }

    if (optionSelects.length > 0) {
        optionSelects.forEach(select => {
            select.addEventListener('change', updateVariantFromOptions);
        });
        // Initial sync
        updateVariantFromOptions();
    }

    if (variantSelect && displayPrice) {
        variantSelect.addEventListener('change', (e) => {
            const selectedOption = e.target.options[e.target.selectedIndex];
            if (!selectedOption) return;

            const price = parseFloat(selectedOption.getAttribute('data-price'));
            const comparePrice = parseFloat(selectedOption.getAttribute('data-compare-price'));

            if (!isNaN(price)) {
                displayPrice.textContent = `£${price.toFixed(2)}`;
            }

            if (comparePriceContainer && displayComparePrice) {
                if (!isNaN(comparePrice) && comparePrice > price) {
                    displayComparePrice.textContent = `£${comparePrice.toFixed(2)}`;
                    comparePriceContainer.style.display = 'inline-flex';
                    
                    if (displaySalePercentage) {
                        const percent = Math.round(((comparePrice - price) / comparePrice) * 100);
                        displaySalePercentage.textContent = `Save ${percent}%`;
                    }
                } else {
                    comparePriceContainer.style.display = 'none';
                }
            }
        });
    }


});
