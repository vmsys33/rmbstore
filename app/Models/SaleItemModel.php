<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleItemModel extends Model
{
    protected $table = 'sale_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'sale_id',
        'product_id',
        'product_name',
        'product_sku',
        'quantity',
        'unit_price',
        'discount_percent',
        'discount_amount',
        'subtotal',
        'total_amount',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'sale_id' => 'required|integer',
        'product_id' => 'required|integer',
        'product_name' => 'required|max_length[255]',
        'product_sku' => 'required|max_length[100]',
        'quantity' => 'required|integer|greater_than[0]',
        'unit_price' => 'required|numeric|greater_than_equal_to[0]',
        'discount_percent' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
        'discount_amount' => 'required|numeric|greater_than_equal_to[0]',
        'subtotal' => 'required|numeric|greater_than_equal_to[0]',
        'total_amount' => 'required|numeric|greater_than_equal_to[0]'
    ];

    protected $validationMessages = [
        'sale_id' => [
            'required' => 'Sale ID is required',
            'integer' => 'Sale ID must be an integer'
        ],
        'product_id' => [
            'required' => 'Product ID is required',
            'integer' => 'Product ID must be an integer'
        ],
        'product_name' => [
            'required' => 'Product name is required',
            'max_length' => 'Product name cannot exceed 255 characters'
        ],
        'product_sku' => [
            'required' => 'Product SKU is required',
            'max_length' => 'Product SKU cannot exceed 100 characters'
        ],
        'quantity' => [
            'required' => 'Quantity is required',
            'integer' => 'Quantity must be an integer',
            'greater_than' => 'Quantity must be greater than 0'
        ],
        'unit_price' => [
            'required' => 'Unit price is required',
            'numeric' => 'Unit price must be a number',
            'greater_than_equal_to' => 'Unit price must be greater than or equal to 0'
        ],
        'total_amount' => [
            'required' => 'Total amount is required',
            'numeric' => 'Total amount must be a number',
            'greater_than_equal_to' => 'Total amount must be greater than or equal to 0'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get items by sale ID
     */
    public function getItemsBySaleId($saleId)
    {
        return $this->where('sale_id', $saleId)->findAll();
    }

    /**
     * Get sale items with product details
     */
    public function getItemsWithProductDetails($saleId)
    {
        $builder = $this->builder();
        $builder->select('sale_items.*, products.product_name as original_name, products.sku as original_sku')
                ->join('products', 'products.id = sale_items.product_id', 'left')
                ->where('sale_items.sale_id', $saleId);

        return $builder->get()->getResultArray();
    }

    /**
     * Calculate item totals
     */
    public function calculateItemTotals($quantity, $unitPrice, $discountPercent = 0)
    {
        $subtotal = $quantity * $unitPrice;
        $discountAmount = ($subtotal * $discountPercent) / 100;
        $totalAmount = $subtotal - $discountAmount;

        return [
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount
        ];
    }

    /**
     * Get top selling products
     */
    public function getTopSellingProducts($limit = 10, $period = 'month')
    {
        $builder = $this->builder();
        $builder->select('product_id, product_name, product_sku, SUM(quantity) as total_quantity, SUM(total_amount) as total_revenue')
                ->groupBy('product_id, product_name, product_sku')
                ->orderBy('total_quantity', 'DESC')
                ->limit($limit);

        // Apply period filter
        switch ($period) {
            case 'today':
                $builder->where('DATE(created_at)', date('Y-m-d'));
                break;
            case 'week':
                $builder->where('created_at >=', date('Y-m-d', strtotime('-7 days')));
                break;
            case 'month':
                $builder->where('created_at >=', date('Y-m-d', strtotime('-30 days')));
                break;
            case 'year':
                $builder->where('YEAR(created_at)', date('Y'));
                break;
        }

        return $builder->get()->getResultArray();
    }
}
