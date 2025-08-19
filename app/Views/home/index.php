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
                                    <i class="uil uil-receipt text-muted" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="text-muted">No Recent Sales</h5>
                                <p class="text-muted mb-3">Start making sales to see them here</p>
                                <a href="<?= base_url('admin/pos') ?>" class="btn btn-primary">
                                    <i class="uil uil-plus"></i> Start First Sale
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
}
</style>