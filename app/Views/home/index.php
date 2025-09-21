<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?> 

<div class="geex-content__wrapper">
    <div class="geex-content__section-wrapper">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <!-- Title and subtitle are already displayed in the header -->
            </div>
            <div class="d-flex align-items-center gap-3">
                <!-- Store Status Indicator -->
                <!-- 
                    Store Status Logic:
                    - OPEN: During business hours (8 AM - 10 PM) and no daily closing recorded
                    - CLOSED: Either outside business hours OR daily closing has been recorded
                    - Business hours: 8:00 AM - 10:00 PM
                -->
                <!-- Store status indicator removed - not needed -->
            </div>e i 
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <!-- Total Products Card -->
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="uil uil-shopping-bag text-primary" style="font-size: 2.5rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mb-1"><?= $totalProducts ?></h4>
                                <p class="text-muted mb-0">Total Products</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="<?= route_to('products') ?>" class="btn btn-sm btn-outline-primary">
                                <i class="uil uil-eye"></i> View Products
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Categories Card -->
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="uil uil-tag-alt text-success" style="font-size: 2.5rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mb-1"><?= $totalCategories ?></h4>
                                <p class="text-muted mb-0">Total Categories</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="<?= route_to('categories') ?>" class="btn btn-sm btn-outline-success">
                                <i class="uil uil-eye"></i> View Categories
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Users Card -->
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="uil uil-user-circle text-info" style="font-size: 2.5rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mb-1"><?= $totalUsers ?></h4>
                                <p class="text-muted mb-0">Total Users</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="#" class="btn btn-sm btn-outline-info">
                                <i class="uil uil-eye"></i> View Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Sales Card -->
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm realtime-sales-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="uil uil-bill text-success" style="font-size: 2.5rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mb-1" id="todaySalesAmount">₱<?= number_format($todaySales['total_amount'] ?? 0, 2) ?></h4>
                                <p class="text-muted mb-0">Today's Sales</p>
                                <small class="text-success" id="salesUpdateIndicator" style="display: none;">
                                    <i class="uil uil-refresh"></i> Live Updates
                                </small>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="<?= base_url('admin/pos') ?>" class="btn btn-sm btn-outline-success">
                                <i class="uil uil-plus"></i> New Sale
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Transactions Card -->
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm realtime-transactions-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="uil uil-transaction text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mb-1" id="todayTransactionsCount"><?= $todaySales['total_transactions'] ?? 0 ?></h4>
                                <p class="text-muted mb-0">Today's Transactions</p>
                                <small class="text-warning" id="transactionsUpdateIndicator" style="display: none;">
                                    <i class="uil uil-refresh"></i> Live Updates
                                </small>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="<?= base_url('admin/pos') ?>" class="btn btn-sm btn-outline-warning">
                                <i class="uil uil-eye"></i> View POS
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Average Order Value Card -->
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="uil uil-chart-pie text-primary" style="font-size: 2.5rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mb-1">₱<?= number_format($todaySales['average_order'] ?? 0, 2) ?></h4>
                                <p class="text-muted mb-0">Avg Order Value</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="<?= base_url('admin/pos') ?>" class="btn btn-sm btn-outline-primary">
                                <i class="uil uil-chart"></i> View Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Sales Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm realtime-recent-sales">
                    <div class="card-header bg-transparent border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="uil uil-clock-three text-primary me-2"></i>
                                Recent Sales
                                <span class="badge bg-success ms-2" id="recentSalesUpdateIndicator" style="display: none;">
                                    <i class="uil uil-refresh"></i> Live
                                </span>
                            </h5>
                            <a href="<?= base_url('admin/pos') ?>" class="btn btn-sm btn-primary">
                                <i class="uil uil-plus"></i> New Sale
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="recentSalesTableContainer">
                            <?php if (!empty($recentSales)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                                                         <thead class="table-light">
                                         <tr>
                                             <th>Customer</th>
                                             <th>Amount</th>
                                             <th>Payment Method</th>
                                             <th>Time</th>
                                             <th>Status</th>
                                         </tr>
                                     </thead>
                                    <tbody id="recentSalesTableBody">
                                        <?php foreach ($recentSales as $sale): ?>
                                            <tr>
                                                <td>
                                                    <span class="badge bg-primary"><?= $sale['sale_number'] ?></span>
                                                </td>
                                                <td><?= $sale['customer_name'] ?? 'Walk-in Customer' ?></td>
                                                <td>
                                                    <span class="fw-bold text-success">₱<?= number_format($sale['total_amount'], 2) ?></span>
                                                </td>
                                                <td>
                                                    <?php
                                                    $methodColors = [
                                                        'cash' => 'success',
                                                        'card' => 'primary',
                                                        'bank_transfer' => 'info',
                                                        'online' => 'warning'
                                                    ];
                                                    $color = $methodColors[$sale['payment_method']] ?? 'secondary';
                                                    ?>
                                                    <span class="badge bg-<?= $color ?>"><?= ucfirst(str_replace('_', ' ', $sale['payment_method'])) ?></span>
                                                </td>
                                                <td><?= date('M d, Y g:i A', strtotime($sale['created_at'])) ?></td>
                                                <td>
                                                    <span class="badge bg-success">Completed</span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <i class="uil uil-receipt text-muted" style="font-size: 3rem;"></i>
                                    </div>
                                    <h5 class="text-muted">No Recent Sales</h5>
                                    <p class="text-muted mb-3">Start making sales to see them here</p>
                                    <a href="<?= base_url('admin/pos') ?>" class="btn btn-primary">
                                        <i class="uil uil-plus"></i> Start First Sale
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Daily Closings Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="uil uil-trophy text-warning me-2"></i>
                                Top 3 Daily Sales Summary
                            </h5>
                            <a href="<?= base_url('admin/sales-summary') ?>" class="btn btn-sm btn-warning">
                                <i class="uil uil-chart"></i> View Full Report
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($topDailyClosings)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Rank</th>
                                            <th>Date</th>
                                            <th>Total Sales</th>
                                            <th>Transactions</th>
                                            <th>Items Sold</th>
                                            <th>Cash Sales</th>
                                            <th>Card Sales</th>
                                            <th>Bank Transfer</th>
                                            <th>Online Sales</th>
                                            <th>Closed By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($topDailyClosings as $index => $closing): ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    $rankColors = [
                                                        0 => 'bg-warning', // 1st place
                                                        1 => 'bg-secondary', // 2nd place
                                                        2 => 'bg-info' // 3rd place
                                                    ];
                                                    $rankIcons = [
                                                        0 => 'uil-trophy',
                                                        1 => 'uil-medal',
                                                        2 => 'uil-award'
                                                    ];
                                                    ?>
                                                    <span class="badge <?= $rankColors[$index] ?> fs-6">
                                                        <i class="uil <?= $rankIcons[$index] ?> me-1"></i>
                                                        <?= $index + 1 ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong><?= date('M d, Y', strtotime($closing['closing_date'])) ?></strong>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-success fs-5">₱<?= number_format($closing['total_sales'], 2) ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?= $closing['total_transactions'] ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary"><?= $closing['total_items_sold'] ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-success">₱<?= number_format($closing['cash_sales'], 2) ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-primary">₱<?= number_format($closing['card_sales'], 2) ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-info">₱<?= number_format($closing['bank_transfer_sales'], 2) ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-warning">₱<?= number_format($closing['online_sales'], 2) ?></span>
                                                </td>
                                                <td>
                                                    <small class="text-muted"><?= $closing['closed_by_name'] ?? 'Unknown' ?></small>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info" onclick="viewDailyClosingDetails('<?= $closing['closing_date'] ?>')" title="View Details">
                                                        <i class="uil uil-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <div class="mb-3">
                                    <i class="uil uil-trophy text-muted" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="text-muted">No Daily Closings Yet</h5>
                                <p class="text-muted mb-3">Close some daily sales to see the top performers here</p>
                                <a href="<?= base_url('admin/pos') ?>" class="btn btn-warning">
                                    <i class="uil uil-cash-register"></i> Start Making Sales
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>



        <!-- Welcome section removed - duplicate of page header -->
    </div>
</div>

<!-- Daily Closing Details Modal -->
<div class="modal fade" id="dailyClosingDetailsModal" tabindex="-1" aria-labelledby="dailyClosingDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dailyClosingDetailsModalLabel">Daily Closing Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Date: <span id="modalClosingDate"></span></h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <h6>Total Sales: <span id="modalTotalSales"></span></h6>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="dailyClosingDetailsTable">
                        <thead>
                            <tr>
                                <th>Sale #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Time</th>
                                <th>Discount</th>
                                <th>Tax</th>
                            </tr>
                        </thead>
                        <tbody id="dailyClosingDetailsTableBody">
                            <tr>
                                <td colspan="7" class="text-center">Loading sales details...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('custom_scripts'); ?>
<script>
// Real-time dashboard updates using AJAX polling
let lastUpdateTime = '<?= $lastUpdated ?>';
let isUpdating = false;

// Auto-refresh dashboard data every 10 seconds
setInterval(() => {
    if (!isUpdating) {
        updateDashboardData();
    }
}, 10000);

// Update dashboard data from AJAX response
function updateDashboardData() {
    if (isUpdating) return;
    
    isUpdating = true;
    
    fetch('/admin/getRealtimeData')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update dashboard data
                updateDashboardFromData(data.data);
            }
        })
        .catch(error => console.error('Auto-refresh error:', error))
        .finally(() => {
            isUpdating = false;
        });
}

// Show update indicator with animation
function showUpdateIndicator(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.style.display = 'inline';
        element.style.animation = 'pulse 1s ease-in-out';
        
        setTimeout(() => {
            element.style.animation = '';
            setTimeout(() => {
                element.style.display = 'none';
            }, 3000);
        }, 1000);
    }
}

// Update recent sales table
function updateRecentSalesTable(recentSales) {
    const tbody = document.getElementById('recentSalesTableBody');
    if (!tbody) return;
    
    if (recentSales.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">No recent sales</td></tr>';
        return;
    }
    
    tbody.innerHTML = recentSales.map(sale => `
        <tr class="new-sale-row">
            <td>
                <span class="badge bg-primary">${sale.sale_number}</span>
            </td>
            <td>${sale.customer_name || 'Walk-in Customer'}</td>
            <td>
                <span class="fw-bold text-success">₱${parseFloat(sale.total_amount).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}</span>
            </td>
            <td>
                <span class="badge bg-${getPaymentMethodColor(sale.payment_method)}">${formatPaymentMethod(sale.payment_method)}</span>
            </td>
            <td>${formatDateTime(sale.created_at)}</td>
            <td>
                <span class="badge bg-success">Completed</span>
            </td>
        </tr>
    `).join('');
    
    // Add highlight animation to new rows
    const newRows = tbody.querySelectorAll('.new-sale-row');
    newRows.forEach(row => {
        row.style.backgroundColor = '#d4edda';
        setTimeout(() => {
            row.style.backgroundColor = '';
            row.classList.remove('new-sale-row');
        }, 2000);
    });
}

// Get payment method color
function getPaymentMethodColor(method) {
    const colors = {
        'cash': 'success',
        'card': 'primary',
        'bank_transfer': 'info',
        'online': 'warning'
    };
    return colors[method] || 'secondary';
}

// Format payment method
function formatPaymentMethod(method) {
    return method.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
}

// Format date time
function formatDateTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
    });
}

// Update store status
function updateStoreStatus(storeStatus) {
    const statusIndicator = document.querySelector('.store-status-indicator');
    if (!statusIndicator) return;
    
    if (storeStatus.is_open) {
        statusIndicator.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="status-dot bg-success me-2"></div>
                <span class="text-success fw-bold">STORE OPEN</span>
                <small class="text-muted ms-2">${storeStatus.business_hours || '8:00 AM - 10:00 PM'}</small>
            </div>
        `;
    } else {
        statusIndicator.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="status-dot bg-danger me-2"></div>
                <span class="text-danger fw-bold">STORE CLOSED</span>
                ${storeStatus.closed_at ? `<small class="text-muted ms-2">Closed at ${formatTime(storeStatus.closed_at)}</small>` : ''}
            </div>
        `;
    }
}

// Format time
function formatTime(timeString) {
    const date = new Date(timeString);
    return date.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
    });
}

// Update last updated time
function updateLastUpdatedTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
    });
    
    const lastUpdatedElement = document.getElementById('lastUpdated');
    if (lastUpdatedElement) {
        lastUpdatedElement.textContent = timeString;
    }
}

// View daily closing details for a specific date
function viewDailyClosingDetails(date) {
    document.getElementById('modalClosingDate').textContent = date;
    document.getElementById('modalTotalSales').textContent = '₱0.00';
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('dailyClosingDetailsModal'));
    modal.show();
    
    // Load sales details using the date
    fetch(`/admin/sales-summary/getSalesDetails/${date}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayDailyClosingDetails(data.data);
            } else {
                document.getElementById('dailyClosingDetailsTableBody').innerHTML = 
                    '<tr><td colspan="7" class="text-center text-danger">Error loading sales details: ' + data.message + '</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('dailyClosingDetailsTableBody').innerHTML = 
                '<tr><td colspan="7" class="text-center text-danger">Error loading sales details</td></tr>';
        });
}

// Display daily closing details in modal
function displayDailyClosingDetails(sales) {
    const tbody = document.getElementById('dailyClosingDetailsTableBody');
    
    if (sales.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center">No sales found for this date</td></tr>';
        document.getElementById('modalTotalSales').textContent = '₱0.00';
        return;
    }
    
    // Calculate total from individual sales
    const total = sales.reduce((sum, sale) => {
        return sum + parseFloat(sale.total_amount.replace(/[^0-9.-]+/g, ''));
    }, 0);
    
    document.getElementById('modalTotalSales').textContent = '₱' + total.toFixed(2);
    
    tbody.innerHTML = sales.map(sale => `
        <tr>
            <td>${sale.sale_number}</td>
            <td>${sale.customer_name}</td>
            <td><strong class="text-success">${sale.total_amount}</strong></td>
            <td>${sale.payment_method}</td>
            <td>${sale.created_at}</td>
            <td>${sale.discount_amount}</td>
            <td>${sale.tax_amount}</td>
        </tr>
    `).join('');
}

// Update dashboard from AJAX data
function updateDashboardFromData(data) {
    // Update today's sales amount
    if (data.today_sales && data.today_sales.total_amount) {
        const amount = parseFloat(data.today_sales.total_amount);
        const currentAmount = document.getElementById('todaySalesAmount').textContent;
        const newAmount = '₱' + amount.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        
        if (currentAmount !== newAmount) {
            document.getElementById('todaySalesAmount').textContent = newAmount;
            showUpdateIndicator('salesUpdateIndicator');
        }
    }
    
    // Update transactions count
    if (data.today_sales && data.today_sales.total_transactions) {
        const currentCount = document.getElementById('todayTransactionsCount').textContent;
        const newCount = data.today_sales.total_transactions;
        
        if (currentCount != newCount) {
            document.getElementById('todayTransactionsCount').textContent = newCount;
            showUpdateIndicator('transactionsUpdateIndicator');
        }
    }
    
    // Update recent sales table if there are new sales
    if (data.recent_sales) {
        updateRecentSalesTable(data.recent_sales);
        showUpdateIndicator('recentSalesUpdateIndicator');
    }
    
    // Update store status
    if (data.store_status) {
        updateStoreStatus(data.store_status);
    }
    
    // Update last updated time
    updateLastUpdatedTime();
}
</script>
<?= $this->endSection(); ?>

<style>
/* Store Status Indicator styles removed - not needed */

.realtime-indicator {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    background: rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.1);
}

/* Real-time update indicators */
#salesUpdateIndicator,
#transactionsUpdateIndicator,
#recentSalesUpdateIndicator {
    animation: pulse 1s ease-in-out;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

/* New sale row highlight */
.new-sale-row {
    transition: background-color 0.3s ease;
}

/* Mobile responsive for dashboard */
@media (max-width: 768px) {
    .col-md-3 {
        margin-bottom: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .table th,
    .table td {
        padding: 0.5rem;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    /* Top daily closings table responsive */
    .table th:nth-child(6),
    .table td:nth-child(6),
    .table th:nth-child(7),
    .table td:nth-child(7),
    .table th:nth-child(8),
    .table td:nth-child(8),
    .table th:nth-child(9),
    .table td:nth-child(9) {
        min-width: 80px;
    }
    
    .fs-5 {
        font-size: 1rem !important;
    }
    
    .fs-6 {
        font-size: 0.875rem !important;
    }
}

@media (max-width: 480px) {
    .d-flex.justify-content-center.gap-3 {
        flex-direction: column;
        gap: 0.5rem !important;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .table-responsive {
        font-size: 0.8rem;
    }
    
    .card-header h5 {
        font-size: 1rem;
    }
    
    /* Extra small screens */
    .table th,
    .table td {
        padding: 0.25rem;
        font-size: 0.75rem;
    }
    
    .badge {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
    }
    
    .table th:nth-child(1),
    .table td:nth-child(1) {
        min-width: 60px;
    }
    
    .table th:nth-child(2),
    .table td:nth-child(2) {
        min-width: 80px;
    }
    
    .table th:nth-child(3),
    .table td:nth-child(3) {
        min-width: 100px;
    }
    
    .table th:nth-child(4),
    .table td:nth-child(4) {
        min-width: 90px;
    }
    
    .table th:nth-child(5),
    .table td:nth-child(5) {
        min-width: 100px;
    }
}

/* Tablet responsive */
@media (min-width: 769px) and (max-width: 1024px) {
    .table-responsive {
        font-size: 0.95rem;
    }
    
    .table th,
    .table td {
        padding: 0.75rem;
    }
    
    .fs-5 {
        font-size: 1.1rem !important;
    }
    
    .fs-6 {
        font-size: 0.9rem !important;
    }
}
</style>