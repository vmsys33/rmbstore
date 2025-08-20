<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SaleModel;
use App\Models\SaleItemModel;
use App\Models\InventoryModel;
use App\Models\InventoryTransactionModel;
use App\Models\CategoryModel;
use App\Models\DailyClosingModel;
use App\Helpers\CurrencyHelper;
use App\Services\RealtimeService;

class PosController extends BaseController
{
    protected $productModel;
    protected $saleModel;
    protected $saleItemModel;
    protected $inventoryModel;
    protected $inventoryTransactionModel;
    protected $categoryModel;
    protected $dailyClosingModel;
    protected $realtimeService;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->saleModel = new SaleModel();
        $this->saleItemModel = new SaleItemModel();
        $this->inventoryModel = new InventoryModel();
        $this->inventoryTransactionModel = new InventoryTransactionModel();
        $this->categoryModel = new CategoryModel();
        $this->dailyClosingModel = new DailyClosingModel();
        $this->realtimeService = new RealtimeService();
    }

    /**
     * Display POS interface
     */
    public function index()
    {
        $data = [
            'title' => 'Point of Sale',
            'subTitle' => 'Process Sales Transactions',
            'categories' => $this->categoryModel->select('id, name as category_name')->findAll(),
            'products' => $this->productModel->getProductsWithInventory(),
            'todaySales' => $this->saleModel->getTodaySalesSummary(),
            'recentSales' => $this->saleModel->getRecentSales(10)
        ];

        return view('pos/pos_interface', $data);
    }

    /**
     * Get products for POS (AJAX)
     */
    public function getProducts()
    {
        $categoryId = $this->request->getGet('category_id');
        $search = $this->request->getGet('search');

        $products = $this->productModel->getProductsForPos($categoryId, $search);

        return $this->response->setJSON([
            'success' => true,
            'products' => $products
        ]);
    }

    /**
     * Get product details (AJAX)
     */
    public function getProductDetails()
    {
        $productId = $this->request->getGet('product_id');
        
        $product = $this->productModel->find($productId);
        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found'
            ]);
        }

        // Get available quantity
        $availableQuantity = $this->inventoryModel->getTotalAvailableQuantity($productId);
        $product['available_quantity'] = $availableQuantity;

        return $this->response->setJSON([
            'success' => true,
            'product' => $product
        ]);
    }

    /**
     * Process sale transaction
     */
    public function processSale()
    {
        // Check if it's a JSON request
        $contentType = $this->request->getHeaderLine('Content-Type');
        if (strpos($contentType, 'application/json') !== false) {
            $saleData = json_decode($this->request->getBody(), true);
        } else {
            $saleData = $this->request->getPost();
        }
        
        // Validate sale data
        $validation = \Config\Services::validation();
        $rules = [
            'customer_name' => 'permit_empty|max_length[255]',
            'payment_method' => 'required|in_list[cash,card,bank_transfer,online]',
            'items' => 'required'
        ];

        if (!$validation->setRules($rules)->run($saleData)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validation->getErrors(),
                'received_data' => $saleData,
                'validation_rules' => $rules
            ]);
        }

        // Items are already in array format from JSON
        $items = $saleData['items'];
        if (empty($items)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No items in sale'
            ]);
        }

        // Calculate totals
        $subtotal = 0;
        $taxAmount = 0;
        $discountAmount = 0;
        $totalAmount = 0;

        foreach ($items as $item) {
            $subtotal += $item['subtotal'];
            $discountAmount += $item['discount_amount'];
        }

        // Apply tax (you can make this configurable)
        $taxRate = 0.12; // 12% tax
        $taxAmount = $subtotal * $taxRate;
        $totalAmount = $subtotal + $taxAmount - $discountAmount;

        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Debug session
            $adminId = session()->get('admin_id');
            log_message('debug', "Admin ID from session: " . ($adminId ?? 'NULL'));
            
            // Generate sale number
            $date = date('Ymd');
            $lastSale = $this->saleModel->where('sale_number LIKE', $date . '%')
                                       ->orderBy('sale_number', 'DESC')
                                       ->first();
            
            if ($lastSale) {
                $lastNumber = intval(substr($lastSale['sale_number'], -4));
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            
            $saleNumber = $date . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            
            // Create sale record
            $saleRecord = [
                'sale_number' => $saleNumber,
                'customer_name' => $saleData['customer_name'] ?? null,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'payment_method' => $saleData['payment_method'],
                'payment_status' => 'paid',
                'sale_status' => 'completed',
                'notes' => $saleData['notes'] ?? null,
                'sold_by' => $adminId ?? 1 // Default to admin ID 1 if session is null
            ];

            $saleId = $this->saleModel->insert($saleRecord);
            log_message('debug', "Sale inserted with ID: " . ($saleId ?: 'FAILED'));
            
            if (!$saleId) {
                throw new \Exception("Failed to insert sale record. Error: " . json_encode($this->saleModel->errors()));
            }
            
            log_message('debug', "Sale number used: " . $saleNumber);

            // Process each item
            foreach ($items as $item) {
                $productId = $item['product_id'];
                $quantity = $item['quantity'];

                // Check if enough inventory is available
                $availableQuantity = $this->inventoryModel->getTotalAvailableQuantity($productId);
                log_message('debug', "Product ID: {$productId}, Available Quantity: {$availableQuantity}, Requested: {$quantity}");
                
                if ($availableQuantity < $quantity) {
                    throw new \Exception("Insufficient inventory for product ID: {$productId}. Available: {$availableQuantity}, Requested: {$quantity}");
                }

                // Reserve quantity
                $reservation = $this->inventoryModel->reserveQuantity($productId, $quantity);
                log_message('debug', "Reservation result for product {$productId}: " . json_encode($reservation));
                
                if (!$reservation['success']) {
                    throw new \Exception("Failed to reserve inventory for product ID: {$productId}. Error: " . ($reservation['message'] ?? 'Unknown error'));
                }

                // Deduct quantity from inventory
                $deduction = $this->inventoryModel->deductQuantity($productId, $quantity);
                log_message('debug', "Deduction result for product {$productId}: " . ($deduction ? 'success' : 'failed'));
                
                if (!$deduction) {
                    throw new \Exception("Failed to deduct inventory for product ID: {$productId}");
                }

                // Create sale item record
                $saleItemRecord = [
                    'sale_id' => $saleId,
                    'product_id' => $productId,
                    'product_name' => $item['product_name'],
                    'product_sku' => $item['product_sku'],
                    'quantity' => $quantity,
                    'unit_price' => $item['unit_price'],
                    'discount_percent' => $item['discount_percent'],
                    'discount_amount' => $item['discount_amount'],
                    'subtotal' => $item['subtotal'],
                    'total_amount' => $item['total_amount']
                ];

                $this->saleItemModel->insert($saleItemRecord);
            }

            // Record inventory transactions for the sale
            // Temporarily disabled to fix POS functionality
            // $this->inventoryTransactionModel->recordSaleTransaction(
            //     $saleId, 
            //     $saleNumber, 
            //     $items, 
            //     $adminId ?? 1
            // );

            $db->transComplete();
            log_message('debug', "Transaction completed. Status: " . ($db->transStatus() ? 'SUCCESS' : 'FAILED'));

            if ($db->transStatus() === false) {
                log_message('error', "Transaction failed. Last error: " . json_encode($db->error()));
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Transaction failed',
                    'error_details' => [
                        'last_error' => $db->error(),
                        'last_query' => $db->getLastQuery()
                    ]
                ]);
            }

            // Construct sale data directly instead of calling getSaleWithItems
            $sale = [
                'id' => $saleId,
                'sale_number' => $saleNumber,
                'customer_name' => $saleData['customer_name'] ?? 'Walk-in Customer',
                'total_amount' => $totalAmount,
                'payment_method' => $saleData['payment_method'],
                'created_at' => date('Y-m-d H:i:s'),
                'items' => $items
            ];

            // Note: Real-time updates are handled via AJAX polling in the dashboard

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Sale processed successfully',
                'sale' => $sale
            ]);

        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage(),
                'error_details' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]
            ]);
        }
    }

    /**
     * Display sales history
     */
    public function salesHistory()
    {
        $page = $this->request->getGet('page') ?? 1;
        $filters = [
            'sale_number' => $this->request->getGet('sale_number'),
            'customer_name' => $this->request->getGet('customer_name'),
            'payment_status' => $this->request->getGet('payment_status'),
            'sale_status' => $this->request->getGet('sale_status'),
            'date_from' => $this->request->getGet('date_from'),
            'date_to' => $this->request->getGet('date_to')
        ];

        $result = $this->saleModel->getSalesWithPagination($page, 10, $filters);

        $data = [
            'title' => 'Sales History',
            'subTitle' => 'View All Sales Transactions',
            'sales' => $result['sales'],
            'pagination' => [
                'total' => $result['total'],
                'pages' => $result['pages'],
                'current_page' => $result['current_page']
            ],
            'filters' => $filters
        ];

        return view('pos/sales_history', $data);
    }

    /**
     * View sale details
     */
    public function viewSale($saleId)
    {
        $sale = $this->saleModel->getSaleWithItems($saleId);
        
        if (!$sale) {
            session()->setFlashdata('error', 'Sale not found');
            return redirect()->to('/admin/pos/sales-history');
        }

        $data = [
            'title' => 'Sale Details',
            'subTitle' => 'View Sale Information',
            'sale' => $sale
        ];

        return view('pos/view_sale', $data);
    }

    /**
     * Print sale receipt
     */
    public function printReceipt($saleId)
    {
        $sale = $this->saleModel->getSaleWithItems($saleId);
        
        if (!$sale) {
            session()->setFlashdata('error', 'Sale not found');
            return redirect()->to('/admin/pos/sales-history');
        }

        $data = [
            'sale' => $sale
        ];

        return view('pos/receipt', $data);
    }

    /**
     * Get sales statistics (AJAX)
     */
    public function getSalesStats()
    {
        $period = $this->request->getGet('period') ?? 'today';
        $stats = $this->saleModel->getSalesStats($period);

        return $this->response->setJSON([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Get today's sales (AJAX)
     */
    public function getTodaySales()
    {
        $today = date('Y-m-d');
        $sales = $this->saleModel->getSalesByDate($today);

        return $this->response->setJSON([
            'success' => true,
            'sales' => $sales
        ]);
    }

    /**
     * Get today's sales statistics (AJAX)
     */
    public function getTodayStats()
    {
        $stats = $this->saleModel->getTodaySalesSummary();

        return $this->response->setJSON([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Get recent sales for POS display (AJAX)
     */
    public function getRecentSales()
    {
        $limit = $this->request->getGet('limit') ?? 10;
        $sales = $this->saleModel->getRecentSales($limit);

        return $this->response->setJSON([
            'success' => true,
            'sales' => $sales
        ]);
    }

    /**
     * Get sale details for preview (AJAX)
     */
    public function getSaleDetails($saleId)
    {
        $sale = $this->saleModel->getSaleWithItems($saleId);
        
        if (!$sale) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Sale not found'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'sale' => $sale
        ]);
    }

    /**
     * Delete sale transaction (AJAX)
     */
    public function deleteSale($saleId)
    {
        // Check if sale exists
        $sale = $this->saleModel->find($saleId);
        if (!$sale) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Sale not found'
            ]);
        }

        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Delete sale items first
            $this->saleItemModel->where('sale_id', $saleId)->delete();
            
            // Delete the sale
            $this->saleModel->delete($saleId);
            
            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to delete sale'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Sale deleted successfully'
            ]);

        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error deleting sale: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get inventory status
     */
    public function inventoryStatus()
    {
        $data = [
            'title' => 'Inventory Status',
            'subTitle' => 'Monitor Product Inventory',
            'lowStock' => $this->inventoryModel->getLowStockInventory(),
            'expiring' => $this->inventoryModel->getExpiringInventory()
        ];

        return view('pos/inventory_status', $data);
    }

    /**
     * Get inventory transactions
     */
    public function getInventoryTransactions()
    {
        $transactions = $this->inventoryTransactionModel
            ->orderBy('created_at', 'DESC')
            ->limit(100)
            ->findAll();
        
        return $this->response->setJSON([
            'success' => true,
            'transactions' => $transactions
        ]);
    }

    /**
     * Get inventory movement report
     */
    public function getInventoryReport()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');
        $productId = $this->request->getGet('product_id');

        $report = $this->inventoryTransactionModel->getInventoryMovementReport(
            $startDate, 
            $endDate, 
            $productId
        );

        return $this->response->setJSON([
            'success' => true,
            'report' => $report,
            'date_range' => [
                'start_date' => $startDate,
                'end_date' => $endDate
            ]
        ]);
    }

    /**
     * Close day - Generate daily closing report
     */
    public function closeDay()
    {
        // Check if it's a JSON request
        $contentType = $this->request->getHeaderLine('Content-Type');
        if (strpos($contentType, 'application/json') !== false) {
            $data = json_decode($this->request->getBody(), true);
        } else {
            $data = $this->request->getPost();
        }

        // No validation needed - just mark sales as processed
        // Check if today is already closed
        if ($this->dailyClosingModel->isTodayClosed()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Today has already been closed'
            ]);
        }

        try {
            // Simply mark sales as processed for today
            $result = $this->dailyClosingModel->markSalesAsProcessed(date('Y-m-d'));

            if ($result['success']) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Day closed successfully - Sales marked as processed',
                    'processed_sales' => $result['processed_sales'],
                    'sales_summary' => $result['sales_summary']
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to close day'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error closing day: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error closing day: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Close a specific date (for testing)
     */
    public function closeSpecificDate()
    {
        // Check if it's a JSON request
        $contentType = $this->request->getHeaderLine('Content-Type');
        if (strpos($contentType, 'application/json') !== false) {
            $data = json_decode($this->request->getBody(), true);
        } else {
            $data = $this->request->getPost();
        }

        // Validate input
        if (!isset($data['opening_cash']) || $data['opening_cash'] < 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid opening cash amount'
            ]);
        }
        
        if (!isset($data['closing_date'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Closing date is required'
            ]);
        }

        // Check if the date is already closed
        $existingClosing = $this->dailyClosingModel->where('closing_date', $data['closing_date'])->first();
        if ($existingClosing) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Date ' . $data['closing_date'] . ' has already been closed'
            ]);
        }

        try {
            // Generate closing data for specific date
            $closingData = $this->dailyClosingModel->generateClosingData(
                $data['closing_date'],
                $data['opening_cash']
            );

            // Add closed_by user ID
            $closingData['closed_by'] = session()->get('admin_id') ?? 1;

            // Debug: Log the closing data
            log_message('debug', 'Closing data for ' . $data['closing_date'] . ': ' . json_encode($closingData));

            // Insert closing record
            $closingId = $this->dailyClosingModel->insert($closingData);

            if ($closingId) {
                $closing = $this->dailyClosingModel->find($closingId);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Date ' . $data['closing_date'] . ' closed successfully',
                    'closing' => $closing
                ]);
            } else {
                // Get validation errors if any
                $errors = $this->dailyClosingModel->errors();
                log_message('error', 'Failed to insert closing record. Errors: ' . json_encode($errors));
                
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create closing record. Errors: ' . json_encode($errors)
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error closing date: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error closing date: ' . $e->getMessage()
            ]);
        }
    }
    

}
