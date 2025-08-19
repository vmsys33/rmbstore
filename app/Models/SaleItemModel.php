<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleItemModel extends Model
{
    protected $table            = 'sale_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'sale_id', 'product_id', 'product_name', 'product_sku',
        'quantity', 'unit_price', 'discount_amount', 'subtotal'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'sale_id' => 'required|integer',
        'product_id' => 'required|integer',
        'product_name' => 'required|max_length[255]',
        'quantity' => 'required|integer|greater_than[0]',
        'unit_price' => 'required|numeric|greater_than[0]',
        'subtotal' => 'required|numeric|greater_than[0]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['calculateSubtotal'];
    protected $beforeUpdate   = ['calculateSubtotal'];

    /**
     * Calculate subtotal before insert/update
     */
    protected function calculateSubtotal(array $data)
    {
        if (isset($data['data']['quantity']) && isset($data['data']['unit_price'])) {
            $quantity = $data['data']['quantity'];
            $unitPrice = $data['data']['unit_price'];
            $discountAmount = $data['data']['discount_amount'] ?? 0;
            
            $data['data']['subtotal'] = ($quantity * $unitPrice) - $discountAmount;
        }
        
        return $data;
    }

    /**
     * Get items for a specific sale
     */
    public function getItemsBySaleId($saleId)
    {
        return $this->where('sale_id', $saleId)->findAll();
    }

    /**
     * Get items with product details
     */
    public function getItemsWithProductDetails($saleId)
    {
        return $this->db->table('sale_items si')
                       ->select('si.*, p.image, p.description')
                       ->join('products p', 'p.id = si.product_id', 'left')
                       ->where('si.sale_id', $saleId)
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get top selling products
     */
    public function getTopSellingProducts($limit = 10, $period = '30')
    {
        $dateFrom = date('Y-m-d', strtotime("-{$period} days"));
        
        return $this->db->table('sale_items si')
                       ->select('si.product_id, si.product_name, SUM(si.quantity) as total_quantity, SUM(si.subtotal) as total_revenue')
                       ->join('sales s', 's.id = si.sale_id')
                       ->where('s.sale_status', 'completed')
                       ->where('DATE(s.created_at) >=', $dateFrom)
                       ->groupBy('si.product_id, si.product_name')
                       ->orderBy('total_quantity', 'DESC')
                       ->limit($limit)
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get sales summary by product
     */
    public function getSalesSummaryByProduct($productId, $period = '30')
    {
        $dateFrom = date('Y-m-d', strtotime("-{$period} days"));
        
        $result = $this->db->table('sale_items si')
                          ->select('
                              SUM(si.quantity) as total_quantity,
                              SUM(si.subtotal) as total_revenue,
                              AVG(si.unit_price) as avg_price,
                              COUNT(DISTINCT si.sale_id) as total_sales
                          ')
                          ->join('sales s', 's.id = si.sale_id')
                          ->where('si.product_id', $productId)
                          ->where('s.sale_status', 'completed')
                          ->where('DATE(s.created_at) >=', $dateFrom)
                          ->get()
                          ->getRowArray();

        return $result ?: [
            'total_quantity' => 0,
            'total_revenue' => 0,
            'avg_price' => 0,
            'total_sales' => 0
        ];
    }
}
