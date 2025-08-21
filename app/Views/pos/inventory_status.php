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

    <div class="row">
        <!-- Low Stock Alert -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="uil uil-exclamation-triangle text-warning"></i> Low Stock Alert
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($lowStock)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>SKU</th>
                                        <th>Available</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lowStock as $item): ?>
                                        <tr>
                                            <td><?= $item['product_name'] ?? 'Unknown Product' ?></td>
                                            <td><?= $item['product_sku'] ?? 'N/A' ?></td>
                                            <td>
                                                <span class="badge bg-warning"><?= $item['available_quantity'] ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-danger">Low Stock</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center">No low stock items found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Expiring Soon -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="uil uil-clock text-danger"></i> Expiring Soon (30 days)
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($expiring)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Batch</th>
                                        <th>Quantity</th>
                                        <th>Expires</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($expiring as $item): ?>
                                        <tr>
                                            <td><?= $item['product_name'] ?? 'Unknown Product' ?></td>
                                            <td><?= $item['batch_number'] ?></td>
                                            <td>
                                                <span class="badge bg-info"><?= $item['quantity'] ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-danger"><?= date('M d, Y', strtotime($item['expiry_date'])) ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center">No items expiring soon.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Summary -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Inventory Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-primary" id="totalProducts">0</h3>
                                <p class="text-muted">Total Products</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-success" id="inStock">0</h3>
                                <p class="text-muted">In Stock</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-warning" id="lowStock">0</h3>
                                <p class="text-muted">Low Stock</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-danger" id="outOfStock">0</h3>
                                <p class="text-muted">Out of Stock</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Inventory Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Product Inventory</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="inventoryTable">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>SKU</th>
                                    <th>Total Quantity</th>
                                    <th>Available</th>
                                    <th>Reserved</th>
                                    <th>Status</th>
                                    <th>Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    loadInventoryData();
});

function loadInventoryData() {
    $.ajax({
        url: '<?= route_to('pos.products') ?>',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                displayInventoryTable(response.products);
                updateInventorySummary(response.products);
            }
        },
        error: function() {
            alert('Error loading inventory data.');
        }
    });
}

function displayInventoryTable(products) {
    const tbody = $('#inventoryTable tbody');
    tbody.empty();
    
    products.forEach(function(product) {
        const status = getStockStatus(product.available_quantity);
        const row = `
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        ${product.image_icon ? `<img src="${product.image_icon}" alt="${product.product_name}" class="me-2" style="width: 40px; height: 40px; object-fit: cover;">` : ''}
                        <div>
                            <strong>${product.product_name}</strong>
                            <br><small class="text-muted">${product.category_name || 'Uncategorized'}</small>
                        </div>
                    </div>
                </td>
                <td>${product.sku}</td>
                <td>
                    <span class="badge bg-primary">${product.available_quantity}</span>
                </td>
                <td>
                    <span class="badge bg-success">${product.available_quantity}</span>
                </td>
                <td>
                    <span class="badge bg-warning">0</span>
                </td>
                <td>
                    <span class="badge ${status.badge}">${status.text}</span>
                </td>
                <td>
                    <small class="text-muted">${new Date().toLocaleDateString()}</small>
                </td>
            </tr>
        `;
        tbody.append(row);
    });
}

function updateInventorySummary(products) {
    let totalProducts = products.length;
    let inStock = 0;
    let lowStock = 0;
    let outOfStock = 0;
    
    products.forEach(function(product) {
        if (product.available_quantity > 10) {
            inStock++;
        } else if (product.available_quantity > 0) {
            lowStock++;
        } else {
            outOfStock++;
        }
    });
    
    $('#totalProducts').text(totalProducts);
    $('#inStock').text(inStock);
    $('#lowStock').text(lowStock);
    $('#outOfStock').text(outOfStock);
}

function getStockStatus(quantity) {
    if (quantity > 10) {
        return { badge: 'bg-success', text: 'In Stock' };
    } else if (quantity > 0) {
        return { badge: 'bg-warning', text: 'Low Stock' };
    } else {
        return { badge: 'bg-danger', text: 'Out of Stock' };
    }
}
</script>
<?= $this->endSection() ?>
