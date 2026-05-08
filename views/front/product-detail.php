<?php require VIEW_DIR . '/front/partials/header.php'; ?>

<main class="product-detail-page">
    <div class="container">
        <!-- Breadcrumbs (Optional but Good for UX) -->
        <nav class="breadcrumb">
            <a href="index.php">Home</a> / <a href="#">Vape Kits</a> / <span>Premium Valiburn Pod Kit</span>
        </nav>

        <div class="product-main-area">
            <!-- Left Side: Images -->
            <div class="product-gallery-side">
                <div class="main-image-container">
                    <img src="<?= BASE_URL ?>/assets/product/product-1.jpg" id="mainProductImage" alt="Product Main Image">
                </div>

                <!-- Thumbnail Slider -->
                <div class="swiper product-thumb-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide thumb-item active">
                            <img src="<?= BASE_URL ?>/assets/product/product-1.jpg" alt="Thumb 1">
                        </div>
                        <div class="swiper-slide thumb-item">
                            <img src="<?= BASE_URL ?>/assets/product/product-2.jpg" alt="Thumb 2">
                        </div>
                        <div class="swiper-slide thumb-item">
                            <img src="<?= BASE_URL ?>/assets/product/product-3.jpg" alt="Thumb 3">
                        </div>
                        <div class="swiper-slide thumb-item">
                            <img src="<?= BASE_URL ?>/assets/product/product-4.jpg" alt="Thumb 4">
                        </div>
                        <div class="swiper-slide thumb-item">
                            <img src="<?= BASE_URL ?>/assets/product/product-5.jpg" alt="Thumb 5">
                        </div>
                        <div class="swiper-slide thumb-item">
                            <img src="<?= BASE_URL ?>/assets/product/product-6.jpg" alt="Thumb 6">
                        </div>
                        <div class="swiper-slide thumb-item">
                            <img src="<?= BASE_URL ?>/assets/product/product-7.jpg" alt="Thumb 7">
                        </div>
                    </div>
                    <!-- Navigation Buttons -->
                    <div class="thumb-next"><i data-lucide="chevron-right"></i></div>
                    <div class="thumb-prev"><i data-lucide="chevron-left"></i></div>
                </div>

            </div>

            <!-- Right Side: Product Details -->
            <div class="product-info-side">
                <h1 class="product-title">Premium Valiburn Pod Kit</h1>

                <div class="price-area">
                    <span class="detail-current-price">£45.00</span>
                    <span class="detail-old-price">£55.00</span>
                    <span class="sale-badge">Save 20%</span>
                </div>

                <a href="#" class="shipping-policy-link">
                    <i data-lucide="truck"></i> Shipping Policy
                </a>

                <div class="product-selection">
                    <!-- Flavor Dropdown -->
                    <div class="selection-group">
                        <label>Select Flavor</label>
                        <select class="custom-select" id="flavorSelect">
                            <option value="mint">Arctic Mint</option>
                            <option value="mango">Sweet Mango</option>
                            <option value="tobacco">Classic Tobacco</option>
                            <option value="berry">Mixed Berries</option>
                        </select>
                    </div>

                    <!-- Size Dropdown -->
                    <div class="selection-group">
                        <label>Select Size</label>
                        <select class="custom-select" id="sizeSelect">
                            <option value="standard">Standard Kit</option>
                            <option value="pro">Pro Edition (+£10)</option>
                        </select>
                    </div>

                    <div class="product-actions-btns">
                        <!-- Quantity Selector -->
                        <div class="quantity-picker-wrapper">
                            <label>Quantity</label>
                            <div class="quantity-picker">
                                <button type="button" class="qty-btn minus" id="qtyMinus">-</button>
                                <input type="number" id="qtyInput" value="1" min="1" readonly>
                                <button type="button" class="qty-btn plus" id="qtyPlus">+</button>
                            </div>
                        </div>

                        <div class="purchase-buttons">
                            <button class="btn-add-to-cart" id="addToCartDetail">Add to cart</button>
                            <button class="btn-buy-now" id="buyNowDetail">Buy it now</button>
                            <button class="detail-wishlist-btn" title="Add to Wishlist" data-id="main-prod-1">
                                <i data-lucide="heart"></i>
                            </button>
                        </div>
                    </div>



                    <div class="short-description">
                        <h4 class="specs-title">Product Specifications</h4>
                        <ul class="specs-list">
                            <li><strong>Puff Count:</strong> Regular Mode ~ 15000 | Pulse ~ 7500</li>
                            <li><strong>E-Liquid Capacity:</strong> 16ml</li>
                            <li><strong>Nicotine Strength:</strong> 5% | 50mg</li>
                            <li><strong>Battery:</strong> 650 mAh Rechargeable (USB Type-C)</li>
                            <li><strong>Coil:</strong> Dual Mesh Coil | Dual Core Heating</li>
                            <li><strong>Display:</strong> Large Screen (Battery, Mode, E-liquid Level)</li>
                            <li><strong>Nicotine Strength:</strong> 5% | 50mg</li>
                            <li><strong>Coil:</strong> Dual Mesh Coil | Dual Core Heating</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <!-- Full Width Description Section -->
        <div class="product-long-description">

            <div class="description-tabs">
                <button class="tab-btn active">Long Description</button>
                <button class="tab-btn">Reviews</button>
            </div>

            <div class="tab-content-wrapper">
                <!-- Description Tab -->
                <div class="tab-content active" id="tab-description">
                    <h3>Discover the Excellence</h3>
                    <p>Designed for those who appreciate the finer things in life, the Premium Valiburn Pod Kit offers a
                        sophisticated vaping experience that stands out from the crowd. With its advanced airflow system
                        and
                        leak-proof technology, every puff is guaranteed to be smooth and flavorful.</p>

                    <ul class="feature-list">
                        <li><i data-lucide="check-circle"></i> Dual Airflow Technology for customizable hits.</li>
                        <li><i data-lucide="check-circle"></i> Long-lasting 1500mAh battery for all-day use.</li>
                        <li><i data-lucide="check-circle"></i> Fast USB-C charging capability.</li>
                        <li><i data-lucide="check-circle"></i> Ergonomic design with premium metallic finish.</li>
                    </ul>

                    <p>Whether you're transitioning from traditional smoking or looking for a reliable daily device, the
                        Valiburn delivers consistent satisfaction. Its compact size makes it perfect for on-the-go
                        vaping
                        without compromising on power or flavor intensity.</p>

                    <!-- Product Video Section -->
                    <div class="product-video-section">
                        <div class="section-title-sm">
                            <h3>Watch Product Showcase</h3>
                        </div>
                        <div class="video-wrapper">
                            <iframe width="100%" height="500" src="https://www.youtube.com/embed/S_8qOAtWIdE"
                                title="Product Video" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-content" id="tab-reviews" style="display: none;">
                    <div class="reviews-header">
                        <div class="overall-rating">
                            <h2>4.8</h2>
                            <div class="stars">
                                <i data-lucide="star" class="fill"></i>
                                <i data-lucide="star" class="fill"></i>
                                <i data-lucide="star" class="fill"></i>
                                <i data-lucide="star" class="fill"></i>
                                <i data-lucide="star" class="fill"></i>
                            </div>
                            <p>Based on 24 Reviews</p>
                        </div>
                        <button class="btn-write-review">Write a Review</button>
                    </div>

                    <!-- Inline Review Form (Initially Hidden) -->
                    <div id="reviewFormContainer" class="review-form-inline" style="display: none;">
                        <div class="form-wrapper glass-effect">
                            <div class="form-header">
                                <h3>Share Your Experience</h3>
                                <p>Your email address will not be published.</p>
                            </div>
                            <form id="reviewForm" class="review-form">
                                <div class="form-row">
                                    <div class="form-group rating-selection">
                                        <label>Your Rating</label>
                                        <div class="star-rating-input" id="starRating">
                                            <i data-lucide="star" data-value="1"></i>
                                            <i data-lucide="star" data-value="2"></i>
                                            <i data-lucide="star" data-value="3"></i>
                                            <i data-lucide="star" data-value="4"></i>
                                            <i data-lucide="star" data-value="5"></i>
                                        </div>
                                        <input type="hidden" name="rating" id="ratingInput" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="reviewTitle">Review Title</label>
                                    <input type="text" id="reviewTitle" name="title" maxlength="100"
                                        placeholder="e.g. Excellent quality!" required>
                                </div>

                                <div class="form-group">
                                    <label for="reviewEmail">Your Email</label>
                                    <input type="email" id="reviewEmail" name="email" placeholder="email@example.com"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="reviewContent">Review Content</label>
                                    <textarea id="reviewContent" name="content" rows="4"
                                        placeholder="How was your experience with this product?" required></textarea>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn-submit-review">Post Review</button>
                                    <button type="button" class="btn-cancel-review" id="cancelReview">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="reviews-list">
                        <!-- Review 1 -->
                        <div class="review-item">
                            <div class="review-meta">
                                <div class="review-user">
                                    <span class="user-initial">M</span>
                                    <div>
                                        <h4>Mark Stevenson</h4>
                                        <span class="review-date">April 12, 2024</span>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    <i data-lucide="star" class="fill"></i>
                                    <i data-lucide="star" class="fill"></i>
                                    <i data-lucide="star" class="fill"></i>
                                    <i data-lucide="star" class="fill"></i>
                                    <i data-lucide="star" class="fill"></i>
                                </div>
                            </div>
                            <p class="review-text">Absolutely brilliant device! The flavor is incredibly crisp and the
                                battery lasts me all day. Highly recommended for anyone looking for a reliable pod kit.
                            </p>
                        </div>

                        <!-- Review 2 -->
                        <div class="review-item">
                            <div class="review-meta">
                                <div class="review-user">
                                    <span class="user-initial">S</span>
                                    <div>
                                        <h4>Sarah Johnson</h4>
                                        <span class="review-date">March 28, 2024</span>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    <i data-lucide="star" class="fill"></i>
                                    <i data-lucide="star" class="fill"></i>
                                    <i data-lucide="star" class="fill"></i>
                                    <i data-lucide="star" class="fill"></i>
                                    <i data-lucide="star"></i>
                                </div>
                            </div>
                            <p class="review-text">Great compact design. It fits perfectly in my pocket. The only minor
                                issue is the charging port position, but other than that, it's perfect!</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Related Product -->
        <section class="product-section">
            <div class="section-header">
                <h2>Related Products</h2>
                <a href="#" class="view-all">View All Products</a>
            </div>
            <div class="product-grid">
                <?php
                $products = [
                    ['name' => 'High-Capacity Battery', 'price' => '£18.50', 'old' => '£25.00', 'img' => 'product-9.jpg'],
                    ['name' => 'Custom Drip Tip', 'price' => '£5.99', 'old' => '£8.00', 'img' => 'product-8.jpg'],
                    ['name' => 'Organic Cotton Pack', 'price' => '£4.50', 'old' => '£6.00', 'img' => 'product-7.jpg'],
                    ['name' => 'Replacement Glass Tank', 'price' => '£7.00', 'old' => '£10.00', 'img' => 'product-2.jpg'],
                ];
                foreach ($products as $p): ?>
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <img src="<?= BASE_URL ?>/assets/product/<?php echo $p['img']; ?>" alt="<?php echo $p['name']; ?>"
                                loading="lazy">
                            <div class="product-actions">
                                <button class="action-btn" title="Add to Wishlist"><i data-lucide="heart"></i></button>
                                <button class="action-btn" title="Quick View"><i data-lucide="eye"></i></button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name"><?php echo $p['name']; ?></h3>
                            <div class="product-price-container">
                                <span class="old-price"><?php echo $p['old']; ?></span>
                                <span class="current-price"><?php echo $p['price']; ?></span>
                            </div>
                            <button class="btn-buy">Add to Cart</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>




</main>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="<?= BASE_URL ?>/js/product-detail.js"></script>

<?php require VIEW_DIR . '/front/partials/footer.php'; ?>