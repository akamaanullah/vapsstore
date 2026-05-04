<?php 
$pageTitle = "Product Reviews | Vape Store Admin";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Product Reviews</h1>
    <div class="header-actions">
        <select class="status-dropdown">
            <option>All Reviews</option>
            <option>Pending</option>
            <option>Approved</option>
        </select>
    </div>
</div>

<div class="card card-no-padding">
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th class="th-product">Review</th>
                    <th class="th-default">Product</th>
                    <th class="th-default">Rating</th>
                    <th class="th-default">Status</th>
                    <th class="th-action">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sampleReviews = [
                    ['user' => 'John Doe', 'product' => 'Geek Bar Pulse', 'rating' => 5, 'status' => 'Approved', 'comment' => 'Best flavor ever!'],
                    ['user' => 'Sarah Smith', 'product' => 'Vaporesso XROS 3', 'rating' => 4, 'status' => 'Pending', 'comment' => 'Great device, fast shipping.'],
                ];
                
                foreach ($sampleReviews as $review): ?>
                <tr>
                    <td class="td-product">
                        <div>
                            <span class="fw-600 d-block"><?php echo $review['user']; ?></span>
                            <p class="text-muted-sm m-0 italic">"<?php echo $review['comment']; ?>"</p>
                        </div>
                    </td>
                    <td class="td-default text-muted"><?php echo $review['product']; ?></td>
                    <td class="td-default">
                        <div class="rating-stars" style="color: #ffc107;">
                            <?php for($i=0; $i<$review['rating']; $i++) echo '<i data-lucide="star" style="width:14px; fill: currentColor;"></i>'; ?>
                        </div>
                    </td>
                    <td class="td-default">
                        <span class="status-badge <?php echo $review['status'] == 'Approved' ? 'badge-active' : 'badge-draft'; ?>">
                            <?php echo $review['status']; ?>
                        </span>
                    </td>
                    <td class="td-action">
                        <div class="action-flex">
                            <button class="btn-action-icon edit-btn" title="Approve">
                                <i data-lucide="check"></i>
                            </button>
                            <button class="btn-action-icon delete-btn" title="Delete">
                                <i data-lucide="trash-2"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
