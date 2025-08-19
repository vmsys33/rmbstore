<?php

namespace App\Controllers;

use App\Models\DailyClosingModel;
use App\Models\SaleModel;
use App\Models\UserModel;
use App\Helpers\CurrencyHelper;

class SalesSummaryController extends BaseController
{
    protected $dailyClosingModel;
    protected $saleModel;
    protected $userModel;

    public function __construct()
    {
        $this->dailyClosingModel = new DailyClosingModel();
        $this->saleModel = new SaleModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Sales Summary',
            'subTitle' => 'Daily Sales Reports & Analytics',
            'currencySymbol' => CurrencyHelper::getCurrencySymbol(),
        ];

        return view('sales_summary/index', $data);
    }

    /**
     * Get sales summary data for AJAX requests
     */
    public function getData()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');
        $limit = $this->request->getGet('limit') ?? 10;
        $showAll = $this->request->getGet('show_all') ?? false;
        
        // Get currency information
        $currencySymbol = CurrencyHelper::getCurrencySymbol();

        try {
            if ($showAll) {
                // Get all records for the date range
                $closings = $this->dailyClosingModel
                    ->select('daily_closings.*, CONCAT(users.first_name, " ", users.last_name) as closed_by_name')
                    ->join('users', 'users.id = daily_closings.closed_by', 'left')
                    ->where('closing_date >=', $startDate)
                    ->where('closing_date <=', $endDate)
                    ->orderBy('closing_date', 'DESC')
                    ->findAll();
            } else {
                // Get top records for the date range
                $closings = $this->dailyClosingModel
                    ->select('daily_closings.*, CONCAT(users.first_name, " ", users.last_name) as closed_by_name')
                    ->join('users', 'users.id = daily_closings.closed_by', 'left')
                    ->where('closing_date >=', $startDate)
                    ->where('closing_date <=', $endDate)
                    ->orderBy('total_sales', 'DESC')
                    ->limit($limit)
                    ->findAll();
            }

            // Format the data
            $formattedClosings = [];
            foreach ($closings as $closing) {
                $formattedClosings[] = [
                    'id' => $closing['id'],
                    'closing_date' => date('M d, Y', strtotime($closing['closing_date'])),
                    'closing_date_raw' => $closing['closing_date'], // Keep raw date for API calls
                    'opening_cash' => number_format($closing['opening_cash'], 2),
                    'closing_cash' => number_format($closing['closing_cash'], 2),
                    'cash_sales' => number_format($closing['cash_sales'], 2),
                    'card_sales' => number_format($closing['card_sales'], 2),
                    'bank_transfer_sales' => number_format($closing['bank_transfer_sales'], 2),
                    'online_sales' => number_format($closing['online_sales'], 2),
                    'total_sales' => number_format($closing['total_sales'], 2),
                    'total_transactions' => $closing['total_transactions'],
                    'total_items_sold' => $closing['total_items_sold'],
                    'total_discounts' => number_format($closing['total_discounts'], 2),
                    'total_tax' => number_format($closing['total_tax'], 2),
                    'cash_shortage' => number_format($closing['cash_shortage'], 2),
                    'closed_by' => $closing['closed_by_name'] ?? 'Unknown',
                    'closed_at' => date('M d, Y H:i', strtotime($closing['closed_at'])),
                    'notes' => $closing['notes'] ?? '-'
                ];
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $formattedClosings,
                'total' => count($formattedClosings),
                'date_range' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate
                ]
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error getting sales summary data: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error retrieving data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get sales details for a specific date
     */
    public function getSalesDetails($date)
    {
        // Get currency information
        $currencySymbol = CurrencyHelper::getCurrencySymbol();
        
        try {
            $sales = $this->saleModel
                ->select('id, sale_number, customer_name, total_amount, payment_method, created_at, discount_amount, tax_amount')
                ->where('DATE(created_at)', $date)
                ->orderBy('created_at', 'DESC')
                ->findAll();

            // Format sales data
            $formattedSales = [];
            foreach ($sales as $sale) {
                $formattedSales[] = [
                    'id' => $sale['id'],
                    'sale_number' => $sale['sale_number'],
                    'customer_name' => $sale['customer_name'] ?: 'Walk-in Customer',
                    'total_amount' => number_format($sale['total_amount'], 2),
                    'payment_method' => ucfirst(str_replace('_', ' ', $sale['payment_method'])),
                    'created_at' => date('M d, Y H:i', strtotime($sale['created_at'])),
                    'discount_amount' => number_format($sale['discount_amount'], 2),
                    'tax_amount' => number_format($sale['tax_amount'], 2)
                ];
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $formattedSales,
                'date' => $date,
                'total_sales' => count($formattedSales)
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error getting sales details: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error retrieving sales details: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get summary statistics
     */
    public function getStats()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');
        
        // Get currency information
        $currencySymbol = CurrencyHelper::getCurrencySymbol();

        try {
            $stats = $this->dailyClosingModel
                ->select('
                    COUNT(*) as total_days,
                    SUM(total_sales) as total_sales,
                    SUM(total_transactions) as total_transactions,
                    SUM(total_items_sold) as total_items_sold,
                    SUM(total_discounts) as total_discounts,
                    SUM(total_tax) as total_tax,
                    SUM(cash_shortage) as total_cash_shortage,
                    AVG(total_sales) as avg_daily_sales,
                    AVG(total_transactions) as avg_daily_transactions,
                    MAX(total_sales) as best_day_sales,
                    MIN(total_sales) as worst_day_sales
                ')
                ->where('closing_date >=', $startDate)
                ->where('closing_date <=', $endDate)
                ->get()
                ->getRowArray();

            if ($stats) {
                $formattedStats = [
                    'total_days' => $stats['total_days'] ?? 0,
                    'total_sales' => number_format($stats['total_sales'] ?? 0, 2),
                    'total_transactions' => $stats['total_transactions'] ?? 0,
                    'total_items_sold' => $stats['total_items_sold'] ?? 0,
                    'total_discounts' => number_format($stats['total_discounts'] ?? 0, 2),
                    'total_tax' => number_format($stats['total_tax'] ?? 0, 2),
                    'total_cash_shortage' => number_format($stats['total_cash_shortage'] ?? 0, 2),
                    'avg_daily_sales' => number_format($stats['avg_daily_sales'] ?? 0, 2),
                    'avg_daily_transactions' => number_format($stats['avg_daily_transactions'] ?? 0, 1),
                    'best_day_sales' => number_format($stats['best_day_sales'] ?? 0, 2),
                    'worst_day_sales' => number_format($stats['worst_day_sales'] ?? 0, 2)
                ];
            } else {
                $formattedStats = [
                    'total_days' => 0,
                    'total_sales' => '0.00',
                    'total_transactions' => 0,
                    'total_items_sold' => 0,
                    'total_discounts' => '0.00',
                    'total_tax' => '0.00',
                    'total_cash_shortage' => '0.00',
                    'avg_daily_sales' => '0.00',
                    'avg_daily_transactions' => '0.0',
                    'best_day_sales' => '0.00',
                    'worst_day_sales' => '0.00'
                ];
            }

            return $this->response->setJSON([
                'success' => true,
                'stats' => $formattedStats,
                'date_range' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate
                ]
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error getting sales stats: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error retrieving statistics: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Export sales summary to CSV
     */
    public function exportCsv()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');
        
        // Get currency information
        $currencySymbol = CurrencyHelper::getCurrencySymbol();

        try {
            $closings = $this->dailyClosingModel
                ->select('daily_closings.*, CONCAT(users.first_name, " ", users.last_name) as closed_by_name')
                ->join('users', 'users.id = daily_closings.closed_by', 'left')
                ->where('closing_date >=', $startDate)
                ->where('closing_date <=', $endDate)
                ->orderBy('closing_date', 'DESC')
                ->findAll();

            // Set headers for CSV download
            $this->response->setHeader('Content-Type', 'text/csv');
            $this->response->setHeader('Content-Disposition', 'attachment; filename="sales_summary_' . $startDate . '_to_' . $endDate . '.csv"');

            // Create CSV content with currency
            $csv = "Date,Opening Cash ({$currencySymbol}),Closing Cash ({$currencySymbol}),Cash Sales ({$currencySymbol}),Card Sales ({$currencySymbol}),Bank Transfer Sales ({$currencySymbol}),Online Sales ({$currencySymbol}),Total Sales ({$currencySymbol}),Total Transactions,Total Items Sold,Total Discounts ({$currencySymbol}),Total Tax ({$currencySymbol}),Cash Shortage ({$currencySymbol}),Closed By,Closed At,Notes\n";

            foreach ($closings as $closing) {
                $csv .= sprintf(
                    '"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s"' . "\n",
                    $closing['closing_date'],
                    $closing['opening_cash'],
                    $closing['closing_cash'],
                    $closing['cash_sales'],
                    $closing['card_sales'],
                    $closing['bank_transfer_sales'],
                    $closing['online_sales'],
                    $closing['total_sales'],
                    $closing['total_transactions'],
                    $closing['total_items_sold'],
                    $closing['total_discounts'],
                    $closing['total_tax'],
                    $closing['cash_shortage'],
                    $closing['closed_by_name'] ?? 'Unknown',
                    $closing['closed_at'],
                    str_replace('"', '""', $closing['notes'] ?? '')
                );
            }

            return $this->response->setBody($csv);

        } catch (\Exception $e) {
            log_message('error', 'Error exporting CSV: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error exporting data: ' . $e->getMessage());
        }
    }
}
