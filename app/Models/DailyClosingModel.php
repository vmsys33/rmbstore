<?php

namespace App\Models;

use CodeIgniter\Model;

class DailyClosingModel extends Model
{
    protected $table            = 'daily_closings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'closing_date', 'opening_cash', 'closing_cash', 'cash_sales',
        'card_sales', 'bank_transfer_sales', 'online_sales', 'total_sales',
        'total_transactions', 'total_items_sold', 'total_discounts',
        'total_tax', 'cash_shortage', 'notes', 'closed_by'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'closing_date' => 'required|valid_date|is_unique[daily_closings.closing_date,id,{id}]',
        'opening_cash' => 'required|numeric|greater_than_equal_to[0]',
        'closing_cash' => 'required|numeric|greater_than_equal_to[0]',
        'total_sales' => 'required|numeric|greater_than_equal_to[0]',
        'total_transactions' => 'required|integer|greater_than_equal_to[0]',
        'closed_by' => 'required|integer'
    ];
    
    protected $validationMessages   = [];
    protected $skipValidation       = true; // Skip validation for now to debug
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['setClosedAt'];
    protected $beforeUpdate   = ['setClosedAt'];

    /**
     * Set closed_at timestamp
     */
    protected function setClosedAt(array $data)
    {
        $data['data']['closed_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    /**
     * Get today's closing data
     */
    public function getTodayClosing()
    {
        $today = date('Y-m-d');
        return $this->where('closing_date', $today)->first();
    }

    /**
     * Check if today is already closed
     */
    public function isTodayClosed()
    {
        $today = date('Y-m-d');
        return $this->where('closing_date', $today)->countAllResults() > 0;
    }

    /**
     * Generate closing data from sales
     */
    public function generateClosingData($closingDate = null, $openingCash = 0)
    {
        if (!$closingDate) {
            $closingDate = date('Y-m-d');
        }

        // Get sales data for the date
        $saleModel = new SaleModel();
        $salesData = $saleModel->getSalesSummaryForDate($closingDate);
        
        // Debug: Log the sales data
        log_message('debug', 'Sales data for closing: ' . json_encode($salesData));

        // Calculate cash shortage
        $expectedCash = $openingCash + ($salesData['cash_sales'] ?? 0);
        $cashShortage = 0; // This would be calculated based on actual cash count

        return [
            'closing_date' => $closingDate,
            'opening_cash' => $openingCash,
            'closing_cash' => $expectedCash, // This should be actual counted cash
            'cash_sales' => $salesData['cash_sales'] ?? 0,
            'card_sales' => $salesData['card_sales'] ?? 0,
            'bank_transfer_sales' => $salesData['bank_transfer_sales'] ?? 0,
            'online_sales' => $salesData['online_sales'] ?? 0,
            'total_sales' => $salesData['total_sales'] ?? 0,
            'total_transactions' => $salesData['total_transactions'] ?? 0,
            'total_items_sold' => $salesData['total_items_sold'] ?? 0,
            'total_discounts' => $salesData['total_discounts'] ?? 0,
            'total_tax' => $salesData['total_tax'] ?? 0,
            'cash_shortage' => $cashShortage,
            'closed_by' => session()->get('admin_id') ?? 1
        ];
    }

    /**
     * Get closing summary for a date range
     */
    public function getClosingSummary($dateFrom, $dateTo)
    {
        return $this->select('
            closing_date,
            opening_cash,
            closing_cash,
            total_sales,
            total_transactions,
            total_items_sold,
            total_discounts,
            total_tax,
            cash_shortage
        ')
        ->where('closing_date >=', $dateFrom)
        ->where('closing_date <=', $dateTo)
        ->orderBy('closing_date', 'DESC')
        ->findAll();
    }

    /**
     * Get monthly summary
     */
    public function getMonthlySummary($year, $month)
    {
        $dateFrom = sprintf('%04d-%02d-01', $year, $month);
        $dateTo = date('Y-m-t', strtotime($dateFrom));

        $result = $this->select('
            COUNT(*) as total_days,
            SUM(total_sales) as total_sales,
            SUM(total_transactions) as total_transactions,
            SUM(total_items_sold) as total_items_sold,
            SUM(total_discounts) as total_discounts,
            SUM(total_tax) as total_tax,
            SUM(cash_shortage) as total_cash_shortage,
            AVG(total_sales) as avg_daily_sales,
            AVG(total_transactions) as avg_daily_transactions
        ')
        ->where('closing_date >=', $dateFrom)
        ->where('closing_date <=', $dateTo)
        ->get()
        ->getRowArray();

        return $result ?: [
            'total_days' => 0,
            'total_sales' => 0,
            'total_transactions' => 0,
            'total_items_sold' => 0,
            'total_discounts' => 0,
            'total_tax' => 0,
            'total_cash_shortage' => 0,
            'avg_daily_sales' => 0,
            'avg_daily_transactions' => 0
        ];
    }
    
    /**
     * Get top 3 daily closings by total sales
     */
    public function getTopDailyClosings($limit = 3)
    {
        return $this->select('
            daily_closings.*,
            CONCAT(users.first_name, " ", users.last_name) as closed_by_name
        ')
        ->join('users', 'users.id = daily_closings.closed_by', 'left')
        ->orderBy('total_sales', 'DESC')
        ->limit($limit)
        ->findAll();
    }
}
