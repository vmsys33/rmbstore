<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="geex-content">
    <div class="geex-content__header">
        <div class="geex-content__header__left">
            <h1 class="geex-content__header__title"><?= $title ?></h1>
            <p class="geex-content__header__subtitle"><?= $subTitle ?></p>
        </div>
        <div class="geex-content__header__right">
            <a href="<?= route_to('pos.index') ?>" class="btn btn-outline-primary">
                <i class="uil uil-cash-register"></i> Back to POS
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-2">
                    <input type="text" name="sale_number" class="form-control" placeholder="Sale Number" value="<?= $filters['sale_number'] ?? '' ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" name="customer_name" class="form-control" placeholder="Customer Name" value="<?= $filters['customer_name'] ?? '' ?>">
                </div>
                <div class="col-md-2">
                    <select name="payment_status" class="form-select">
                        <option value="">All Payment Status</option>
                        <option value="pending" <?= ($filters['payment_status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="paid" <?= ($filters['payment_status'] ?? '') === 'paid' ? 'selected' : '' ?>>Paid</option>
                        <option value="cancelled" <?= ($filters['payment_status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="sale_status" class="form-select">
                        <option value="">All Sale Status</option>
                        <option value="completed" <?= ($filters['sale_status'] ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="cancelled" <?= ($filters['sale_status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        <option value="refunded" <?= ($filters['sale_status'] ?? '') === 'refunded' ? 'selected' : '' ?>>Refunded</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" placeholder="From Date" value="<?= $filters['date_from'] ?? '' ?>">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" placeholder="To Date" value="<?= $filters['date_to'] ?? '' ?>">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="uil uil-search"></i> Filter
                    </button>
                    <a href="<?= route_to('pos.salesHistory') ?>" class="btn btn-outline-secondary">
                        <i class="uil uil-refresh"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Sales Transactions</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($sales)): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Sale #</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Total Amount</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Sale Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sales as $sale): ?>
                                <tr>
                                    <td>
                                        <strong><?= $sale['sale_number'] ?></strong>
                                    </td>
                                    <td>
                                        <?php if ($sale['customer_name']): ?>
                                            <div>
                                                <strong><?= $sale['customer_name'] ?></strong>
                                                <?php if ($sale['customer_email']): ?>
                                                    <br><small class="text-muted"><?= $sale['customer_email'] ?></small>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">Walk-in Customer</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?= count($sale['items'] ?? []) ?> items</span>
                                    </td>
                                    <td>
                                        <strong class="text-primary">₱<?= number_format($sale['total_amount'], 2) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary"><?= ucfirst(str_replace('_', ' ', $sale['payment_method'])) ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        $paymentStatusClass = match($sale['payment_status']) {
                                            'paid' => 'bg-success',
                                            'pending' => 'bg-warning',
                                            'cancelled' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                        ?>
                                        <span class="badge <?= $paymentStatusClass ?>"><?= ucfirst($sale['payment_status']) ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        $saleStatusClass = match($sale['sale_status']) {
                                            'completed' => 'bg-success',
                                            'cancelled' => 'bg-danger',
                                            'refunded' => 'bg-info',
                                            default => 'bg-secondary'
                                        };
                                        ?>
                                        <span class="badge <?= $saleStatusClass ?>"><?= ucfirst($sale['sale_status']) ?></span>
                                    </td>
                                    <td>
                                        <small><?= date('M d, Y H:i', strtotime($sale['created_at'])) ?></small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= route_to('pos.viewSale', $sale['id']) ?>" class="btn btn-outline-primary" title="View Details">
                                                <i class="uil uil-eye"></i>
                                            </a>
                                            <a href="<?= route_to('pos.printReceipt', $sale['id']) ?>" class="btn btn-outline-secondary" title="Print Receipt" target="_blank">
                                                <i class="uil uil-print"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($pagination['pages'] > 1): ?>
                    <nav aria-label="Sales pagination" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php if ($pagination['current_page'] > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $pagination['current_page'] - 1 ?>&<?= http_build_query($filters) ?>">Previous</a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $pagination['pages']; $i++): ?>
                                <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>&<?= http_build_query($filters) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($pagination['current_page'] < $pagination['pages']): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $pagination['current_page'] + 1 ?>&<?= http_build_query($filters) ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>

                <!-- Summary -->
                <div class="mt-4">
                    <p class="text-muted">
                        Showing <?= count($sales) ?> of <?= $pagination['total'] ?> sales
                    </p>
                </div>

            <?php else: ?>
                <div class="text-center py-5">
                    <i class="uil uil-receipt text-muted" style="font-size: 4rem;"></i>
                    <h5 class="text-muted mt-3">No sales found</h5>
                    <p class="text-muted">No sales transactions match your current filters.</p>
                    <a href="<?= route_to('pos.index') ?>" class="btn btn-primary">
                        <i class="uil uil-cash-register"></i> Start a New Sale
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
