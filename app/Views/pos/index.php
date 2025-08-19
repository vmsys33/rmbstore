<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="geex-content">
    <div class="geex-content__header">
        <div class="geex-content__header__left">
            <h1 class="geex-content__header__title"><?= $title ?></h1>
            <p class="geex-content__header__subtitle"><?= $subTitle ?></p>
        </div>
        <div class="geex-content__header__right">
            <a href="<?= route_to('pos.salesHistory') ?>" class="btn btn-outline-primary">
                <i class="uil uil-history"></i> Sales History
            </a>
            <a href="<?= route_to('pos.inventoryStatus') ?>" class="btn btn-outline-info">
                <i class="uil uil-box"></i> Inventory Status
            </a>
        </div>
    </div>

    <!-- Sales Transaction Datatable -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">New Sale Transaction</h5>
        </div>
        <div class="card-body">
            <form id="posForm">
                <!-- Customer Information -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" id="customerName" class="form-control" placeholder="Customer Name (Optional)">
                    </div>
                    <div class="col-md-4">
                        <input type="email" id="customerEmail" class="form-control" placeholder="Customer Email (Optional)">
                    </div>
                    <div class="col-md-4">
                        <input type="tel" id="customerPhone" class="form-control" placeholder="Customer Phone (Optional)">
                    </div>
                </div>

                <!-- Sales Items Datatable -->
                <div class="table-responsive">
                    <table id="pos-table" class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="relative">
                                    <input type="text" class="form-control product-input" placeholder="Search Product" autocomplete="off" tabindex="1" />
                                    <div class="auto-suggest"></div>
                                </td>
                                <td>
                                    <input type="number" class="form-control quantity-input" value="1" min="1" tabindex="2" />
                                </td>
                                <td>
                                    <span class="total-display font-weight-bold">₱0.00</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Action Buttons -->
                <div class="mb-3">
                    <button type="button" id="add-row-btn" class="btn btn-primary">
                        <i class="uil uil-plus"></i> Add Item
                    </button>
                    <button type="submit" id="process-transaction-btn" class="btn btn-success ml-2">
                        <i class="uil uil-check-circle"></i> Process Transaction
                    </button>
                    <button type="button" id="test-suggest-btn" class="btn btn-warning ml-2">
                        <i class="uil uil-bug"></i> Test Auto-Suggest
                    </button>
                </div>

                <!-- Payment and Totals -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Payment Method</label>
                            <select id="paymentMethod" class="form-select" required>
                                <option value="">Select Payment Method</option>
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="online">Online Payment</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea id="notes" class="form-control" rows="2" placeholder="Optional notes..."></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Transaction Summary</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span id="subtotal">₱0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax (12%):</span>
                                    <span id="taxAmount">₱0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Discount:</span>
                                    <span id="discountAmount">₱0.00</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>Total:</strong>
                                    <strong id="totalAmount">₱0.00</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Today's Sales Summary -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Sales</h6>
                            <h4 class="mb-0">₱<?= number_format($todaySales['total_sales'] ?? 0, 2) ?></h4>
                        </div>
                        <div class="align-self-center">
                            <i class="uil uil-dollar-sign fs-1"></i>
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
                            <h6 class="card-title">Transactions</h6>
                            <h4 class="mb-0"><?= $todaySales['total_transactions'] ?? 0 ?></h4>
                        </div>
                        <div class="align-self-center">
                            <i class="uil uil-receipt fs-1"></i>
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
                            <h6 class="card-title">Items Sold</h6>
                            <h4 class="mb-0"><?= $todaySales['total_items_sold'] ?? 0 ?></h4>
                        </div>
                        <div class="align-self-center">
                            <i class="uil uil-box fs-1"></i>
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
                            <h6 class="card-title">Cash Sales</h6>
                            <h4 class="mb-0">₱<?= number_format($todaySales['cash_sales'] ?? 0, 2) ?></h4>
                        </div>
                        <div class="align-self-center">
                            <i class="uil uil-money-bill fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Sales Transactions Datatable -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Today's Sales Transactions</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="todaySalesTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Sale #</th>
                            <th>Customer</th>
                            <th>Total Amount</th>
                            <th>Payment Method</th>
                            <th>Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentSales)): ?>
                            <?php foreach ($recentSales as $sale): ?>
                                <tr>
                                    <td><strong><?= esc($sale['sale_number']) ?></strong></td>
                                    <td><?= esc($sale['customer_name'] ?? 'Walk-in Customer') ?></td>
                                    <td><strong>₱<?= number_format($sale['total_amount'], 2) ?></strong></td>
                                    <td><span class="badge bg-primary"><?= esc($sale['payment_method']) ?></span></td>
                                    <td><?= date('H:i', strtotime($sale['created_at'])) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info preview-btn" data-sale-id="<?= $sale['id'] ?>" title="Preview">
                                            <i class="uil uil-eye"></i>
                                        </button>
                                        <a href="<?= base_url('admin/pos/receipt/' . $sale['id']) ?>" class="btn btn-sm btn-outline-primary" target="_blank" title="Print">
                                            <i class="uil uil-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No sales today</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Transaction Details Modal -->
<div id="transactionModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="transactionDetails">
                    <!-- Transaction details will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.auto-suggest {
    position: absolute;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    z-index: 99999;
    width: 100%;
    max-height: 200px;
    overflow-y: auto;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: none;
    top: 100%;
    left: 0;
    margin-top: 2px;
    min-width: 300px;
}

.suggest-item {
    display: flex;
    align-items: center;
    padding: 10px;
    cursor: pointer;
    gap: 12px;
    border-bottom: 1px solid #f1f5f9;
}

.suggest-item:last-child {
    border-bottom: none;
}

.suggest-item:hover, .suggest-item.selected {
    background-color: #f1f5f9;
}

.suggest-image {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 6px;
    flex-shrink: 0;
}

.suggest-text {
    flex-grow: 1;
    min-width: 0;
}

.suggest-text > div:first-child {
    font-weight: 500;
    margin-bottom: 2px;
}

.suggest-price {
    font-weight: 500;
    color: #059669;
}

.relative {
    position: relative;
}

.product-input {
    position: relative;
}

/* Ensure the table cell can contain the dropdown */
#pos-table td.relative {
    position: relative;
    overflow: visible;
}

/* Debug styles */
.auto-suggest.show {
    display: block !important;
    border: 2px solid red !important;
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let allProducts = <?= json_encode($products) ?>;
let selectedSuggestionIndex = -1;

// Initialize
$(document).ready(function() {
    console.log('POS initialized');
    console.log('All products:', allProducts);
    
    attachEventListeners($("#pos-table tbody tr:first"));
    
    // Handle preview button clicks
    $(document).on('click', '.preview-btn', function() {
        const saleId = $(this).data('sale-id');
        loadSaleDetails(saleId);
    });
    
    // Add row button
    $('#add-row-btn').on('click', function() {
        addNewRow();
    });

    // Test auto-suggest button
    $('#test-suggest-btn').on('click', function() {
        const firstInput = $("#pos-table tbody tr:first .product-input");
        if (firstInput.length > 0) {
            console.log('Manually testing auto-suggest');
            firstInput.val('test');
            firstInput.trigger('input');
            
            // Force show the suggestion box
            const suggestionBox = firstInput.siblings('.auto-suggest');
            if (suggestionBox.length > 0) {
                suggestionBox.addClass('show');
                console.log('Suggestion box should be visible now');
            }
        }
    });

    // Process transaction
    $('#posForm').on('submit', function(e) {
        e.preventDefault();
        processTransaction();
    });
    
    // Test auto-suggest by typing in the first product input
    setTimeout(function() {
        const firstInput = $("#pos-table tbody tr:first .product-input");
        if (firstInput.length > 0) {
            console.log('Testing auto-suggest with first product name');
            firstInput.val(allProducts[0]?.product_name || 'test');
            firstInput.trigger('input');
        }
    }, 1000);
});

// Function to create a new row
function addNewRow() {
    const tbody = $("#pos-table tbody");
    const newRow = $("<tr></tr>");
    newRow.html(`
        <td class="relative">
            <input type="text" class="form-control product-input" placeholder="Search Product" autocomplete="off" tabindex="1" />
            <div class="auto-suggest"></div>
        </td>
        <td>
            <input type="number" class="form-control quantity-input" value="1" min="1" tabindex="2" />
        </td>
        <td>
            <span class="total-display font-weight-bold">₱0.00</span>
        </td>
    `);
    tbody.append(newRow);
    attachEventListeners(newRow);
}

// Function to attach event listeners to a row
function attachEventListeners(row) {
    const productInput = row.find(".product-input");
    const quantityInput = row.find(".quantity-input");
    const totalDisplay = row.find(".total-display");
    const suggestionBox = row.find(".auto-suggest");
    
    console.log('Attaching event listeners to row:', row);
    console.log('Products available:', allProducts.length);
    
    // Handle product search and suggestions
    productInput.on("input", function() {
        const query = $(this).val().toLowerCase();
        console.log('Search query:', query);
        
        suggestionBox.empty();
        selectedSuggestionIndex = -1;
        
        if (query.length > 0) {
            const filteredProducts = allProducts.filter(product => 
                product.product_name.toLowerCase().includes(query) ||
                (product.sku && product.sku.toLowerCase().includes(query))
            );
            
            console.log('Filtered products:', filteredProducts.length);
            
            if (filteredProducts.length > 0) {
                filteredProducts.forEach(product => {
                    const item = $(`<div class="suggest-item"></div>`);
                    const imageUrl = product.image_icon ? '<?= base_url('uploads/products/icons/') ?>' + product.image_icon : '<?= base_url('assets/img/no-image.png') ?>';
                    
                    item.html(`
                        <img src="${imageUrl}" alt="${product.product_name}" class="suggest-image" onerror="this.src='<?= base_url('assets/img/no-image.png') ?>'" />
                        <div class="suggest-text">
                            <div>${product.product_name}</div>
                            <div class="suggest-price">₱${parseFloat(product.price).toFixed(2)}</div>
                        </div>
                    `);
                    
                    item.on("click", function() {
                        console.log('Product selected:', product.product_name);
                        productInput.val(product.product_name);
                        productInput.data('product-id', product.id);
                        productInput.data('product-price', product.price);
                        calculateTotal(row);
                        suggestionBox.hide();
                        selectedSuggestionIndex = -1;
                        
                        // Add new row after selection
                        setTimeout(() => {
                            addNewRow();
                        }, 100);
                    });
                    
                    suggestionBox.append(item);
                });
                
                console.log('Showing suggestion box');
                suggestionBox.show();
            } else {
                console.log('No products found, hiding suggestion box');
                suggestionBox.hide();
            }
        } else {
            console.log('Empty query, hiding suggestion box');
            suggestionBox.hide();
        }
    });
    
    // Update total when quantity changes
    quantityInput.on("input", function() {
        calculateTotal(row);
    });
    
    // Add new row on Enter key
    productInput.on("keypress", function(e) {
        if (e.key === "Enter") {
            e.preventDefault();
            addNewRow();
        }
    });
    
    // Handle arrow key navigation
    productInput.on("keydown", function(e) {
        handleArrowNavigation(e, row, "product");
    });
    
    quantityInput.on("keydown", function(e) {
        handleArrowNavigation(e, row, "quantity");
    });
    
    // Handle dropdown navigation
    productInput.on("keydown", function(e) {
        if (suggestionBox.is(":visible")) {
            handleDropdownNavigation(e, suggestionBox);
        }
    });
}

// Function to handle dropdown navigation
function handleDropdownNavigation(e, suggestionBox) {
    const keyCode = e.keyCode;
    const items = suggestionBox.children();
    
    if (keyCode === 40) { // Down arrow
        e.preventDefault();
        if (selectedSuggestionIndex < items.length - 1) {
            selectedSuggestionIndex++;
            updateSelectedSuggestion(items, selectedSuggestionIndex);
        }
    } else if (keyCode === 38) { // Up arrow
        e.preventDefault();
        if (selectedSuggestionIndex > 0) {
            selectedSuggestionIndex--;
            updateSelectedSuggestion(items, selectedSuggestionIndex);
        }
    } else if (keyCode === 13) { // Enter
        e.preventDefault();
        if (selectedSuggestionIndex >= 0) {
            const selectedItem = items.eq(selectedSuggestionIndex);
            selectedItem.click();
        }
    }
}

// Function to update selected suggestion
function updateSelectedSuggestion(items, index) {
    items.removeClass('selected');
    items.eq(index).addClass('selected');
}

// Function to handle arrow key navigation
function handleArrowNavigation(e, row, currentField) {
    const keyCode = e.keyCode;
    const isLastRow = row.is(":last-child");
    const isFirstRow = row.is(":first-child");
    
    switch(keyCode) {
        case 37: // Left arrow
        case 39: // Right arrow
            return; // Skip horizontal navigation
            
        case 38: // Up arrow
            if (!isFirstRow) {
                e.preventDefault();
                const prevRow = row.prev();
                if (currentField === "product") {
                    prevRow.find(".product-input").focus();
                } else {
                    prevRow.find(".quantity-input").focus();
                }
            }
            break;
            
        case 40: // Down arrow
            if (!isLastRow) {
                e.preventDefault();
                const nextRow = row.next();
                if (currentField === "product") {
                    nextRow.find(".product-input").focus();
                } else {
                    nextRow.find(".quantity-input").focus();
                }
            }
            break;
            
        case 9: // Tab key
            e.preventDefault();
            if (currentField === "product") {
                row.find(".quantity-input").focus();
            } else if (currentField === "quantity") {
                if (!isLastRow) {
                    const nextRow = row.next();
                    nextRow.find(".product-input").focus();
                } else {
                    addNewRow();
                    const newRow = $("#pos-table tbody tr:last");
                    newRow.find('.product-input').focus();
                }
            }
            break;
    }
}

// Function to calculate total for a row
function calculateTotal(row) {
    const productInput = row.find(".product-input");
    const quantityInput = row.find(".quantity-input");
    const totalDisplay = row.find(".total-display");
    
    const productPrice = parseFloat(productInput.data('product-price')) || 0;
    const quantity = parseInt(quantityInput.val()) || 0;
    
    if (productPrice > 0 && quantity > 0) {
        const total = productPrice * quantity;
        totalDisplay.text("₱" + total.toFixed(2));
    } else {
        totalDisplay.text("₱0.00");
    }
    
    updateSaleTotals();
}

function updateSaleTotals() {
    let subtotal = 0;
    
    $('.total-display').each(function() {
        const total = parseFloat($(this).text().replace('₱', '')) || 0;
        subtotal += total;
    });
    
    const taxAmount = subtotal * 0.12;
    const discountAmount = 0;
    const totalAmount = subtotal + taxAmount - discountAmount;
    
    $('#subtotal').text('₱' + subtotal.toFixed(2));
    $('#taxAmount').text('₱' + taxAmount.toFixed(2));
    $('#discountAmount').text('₱' + discountAmount.toFixed(2));
    $('#totalAmount').text('₱' + totalAmount.toFixed(2));
    
    // Enable/disable process button
    $('#process-transaction-btn').prop('disabled', subtotal <= 0);
}

// Process transaction
function processTransaction() {
    const rows = $("#pos-table tbody tr");
    const items = [];
    
    rows.each(function(index) {
        const row = $(this);
        const productInput = row.find(".product-input");
        const productId = productInput.data('product-id');
        const productName = productInput.val();
        const quantity = parseInt(row.find(".quantity-input").val()) || 0;
        const totalText = row.find(".total-display").text();
        const total = parseFloat(totalText.replace('₱', '')) || 0;
        
        if (productId && productName && quantity > 0 && total > 0) {
            const product = allProducts.find(p => p.id == productId);
            items.push({
                product_id: productId,
                product_name: productName,
                product_sku: product.sku,
                unit_price: product.price,
                quantity: quantity,
                discount_percent: 0,
                discount_amount: 0,
                subtotal: total,
                total_amount: total
            });
        }
    });
    
    if (items.length === 0) {
        alert('Please add at least one item to the sale');
        return;
    }
    
    const paymentMethod = $('#paymentMethod').val();
    if (!paymentMethod) {
        alert('Please select a payment method');
        return;
    }
    
    const saleData = {
        customer_name: $('#customerName').val(),
        customer_email: $('#customerEmail').val(),
        customer_phone: $('#customerPhone').val(),
        payment_method: paymentMethod,
        notes: $('#notes').val(),
        items: JSON.stringify(items)
    };
    
    $.ajax({
        url: '<?= route_to('pos.processSale') ?>',
        type: 'POST',
        data: saleData,
        success: function(response) {
            if (response.success) {
                alert('Sale processed successfully!');
                clearSale();
                
                // Refresh the page to show updated data
                location.reload();
                
                // Optionally redirect to receipt
                if (confirm('Would you like to view the receipt?')) {
                    window.open('<?= base_url('admin/pos/receipt/') ?>' + response.sale.id, '_blank');
                }
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function() {
            alert('An error occurred while processing the sale.');
        }
    });
}

function clearSale() {
    $('#pos-table tbody').empty();
    $('#posForm')[0].reset();
    addNewRow();
    updateSaleTotals();
}

function loadTodaySales() {
    $.ajax({
        url: '<?= route_to('pos.todaySales') ?>',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                displayTodaySales(response.sales);
            } else {
                $('#todaySalesTable tbody').html('<tr><td colspan="7" class="text-center text-danger">Error loading sales data</td></tr>');
            }
        },
        error: function() {
            $('#todaySalesTable tbody').html('<tr><td colspan="7" class="text-center text-danger">Error loading sales data</td></tr>');
        }
    });
}

function displayTodaySales(sales) {
    const tbody = $('#todaySalesTable tbody');
    tbody.empty();
    
    if (sales.length === 0) {
        tbody.html('<tr><td colspan="7" class="text-center text-muted">No sales today</td></tr>');
        return;
    }
    
    sales.forEach(function(sale) {
        const row = `
            <tr>
                <td><strong>${sale.sale_number}</strong></td>
                <td>${sale.customer_name || 'Walk-in Customer'}</td>
                <td>${sale.total_items || 0} items</td>
                <td><strong>₱${parseFloat(sale.total_amount).toFixed(2)}</strong></td>
                <td><span class="badge bg-primary">${sale.payment_method}</span></td>
                <td>${new Date(sale.created_at).toLocaleTimeString()}</td>
                <td>
                    <a href="<?= base_url('admin/pos/receipt/') ?>${sale.id}" class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="uil uil-print"></i>
                    </a>
                </td>
            </tr>
        `;
        tbody.append(row);
    });
}

// Close suggestion boxes when clicking outside
$(document).on("click", function(e) {
    if (!$(e.target).closest(".product-input").length) {
        $(".auto-suggest").hide();
    }
});

// Load sale details for preview
function loadSaleDetails(saleId) {
    $.ajax({
        url: '<?= base_url('admin/pos/sale-details/') ?>' + saleId,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                displaySaleDetails(response.sale);
                $('#transactionModal').modal('show');
            } else {
                alert('Error loading sale details: ' + response.message);
            }
        },
        error: function() {
            alert('Error loading sale details');
        }
    });
}

// Display sale details in modal
function displaySaleDetails(sale) {
    let itemsHtml = '';
    if (sale.items && sale.items.length > 0) {
        sale.items.forEach(function(item) {
            itemsHtml += `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center">
                        <img src="<?= base_url('uploads/products/icons/') ?>${item.product_image || 'no-image.png'}" 
                             alt="${item.product_name}" class="me-2" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;" 
                             onerror="this.src='<?= base_url('assets/img/no-image.png') ?>'">
                        <div>
                            <strong>${item.product_name}</strong><br>
                            <small class="text-muted">SKU: ${item.product_sku}</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <div>₱${parseFloat(item.unit_price).toFixed(2)} × ${item.quantity}</div>
                        <strong>₱${parseFloat(item.subtotal).toFixed(2)}</strong>
                    </div>
                </div>
            `;
        });
    }

    const detailsHtml = `
        <div class="row">
            <div class="col-md-6">
                <h6>Sale Information</h6>
                <p><strong>Sale #:</strong> ${sale.sale_number}</p>
                <p><strong>Date:</strong> ${new Date(sale.created_at).toLocaleString()}</p>
                <p><strong>Status:</strong> <span class="badge bg-success">${sale.sale_status}</span></p>
            </div>
            <div class="col-md-6">
                <h6>Customer Information</h6>
                <p><strong>Name:</strong> ${sale.customer_name || 'Walk-in Customer'}</p>
                <p><strong>Email:</strong> ${sale.customer_email || 'N/A'}</p>
                <p><strong>Phone:</strong> ${sale.customer_phone || 'N/A'}</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h6>Payment Information</h6>
                <p><strong>Method:</strong> <span class="badge bg-primary">${sale.payment_method}</span></p>
                <p><strong>Status:</strong> <span class="badge bg-success">${sale.payment_status}</span></p>
            </div>
            <div class="col-md-6">
                <h6>Totals</h6>
                <p><strong>Subtotal:</strong> ₱${parseFloat(sale.subtotal).toFixed(2)}</p>
                <p><strong>Tax:</strong> ₱${parseFloat(sale.tax_amount).toFixed(2)}</p>
                <p><strong>Discount:</strong> ₱${parseFloat(sale.discount_amount).toFixed(2)}</p>
                <p><strong>Total:</strong> <strong>₱${parseFloat(sale.total_amount).toFixed(2)}</strong></p>
            </div>
        </div>
        <hr>
        <h6>Items Purchased</h6>
        <div class="items-list">
            ${itemsHtml}
        </div>
    `;

    $('#transactionDetails').html(detailsHtml);
}
</script>
<?= $this->endSection() ?>
