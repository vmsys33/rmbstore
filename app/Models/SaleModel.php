<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\SaleItemModel;
use App\Models\UserModel;

class SaleModel extends Model
{
    protected $table            = 'sales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'sale_number', 'customer_name', 'customer_email', 'customer_phone',
        'subtotal', 'tax_amount', 'discount_amount', 'total_amount',
        'payment_method', 'payment_status', 'sale_status', 'notes', 'sold_by'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'sale_number' => 'required|is_unique[sales.sale_number,id,{id}]',
        'total_amount' => 'required|numeric',
        'payment_method' => 'required|in_list[cash,card,bank_transfer,online]',
        'payment_status' => 'required|in_list[pending,paid,failed,refunded]',
        'sale_status' => 'required|in_list[completed,cancelled,refunded,cleared]',
        'sold_by' => 'required|integer'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateSaleNumber'];
    protected $beforeUpdate   = [];

    /**
     * Generate unique sale number
     */
    protected function generateSaleNumber(array $data)
    {
        if (!isset($data['data']['sale_number']) || empty($data['data']['sale_number'])) {
            $date = date('Ymd');
            $lastSale = $this->where('sale_number LIKE', $date . '%')
                            ->orderBy('sale_number', 'DESC')
                            ->first();
            
            if ($lastSale) {
                $lastNumber = intval(substr($lastSale['sale_number'], -4));
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            
            $data['data']['sale_number'] = $date . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        }
        
        return $data;
    }

    /**
     * Get sales with items and customer details
     */
    public function getSalesWithDetails($limit = null, $offset = 0, $filters = [])
    {
        $builder = $this->db->table('sales s')
                           ->select('s.*, u.name as seller_name')
                           ->join('users u', 'u.id = s.sold_by', 'left');

        // Apply filters
        if (!empty($filters['date_from'])) {
            $builder->where('DATE(s.created_at) >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $builder->where('DATE(s.created_at) <=', $filters['date_to']);
        }
        if (!empty($filters['payment_method'])) {
            $builder->where('s.payment_method', $filters['payment_method']);
        }
        if (!empty($filters['customer_name'])) {
            $builder->like('s.customer_name', $filters['customer_name']);
        }

        $builder->orderBy('s.created_at', 'DESC');

        if ($limit) {
            $builder->limit($limit, $offset);
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Get sale with all items
     */
    public function getSaleWithItems($saleId)
    {
        $sale = $this->find($saleId);
        if (!$sale) {
            return null;
        }

        // Get sale items
        $saleItemsModel = new SaleItemModel();
        $sale['items'] = $saleItemsModel->where('sale_id', $saleId)->findAll();

        // Simplified seller info - just return basic info without UserModel dependency
        $sale['seller'] = [
            'id' => $sale['sold_by'],
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin'
        ];

        return $sale;
    }

    /**
     * Get today's sales summary
     */
    public function getTodaySalesSummary()
    {
        return $this->getSalesSummaryForDate(date('Y-m-d'));
    }
    
    /**
     * Get sales summary for a specific date
     */
    public function getSalesSummaryForDate($date)
    {
        // Check if this date has been closed
        $dailyClosingModel = new \App\Models\DailyClosingModel();
        $isDateClosed = $dailyClosingModel->where('closing_date', $date)->countAllResults() > 0;
        
        // If date is closed, return zero values
        if ($isDateClosed) {
            return [
                'total_transactions' => 0,
                'total_sales' => 0,
                'cash_sales' => 0,
                'card_sales' => 0,
                'bank_transfer_sales' => 0,
                'online_sales' => 0,
                'total_discounts' => 0,
                'total_tax' => 0
            ];
        }
        
        $result = $this->select('
            COUNT(*) as total_transactions,
            SUM(total_amount) as total_sales,
            SUM(CASE WHEN payment_method = "cash" THEN total_amount ELSE 0 END) as cash_sales,
            SUM(CASE WHEN payment_method = "card" THEN total_amount ELSE 0 END) as card_sales,
            SUM(CASE WHEN payment_method = "bank_transfer" THEN total_amount ELSE 0 END) as bank_transfer_sales,
            SUM(CASE WHEN payment_method = "online" THEN total_amount ELSE 0 END) as online_sales,
            SUM(discount_amount) as total_discounts,
            SUM(tax_amount) as total_tax
        ')
        ->where('DATE(created_at)', $date)
        ->get()
        ->getRowArray();

        return $result ?: [
            'total_transactions' => 0,
            'total_sales' => 0,
            'cash_sales' => 0,
            'card_sales' => 0,
            'bank_transfer_sales' => 0,
            'online_sales' => 0,
            'total_discounts' => 0,
            'total_tax' => 0
        ];
    }

    /**
     * Get recent sales for POS display
     */
    public function getRecentSales($limit = 10)
    {
        // Get all closed dates
        $dailyClosingModel = new \App\Models\DailyClosingModel();
        $closedDates = $dailyClosingModel->select('closing_date')->findAll();
        $closedDateList = array_column($closedDates, 'closing_date');
        
        $builder = $this->select('id, sale_number, customer_name, total_amount, payment_method, created_at')
                       ->orderBy('created_at', 'DESC');
        
        // Exclude sales from closed dates
        if (!empty($closedDateList)) {
            $builder->whereNotIn('DATE(created_at)', $closedDateList);
        }
        
        return $builder->limit($limit)->findAll();
    }
    
    /**
     * Get sales details for a specific date
     */
    public function getSalesByDate($date)
    {
        // Check if this date has been closed
        $dailyClosingModel = new \App\Models\DailyClosingModel();
        $isDateClosed = $dailyClosingModel->where('closing_date', $date)->countAllResults() > 0;
        
        // Return sales regardless of closing status
        // The frontend will handle showing the closed status
        return $this->select('id, sale_number, customer_name, total_amount, payment_method, created_at, discount_amount, tax_amount')
                   ->where('DATE(created_at)', $date)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }
    
}
