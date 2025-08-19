<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<div class="geex-content__section geex-content__form">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><?= $title ?></h2>
            <p class="text-muted mb-0"><?= $subTitle ?></p>
        </div>
        <div>
            <button class="btn btn-success me-2" onclick="exportToCsv()">
                <i class="uil uil-export"></i> Export CSV
            </button>
            <button class="btn btn-primary" onclick="refreshData()">
                <i class="uil uil-refresh"></i> Refresh
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Days</h6>
                            <h3 id="totalDays">0</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="uil uil-calendar-alt fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Sales</h6>
                            <h3 id="totalSales"><?= $currencySymbol ?>0.00</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="uil uil-dollar-sign fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Transactions</h6>
                            <h3 id="totalTransactions">0</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="uil uil-receipt fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Avg Daily Sales</h6>
                            <h3 id="avgDailySales"><?= $currencySymbol ?>0.00</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="uil uil-chart-line fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startDate" value="<?= date('Y-m-01') ?>">
                </div>
                <div class="col-md-3">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="endDate" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-2">
                    <label for="limit" class="form-label">Show Top</label>
                    <select class="form-select" id="limit">
                        <option value="5">Top 5</option>
                        <option value="10" selected>Top 10</option>
                        <option value="20">Top 20</option>
                        <option value="50">Top 50</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="showAll">
                        <label class="form-check-label" for="showAll">
                            Show All
                        </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button class="btn btn-primary w-100" onclick="searchData()">
                        <i class="uil uil-search"></i> Search
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Summary Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daily Sales Summary</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="salesSummaryTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Opening Cash (<?= $currencySymbol ?>)</th>
                            <th>Closing Cash (<?= $currencySymbol ?>)</th>
                            <th>Cash Sales (<?= $currencySymbol ?>)</th>
                            <th>Card Sales (<?= $currencySymbol ?>)</th>
                            <th>Bank Transfer (<?= $currencySymbol ?>)</th>
                            <th>Online Sales (<?= $currencySymbol ?>)</th>
                            <th>Total Sales (<?= $currencySymbol ?>)</th>
                            <th>Transactions</th>
                            <th>Items Sold</th>
                            <th>Discounts (<?= $currencySymbol ?>)</th>
                            <th>Tax (<?= $currencySymbol ?>)</th>
                            <th>Cash Shortage (<?= $currencySymbol ?>)</th>
                            <th>Closed By</th>
                            <th>Closed At</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="salesSummaryTableBody">
                        <tr>
                            <td colspan="16" class="text-center">Loading data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Sales Details Modal -->
<div class="modal fade" id="salesDetailsModal" tabindex="-1" aria-labelledby="salesDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salesDetailsModalLabel">Sales Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Date: <span id="modalDate"></span></h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <h6>Total Sales: <span id="modalTotalSales"></span></h6>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="salesDetailsTable">
                        <thead>
                                                    <tr>
                            <th>Sale #</th>
                            <th>Customer</th>
                            <th>Amount (<?= $currencySymbol ?>)</th>
                            <th>Payment Method</th>
                            <th>Time</th>
                            <th>Discount (<?= $currencySymbol ?>)</th>
                            <th>Tax (<?= $currencySymbol ?>)</th>
                        </tr>
                        </thead>
                        <tbody id="salesDetailsTableBody">
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
let currentData = [];

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    loadData();
    loadStats();
});

// Load sales summary data
function loadData() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const limit = document.getElementById('limit').value;
    const showAll = document.getElementById('showAll').checked;

    const params = new URLSearchParams({
        start_date: startDate,
        end_date: endDate,
        limit: limit,
        show_all: showAll
    });

    fetch(`/admin/sales-summary/getData?${params}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentData = data.data;
                displayData(data.data);
            } else {
                showAlert('error', 'Error loading data: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'Error loading data');
        });
}

// Load statistics
function loadStats() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    const params = new URLSearchParams({
        start_date: startDate,
        end_date: endDate
    });

    fetch(`/admin/sales-summary/getStats?${params}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayStats(data.stats);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Display data in table
function displayData(data) {
    const tbody = document.getElementById('salesSummaryTableBody');
    
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="16" class="text-center">No data found for the selected date range</td></tr>';
        return;
    }

    tbody.innerHTML = data.map(item => `
        <tr>
            <td>${item.closing_date}</td>
            <td>${item.opening_cash}</td>
            <td>${item.closing_cash}</td>
            <td>${item.cash_sales}</td>
            <td>${item.card_sales}</td>
            <td>${item.bank_transfer_sales}</td>
            <td>${item.online_sales}</td>
            <td><strong class="text-success">${item.total_sales}</strong></td>
            <td>${item.total_transactions}</td>
            <td>${item.total_items_sold}</td>
            <td>${item.total_discounts}</td>
            <td>${item.total_tax}</td>
            <td>${item.cash_shortage}</td>
            <td>${item.closed_by}</td>
            <td>${item.closed_at}</td>
            <td>${item.notes}</td>
            <td>
                <button class="btn btn-sm btn-info" onclick="viewSalesDetails('${item.closing_date}', '${item.closing_date_raw}')" title="View Sales Details">
                    <i class="uil uil-eye"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

// Display statistics
function displayStats(stats) {
    document.getElementById('totalDays').textContent = stats.total_days;
    document.getElementById('totalSales').textContent = '<?= $currencySymbol ?>' + stats.total_sales;
    document.getElementById('totalTransactions').textContent = stats.total_transactions;
    document.getElementById('avgDailySales').textContent = '<?= $currencySymbol ?>' + stats.avg_daily_sales;
}

// Search data
function searchData() {
    loadData();
    loadStats();
}

// Refresh data
function refreshData() {
    loadData();
    loadStats();
}

// View sales details for a specific date
function viewSalesDetails(displayDate, rawDate) {
    document.getElementById('modalDate').textContent = displayDate;
    document.getElementById('modalTotalSales').textContent = '<?= $currencySymbol ?>0.00';
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('salesDetailsModal'));
    modal.show();
    
    // Load sales details using the raw date
    fetch(`/admin/sales-summary/getSalesDetails/${rawDate}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displaySalesDetails(data.data, data.total_sales);
            } else {
                document.getElementById('salesDetailsTableBody').innerHTML = 
                    '<tr><td colspan="7" class="text-center text-danger">Error loading sales details: ' + data.message + '</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('salesDetailsTableBody').innerHTML = 
                '<tr><td colspan="7" class="text-center text-danger">Error loading sales details</td></tr>';
        });
}

// Display sales details in modal
function displaySalesDetails(sales, totalSales) {
    const tbody = document.getElementById('salesDetailsTableBody');
    
    if (sales.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center">No sales found for this date</td></tr>';
        document.getElementById('modalTotalSales').textContent = '<?= $currencySymbol ?>0.00';
        return;
    }
    
    // Calculate total from individual sales
    const total = sales.reduce((sum, sale) => {
        return sum + parseFloat(sale.total_amount.replace(/[^0-9.-]+/g, ''));
    }, 0);
    
    document.getElementById('modalTotalSales').textContent = '<?= $currencySymbol ?>' + total.toFixed(2);
    
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

// Export to CSV
function exportToCsv() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    const url = `/admin/sales-summary/exportCsv?start_date=${startDate}&end_date=${endDate}`;
    
    // Create a temporary link and trigger download
    const link = document.createElement('a');
    link.href = url;
    link.download = `sales_summary_${startDate}_to_${endDate}.csv`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Show alert
function showAlert(type, message) {
    Swal.fire({
        icon: type,
        title: type === 'success' ? 'Success!' : 'Error!',
        text: message,
        timer: type === 'success' ? 2000 : 4000,
        showConfirmButton: false
    });
}

// Event listeners
document.getElementById('startDate').addEventListener('change', function() {
    if (this.value > document.getElementById('endDate').value) {
        document.getElementById('endDate').value = this.value;
    }
});

document.getElementById('endDate').addEventListener('change', function() {
    if (this.value < document.getElementById('startDate').value) {
        document.getElementById('startDate').value = this.value;
    }
});

document.getElementById('showAll').addEventListener('change', function() {
    if (this.checked) {
        document.getElementById('limit').disabled = true;
    } else {
        document.getElementById('limit').disabled = false;
    }
});
</script>
<?= $this->endSection(); ?>
