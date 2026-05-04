<?php 
$pageTitle = "Customers | Vape Store Admin";
$pageScript = "customers.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Customers</h1>
    
    <div class="header-actions">
        <div class="search-container">
            <input type="text" placeholder="Search customers..." class="search-input">
        </div>

        <div class="per-page-container">
            <span class="text-label">Rows:</span>
            <select class="per-page-select">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
        <button class="btn btn-primary btn-add" id="exportBtn">
            <i class="iconoir-download"></i>
            <span>Export CSV</span>
        </button>
    </div>
</div>

<div class="card card-no-padding">
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th class="th-product">Customer Name</th>
                    <th class="th-default">Email</th>
                    <th class="th-default">Location</th>
                    <th class="th-default">Orders</th>
                    <th class="th-default">Amount Spent</th>
                    <th class="th-action">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sampleCustomers = [
                    ['name' => 'Alice Johnson', 'email' => 'alice@example.com', 'location' => 'New York, USA', 'orders' => 12, 'spent' => 450.00, 'image' => ''],
                    ['name' => 'Bob Smith', 'email' => 'bob@example.com', 'location' => 'London, UK', 'orders' => 1, 'spent' => 25.50, 'image' => ''],
                    ['name' => 'Charlie Brown', 'email' => 'charlie@example.com', 'location' => 'Sydney, AU', 'orders' => 5, 'spent' => 180.00, 'image' => ''],
                    ['name' => 'Diana Prince', 'email' => 'diana@example.com', 'location' => 'Paris, FR', 'orders' => 28, 'spent' => 1250.75, 'image' => ''],
                    ['name' => 'Ethan Hunt', 'email' => 'ethan@example.com', 'location' => 'Berlin, DE', 'orders' => 0, 'spent' => 0.00, 'image' => ''],
                    ['name' => 'Fiona Gallagher', 'email' => 'fiona@example.com', 'location' => 'Chicago, USA', 'orders' => 3, 'spent' => 110.20, 'image' => ''],
                    ['name' => 'George Costanza', 'email' => 'george@example.com', 'location' => 'New York, USA', 'orders' => 15, 'spent' => 540.00, 'image' => ''],
                    ['name' => 'Hannah Abbott', 'email' => 'hannah@example.com', 'location' => 'London, UK', 'orders' => 8, 'spent' => 290.40, 'image' => ''],
                    ['name' => 'Ian Malcolm', 'email' => 'ian@example.com', 'location' => 'Austin, USA', 'orders' => 2, 'spent' => 65.00, 'image' => ''],
                    ['name' => 'Julia Roberts', 'email' => 'julia@example.com', 'location' => 'Los Angeles, USA', 'orders' => 42, 'spent' => 2100.00, 'image' => ''],
                    ['name' => 'Kevin Hart', 'email' => 'kevin@example.com', 'location' => 'Philadelphia, USA', 'orders' => 4, 'spent' => 140.50, 'image' => ''],
                    ['name' => 'Laura Palmer', 'email' => 'laura@example.com', 'location' => 'Twin Peaks, USA', 'orders' => 7, 'spent' => 230.00, 'image' => ''],
                    ['name' => 'Michael Scott', 'email' => 'michael@example.com', 'location' => 'Scranton, USA', 'orders' => 18, 'spent' => 720.99, 'image' => ''],
                    ['name' => 'Nancy Wheeler', 'email' => 'nancy@example.com', 'location' => 'Hawkins, USA', 'orders' => 6, 'spent' => 195.00, 'image' => ''],
                    ['name' => 'Oscar Martinez', 'email' => 'oscar@example.com', 'location' => 'Scranton, USA', 'orders' => 11, 'spent' => 410.25, 'image' => ''],
                ];
                
                foreach ($sampleCustomers as $customer): ?>
                <tr>
                    <td class="td-product">
                        <div class="product-info-flex">
                            <img src="<?= BASE_URL ?>/admin_assets/image/default-profile-picture.webp" alt="" class="product-image">
                            <a href="<?= BASE_URL ?>/admin/customers/detail" class="product-name-txt" style="text-decoration: none;"><?php echo $customer['name']; ?></a>
                        </div>
                    </td>
                    <td class="td-default text-muted"><?php echo $customer['email']; ?></td>
                    <td class="td-default text-muted"><?php echo $customer['location']; ?></td>
                    <td class="td-default text-muted"><?php echo $customer['orders']; ?></td>
                    <td class="td-default text-price">$<?php echo number_format($customer['spent'], 2); ?></td>
                    <td class="td-action">
                        <div class="action-flex">
                            <a href="<?= BASE_URL ?>/admin/customers/detail" class="btn-action-icon view-btn" title="View Details">
                                <i data-lucide="eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="pagination-container">
        <div class="pagination-info">
            Showing <span id="page-start">1</span> to <span id="page-end">0</span> of <span id="page-total">0</span> entries
        </div>
        <ul class="pagination">
            <!-- Populated by JS -->
        </ul>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>

