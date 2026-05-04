document.addEventListener('DOMContentLoaded', function() {
    // 1. Sales Trend Chart
    const salesTrendCtx = document.getElementById('salesTrendChart');
    if (salesTrendCtx) {
        new Chart(salesTrendCtx, {
            type: 'line',
            data: {
                labels: ['Jan 1', 'Jan 5', 'Jan 10', 'Jan 15', 'Jan 20', 'Jan 25', 'Jan 30'],
                datasets: [{
                    label: 'Revenue',
                    data: [1200, 1900, 1500, 2500, 2200, 3000, 2800],
                    borderColor: '#6f6af8',
                    backgroundColor: 'rgba(111, 106, 248, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Orders',
                    data: [80, 120, 100, 180, 150, 220, 190],
                    borderColor: '#10b981',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5] }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // 2. Order Status Chart (Donut)
    const orderStatusCtx = document.getElementById('orderStatusChart');
    if (orderStatusCtx) {
        new Chart(orderStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Delivered', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [12, 5, 2],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                cutout: '75%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    // 3. Top Selling Categories (Horizontal Bar)
    const topCategoriesCtx = document.getElementById('topCategoriesChart');
    if (topCategoriesCtx) {
        new Chart(topCategoriesCtx, {
            type: 'bar',
            data: {
                labels: ['Disposables', 'Pod Systems', 'E-Liquids', 'Coils/Pods', 'Accessories'],
                datasets: [{
                    label: 'Units Sold',
                    data: [450, 320, 280, 150, 90],
                    backgroundColor: '#6f6af8',
                    borderRadius: 6,
                    barThickness: 20
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { grid: { display: false } }
                }
            }
        });
    }

    // 4. Customer Retention Chart
    const customerRetentionCtx = document.getElementById('customerRetentionChart');
    if (customerRetentionCtx) {
        new Chart(customerRetentionCtx, {
            type: 'doughnut',
            data: {
                labels: ['New', 'Returning'],
                datasets: [{
                    data: [65, 35],
                    backgroundColor: ['#6f6af8', '#e2e8f0'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                cutout: '70%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    }

    // Mini Sparklines (Simplified representation)
    const sparklineOptions = {
        type: 'line',
        data: {
            labels: [1, 2, 3, 4, 5, 6, 7],
            datasets: [{
                data: [10, 15, 8, 12, 18, 14, 20],
                borderColor: '#6f6af8',
                borderWidth: 1.5,
                fill: false,
                pointRadius: 0,
                tension: 0.4
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { x: { display: false }, y: { display: false } },
            responsive: true,
            maintainAspectRatio: false
        }
    };

    // Initialize mini sparklines if needed (logic can be expanded)
});
