<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryTransactionModel extends Model
{
    protected $table = 'inventory_transactions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'product_id',
        'transaction_type',
        'quantity',
        'unit_cost',
        'total_cost',
        'reference_type',
        'reference_id',
        'notes',
        'transaction_date',
        'created_by',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = null; // Table doesn't have updated_at

    // Validation
    protected $validationRules = [
        'product_id' => 'required|integer',
        'transaction_type' => 'required|in_list[in,out,reserve,release,adjustment]',
        'quantity' => 'required|integer|greater_than[0]',
        'unit_cost' => 'required|numeric|greater_than_equal_to[0]',
        'total_cost' => 'required|numeric|greater_than_equal_to[0]',
        'reference_type' => 'required|in_list[sale,purchase,adjustment,transfer,return]'
    ];

    protected $validationMessages = [
        'product_id' => [
            'required' => 'Product ID is required',
            'integer' => 'Product ID must be an integer'
        ],
        'transaction_type' => [
            'required' => 'Transaction type is required',
            'in_list' => 'Invalid transaction type'
        ],
        'quantity' => [
            'required' => 'Quantity is required',
            'integer' => 'Quantity must be an integer',
            'greater_than' => 'Quantity must be greater than 0'
        ],
        'unit_cost' => [
            'required' => 'Unit cost is required',
            'numeric' => 'Unit cost must be a number',
            'greater_than_equal_to' => 'Unit cost must be greater than or equal to 0'
        ],
        'total_cost' => [
            'required' => 'Total cost is required',
            'numeric' => 'Total cost must be a number',
            'greater_than_equal_to' => 'Total cost must be greater than or equal to 0'
        ],
        'reference_type' => [
            'required' => 'Reference type is required',
            'in_list' => 'Invalid reference type'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['calculateTotalCost'];
    protected $beforeUpdate = ['calculateTotalCost'];

    /**
     * Calculate total cost before insert/update
     */
    protected function calculateTotalCost(array $data)
    {
        if (isset($data['data']['quantity']) && isset($data['data']['unit_cost'])) {
            $data['data']['total_cost'] = $data['data']['quantity'] * $data['data']['unit_cost'];
        }
        return $data;
    }

    /**
     * Record inventory transaction
     */
    public function recordTransaction($data)
    {
        return $this->insert($data);
    }

    /**
     * Record sale transaction (inventory out)
     */
    public function recordSaleTransaction($saleId, $saleNumber, $items, $userId = null)
    {
        $transactions = [];
        
        foreach ($items as $item) {
            $transactions[] = [
                'product_id' => $item['product_id'],
                'transaction_type' => 'out',
                'quantity' => $item['quantity'],
                'unit_cost' => $item['unit_cost'] ?? 0,
                'total_cost' => ($item['unit_cost'] ?? 0) * $item['quantity'],
                'reference_type' => 'sale',
                'reference_id' => $saleId,
                'notes' => "Sale transaction for {$item['product_name']} - {$saleNumber}",
                'transaction_date' => date('Y-m-d H:i:s'),
                'created_by' => $userId
            ];
        }

        return $this->insertBatch($transactions);
    }

    /**
     * Record purchase transaction (inventory in)
     */
    public function recordPurchaseTransaction($purchaseId, $purchaseNumber, $items, $userId = null)
    {
        $transactions = [];
        
        foreach ($items as $item) {
            $transactions[] = [
                'product_id' => $item['product_id'],
                'transaction_type' => 'in',
                'quantity' => $item['quantity'],
                'unit_cost' => $item['unit_cost'],
                'total_cost' => $item['unit_cost'] * $item['quantity'],
                'reference_type' => 'purchase',
                'reference_id' => $purchaseId,
                'notes' => "Purchase transaction for {$item['product_name']} - {$purchaseNumber}",
                'transaction_date' => date('Y-m-d H:i:s'),
                'created_by' => $userId
            ];
        }

        return $this->insertBatch($transactions);
    }

    /**
     * Record inventory reservation
     */
    public function recordReservation($productId, $quantity, $referenceType, $referenceId, $referenceNumber, $userId = null)
    {
        return $this->insert([
            'product_id' => $productId,
            'transaction_type' => 'reserve',
            'quantity' => $quantity,
            'unit_cost' => 0, // Reservation doesn't affect cost
            'total_cost' => 0,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'notes' => "Inventory reservation - {$referenceNumber}",
            'transaction_date' => date('Y-m-d H:i:s'),
            'created_by' => $userId
        ]);
    }

    /**
     * Record inventory release
     */
    public function recordRelease($productId, $quantity, $referenceType, $referenceId, $referenceNumber, $userId = null)
    {
        return $this->insert([
            'product_id' => $productId,
            'transaction_type' => 'release',
            'quantity' => $quantity,
            'unit_cost' => 0, // Release doesn't affect cost
            'total_cost' => 0,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'notes' => "Inventory release - {$referenceNumber}",
            'transaction_date' => date('Y-m-d H:i:s'),
            'created_by' => $userId
        ]);
    }

    /**
     * Record inventory adjustment
     */
    public function recordAdjustment($productId, $quantity, $unitCost, $reason, $userId = null)
    {
        $referenceNumber = 'ADJ-' . date('YmdHis');
        return $this->insert([
            'product_id' => $productId,
            'transaction_type' => 'adjustment',
            'quantity' => abs($quantity),
            'unit_cost' => $unitCost,
            'total_cost' => abs($quantity) * $unitCost,
            'reference_type' => 'adjustment',
            'reference_id' => null,
            'notes' => "{$reason} - {$referenceNumber}",
            'transaction_date' => date('Y-m-d H:i:s'),
            'created_by' => $userId
        ]);
    }

    /**
     * Get transactions by product ID
     */
    public function getTransactionsByProduct($productId, $limit = 50)
    {
        return $this->where('product_id', $productId)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get transactions by reference
     */
    public function getTransactionsByReference($referenceType, $referenceId)
    {
        return $this->where('reference_type', $referenceType)
                    ->where('reference_id', $referenceId)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    /**
     * Get transaction summary by date range
     */
    public function getTransactionSummary($startDate, $endDate, $productId = null)
    {
        $builder = $this->builder();
        
        $builder->select('
            transaction_type,
            SUM(quantity) as total_quantity,
            SUM(total_cost) as total_cost,
            COUNT(*) as transaction_count
        ');
        
        $builder->where('created_at >=', $startDate);
        $builder->where('created_at <=', $endDate);
        
        if ($productId) {
            $builder->where('product_id', $productId);
        }
        
        $builder->groupBy('transaction_type');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get inventory movement report
     */
    public function getInventoryMovementReport($startDate, $endDate, $productId = null)
    {
        $builder = $this->builder();
        
        $builder->select('
            it.product_id,
            p.product_name,
            p.sku,
            it.transaction_type,
            SUM(it.quantity) as total_quantity,
            SUM(it.total_cost) as total_cost,
            COUNT(*) as transaction_count
        ');
        
        $builder->join('products p', 'p.id = it.product_id', 'left');
        $builder->where('it.created_at >=', $startDate);
        $builder->where('it.created_at <=', $endDate);
        
        if ($productId) {
            $builder->where('it.product_id', $productId);
        }
        
        $builder->groupBy(['it.product_id', 'it.transaction_type']);
        $builder->orderBy('p.product_name', 'ASC');
        $builder->orderBy('it.transaction_type', 'ASC');
        
        return $builder->get()->getResultArray();
    }
}
