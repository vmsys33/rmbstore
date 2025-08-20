<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="geex-content">
    <!-- POS Interface -->
    <div class="pos-container">
        <!-- Product Search Section -->
        <div class="search-section">
            <div class="search-header">
                <div class="search-input-container">
                    <input type="text" id="productSearch" placeholder="Search products..." class="search-input">
                    <button type="button" id="clearSearch" class="clear-search-btn" style="display: none;">×</button>
                    <div id="suggestions" class="suggestions hidden"></div>
                </div>
                <div class="customer-input-container">
                    <input type="text" id="customerName" placeholder="Customer name (optional)" class="customer-input">
                </div>
                <button id="newSaleBtn" class="btn btn-outline-primary" onclick="startNewSale()">
                    <i class="uil uil-plus"></i> New Sale
                </button>
            </div>
        </div>

        <!-- Selected Products Section -->
        <div class="products-section">
            <h3>Selected Products</h3>
            <div id="productList" class="product-list">
                <p style="text-align: center; color: #6c757d; font-style: italic;">No products selected yet. Start searching above!</p>
            </div>
            <button id="finishBtn" class="finish-btn" disabled onclick="finishProcess()">Finish Process</button>
        </div>

        <!-- Checkout Section -->
        <div id="checkoutSection" class="checkout-section" style="display: none;">
            <h3>Checkout</h3>
            <div class="checkout-summary">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span id="subtotal"><?= \App\Helpers\CurrencyHelper::format(0) ?></span>
                </div>
                <div class="summary-row">
                    <span>Tax (12%):</span>
                    <span id="tax"><?= \App\Helpers\CurrencyHelper::format(0) ?></span>
                </div>
                <div class="summary-row total">
                    <span>Total:</span>
                    <span id="total"><?= \App\Helpers\CurrencyHelper::format(0) ?></span>
                </div>
            </div>
            <div class="payment-buttons">
                <button onclick="processPayment('cash')" class="payment-btn cash">Cash</button>
                <button onclick="processPayment('card')" class="payment-btn card">Card</button>
                <button onclick="processPayment('bank_transfer')" class="payment-btn bank">Bank Transfer</button>
                <button onclick="processPayment('online')" class="payment-btn online">Online</button>
            </div>
        </div>

        <!-- Today's Sales Section -->
        <div class="sales-section">
            <div class="sales-header">
                <h3>📊 Today's Sales Summary</h3>
                <div class="sales-summary">
                    <div class="summary-card">
                        <span class="summary-label">💰 Total Sales Today:</span>
                        <span class="summary-value" id="totalSalesToday"><?= \App\Helpers\CurrencyHelper::format(0) ?></span>
                    </div>
                    <div class="summary-card">
                        <span class="summary-label">📋 Transactions:</span>
                        <span class="summary-value" id="totalTransactions">0</span>
                    </div>
                    <div class="summary-card">
                        <button id="closeDayBtn" class="close-day-btn" onclick="closeDay()" style="display: none;">
                            <span style="color: white; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);">🔒 Close Day</span>
                        </button>

                    </div>
                </div>
            </div>
            <div class="sales-table-container">
                <table id="transactionsTable" class="transactions-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="transactionsTableBody">
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px 20px; color: #6c757d;">
                                <div style="margin-bottom: 10px;">📊</div>
                                <div style="font-size: 16px; font-weight: 500; margin-bottom: 5px;">No Sales Today</div>
                                <div style="font-size: 14px; font-style: italic;">Complete your first transaction to see it here</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- Transaction Details Modal -->
<div id="transactionModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Transaction Details</h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <div id="transactionDetails">
                <!-- Transaction details will be loaded here -->
            </div>
        </div>
        <div class="modal-footer" id="modalFooter" style="display: none;">
            <button class="btn btn-primary" onclick="printTransactionReceipt()" style="min-height: 44px; min-width: 120px;">
                <i class="uil uil-print"></i> Print Receipt
            </button>
            <button class="btn btn-secondary" onclick="closeModal()" style="min-height: 44px; min-width: 80px;">Close</button>
        </div>
    </div>
</div>

<style>
/* POS Container */
.pos-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
    margin-top: 20px;
    max-width: 1400px;
    margin-left: auto;
    margin-right: auto;
}

/* Desktop layout */
@media (min-width: 769px) {
    .pos-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }
    
    /* Fallback for browsers that don't support grid */
    @supports not (display: grid) {
        .pos-container {
            display: flex;
            flex-wrap: wrap;
        }
        
        .pos-container > * {
            flex: 1 1 45%;
            margin: 10px;
        }
        
        .search-section {
            flex: 1 1 100%;
        }
    }
}

/* Search Section */
.search-section {
    width: 100%;
}

.search-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.search-input-container {
    position: relative;
    flex: 2;
    min-width: 400px;
    max-width: 1000px;
}

.customer-input-container {
    position: relative;
    flex: 0 0 auto;
    min-width: 180px;
    max-width: 250px;
}

.customer-input {
    width: 100%;
    padding: 12px 16px;
    font-size: 16px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    outline: none;
    transition: border-color 0.3s;
}

.customer-input:focus {
    border-color: #007bff;
}

.search-input {
    width: 100%;
    padding: 15px 20px;
    padding-right: 50px;
    font-size: 18px;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    outline: none;
    transition: border-color 0.3s;
}

.clear-search-btn {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    font-size: 20px;
    color: #6c757d;
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.clear-search-btn:hover {
    background-color: #e9ecef;
    color: #495057;
}

.search-input:focus {
    border-color: #007bff;
}

.suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    z-index: 1000;
    max-height: 300px;
    overflow-y: auto;
}

.suggestion-item {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    cursor: pointer;
    border-bottom: 1px solid #f1f3f4;
    transition: background-color 0.2s;
}

.suggestion-item:hover {
    background-color: #f8f9fa;
}

.suggestion-item:last-child {
    border-bottom: none;
}

.suggestion-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 12px;
}

.suggestion-info {
    flex: 1;
}

.suggestion-name {
    font-weight: 600;
    margin-bottom: 4px;
}

.suggestion-price {
    color: #28a745;
    font-weight: 600;
}

.hidden {
    display: none !important;
}

/* Debug styles for suggestions */
.suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    z-index: 1000;
    max-height: 300px;
    overflow-y: auto;
}

/* Force show suggestions for debugging */
.suggestions.show {
    display: block !important;
    border: 2px solid red !important;
}

/* Products Section */
.products-section {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    border: 2px solid #e9ecef;
}

.products-section h3 {
    margin-bottom: 20px;
    color: #2c3e50;
    font-size: 1.3rem;
}

.product-list {
    max-height: 400px;
    overflow-y: auto;
}

.selected-product {
    display: flex;
    align-items: center;
    padding: 12px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin-bottom: 10px;
    background: #f8f9fa;
    min-width: 0;
    overflow: hidden;
}

.selected-product-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 15px;
}

.selected-product-info {
    flex: 1;
    min-width: 0;
    overflow: hidden;
}

.selected-product-name {
    font-weight: 600;
    margin-bottom: 4px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.selected-product-price {
    color: #666;
    font-size: 14px;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-left: 15px;
    flex-shrink: 0;
}

.quantity-btn {
    background: #6c757d;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    font-size: 0.9rem;
}

.quantity-btn:hover {
    background: #5a6268;
}

.quantity-display {
    font-weight: bold;
    min-width: 30px;
    text-align: center;
}

.remove-btn {
    background: #dc3545;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 6px;
    cursor: pointer;
    margin-left: 8px;
    font-size: 0.9rem;
    white-space: nowrap;
}

.remove-btn:hover {
    background: #c82333;
}

.finish-btn {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.1rem;
    font-weight: 600;
    width: 100%;
    margin-top: 15px;
    transition: all 0.3s ease;
}

.finish-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
}

.finish-btn:disabled {
    background: #6c757d;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.no-products {
    text-align: center;
    color: #6c757d;
    padding: 40px 20px;
    font-style: italic;
}

/* Checkout Section */
.checkout-section {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    border: 2px solid #e9ecef;
    margin-top: 20px;
}

.checkout-section h3 {
    margin-bottom: 20px;
    color: #2c3e50;
    font-size: 1.3rem;
}

.checkout-summary {
    margin-bottom: 20px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #e9ecef;
}

.summary-row.total {
    font-weight: bold;
    font-size: 18px;
    border-bottom: none;
    margin-top: 10px;
    padding-top: 15px;
    border-top: 2px solid #007bff;
}

.payment-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.payment-btn {
    padding: 15px 20px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.payment-btn.cash {
    background: #28a745;
    color: white;
}

.payment-btn.cash:hover {
    background: #218838;
}

.payment-btn.card {
    background: #007bff;
    color: white;
}

.payment-btn.card:hover {
    background: #0056b3;
}

.payment-btn.bank {
    background: #6f42c1;
    color: white;
}

.payment-btn.bank:hover {
    background: #5a32a3;
}

.payment-btn.online {
    background: #fd7e14;
    color: white;
}

.payment-btn.online:hover {
    background: #e8690b;
}

/* Sales Section */
.sales-section {
    grid-column: 1 / -1;
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    border: 2px solid #e9ecef;
    margin-top: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.sales-section h3 {
    margin-bottom: 20px;
    color: #2c3e50;
    font-size: 1.3rem;
}

.sales-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 15px;
}

.sales-summary {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.summary-card {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 150px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    transition: transform 0.2s ease;
}

.summary-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(40, 167, 69, 0.5);
}

.summary-label {
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 4px;
    opacity: 0.9;
}

.summary-value {
    font-size: 1.4rem;
    font-weight: bold;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.close-day-btn {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white !important;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    width: 100%;
    margin-top: 10px;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
}

.close-day-btn:hover {
    background: linear-gradient(135deg, #c82333, #a71e2a);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
}

.close-day-btn:disabled {
    background: #6c757d;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.sales-table-container {
    overflow-x: auto;
    max-width: 100%;
    border-radius: 8px;
    display: block;
    width: 100%;
}

.transactions-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    table-layout: fixed;
    min-width: 600px;
    display: table;
}

.transactions-table th,
.transactions-table td {
    padding: 12px 16px;
    text-align: left;
    border-bottom: 1px solid #e9ecef;
    white-space: nowrap;
    overflow: visible;
    text-overflow: ellipsis;
    vertical-align: middle;
    display: table-cell;
}

.transactions-table th:nth-child(1),
.transactions-table td:nth-child(1) {
    width: 20%;
    min-width: 100px;
}

.transactions-table th:nth-child(2),
.transactions-table td:nth-child(2) {
    width: 30%;
    min-width: 120px;
}

.transactions-table th:nth-child(3),
.transactions-table td:nth-child(3) {
    width: 30%;
    min-width: 80px;
}

.transactions-table th:nth-child(4),
.transactions-table td:nth-child(4) {
    width: 30%;
    min-width: 120px;
    overflow: visible;
    white-space: nowrap;
}

.transactions-table th {
    background: #2c3e50;
    color: white;
    font-weight: 600;
    display: table-cell;
}

.transactions-table tr {
    display: table-row;
}

.transactions-table thead {
    display: table-header-group;
}

.transactions-table tbody {
    display: table-row-group;
}

.transactions-table tr:last-child td {
    border-bottom: none;
}

/* Chrome-specific fixes */
@supports (-webkit-appearance: none) {
    .transactions-table {
        -webkit-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: table !important;
        width: 100% !important;
    }
    
    .transactions-table th,
    .transactions-table td {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        display: table-cell !important;
    }
    
    .transactions-table tr {
        display: table-row !important;
    }
    
    .transactions-table thead {
        display: table-header-group !important;
    }
    
    .transactions-table tbody {
        display: table-row-group !important;
    }
    
    .sales-table-container {
        display: block !important;
        width: 100% !important;
        overflow-x: auto !important;
    }
}

.transactions-table tr:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Desktop-specific improvements */
@media (min-width: 769px) {
    .transactions-table {
        font-size: 0.95rem;
    }
    
    .transactions-table th {
        font-size: 1rem;
        padding: 16px;
    }
    
    .transactions-table td {
        padding: 14px 16px;
    }
    
    /* Better hover effects for desktop */
    .action-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    
    /* Improve table header */
    .transactions-table th {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }
    
    /* Better table borders */
    .transactions-table {
        border: 1px solid #dee2e6;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    /* Ensure action buttons are visible on desktop */
    .transactions-table td:nth-child(4) {
        overflow: visible;
        white-space: nowrap;
        min-width: 200px;
        padding-right: 20px;
    }
    
    .action-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        align-items: center;
        min-width: 200px;
        width: 100%;
    }
}
}

.action-btn {
    background: none;
    border: none;
    padding: 8px;
    margin: 0 2px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.action-btn:hover {
    background-color: #e9ecef;
}

.action-btn.preview {
    color: #007bff;
}

.action-btn.edit {
    color: #28a745;
}

.action-btn.delete {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    border: none;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
}

.action-btn.delete:hover {
    background: linear-gradient(135deg, #c82333, #a71e2a);
    transform: translateY(-1px);
    box-shadow: 0 3px 6px rgba(220, 53, 69, 0.4);
}

.action-btn.delete:active {
    transform: scale(0.95);
}

/* Action buttons styling */
.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: nowrap;
    justify-content: center;
    min-width: 180px;
    width: 100%;
}

.action-btn {
    padding: 8px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    flex-shrink: 0;
    min-width: 36px;
    min-height: 36px;
}

.preview-btn {
    background: #17a2b8;
    color: white;
}

.preview-btn:hover {
    background: #138496;
}

.edit-btn {
    background: #ffc107;
    color: #212529;
}

.edit-btn:hover {
    background: #e0a800;
}

.delete-btn {
    background: #dc3545;
    color: white;
}

.delete-btn:hover {
    background: #c82333;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: white;
    margin: 2% auto;
    padding: 0;
    border-radius: 10px;
    width: 90%;
    max-width: 800px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
}

.modal-header h2 {
    margin: 0;
    color: #333;
}

.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover {
    color: #000;
}

.modal-body {
    padding: 20px;
}

.transaction-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.detail-group {
    margin-bottom: 15px;
}

.detail-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
}

.detail-value {
    color: #333;
}

.products-list {
    grid-column: 1 / -1;
    margin-top: 20px;
}

.products-header {
    font-weight: 600;
    margin-bottom: 10px;
    color: #495057;
}

.product-item {
    display: flex;
    align-items: center;
    padding: 10px;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    margin-bottom: 8px;
    background: #f8f9fa;
}

.product-name {
    flex: 1;
    font-weight: 500;
}

.product-price {
    color: #28a745;
    font-weight: 600;
}

/* Mobile responsive design - EXACT COPY from test.html */
@media (max-width: 768px) {
    .pos-container {
        grid-template-columns: 1fr;
        gap: 15px;
        padding: 15px;
        margin-top: 10px;
    }
    
    .search-section {
        margin-bottom: 10px;
    }
    
    .search-header {
        flex-direction: column;
        gap: 12px;
        margin-bottom: 15px;
    }
    
    .search-input-container {
        max-width: 100%;
    }
    
    .customer-input-container {
        min-width: 100%;
    }
    
    /* Improve sales summary visibility on mobile */
    .sales-summary {
        flex-direction: column;
        gap: 10px;
        margin-bottom: 15px;
    }
    
    .summary-card {
        width: 100%;
        padding: 15px;
        text-align: center;
    }
    
    .summary-label {
        font-size: 14px;
        margin-bottom: 5px;
    }
    
    .summary-value {
        font-size: 18px;
        font-weight: bold;
    }
    
    .search-input {
        font-size: 16px;
        padding: 12px 16px;
        padding-right: 45px;
        border-radius: 8px;
    }
    
    .clear-search-btn {
        right: 12px;
        font-size: 18px;
        width: 25px;
        height: 25px;
    }
    
    #newSaleBtn {
        width: 100%;
        padding: 12px 16px;
        font-size: 14px;
        border-radius: 8px;
    }
    
    .suggestion-image {
        width: 40px !important;
        height: 40px !important;
    }
    
    .suggestion-name {
        font-size: 0.9rem;
    }
    
    .suggestion-price {
        font-size: 0.8rem;
    }
    
    .suggestion-item {
        padding: 10px 12px;
        min-height: 60px;
        touch-action: manipulation;
    }
    
    .suggestion-item:active {
        background-color: #e9ecef;
    }
    
    .products-section {
        padding: 15px;
        margin-bottom: 15px;
    }
    
    .products-section h3 {
        font-size: 18px;
        margin-bottom: 15px;
    }
    
    .selected-product {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        padding: 12px;
        margin-bottom: 10px;
    }
    
    .selected-product-image {
        width: 50px !important;
        height: 50px !important;
        margin-right: 0 !important;
        margin-bottom: 8px;
    }
    
    .selected-product-info {
        width: 100% !important;
        margin-right: 0 !important;
    }
    
    .selected-product-name {
        font-size: 0.9rem;
        margin-bottom: 4px;
    }
    
    .selected-product-price {
        font-size: 0.8rem;
        margin-bottom: 8px;
    }
    
    .quantity-controls {
        width: 100% !important;
        justify-content: space-between !important;
        flex-wrap: wrap;
        gap: 8px;
        margin-left: 0 !important;
    }
    
    .quantity-btn {
        padding: 8px 12px;
        font-size: 0.9rem;
        border-radius: 6px;
    }
    
    .remove-btn {
        margin-left: 0 !important;
        margin-top: 8px;
        width: 100%;
        padding: 10px !important;
        border-radius: 6px;
    }
    
    .finish-btn {
        padding: 15px 20px;
        font-size: 1rem;
        width: 100%;
        border-radius: 8px;
        margin-top: 15px;
    }
    
    .checkout-section {
        padding: 15px;
        margin-top: 15px;
    }
    
    .checkout-section h3 {
        font-size: 18px;
        margin-bottom: 15px;
    }
    
    .checkout-summary {
        margin-bottom: 20px;
    }
    
    .summary-row {
        font-size: 0.9rem;
        padding: 8px 0;
    }
    
    .summary-row.total {
        font-size: 16px;
        font-weight: bold;
        margin-top: 10px;
        padding-top: 12px;
    }
    
    .payment-buttons {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    
    .payment-btn {
        padding: 15px 16px;
        font-size: 14px;
        border-radius: 8px;
    }
    
    .sales-section {
        padding: 15px;
        margin-top: 15px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .sales-section h3 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #333;
        text-align: center;
    }
    
    .sales-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    
    .sales-summary {
        width: 100%;
        justify-content: space-between;
        gap: 10px;
    }
    
    .summary-card {
        flex: 1;
        min-width: 120px;
        padding: 10px 15px;
    }
    
    .summary-label {
        font-size: 0.8rem;
    }
    
    .summary-value {
        font-size: 1.1rem;
    }
    
    .sales-table-container {
        border-radius: 8px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .transactions-table {
        font-size: 0.85rem;
        min-width: 500px;
    }
    
    .transactions-table th,
    .transactions-table td {
        padding: 8px 6px;
        white-space: nowrap;
        text-align: center;
    }
    
    .transactions-table th {
        background: #2c3e50;
        color: white;
        font-weight: 600;
        position: sticky;
        top: 0;
    }
    
    .transactions-table tr {
        border-bottom: 1px solid #e9ecef;
    }
    
    .transactions-table tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Show all columns on mobile but make them more compact */
    .transactions-table th,
    .transactions-table td {
        padding: 8px 4px;
        font-size: 0.8rem;
    }
    
    /* Make customer column more prominent */
    .transactions-table td:nth-child(2) {
        font-weight: 600;
        color: #007bff;
    }
    
    .action-buttons {
        display: flex;
        gap: 5px;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .action-btn {
        padding: 6px 8px;
        font-size: 0.8rem;
        border-radius: 4px;
        min-width: 32px;
        min-height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        touch-action: manipulation;
    }
    
    .action-btn:active {
        transform: scale(0.95);
    }
    
    .modal-content {
        margin: 5% auto;
        width: 95%;
        padding: 15px;
    }
    
    .modal-header {
        padding: 15px;
    }
    
    .modal-header h2 {
        font-size: 18px;
    }
    
    .transaction-details {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .detail-group {
        margin-bottom: 10px;
    }
    
    .detail-label {
        font-size: 0.9rem;
    }
    
    .detail-value {
        font-size: 0.9rem;
    }
    
    .product-item {
        padding: 8px;
        margin-bottom: 6px;
    }
    
    .product-name {
        font-size: 0.9rem;
    }
    
         .product-price {
         font-size: 0.8rem;
     }
     
     .action-buttons {
        flex-direction: row;
         gap: 4px;
         justify-content: flex-start;
     }
     
     .action-btn {
         padding: 8px;
         font-size: 1rem;
         width: 32px;
         height: 32px;
         border-radius: 6px;
         display: flex;
         align-items: center;
         justify-content: center;
     }
     
     .action-btn.delete {
         background: linear-gradient(135deg, #dc3545, #c82333) !important;
         color: white !important;
         border: none !important;
         font-weight: 600 !important;
         box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3) !important;
         display: flex !important;
         visibility: visible !important;
         opacity: 1 !important;
     }
     
     .action-btn.delete:hover {
         background: linear-gradient(135deg, #c82333, #a71e2a) !important;
         transform: translateY(-1px);
         box-shadow: 0 3px 6px rgba(220, 53, 69, 0.4) !important;
     }
     
     .action-btn.delete:active {
         transform: scale(0.95);
     }
     
     /* Ensure actions column is visible on medium mobile */
     .transactions-table th:nth-child(4),
     .transactions-table td:nth-child(4) {
         display: table-cell !important;
         visibility: visible !important;
         opacity: 1 !important;
     }
     
     /* Improve table mobile layout */
     .transactions-table {
         min-width: 300px;
     }
     
     .transactions-table th,
     .transactions-table td {
         white-space: nowrap;
         text-align: center;
     }
     
     /* Make sale number more prominent on mobile */
     .transactions-table td:first-child {
         font-weight: 600;
         color: #007bff;
     }
 }

/* Extra small screens */
@media (max-width: 480px) {
    .pos-container {
        padding: 10px;
        gap: 10px;
        margin-top: 5px;
    }
    
    .search-header {
        gap: 8px;
        margin-bottom: 10px;
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-input-container {
        flex: 1;
        min-width: unset;
        max-width: none;
    }
    
    .customer-input-container {
        min-width: 100%;
        max-width: none;
    }
    
    .search-input {
        padding: 10px 14px;
        padding-right: 40px;
        font-size: 16px;
        border-radius: 6px;
    }
    
    .clear-search-btn {
        right: 10px;
        font-size: 16px;
        width: 22px;
        height: 22px;
    }
    
    #newSaleBtn {
        padding: 10px 14px;
        font-size: 13px;
        border-radius: 6px;
    }
    
    .products-section,
    .checkout-section,
    .sales-section {
        padding: 12px;
        margin-bottom: 10px;
    }
    
    .products-section h3,
    .checkout-section h3,
    .sales-section h3 {
        font-size: 16px;
        margin-bottom: 12px;
    }
    
    .selected-product {
        padding: 10px;
        margin-bottom: 8px;
    }
    
    .selected-product-image {
        width: 40px !important;
        height: 40px !important;
    }
    
    .selected-product-name {
        font-size: 0.8rem;
    }
    
    .selected-product-price {
        font-size: 0.7rem;
    }
    
    .quantity-controls {
        gap: 6px;
    }
    
    .quantity-btn {
        padding: 6px 10px;
        font-size: 0.8rem;
        border-radius: 4px;
    }
    
    .remove-btn {
        padding: 8px !important;
        font-size: 0.8rem;
        border-radius: 4px;
    }
    
    .finish-btn {
        padding: 12px 16px;
        font-size: 0.9rem;
        border-radius: 6px;
    }
    
    .payment-btn {
        padding: 12px 14px;
        font-size: 13px;
        border-radius: 6px;
    }
    
    .transactions-table {
        font-size: 0.75rem;
        min-width: 280px;
    }
    
    .transactions-table th,
    .transactions-table td {
        padding: 6px 4px;
    }
    
    /* Show only essential columns on very small screens */
    .transactions-table th:nth-child(1),
    .transactions-table td:nth-child(1) {
        display: none;
    }
    
    .transactions-table th:nth-child(3),
    .transactions-table td:nth-child(3) {
        display: none;
    }
    
    /* Optimize remaining columns for mobile */
    .transactions-table th:nth-child(2),
    .transactions-table td:nth-child(2) {
        width: 55%;
        min-width: 100px;
    }
    
    .transactions-table th:nth-child(4),
    .transactions-table td:nth-child(4) {
        width: 45%;
        min-width: 90px;
    }
    
    /* Improve action buttons for very small screens */
    .action-buttons {
        gap: 4px;
        flex-wrap: nowrap;
        justify-content: flex-start;
        width: 100%;
        display: flex !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    
    .action-btn {
        min-width: 28px;
        min-height: 28px;
        font-size: 0.8rem;
        padding: 4px 6px;
        border-radius: 4px;
        display: flex !important;
        align-items: center;
        justify-content: center;
        touch-action: manipulation;
        white-space: nowrap;
        visibility: visible !important;
        opacity: 1 !important;
    }
    
    .action-btn.delete {
        background: linear-gradient(135deg, #dc3545, #c82333) !important;
        color: white !important;
        border: none !important;
        font-weight: 600 !important;
        box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3) !important;
        display: flex !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    
    .action-btn.delete:hover {
        background: linear-gradient(135deg, #c82333, #a71e2a) !important;
        transform: translateY(-1px);
        box-shadow: 0 3px 6px rgba(220, 53, 69, 0.4) !important;
    }
    
    .action-btn.delete:active {
        transform: scale(0.95);
    }
    
    /* Ensure actions column is visible */
    .transactions-table th:nth-child(4),
    .transactions-table td:nth-child(4) {
        display: table-cell !important;
        visibility: visible !important;
        opacity: 1 !important;
        width: 40% !important;
        min-width: 80px !important;
    }
    
    .transactions-table th,
    .transactions-table td {
        padding: 4px 2px;
    }
    
    .modal-content {
        margin: 2% auto;
        width: 98%;
        padding: 10px;
    }
    
    .modal-header {
        padding: 10px;
    }
    
    .modal-header h2 {
        font-size: 16px;
    }
    
    .modal-body {
        padding: 10px;
    }
    
    /* Improve mobile touch targets */
    .suggestion-item {
        padding: 15px 12px;
        min-height: 60px;
    }
    
    .quantity-btn {
        min-width: 40px;
        min-height: 40px;
    }
    
    .remove-btn {
        min-height: 40px;
    }
    
    /* Better mobile spacing */
    .sales-section {
        margin-top: 15px;
    }
    
    .sales-table-container {
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    /* Mobile table improvements */
    .transactions-table {
        border: 1px solid #dee2e6;
    }
    
    .transactions-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #495057;
    }
    
    /* Better mobile table scrolling */
    .sales-table-container {
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
    }
    
    .sales-table-container::-webkit-scrollbar {
        height: 4px;
    }
    
    .sales-table-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 2px;
    }
    
    .sales-table-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 2px;
    }
    
    .sales-table-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    
    /* Mobile table row improvements */
    .transactions-table tr {
        border-bottom: 1px solid #e9ecef;
    }
    
    .transactions-table tr:last-child {
        border-bottom: none;
    }
    
    /* Better mobile table header */
    .transactions-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .transactions-table th {
        position: sticky;
        top: 0;
        background: #f8f9fa;
        z-index: 10;
    }
}
</style>

<?= $this->endSection() ?>

<?= $this->section('custom_scripts') ?>
<script>
// Products data from PHP
const products = <?= json_encode($products) ?>;
let selectedProducts = [];





// Debug: Check product data
console.log('Products loaded:', products.length);
if (products.length > 0) {
    console.log('First product:', products[0]);
    console.log('Products with image_icon:', products.filter(p => p.image_icon).length);
    console.log('Sample image_icon values:', products.slice(0, 3).map(p => p.image_icon));
}



// Currency configuration from PHP
const currencySymbol = '<?= \App\Helpers\CurrencyHelper::getCurrencySymbol() ?>';
const currencyCode = '<?= \App\Helpers\CurrencyHelper::getCurrency() ?>';

// Currency formatting functions
function formatCurrency(amount, decimals = 2) {
    const formattedAmount = parseFloat(amount).toFixed(decimals);
    return currencySymbol + formattedAmount;
}

function formatAmount(amount, decimals = 2) {
    return parseFloat(amount).toFixed(decimals);
}

// Global variables for DOM elements
let searchInput, suggestions, productList, clearSearchBtn;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    searchInput = document.getElementById('productSearch');
    suggestions = document.getElementById('suggestions');
    productList = document.getElementById('productList');
    clearSearchBtn = document.getElementById('clearSearch');

    // Initialize
    if (searchInput && suggestions && productList) {
    // Add input event listener
    searchInput.addEventListener('input', function() {
    const query = this.value.toLowerCase();
        
        // Show/hide clear button
        if (query.length > 0) {
            clearSearchBtn.style.display = 'flex';
        } else {
            clearSearchBtn.style.display = 'none';
        }
        
        if (query.length < 2) {
        hideSuggestions();
        return;
    }
    
        const filteredProducts = products.filter(product =>
            product.product_name.toLowerCase().includes(query)
    );
    
    showSuggestions(filteredProducts);
});

    // Add blur event listener
    searchInput.addEventListener('blur', function() {
        setTimeout(hideSuggestions, 200);
    });
    
    // Add clear search functionality
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            clearSearchBtn.style.display = 'none';
            hideSuggestions();
            searchInput.focus();
        });
    }
    
    // Load initial transactions
    loadTransactions();
    
    // Update sales summary on page load
    updateSalesSummary();
    }
});

// Show suggestions - EXACT COPY from test.html
function showSuggestions(products) {
    if (products.length === 0) {
        hideSuggestions();
        return;
    }
    
    console.log('Showing suggestions for products:', products.length);
        
    suggestions.innerHTML = products.map(product => {
        // Check if image_icon already contains the full path
        const imageUrl = product.image_icon ? 
            (product.image_icon.startsWith('uploads/') ? 
                '<?= base_url() ?>' + product.image_icon : 
                '<?= base_url('uploads/products/icons/') ?>' + product.image_icon) : 
            '<?= base_url('assets/img/avatar/user.svg') ?>';
        
        console.log('Product:', product.product_name, 'Image URL:', imageUrl, 'Has image_icon:', !!product.image_icon);
        
        return '<div class="suggestion-item" onclick="selectProduct(' + product.id + ')">' +
            '<img src="' + imageUrl + '" alt="' + product.product_name + '" class="suggestion-image" onerror="this.src=\'<?= base_url('assets/img/avatar/user.svg') ?>\'">' +
            '<div class="suggestion-info">' +
                '<div class="suggestion-name">' + product.product_name + '</div>' +
                '<div class="suggestion-price">' + formatCurrency(product.price) + '</div>' +
            '</div>' +
        '</div>';
    }).join('');

    suggestions.classList.remove('hidden');
    

}

// Hide suggestions - EXACT COPY from test.html
function hideSuggestions() {
    suggestions.classList.add('hidden');
}

// Select product - GLOBAL FUNCTION
window.selectProduct = function(productId) {
    console.log('selectProduct called - starting new transaction');
    
    // Fix: Handle both string and number ID types
    const product = products.find(p => p.id == productId || Number(p.id) === productId);
    
    if (!product) {
        return;
    }

    const existingProduct = selectedProducts.find(p => p.id == productId || Number(p.id) === productId);
    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        selectedProducts.push({
            ...product,
            quantity: 1
        });
    }
    
    // Clear the search input for next product search
    if (searchInput) {
        searchInput.value = '';
    }
    
    // Hide suggestions
    hideSuggestions();
    
    // Update the product list
    updateProductList();
    
    // Show success notification with SweetAlert
    Swal.fire({
        icon: 'success',
        title: 'Product Added!',
        text: `${product.product_name} has been added to cart.`,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        background: '#28a745',
        color: '#fff'
    });
}

// Update quantity - EXACT COPY from test.html
function updateQuantity(productId, change) {
    const product = selectedProducts.find(p => p.id == productId || Number(p.id) === productId);
    if (!product) return;

        product.quantity += change;
        if (product.quantity <= 0) {
            removeProduct(productId);
        } else {
            updateProductList();
    }
}

// Remove product - EXACT COPY from test.html
function removeProduct(productId) {
    const product = selectedProducts.find(p => p.id == productId || Number(p.id) === productId);
    selectedProducts = selectedProducts.filter(p => p.id != productId && Number(p.id) !== productId);
    updateProductList();
    
    // Show notification for removed product
    if (product) {
        Swal.fire({
            icon: 'info',
            title: 'Product Removed',
            text: `${product.product_name} has been removed from cart.`,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            background: '#17a2b8',
            color: '#fff'
        });
    }
}

            // Update product list
function updateProductList() {
    console.log('updateProductList called with selectedProducts:', selectedProducts);
    const finishBtn = document.getElementById('finishBtn');
    
    if (selectedProducts.length === 0) {
        console.log('No products selected - clearing product list display');
        productList.innerHTML = '<p style="text-align: center; color: #6c757d; font-style: italic;">No products selected yet. Start searching above!</p>';
        if (finishBtn) finishBtn.disabled = true;
    } else {
        const productHTML = selectedProducts.map(product => {
            // Check if image_icon already contains the full path
            const imageUrl = product.image_icon ?
                (product.image_icon.startsWith('uploads/') ? 
                    '<?= base_url() ?>' + product.image_icon : 
                    '<?= base_url('uploads/products/icons/') ?>' + product.image_icon) :
                '<?= base_url('assets/img/avatar/user.svg') ?>';

            return '<div class="selected-product">' +
                '<img src="' + imageUrl + '" alt="' + product.product_name + '" class="selected-product-image" onerror="this.src=\'<?= base_url('assets/img/avatar/user.svg') ?>\'">' +
                '<div class="selected-product-info">' +
                    '<div class="selected-product-name">' + product.product_name + '</div>' +
                    '<div class="selected-product-price">' + formatCurrency(product.price) + ' × ' + product.quantity + ' = ' + formatCurrency(parseFloat(product.price) * product.quantity) + '</div>' +
                '</div>' +
                '<div class="quantity-controls">' +
                    '<button class="quantity-btn" onclick="updateQuantity(' + product.id + ', -1)">-</button>' +
                    '<span style="font-weight: bold; min-width: 20px; text-align: center;">' + product.quantity + '</span>' +
                    '<button class="quantity-btn" onclick="updateQuantity(' + product.id + ', 1)">+</button>' +
                    '<button class="remove-btn" onclick="removeProduct(' + product.id + ')">Remove</button>' +
                '</div>' +
            '</div>';
        }).join('');
        
        productList.innerHTML = productHTML;
        
        if (finishBtn) finishBtn.disabled = false;
    }

    updateTotals();
}

// Update totals
function updateTotals() {
    const subtotal = selectedProducts.reduce((sum, product) => sum + (parseFloat(product.price) * product.quantity), 0);
    const tax = subtotal * 0.12;
    const total = subtotal + tax;
    
    console.log('updateTotals called - subtotal:', subtotal, 'tax:', tax, 'total:', total);
    
    const subtotalElement = document.getElementById('subtotal');
    const taxElement = document.getElementById('tax');
    const totalElement = document.getElementById('total');
    
    if (subtotalElement) {
        subtotalElement.textContent = formatCurrency(subtotal);
        console.log('Subtotal updated to:', subtotalElement.textContent);
    }
    if (taxElement) {
        taxElement.textContent = formatCurrency(tax);
        console.log('Tax updated to:', taxElement.textContent);
    }
    if (totalElement) {
        totalElement.textContent = formatCurrency(total);
        console.log('Total updated to:', totalElement.textContent);
    }
}

// Transaction history variables
let transactionHistory = [];



// Load transactions from database
function loadTransactions() {
    fetch('<?= base_url('admin/pos/recent-sales') ?>')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                transactionHistory = data.sales;
                updateTransactionsTable();
            } else {
                console.error('Failed to load transactions:', data.message);
            }
        })
        .catch(error => {
            console.error('Error loading transactions:', error);
        });
}

// Load transactions after sale (without updating sales summary)
function loadTransactionsAfterSale() {
    fetch('<?= base_url('admin/pos/recent-sales') ?>')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                transactionHistory = data.sales;
                updateTransactionsTableAfterSale();
            } else {
                console.error('Failed to load transactions:', data.message);
            }
        })
        .catch(error => {
            console.error('Error loading transactions:', error);
        });
}

// Process payment
function processPayment(method) {
    if (selectedProducts.length === 0) {
        return;
    }
    
    const total = selectedProducts.reduce((sum, product) => sum + (parseFloat(product.price) * product.quantity), 0);
    const tax = total * 0.12;
    const grandTotal = total + tax;
    
    // Prepare sale data for database
    const customerName = document.getElementById('customerName').value.trim() || 'Walk-in Customer';
    const saleData = {
        customer_name: customerName,
        payment_method: method,
        items: selectedProducts.map(product => ({
            product_id: product.id,
            product_name: product.product_name,
            product_sku: product.sku || 'SKU-' + product.id,
            quantity: product.quantity,
            unit_price: parseFloat(product.price),
            discount_percent: 0,
            discount_amount: 0,
            subtotal: parseFloat(product.price) * product.quantity,
            total_amount: parseFloat(product.price) * product.quantity
        })),
        subtotal: total,
        tax_amount: tax,
        discount_amount: 0,
        total_amount: grandTotal,
        notes: 'POS Transaction'
    };
    
    // Send to server
    fetch('<?= base_url('admin/pos/process-sale') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(saleData)
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        return response.text().then(text => {
            console.log('Raw response text:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Failed to parse JSON:', e);
                console.log('Response text that failed to parse:', text);
                throw new Error('Invalid JSON response: ' + text);
            }
        });
    })
            .then(data => {
            console.log('Parsed response data:', data);
            if (data.success) {
                console.log('Transaction successful - starting cleanup...');
                
                // Clear cart after successful payment
                selectedProducts = [];
                console.log('Selected products cleared:', selectedProducts);
                updateProductList();
                
                // Clear customer name
                const customerNameInput = document.getElementById('customerName');
                if (customerNameInput) {
                    customerNameInput.value = '';
                    console.log('Customer name cleared');
                } else {
                    console.error('Customer name input not found');
                }
                
                // Clear search input
                const searchInput = document.getElementById('productSearch');
                if (searchInput) {
                    searchInput.value = '';
                    console.log('Search input cleared');
                } else {
                    console.error('Search input not found');
                }
                
                // Hide checkout section
                const checkoutSection = document.getElementById('checkoutSection');
                if (checkoutSection) {
                    checkoutSection.style.display = 'none';
                    console.log('Checkout section hidden');
                } else {
                    console.error('Checkout section not found');
                }
                
                // Load updated transactions and update sales summary
                console.log('Loading updated transactions...');
                loadTransactionsAfterSale();
                
                // Update sales summary after loading transactions
                setTimeout(() => {
                    console.log('Updating sales summary...');
                    updateSalesSummary();
                }, 500);
                
                // Show success message with SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Transaction Completed!',
                    text: 'Payment processed successfully.',
                    confirmButtonText: 'OK',
                    timer: 3000,
                    timerProgressBar: true
                });
            } else {
                console.error('Validation Error Details:', data);
                Swal.fire({
                    icon: 'error',
                    title: 'Transaction Failed',
                    text: data.message || 'An error occurred during payment processing.',
                    confirmButtonText: 'OK'
                });
            }
        })
    .catch(error => {
        console.error('Error processing payment:', error);
        Swal.fire({
            icon: 'error',
            title: 'Payment Error',
            text: 'Error processing payment. Please try again.',
            confirmButtonText: 'OK'
        });
    });
}

// Finish process function
function finishProcess() {
    if (selectedProducts.length === 0) {
        return;
    }

    // Show checkout section
    const checkoutSection = document.getElementById('checkoutSection');
    if (checkoutSection) {
        checkoutSection.style.display = 'block';
        checkoutSection.scrollIntoView({ behavior: 'smooth' });
    }
}

// Update transactions table
function updateTransactionsTable() {
    const tbody = document.getElementById('transactionsTableBody');
    console.log('Updating transactions table...');
    console.log('Table body element:', tbody);
    console.log('Transaction history:', transactionHistory);
    
    if (!tbody) {
        console.error('Table body not found');
        return;
    }
    
    if (transactionHistory.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 40px 20px; color: #6c757d;">' +
            '<div style="margin-bottom: 10px;">📊</div>' +
            '<div style="font-size: 16px; font-weight: 500; margin-bottom: 5px;">No Sales Today</div>' +
            '<div style="font-size: 14px; font-style: italic;">Complete your first transaction to see it here</div>' +
            '</td></tr>';
        return;
    }
    
    tbody.innerHTML = transactionHistory.map(transaction => {
        const date = new Date(transaction.created_at);
        const timeString = date.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit',
            hour12: true 
        });
        
        console.log('Rendering transaction:', transaction.id, 'with delete button');
        
        return '<tr>' +
            '<td>' + timeString + '</td>' +
            '<td>' + (transaction.customer_name || 'Walk-in Customer') + '</td>' +
            '<td>' + formatCurrency(transaction.total_amount) + '</td>' +
            '<td>' +
                '<div class="action-buttons">' +
                    '<button class="action-btn preview" onclick="previewTransaction(' + transaction.id + ')" title="Preview">👁️</button>' +
                    '<button class="action-btn delete" onclick="deleteTransaction(' + transaction.id + ')" title="Delete">🗑️</button>' +
                '</div>' +
            '</td>' +
        '</tr>';
    }).join('');
    
    // Update sales summary
    updateSalesSummary();
}

// Update transactions table after sale (without updating sales summary)
function updateTransactionsTableAfterSale() {
    const tbody = document.getElementById('transactionsTableBody');
    console.log('Updating transactions table after sale...');
    console.log('Table body element:', tbody);
    console.log('Transaction history:', transactionHistory);
    
    if (!tbody) {
        console.error('Table body not found');
        return;
    }
    
    if (transactionHistory.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 40px 20px; color: #6c757d;">' +
            '<div style="margin-bottom: 10px;">📊</div>' +
            '<div style="font-size: 16px; font-weight: 500; margin-bottom: 5px;">No Sales Today</div>' +
            '<div style="font-size: 14px; font-style: italic;">Complete your first transaction to see it here</div>' +
            '</td></tr>';
        return;
    }
    
    tbody.innerHTML = transactionHistory.map(transaction => {
        const date = new Date(transaction.created_at);
        const timeString = date.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit',
            hour12: true 
        });
        
        console.log('Rendering transaction:', transaction.id, 'with delete button');
        
        return '<tr>' +
            '<td>' + timeString + '</td>' +
            '<td>' + (transaction.customer_name || 'Walk-in Customer') + '</td>' +
            '<td>' + formatCurrency(transaction.total_amount) + '</td>' +
            '<td>' +
                '<div class="action-buttons">' +
                    '<button class="action-btn preview" onclick="previewTransaction(' + transaction.id + ')" title="Preview">👁️</button>' +
                    '<button class="action-btn delete" onclick="deleteTransaction(' + transaction.id + ')" title="Delete">🗑️</button>' +
                '</div>' +
            '</td>' +
        '</tr>';
    }).join('');
    
    // Don't update sales summary - keep it reset
    console.log('Transactions table updated after sale (sales summary kept reset)');
}

// Update sales summary
function updateSalesSummary() {
    console.log('updateSalesSummary called');
    
    const totalSales = transactionHistory.reduce((sum, transaction) => sum + parseFloat(transaction.total_amount), 0);
    const totalTransactions = transactionHistory.length;
    
    const totalSalesElement = document.getElementById('totalSalesToday');
    const totalTransactionsElement = document.getElementById('totalTransactions');
    const closeDayBtn = document.getElementById('closeDayBtn');
    
    if (totalSalesElement) {
        totalSalesElement.textContent = formatCurrency(totalSales);
    }
    
    if (totalTransactionsElement) {
        totalTransactionsElement.textContent = totalTransactions;
    }
    
    // Show/hide close day button based on transactions
    if (closeDayBtn) {
        if (totalTransactions > 0) {
            closeDayBtn.style.display = 'block';
        } else {
            closeDayBtn.style.display = 'none';
        }
    }
    
    // Add visual feedback for empty state
    const salesSection = document.querySelector('.sales-section');
    if (salesSection) {
        if (totalTransactions === 0) {
            salesSection.style.opacity = '0.8';
        } else {
            salesSection.style.opacity = '1';
        }
    }
    
    console.log('Sales Summary Updated:', { totalSales, totalTransactions });
}

// Clear sales by creating daily closing record
function clearSalesByDailyClosing() {
    console.log('clearSalesByDailyClosing called...');
    
    // Create daily closing record to clear today's sales
    fetch('<?= base_url('admin/pos/close-day') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            opening_cash: 0,
            closing_cash: 0,
            notes: 'Auto-cleared after transaction'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Daily closing created successfully');
            // Reload transactions to reflect cleared state
            loadTransactions();
        } else {
            console.error('Failed to create daily closing:', data.message);
            // Fallback to manual reset
            resetSalesSummary();
            loadTransactions();
        }
    })
    .catch(error => {
        console.error('Error creating daily closing:', error);
        // Fallback to manual reset
        resetSalesSummary();
        loadTransactions();
    });
}

// Reset sales summary to initial state (fallback function)
function resetSalesSummary() {
    console.log('resetSalesSummary called...');
    
    const totalSalesElement = document.getElementById('totalSalesToday');
    const totalTransactionsElement = document.getElementById('totalTransactions');
    const closeDayBtn = document.getElementById('closeDayBtn');
    
    console.log('Found elements:', {
        totalSalesElement: !!totalSalesElement,
        totalTransactionsElement: !!totalTransactionsElement,
        closeDayBtn: !!closeDayBtn
    });
    
    if (totalSalesElement) {
        totalSalesElement.textContent = formatCurrency(0);
        console.log('Total sales reset to:', totalSalesElement.textContent);
    } else {
        console.error('totalSalesToday element not found');
    }
    
    if (totalTransactionsElement) {
        totalTransactionsElement.textContent = '0';
        console.log('Total transactions reset to:', totalTransactionsElement.textContent);
    } else {
        console.error('totalTransactions element not found');
    }
    
    // Hide close day button
    if (closeDayBtn) {
        closeDayBtn.style.display = 'none';
        console.log('Close day button hidden');
    } else {
        console.error('closeDayBtn element not found');
    }
    
    // Reset visual feedback
    const salesSection = document.querySelector('.sales-section');
    if (salesSection) {
        salesSection.style.opacity = '0.8';
        console.log('Sales section opacity reset');
    } else {
        console.error('sales-section element not found');
    }
    
    console.log('Sales Summary Reset Complete');
}
            
// Print receipt function
function printReceipt(paymentMethod, total, sale = null) {
                const printWindow = window.open('', '_blank');
                const receiptContent = 
                    '<html><head><title>Receipt</title>' +
                    '<style>' +
                    'body { font-family: Arial, sans-serif; margin: 20px; }' +
                    '.receipt { max-width: 300px; margin: 0 auto; }' +
                    '.header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }' +
                    '.item { display: flex; justify-content: space-between; margin-bottom: 5px; }' +
                    '.total { border-top: 1px solid #000; padding-top: 10px; margin-top: 10px; font-weight: bold; }' +
                    '.footer { text-align: center; margin-top: 20px; font-size: 12px; }' +
                    '</style></head><body>' +
                    '<div class="receipt">' +
                        '<div class="header">' +
                            '<h2>POS Receipt</h2>' +
                            '<p>Date: ' + new Date().toLocaleDateString() + '</p>' +
                            '<p>Time: ' + new Date().toLocaleTimeString() + '</p>' +
                        '</div>' +
                        '<div class="items">';
                
                selectedProducts.forEach(product => {
                                    receiptContent += 
                    '<div class="item">' +
                        '<span>' + product.product_name + ' x' + product.quantity + '</span>' +
                        '<span>' + formatCurrency(parseFloat(product.price) * product.quantity) + '</span>' +
                    '</div>';
                });
                
                const subtotal = selectedProducts.reduce((sum, product) => sum + (parseFloat(product.price) * product.quantity), 0);
                const tax = subtotal * 0.12;
                
                receiptContent += 
                        '</div>' +
                        '<div class="total">' +
                            '<div class="item"><span>Subtotal:</span><span>' + formatCurrency(subtotal) + '</span></div>' +
                            '<div class="item"><span>Tax (12%):</span><span>' + formatCurrency(tax) + '</span></div>' +
                            '<div class="item"><span>Total:</span><span>' + formatCurrency(total) + '</span></div>' +
                            '<div class="item"><span>Payment:</span><span>' + paymentMethod + '</span></div>' +
                        '</div>' +
                                                 '<div class="footer">' +
                             '<p>Thank you for your purchase!</p>' +
                             '<p>Transaction #' + (sale ? sale.sale_number : 'N/A') + '</p>' +
                         '</div>' +
                    '</div>' +
                    '</body></html>';
                
                printWindow.document.write(receiptContent);
                printWindow.document.close();
                printWindow.print();
            }
            
// Preview transaction
function previewTransaction(transactionId) {
    // Fetch transaction details from server
    fetch('<?= base_url('admin/pos/sale-details/') ?>' + transactionId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const transaction = data.sale;
                const modal = document.getElementById('transactionModal');
                const details = document.getElementById('transactionDetails');
                
                const date = new Date(transaction.created_at);
                const timeString = date.toLocaleTimeString('en-US', { 
                    hour: '2-digit', 
                    minute: '2-digit',
                    hour12: true 
                });
                const dateString = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                details.innerHTML = 
                    '<div class="transaction-details">' +
                        '<div class="detail-group">' +
                            '<div class="detail-label">Sale Number:</div>' +
                            '<div class="detail-value">' + transaction.sale_number + '</div>' +
                        '</div>' +
                        '<div class="detail-group">' +
                            '<div class="detail-label">Customer:</div>' +
                            '<div class="detail-value">' + (transaction.customer_name || 'Walk-in Customer') + '</div>' +
                        '</div>' +
                        '<div class="detail-group">' +
                            '<div class="detail-label">Date:</div>' +
                            '<div class="detail-value">' + dateString + '</div>' +
                        '</div>' +
                        '<div class="detail-group">' +
                            '<div class="detail-label">Time:</div>' +
                            '<div class="detail-value">' + timeString + '</div>' +
                        '</div>' +
                        '<div class="detail-group">' +
                            '<div class="detail-label">Payment Method:</div>' +
                            '<div class="detail-value">' + transaction.payment_method + '</div>' +
                        '</div>' +
                        '<div class="detail-group">' +
                            '<div class="detail-label">Payment Status:</div>' +
                            '<div class="detail-value">' + transaction.payment_status + '</div>' +
                        '</div>' +
                        '<div class="detail-group">' +
                            '<div class="detail-label">Subtotal:</div>' +
                            '<div class="detail-value">' + formatCurrency(transaction.subtotal) + '</div>' +
                        '</div>' +
                        '<div class="detail-group">' +
                            '<div class="detail-label">Tax (12%):</div>' +
                            '<div class="detail-value">' + formatCurrency(transaction.tax_amount) + '</div>' +
                        '</div>' +
                        '<div class="detail-group">' +
                            '<div class="detail-label">Total Amount:</div>' +
                            '<div class="detail-value">' + formatCurrency(transaction.total_amount) + '</div>' +
                        '</div>';
                
                // Add products list if available
                if (transaction.items && transaction.items.length > 0) {
                    details.innerHTML += '<div class="products-list">' +
                        '<div class="products-header">Products:</div>';
                    
                    transaction.items.forEach(item => {
                        details.innerHTML += 
                            '<div class="product-item">' +
                                '<div class="product-name">' + item.product_name + ' x' + item.quantity + '</div>' +
                                '<div class="product-price">' + formatCurrency(item.total_amount) + '</div>' +
                            '</div>';
                    });
                    
                    details.innerHTML += '</div>';
                }
                
                details.innerHTML += '</div>';
                
                // Show modal footer with action buttons
                const modalFooter = document.getElementById('modalFooter');
                if (modalFooter) {
                    modalFooter.style.display = 'block';
                }
                
                // Store transaction ID for print function
                modal.setAttribute('data-transaction-id', transactionId);
                
                modal.style.display = 'block';
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to load transaction details.',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error loading transaction details:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load transaction details.',
                confirmButtonText: 'OK'
            });
        });
}
            


// Delete transaction
function deleteTransaction(transactionId) {
    Swal.fire({
        title: 'Delete Transaction',
        text: 'Are you sure you want to delete this transaction? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we delete the transaction.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Send delete request to server
            fetch('<?= base_url('admin/pos/delete-sale/') ?>' + transactionId, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove from local array immediately
                    transactionHistory = transactionHistory.filter(t => t.id !== transactionId);
                    
                    // Update table immediately
                    updateTransactionsTable();
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Transaction has been deleted successfully.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to delete transaction.',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error deleting transaction:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to delete transaction.',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
}

// Print transaction receipt
function printTransactionReceipt() {
    const modal = document.getElementById('transactionModal');
    const transactionId = modal.getAttribute('data-transaction-id');
    
    if (!transactionId) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Transaction ID not found.',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    // Open print window with receipt
    const printWindow = window.open('<?= base_url('admin/pos/receipt/') ?>' + transactionId, '_blank');
    
    if (printWindow) {
        printWindow.onload = function() {
            printWindow.print();
        };
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please allow pop-ups to print receipts.',
            confirmButtonText: 'OK'
        });
    }
}

// Close modal
function closeModal() {
    const modal = document.getElementById('transactionModal');
    const modalFooter = document.getElementById('modalFooter');
    
    modal.style.display = 'none';
    if (modalFooter) {
        modalFooter.style.display = 'none';
    }
}

// Start new sale
function startNewSale() {
    selectedProducts = [];
    updateProductList();
    if (searchInput) {
        searchInput.value = '';
        searchInput.focus();
    }
    // Clear customer name input
    const customerNameInput = document.getElementById('customerName');
    if (customerNameInput) {
        customerNameInput.value = '';
    }
    hideSuggestions();
    
    // Hide checkout section
    const checkoutSection = document.getElementById('checkoutSection');
    if (checkoutSection) {
        checkoutSection.style.display = 'none';
    }
    
    // Show notification for new sale
    Swal.fire({
        icon: 'info',
        title: 'New Sale Started',
        text: 'Ready to process a new transaction!',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        background: '#6c757d',
        color: '#fff'
    });
}

// Close day function
function closeDay() {
    Swal.fire({
        title: 'Close Day',
        html: `
            <div style="text-align: left; margin-bottom: 20px;">
                <p><strong>Are you sure you want to close the day?</strong></p>
                <p>This will:</p>
                <ul style="text-align: left; margin-left: 20px;">
                    <li>Mark today's sales as processed</li>
                    <li>Lock today's transactions</li>
                    <li>Prepare for the next business day</li>
                </ul>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Close Day',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Closing Day...',
                text: 'Please wait while we process the closing.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Send close day request
            fetch('<?= base_url('admin/pos/close-day') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Day Closed Successfully!',
                        html: `
                            <div style="text-align: left;">
                                <p><strong>Sales Summary:</strong></p>
                                <p>📊 Total Sales: ${formatCurrency(data.sales_summary.total_sales || 0)}</p>
                                <p>📋 Total Transactions: ${data.sales_summary.total_transactions || 0}</p>
                                <p>💰 Cash Sales: ${formatCurrency(data.sales_summary.cash_sales || 0)}</p>
                                <p>💳 Card Sales: ${formatCurrency(data.sales_summary.card_sales || 0)}</p>
                                <p>🏦 Bank Transfer: ${formatCurrency(data.sales_summary.bank_transfer_sales || 0)}</p>
                                <p>🌐 Online Sales: ${formatCurrency(data.sales_summary.online_sales || 0)}</p>
                                <p>✅ Processed Sales: ${data.processed_sales || 0}</p>
                            </div>
                        `,
                        confirmButtonText: 'OK'
                    });
                    
                    // Hide close day button
                    const closeDayBtn = document.getElementById('closeDayBtn');
                    if (closeDayBtn) {
                        closeDayBtn.style.display = 'none';
                    }
                    
                    // Refresh sales summary
                    updateSalesSummary();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to close day.',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error closing day:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to close day. Please try again.',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
}


</script>
<?= $this->endSection() ?>
