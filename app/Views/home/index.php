<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?> 

<div class="geex-content__wrapper">
    <div class="geex-content__section-wrapper">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1"><?= $title ?></h2>
                <p class="text-muted mb-0"><?= $subTitle ?></p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <!-- Total Products Card -->
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                    <i class="uil uil-box text-primary" style="font-size: 2rem;"></i>
                                </div>
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
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i class="uil uil-list-ul text-success" style="font-size: 2rem;"></i>
                                </div>
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
                                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                    <i class="uil uil-users-alt text-info" style="font-size: 2rem;"></i>
                                </div>
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
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i class="uil uil-money-bill text-success" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mb-1">₱<?= number_format($todaySales['total_amount'] ?? 0, 2) ?></h4>
                                <p class="text-muted mb-0">Today's Sales</p>
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
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                    <i class="uil uil-receipt text-warning" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mb-1"><?= $todaySales['total_transactions'] ?? 0 ?></h4>
                                <p class="text-muted mb-0">Today's Transactions</p>
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
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                    <i class="uil uil-chart-line text-primary" style="font-size: 2rem;"></i>
                                </div>
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
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="uil uil-clock-three text-primary me-2"></i>
                                Recent Sales
                            </h5>
                            <a href="<?= base_url('admin/pos') ?>" class="btn btn-sm btn-primary">
                                <i class="uil uil-plus"></i> New Sale
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
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
                                    <tbody>
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



        <!-- Welcome Section -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="uil uil-store text-primary" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="mb-3">Welcome to RMB Store</h3>
                    <p class="text-muted mb-4">Manage your products, categories, and users from this centralized dashboard.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="<?= route_to('products') ?>" class="btn btn-primary">
                            <i class="uil uil-plus"></i> Add New Product
                        </a>
                        <a href="<?= base_url('admin/pos') ?>" class="btn btn-outline-secondary">
                            <i class="uil uil-cash-register"></i> Open POS
                        </a>
                    </div>
                </div>
            </div>
        </div>
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
</script>
<?= $this->endSection(); ?>

<style>
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