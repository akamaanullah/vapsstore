<?php 
$pageTitle = "Dashboard | Vape Store Admin";
$pageScript = "dashboard.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="dashboard-page-content">
    <div class="page-header-container mb-30" style="display:; justify-content: space-between; align-items: flex-start;">
        <div class="header-title-group">
            <h1 class="m-0">Dashboard</h1>
        </div>
        <div class="header-actions">
            <button class="btn btn-primary">
                <i data-lucide="download"></i>
                <span>Download Report</span>
            </button>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="dashboard-stats-grid mb-30">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon-box bg-soft-primary">
                    <i data-lucide="dollar-sign" class="text-primary"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Total Revenue</span>
                    <span class="stat-change text-success">+12.5% <i data-lucide="trending-up"></i></span>
                </div>
            </div>
            <div class="stat-card-body">
                <h2 class="stat-value">$172.87</h2>
                <div class="stat-sparkline">
                    <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="height: 30px; width: 100%;">
                        <path d="M0 25 C 20 25, 40 5, 60 15 S 80 5, 100 10" fill="none" stroke="#6f6af8" stroke-width="2" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon-box bg-soft-info">
                    <i data-lucide="shopping-bag" class="text-info"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Total Orders</span>
                    <span class="stat-change text-success">+8.2% <i data-lucide="trending-up"></i></span>
                </div>
            </div>
            <div class="stat-card-body">
                <h2 class="stat-value">19</h2>
                <div class="stat-sparkline">
                    <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="height: 30px; width: 100%;">
                        <path d="M0 20 L 10 15 L 20 25 L 30 10 L 40 20 L 50 5 L 60 15 L 70 10 L 80 25 L 90 15 L 100 5" fill="none" stroke="#0ea5e9" stroke-width="2" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon-box bg-soft-warning">
                    <i data-lucide="users" class="text-warning"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Total Customers</span>
                    <span class="stat-change text-success">+5.4% <i data-lucide="trending-up"></i></span>
                </div>
            </div>
            <div class="stat-card-body">
                <h2 class="stat-value">8</h2>
                <div class="stat-sparkline">
                    <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="height: 30px; width: 100%;">
                        <circle cx="50" cy="15" r="12" fill="none" stroke="#f59e0b" stroke-width="2" stroke-dasharray="4,2" />
                        <circle cx="50" cy="15" r="8" fill="none" stroke="#f59e0b" stroke-width="2" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon-box bg-soft-success">
                    <i data-lucide="box" class="text-success"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Total Products</span>
                    <span class="stat-sub-label">65 active</span>
                </div>
            </div>
            <div class="stat-card-body">
                <h2 class="stat-value">65</h2>
                <div class="stat-sparkline">
                    <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="height: 30px; width: 100%;">
                        <rect x="10" y="10" width="10" height="10" fill="#10b981" opacity="0.3" />
                        <rect x="25" y="5" width="10" height="15" fill="#10b981" opacity="0.6" />
                        <rect x="40" y="12" width="10" height="8" fill="#10b981" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="dashboard-main-grid mb-30">
        <!-- Sales Trend -->
        <div class="card grid-span-2">
            <div class="card-header-flex mb-20">
                <h3 class="card-title-sm">Sales Analytics</h3>
                <div class="chart-legend">
                    <span class="legend-item"><span class="dot bg-primary"></span> Revenue</span>
                    <span class="legend-item"><span class="dot bg-secondary"></span> Orders</span>
                </div>
            </div>
            <div class="chart-container" style="height: 300px;">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>

        <!-- Order Status Donut -->
        <div class="card">
            <h3 class="card-title-sm mb-20">Order Status</h3>
            <div class="chart-container" style="height: 220px; display: flex; align-items: center; justify-content: center;">
                <canvas id="orderStatusChart"></canvas>
            </div>
            <div class="status-summary-list mt-20">
                <div class="status-item">
                    <span class="status-dot bg-success"></span>
                    <span class="status-name">Delivered</span>
                    <span class="status-count">12</span>
                </div>
                <div class="status-item">
                    <span class="status-dot bg-warning"></span>
                    <span class="status-name">Pending</span>
                    <span class="status-count">5</span>
                </div>
                <div class="status-item">
                    <span class="status-dot bg-danger"></span>
                    <span class="status-name">Cancelled</span>
                    <span class="status-count">2</span>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-main-grid">
        <!-- Recent Orders -->
        <div class="card grid-span-2">
            <div class="card-header-flex mb-15">
                <h3 class="card-title-sm">Recent Orders</h3>
                <a href="<?= BASE_URL ?>/admin/orders" class="link-primary-sm">View all orders</a>
            </div>
            <div class="table-responsive">
                <table class="data-table-minimal">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="fw-600">#ORD-2401</span></td>
                            <td>Today, 10:45 AM</td>
                            <td>John Doe</td>
                            <td>$156.00</td>
                            <td><span class="badge-active">Paid</span></td>
                        </tr>
                        <tr>
                            <td><span class="fw-600">#ORD-2402</span></td>
                            <td>Today, 09:12 AM</td>
                            <td>Sarah Smith</td>
                            <td>$89.50</td>
                            <td><span class="badge-draft">Pending</span></td>
                        </tr>
                        <tr>
                            <td><span class="fw-600">#ORD-2399</span></td>
                            <td>Yesterday</td>
                            <td>Mike Johnson</td>
                            <td>$210.00</td>
                            <td><span class="badge-active">Paid</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Inventory Alerts -->
        <div class="card">
            <div class="card-header-flex mb-15">
                <h3 class="card-title-sm">Inventory Alerts</h3>
                <span class="badge-danger-sm">3 Low Stock</span>
            </div>
            <div class="alert-list">
                <div class="alert-item">
                    <div class="alert-product-info">
                        <img src="<?= BASE_URL ?>/admin_assets/image/placeholder.png" alt="" class="alert-img">
                        <div>
                            <p class="alert-name">Geek Bar Pulse 15k</p>
                            <p class="alert-variant">Blue Razz Ice</p>
                        </div>
                    </div>
                    <div class="alert-status">
                        <span class="text-danger fw-600">2 left</span>
                        <button class="btn-icon-sm"><i data-lucide="refresh-cw"></i></button>
                    </div>
                </div>
                <div class="alert-item">
                    <div class="alert-product-info">
                        <img src="<?= BASE_URL ?>/admin_assets/image/placeholder.png" alt="" class="alert-img">
                        <div>
                            <p class="alert-name">Oxbar x Pod Juice</p>
                            <p class="alert-variant">Clear</p>
                        </div>
                    </div>
                    <div class="alert-status">
                        <span class="text-danger fw-600">5 left</span>
                        <button class="btn-icon-sm"><i data-lucide="refresh-cw"></i></button>
                    </div>
                </div>
                <div class="alert-item">
                    <div class="alert-product-info">
                        <img src="<?= BASE_URL ?>/admin_assets/image/placeholder.png" alt="" class="alert-img">
                        <div>
                            <p class="alert-name">Vaporesso XROS 3</p>
                            <p class="alert-variant">Silver</p>
                        </div>
                    </div>
                    <div class="alert-status">
                        <span class="text-warning fw-600">8 left</span>
                        <button class="btn-icon-sm"><i data-lucide="refresh-cw"></i></button>
                    </div>
                </div>
            </div>
            <a href="<?= BASE_URL ?>/admin/products" class="btn btn-outline btn-full mt-20">View Inventory</a>
        </div>
    </div>

    <!-- New Insights Row -->
    <div class="dashboard-main-grid mb-30">
        <!-- Top Selling Categories -->
        <div class="card grid-span-2">
            <h3 class="card-title-sm mb-20">Top Selling Categories</h3>
            <div class="chart-container" style="height: 250px;">
                <canvas id="topCategoriesChart"></canvas>
            </div>
        </div>

        <!-- New vs Returning -->
        <div class="card">
            <h3 class="card-title-sm mb-20">Customers</h3>
            <div class="chart-container" style="height: 200px;">
                <canvas id="customerRetentionChart"></canvas>
            </div>
            <div class="customer-stats-grid mt-20">
                <div class="cust-stat">
                    <p class="text-muted-sm m-0">New</p>
                    <p class="fw-700 m-0">65%</p>
                </div>
                <div class="cust-stat">
                    <p class="text-muted-sm m-0">Returning</p>
                    <p class="fw-700 m-0">35%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Final Row: Activity & Search -->
    <div class="dashboard-main-grid">
        <!-- Real-time Activity Feed -->
        <div class="card grid-span-2">
            <div class="card-header-flex mb-20">
                <h3 class="card-title-sm">Live Activity Feed</h3>
                <span class="pulse-indicator"><span class="pulse-dot"></span> Live</span>
            </div>
            <div class="activity-timeline">
                <div class="activity-item">
                    <div class="activity-point bg-primary"></div>
                    <div class="activity-content">
                        <p class="m-0 fs-13"><span class="fw-600">Arsalan Khan</span> placed a new order <a href="#" class="link-primary-xs">#ORD-2405</a></p>
                        <span class="text-muted-xs">2 minutes ago</span>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-point bg-success"></div>
                    <div class="activity-content">
                        <p class="m-0 fs-13">New product <span class="fw-600">Lost Mary MO5000</span> was added to inventory</p>
                        <span class="text-muted-xs">15 minutes ago</span>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-point bg-warning"></div>
                    <div class="activity-content">
                        <p class="m-0 fs-13"><span class="fw-600">Zeeshan</span> left a 5-star review on <span class="fw-600">Elf Bar BC5000</span></p>
                        <span class="text-muted-xs">1 hour ago</span>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-point bg-info"></div>
                    <div class="activity-content">
                        <p class="m-0 fs-13"><span class="fw-600">Fatima</span> updated their profile information</p>
                        <span class="text-muted-xs">3 hours ago</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Search Terms -->
        <div class="card">
            <h3 class="card-title-sm mb-20">Popular Search Terms</h3>
            <div class="search-terms-list">
                <div class="search-term-item">
                    <span class="term-name">Disposable Vape</span>
                    <span class="term-count">1.2k</span>
                </div>
                <div class="search-term-item">
                    <span class="term-name">Nicotine Free</span>
                    <span class="term-count">850</span>
                </div>
                <div class="search-term-item">
                    <span class="term-name">Geek Bar</span>
                    <span class="term-count">720</span>
                </div>
                <div class="search-term-item">
                    <span class="term-name">Pod Systems</span>
                    <span class="term-count">540</span>
                </div>
                <div class="search-term-item">
                    <span class="term-name">Blue Razz Ice</span>
                    <span class="term-count">430</span>
                </div>
            </div>
            <p class="text-muted-sm mt-20">Insights based on the last 7 days of store searches.</p>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>


