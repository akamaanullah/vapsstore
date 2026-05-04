<?php 
$pageTitle = "Alice Johnson | Customer Details";
$pageScript = "customer-detail.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/customers" class="btn-action-icon" title="Back to Customers">
            <i data-lucide="arrow-left"></i>
        </a>
        <div>
            <h1 class="m-0">Alice Johnson</h1>
            <p class="text-muted-sm">Customer since Oct 12, 2023 • <span class="badge-active status-badge">Active</span></p>
        </div>
    </div>
    
    <div class="header-actions">
        <button class="btn btn-outline">
            <i data-lucide="mail"></i>
            <span>Send Email</span>
        </button>
    </div>
</div>

<div class="form-layout">
    <!-- Main Content -->
    <div class="form-main">
        <!-- Stats Overview -->
        <!-- Stats Overview -->
        <div class="dashboard-stats-grid mb-30">
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
                    <h2 class="stat-value">12</h2>
                    <div class="stat-sparkline">
                        <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="height: 30px; width: 100%;">
                            <rect x="5" y="15" width="8" height="15" fill="#0ea5e9" opacity="0.3" rx="2" />
                            <rect x="20" y="10" width="8" height="20" fill="#0ea5e9" opacity="0.5" rx="2" />
                            <rect x="35" y="18" width="8" height="12" fill="#0ea5e9" opacity="0.4" rx="2" />
                            <rect x="50" y="5" width="8" height="25" fill="#0ea5e9" opacity="0.7" rx="2" />
                            <rect x="65" y="12" width="8" height="18" fill="#0ea5e9" opacity="0.6" rx="2" />
                            <rect x="80" y="2" width="8" height="28" fill="#0ea5e9" rx="2" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon-box bg-soft-primary">
                        <i data-lucide="dollar-sign" class="text-primary"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Total Spent</span>
                        <span class="stat-change text-success">+12.5% <i data-lucide="trending-up"></i></span>
                    </div>
                </div>
                <div class="stat-card-body">
                    <h2 class="stat-value">$450.00</h2>
                    <div class="stat-sparkline">
                        <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="height: 30px; width: 100%;">
                            <path d="M0 28 Q 25 28, 50 15 T 100 2" fill="none" stroke="#6f6af8" stroke-width="2.5" stroke-linecap="round" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon-box bg-soft-warning">
                        <i data-lucide="trending-up" class="text-warning"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Avg. Order Value</span>
                        <span class="stat-change text-success">+5.4% <i data-lucide="trending-up"></i></span>
                    </div>
                </div>
                <div class="stat-card-body">
                    <h2 class="stat-value">$37.50</h2>
                    <div class="stat-sparkline">
                        <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="height: 30px; width: 100%;">
                            <line x1="0" y1="25" x2="100" y2="5" stroke="#f59e0b" stroke-width="2" stroke-dasharray="5,3" />
                            <circle cx="100" cy="5" r="3" fill="#f59e0b" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order History -->
        <div class="card card-no-padding">
            <div class="card-header-padding d-grid justify-content-between align-items-end card-header-padding-fix">
                <h3 class="m-0">Order History</h3>
                <span class="text-muted-sm text-11 fw-500">Showing last 5 orders</span>
            </div>
            <div class="table-responsive">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th class="th-default th-bg-muted table-padding-x">Order ID</th>
                            <th class="th-default th-bg-muted">Date</th>
                            <th class="th-default th-bg-muted">Status</th>
                            <th class="th-default th-bg-muted">Items</th>
                            <th class="th-default th-bg-muted text-right table-padding-x">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="td-default td-row-padding table-padding-x"><a href="<?= BASE_URL ?>/admin/orders/detail" class="order-id-link">#ORD-7721</a></td>
                            <td class="td-default text-muted">Oct 24, 2023</td>
                            <td class="td-default"><span class="status-badge badge-active">Fulfilled</span></td>
                            <td class="td-default text-muted">3 Items</td>
                            <td class="td-default fw-700 text-right table-padding-x text-dark">$125.00</td>
                        </tr>
                        <tr>
                            <td class="td-default td-row-padding table-padding-x"><a href="<?= BASE_URL ?>/admin/orders/detail" class="order-id-link">#ORD-7690</a></td>
                            <td class="td-default text-muted">Oct 18, 2023</td>
                            <td class="td-default"><span class="status-badge badge-active">Fulfilled</span></td>
                            <td class="td-default text-muted">1 Item</td>
                            <td class="td-default fw-700 text-right table-padding-x text-dark">$45.00</td>
                        </tr>
                        <tr>
                            <td class="td-default td-row-padding table-padding-x"><a href="<?= BASE_URL ?>/admin/orders/detail" class="order-id-link">#ORD-7542</a></td>
                            <td class="td-default text-muted">Oct 05, 2023</td>
                            <td class="td-default"><span class="status-badge badge-active">Fulfilled</span></td>
                            <td class="td-default text-muted">2 Items</td>
                            <td class="td-default fw-700 text-right table-padding-x text-dark">$80.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Timeline -->
        <div class="card">
            <h3 class="mb-20">Customer Timeline</h3>
            <div class="vertical-timeline-container">
                <div class="timeline-line"></div>
                <div class="timeline-items">
                    <div class="timeline-item">
                        <div class="timeline-marker marker-primary"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <span class="timeline-title"><strong>Order #ORD-7721</strong> was fulfilled</span>
                                <span class="timeline-date">Oct 24, 2023 • 02:45 PM</span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker marker-primary"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <span class="timeline-title">Placed <strong>Order #ORD-7721</strong></span>
                                <span class="timeline-date">Oct 24, 2023 • 10:15 AM</span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker marker-neutral">
                            <i data-lucide="mail" style="width: 10px; height: 10px;"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <span class="timeline-title">Sent inquiry about <strong>Wholesale Prices</strong></span>
                                <span class="timeline-date">Oct 22, 2023 • 11:30 AM</span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker marker-primary"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <span class="timeline-title">Account was created</span>
                                <span class="timeline-date">Oct 12, 2023 • 09:00 AM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Content -->
    <div class="form-sidebar">
        <!-- Customer Profile Card -->
        <div class="card">
            <div class="text-center mb-20">
                <img src="<?= BASE_URL ?>/admin_assets/image/default-profile-picture.webp" alt="Profile" style="width: 80px; height: 80px; border-radius: 50%;">
                <h3 class="m-0">Alice Johnson</h3>
                <p class="text-muted-sm text-13">alice@example.com</p>
            </div>
            <div class="info-list">
                <div class="info-item">
                    <span class="info-label">Phone</span>
                    <span class="info-value">+1 (555) 000-1234</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Marketing</span>
                    <span class="status-badge badge-active">Subscribed</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tax Status</span>
                    <span class="text-muted-sm text-12">Tax Exempt</span>
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="card">
            <div class="card-header-flex mb-15">
                <h3 class="card-title-sm">Shipping Address</h3>
            </div>
            <address class="address-box mt-5">
                Alice Johnson<br>
                123 Business Avenue, Suite 450<br>
                New York, NY 10001<br>
                United States
            </address>
        </div>

        <!-- Tags & Notes -->
        <div class="card">
            <h3 class="card-title-sm mb-15">Tags</h3>
            <div class="tags-container mb-20">
                <span class="tag">VIP Customer <i data-lucide="x"></i></span>
                <span class="tag">Wholesale <i data-lucide="x"></i></span>
                <span class="tag">Frequent Buyer <i data-lucide="x"></i></span>
            </div>
            
            <h3 class="card-title-sm mb-10">Private Notes</h3>
            <textarea class="modal-field-input text-13" rows="4" placeholder="Add a private note about this customer..." style="resize: none;"></textarea>
            <button class="btn btn-outline btn-sm mt-10 btn-full">Save Note</button>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>


