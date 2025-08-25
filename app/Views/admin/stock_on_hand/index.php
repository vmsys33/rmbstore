<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Admin Dashboard</title>
    
    <!-- Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .stock-table {
            margin-top: 20px;
        }
        
        .stock-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-in-stock {
            background-color: #4caf50;
            color: white;
        }
        
        .status-low-stock {
            background-color: #ff9800;
            color: white;
        }
        
        .status-out-of-stock {
            background-color: #f44336;
            color: white;
        }
        
        .status-sold-out {
            background-color: #9c27b0;
            color: white;
        }
        
        .summary-cards {
            margin-bottom: 30px;
        }
        
        .summary-card {
            text-align: center;
            padding: 20px;
        }
        
        .summary-card .card-title {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .summary-card .card-content {
            padding: 0;
        }
        
        .summary-card .number {
            font-size: 36px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .export-btn {
            margin-top: 20px;
        }
        
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h2 class="header">
                    <i class="fas fa-boxes"></i> <?= $title ?>
                </h2>
                
                <!-- Summary Cards -->
                <div class="row summary-cards">
                    <div class="col s12 m3">
                        <div class="card blue darken-1">
                            <div class="card-content white-text summary-card">
                                <span class="card-title">Total Products</span>
                                <div class="number"><?= count($stockSummary) ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col s12 m3">
                        <div class="card green darken-1">
                            <div class="card-content white-text summary-card">
                                <span class="card-title">In Stock</span>
                                <div class="number">
                                    <?= count(array_filter($stockSummary, function($item) { 
                                        return $item['availability_status'] === 'In Stock'; 
                                    })) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col s12 m3">
                        <div class="card orange darken-1">
                            <div class="card-content white-text summary-card">
                                <span class="card-title">Low Stock</span>
                                <div class="number"><?= count($lowStockProducts) ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col s12 m3">
                        <div class="card red darken-1">
                            <div class="card-content white-text summary-card">
                                <span class="card-title">Out of Stock</span>
                                <div class="number"><?= count($outOfStockProducts) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Export Button -->
                <div class="row">
                    <div class="col s12">
                        <a href="<?= base_url('admin/stock-on-hand/export-csv') ?>" class="btn waves-effect waves-light export-btn">
                            <i class="fas fa-download"></i> Export to CSV
                        </a>
                    </div>
                </div>
                
                <!-- Stock Summary Table -->
                <div class="row">
                    <div class="col s12">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Stock Summary</span>
                                
                                <div class="table-responsive">
                                    <table class="striped stock-table">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Price</th>
                                                <th>Stock on Hand</th>
                                                <th>Total Sold</th>
                                                <th>Remaining</th>
                                                <th>Status</th>
                                                <th>Last Updated</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($stockSummary as $product): ?>
                                            <tr>
                                                <td>
                                                    <?php if ($product['featured_image']): ?>
                                                        <img src="<?= base_url('uploads/products/' . $product['featured_image']) ?>" 
                                                             alt="<?= $product['product_name'] ?>" 
                                                             class="product-image">
                                                    <?php else: ?>
                                                        <img src="<?= base_url('assets/frontend/images/product1.jpg') ?>" 
                                                             alt="Default Product Image" 
                                                             class="product-image">
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong><?= $product['product_name'] ?></strong>
                                                </td>
                                                <td><?= $product['category'] ?></td>
                                                <td>$<?= number_format($product['price'], 2) ?></td>
                                                <td>
                                                    <span class="badge blue white-text">
                                                        <?= $product['stock_on_hand'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge grey white-text">
                                                        <?= $product['total_sold'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge <?= $product['remaining_quantity'] > 5 ? 'green' : ($product['remaining_quantity'] > 0 ? 'orange' : 'red') ?> white-text">
                                                        <?= $product['remaining_quantity'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php
                                                    $statusClass = '';
                                                    switch ($product['availability_status']) {
                                                        case 'In Stock':
                                                            $statusClass = 'status-in-stock';
                                                            break;
                                                        case 'Low Stock':
                                                            $statusClass = 'status-low-stock';
                                                            break;
                                                        case 'Out of Stock':
                                                            $statusClass = 'status-out-of-stock';
                                                            break;
                                                        case 'Sold Out':
                                                            $statusClass = 'status-sold-out';
                                                            break;
                                                    }
                                                    ?>
                                                    <span class="stock-status <?= $statusClass ?>">
                                                        <?= $product['availability_status'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <small>
                                                        <?= $product['last_stock_update'] ? date('M j, Y', strtotime($product['last_stock_update'])) : 'N/A' ?>
                                                    </small>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Low Stock Alert -->
                <?php if (!empty($lowStockProducts)): ?>
                <div class="row">
                    <div class="col s12">
                        <div class="card orange lighten-4">
                            <div class="card-content">
                                <span class="card-title orange-text">
                                    <i class="fas fa-exclamation-triangle"></i> Low Stock Alert
                                </span>
                                <p>The following products are running low on stock:</p>
                                
                                <div class="collection">
                                    <?php foreach ($lowStockProducts as $product): ?>
                                    <div class="collection-item">
                                        <strong><?= $product['product_name'] ?></strong> - 
                                        Only <span class="badge orange white-text"><?= $product['remaining_quantity'] ?></span> remaining
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Out of Stock Alert -->
                <?php if (!empty($outOfStockProducts)): ?>
                <div class="row">
                    <div class="col s12">
                        <div class="card red lighten-4">
                            <div class="card-content">
                                <span class="card-title red-text">
                                    <i class="fas fa-times-circle"></i> Out of Stock Alert
                                </span>
                                <p>The following products are currently out of stock:</p>
                                
                                <div class="collection">
                                    <?php foreach ($outOfStockProducts as $product): ?>
                                    <div class="collection-item">
                                        <strong><?= $product['product_name'] ?></strong> - 
                                        <span class="badge red white-text">Out of Stock</span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Materialize JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    
    <script>
        // Initialize Materialize components
        document.addEventListener('DOMContentLoaded', function() {
            M.AutoInit();
        });
    </script>
</body>
</html>
