<?php

namespace App\Controllers;

use App\Models\StockOnHandModel;
use App\Models\ProductModel;

class StockOnHandController extends BaseController
{
    protected $stockOnHandModel;
    protected $productModel;

    public function __construct()
    {
        $this->stockOnHandModel = new StockOnHandModel();
        $this->productModel = new ProductModel();
    }

    /**
     * Display stock on hand summary table
     */
    public function index()
    {
        $data = [
            'title' => 'Stock on Hand Summary',
            'stockSummary' => $this->stockOnHandModel->getStockSummary(),
            'lowStockProducts' => $this->stockOnHandModel->getLowStockProducts(),
            'outOfStockProducts' => $this->stockOnHandModel->getOutOfStockProducts()
        ];

        return view('admin/stock_on_hand/index', $data);
    }

    /**
     * Add stock to a product
     */
    public function addStock()
    {
        if ($this->request->getMethod() === 'post') {
            $productId = $this->request->getPost('product_id');
            $quantity = (int) $this->request->getPost('quantity');
            $notes = $this->request->getPost('notes');

            if ($quantity <= 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Quantity must be greater than 0'
                ]);
            }

            try {
                $stockId = $this->stockOnHandModel->addOrUpdateStock($productId, $quantity, $notes);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Stock updated successfully',
                    'stock_id' => $stockId
                ]);
            } catch (\Exception $e) {
                log_message('error', 'Error adding stock: ' . $e->getMessage());
                
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error updating stock: ' . $e->getMessage()
                ]);
            }
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
    }

    /**
     * Get stock summary for AJAX requests
     */
    public function getStockSummary()
    {
        try {
            $stockSummary = $this->stockOnHandModel->getStockSummary();
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $stockSummary
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error getting stock summary: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error retrieving stock summary'
            ]);
        }
    }

    /**
     * Get stock details for a specific product
     */
    public function getProductStock($productId)
    {
        try {
            $stockDetails = $this->stockOnHandModel->getProductStockSummary($productId);
            
            if (!$stockDetails) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Product not found'
                ]);
            }
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $stockDetails
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error getting product stock: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error retrieving product stock'
            ]);
        }
    }

    /**
     * Export stock summary to CSV
     */
    public function exportCSV()
    {
        try {
            $stockSummary = $this->stockOnHandModel->getStockSummary();
            
            $filename = 'stock_on_hand_' . date('Y-m-d_H-i-s') . '.csv';
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            $output = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($output, [
                'Product ID',
                'Product Name',
                'Category',
                'Price',
                'Stock on Hand',
                'Total Sold',
                'Remaining Quantity',
                'Stock Status',
                'Availability Status',
                'Last Updated'
            ]);
            
            // CSV data
            foreach ($stockSummary as $row) {
                fputcsv($output, [
                    $row['id'],
                    $row['product_name'],
                    $row['category'],
                    $row['price'],
                    $row['stock_on_hand'],
                    $row['total_sold'],
                    $row['remaining_quantity'],
                    $row['stock_status'],
                    $row['availability_status'],
                    $row['last_stock_update']
                ]);
            }
            
            fclose($output);
            exit;
            
        } catch (\Exception $e) {
            log_message('error', 'Error exporting CSV: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Error exporting CSV file');
        }
    }
}
