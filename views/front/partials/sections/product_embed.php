<?php if (!empty($section['items'])): ?>
<div class="product-embed-section horizontal">
    <?php if (!empty($section['title'])): ?>
        <h3 class="embed-title"><?= htmlspecialchars($section['title']) ?></h3>
    <?php endif; ?>
    
    <div class="product-horizontal-list">
        <?php foreach ($section['items'] as $item): ?>
            <?php 
                $productId = $item['entity_id'];
                $productName = $item['title'] ?? 'Product';
                $productPrice = $item['price'] ?? '0.00';
                $productDesc = $item['short_desc'] ?? '';
                $productImage = $item['image_url'] ?? 'assets/product/product-1.jpg';
                $productUrl = BASE_URL . '/product/' . ($item['product_slug'] ?? $productId);
                $variants = $item['variants'] ?? [];
                $hasVariants = count($variants) > 1 || (!empty($variants[0]['variant_name']));
            ?>
            <div class="product-embed-slim" data-product-id="<?= $productId ?>">
                <div class="slim-left">
                    <div class="slim-img">
                        <a href="<?= $productUrl ?>">
                            <img src="<?= BASE_URL ?>/<?= htmlspecialchars($productImage) ?>" alt="<?= htmlspecialchars($productName) ?>">
                        </a>
                    </div>
                    <div class="slim-info">
                        <h4 class="slim-title"><a href="<?= $productUrl ?>"><?= htmlspecialchars($productName) ?></a></h4>
                        <p class="slim-desc"><?= htmlspecialchars(substr($productDesc, 0, 80)) ?><?= strlen($productDesc) > 80 ? '...' : '' ?></p>
                    </div>
                </div>
                
                <div class="slim-right">
                    <?php if ($hasVariants): ?>
                        <select class="slim-variant-select" onchange="updateSlimPrice(this)">
                            <?php foreach ($variants as $v): ?>
                                <option value="<?= $v['id'] ?>" data-price="<?= $v['price'] ?>">
                                    <?= htmlspecialchars($v['variant_name'] ?: 'Select') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                    <div class="slim-qty">
                        <button type="button" class="qty-btn" onclick="changeQty(this, -1)">-</button>
                        <input type="number" class="qty-input" value="1" min="1" readonly>
                        <button type="button" class="qty-btn" onclick="changeQty(this, 1)">+</button>
                    </div>
                    
                    <div class="slim-price-wrap">
                        <span class="slim-price">£<?= number_format((float)$productPrice, 2) ?></span>
                    </div>
                    
                    <div class="slim-action">
                        <button type="button" class="btn-add-to-cart">Add To Cart</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function changeQty(btn, delta) {
    const input = btn.parentElement.querySelector('.qty-input');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    input.value = val;
}

function updateSlimPrice(select) {
    const price = select.options[select.selectedIndex].getAttribute('data-price');
    const card = select.closest('.product-embed-slim');
    const priceDisplay = card.querySelector('.slim-price');
    if (priceDisplay) {
        priceDisplay.innerText = '£' + parseFloat(price).toFixed(2);
    }
}
</script>

<style>
.product-embed-section.horizontal {
    margin: 25px 0;
}

.product-horizontal-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.product-embed-slim {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff;
    border: 1px solid #f1f5f9;
    border-radius: 12px;
    padding: 12px 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    transition: all 0.3s ease;
}

.product-embed-slim:hover {
    box-shadow: 0 8px 30px rgba(0,0,0,0.06);
    border-color: #e2e8f0;
}

.slim-left {
    display: flex;
    align-items: center;
    flex: 1;
    gap: 15px;
}

.slim-img {
    width: 64px;
    height: 64px;
    flex-shrink: 0;
    border-radius: 8px;
    overflow: hidden;
    background: #f8fafc;
}

.slim-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.slim-info {
    flex: 1;
}

.slim-title {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
}

.slim-title a {
    text-decoration: none;
    color: inherit;
}

.slim-desc {
    margin: 2px 0 0 0;
    font-size: 12px;
    color: #64748b;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.slim-variant-select {
    padding: 6px 30px 6px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
    color: #475569;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") no-repeat right 10px center;
    appearance: none;
    -webkit-appearance: none;
    outline: none;
    cursor: pointer;
    transition: all 0.2s;
    min-width: 110px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}

.slim-variant-select:hover {
    border-color: #cbd5e1;
    background-color: #f8fafc;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.slim-variant-select:focus {
    border-color: #bd0028;
    box-shadow: 0 0 0 2px rgba(189, 0, 40, 0.1);
}

.slim-right {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-left: 20px;
}

.slim-qty {
    display: flex;
    align-items: center;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 2px 8px;
    height: 36px;
}

.slim-qty .qty-btn {
    border: none;
    background: none;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 16px;
    color: #64748b;
}

.slim-qty .qty-input {
    width: 30px;
    border: none;
    background: transparent;
    text-align: center;
    font-weight: 600;
    font-size: 14px;
}

.slim-price-wrap {
    min-width: 70px;
    text-align: right;
}

.slim-price {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
}

.btn-add-to-cart {
    display: inline-block;
    background: #bd0028; /* Theme Red */
    color: #fff;
    padding: 8px 20px;
    border: none;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    white-space: nowrap;
    cursor: pointer;
}

.btn-add-to-cart:hover {
    background: #a00022;
    transform: scale(1.05);
}

@media (max-width: 768px) {
    .product-embed-slim {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    .slim-right {
        width: 100%;
        padding-left: 0;
        justify-content: space-between;
        border-top: 1px solid #f1f5f9;
        padding-top: 15px;
    }
}
</style>
<?php endif; ?>
