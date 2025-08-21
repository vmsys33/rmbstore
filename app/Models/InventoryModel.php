<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryModel extends Model
{
    protected $table = 'inventory';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'product_id',
        'batch_number',
        'quantity',
        'reserved_quantity',
        'available_quantity',
        'unit_cost',
        'delivery_date',
        'expiry_date',
        'supplier_name',
        'supplier_contact',
        'status',
        'notes',
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
        'product_id' => 'required|integer',
        'batch_number' => 'permit_empty|max_length[100]',
        'quantity' => 'required|integer|greater_than_equal_to[0]',
        'reserved_quantity' => 'required|integer|greater_than_equal_to[0]',
        'available_quantity' => 'required|integer|greater_than_equal_to[0]',
        'unit_cost' => 'required|numeric|greater_than_equal_to[0]',
        'delivery_date' => 'permit_empty|valid_date',
        'expiry_date' => 'permit_empty|valid_date',
        'supplier_name' => 'permit_empty|max_length[255]',
        'supplier_contact' => 'permit_empty|max_length[255]',
        'status' => 'required|in_list[active,inactive,expired]'
    ];

    protected $validationMessages = [
        'product_id' => [
            'required' => 'Product ID is required',
            'integer' => 'Product ID must be an integer'
        ],
        'quantity' => [
            'required' => 'Quantity is required',
            'integer' => 'Quantity must be an integer',
            'greater_than_equal_to' => 'Quantity must be greater than or equal to 0'
        ],
        'unit_cost' => [
            'required' => 'Unit cost is required',
            'numeric' => 'Unit cost must be a number',
            'greater_than_equal_to' => 'Unit cost must be greater than or equal to 0'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Invalid status'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $beforeInsert = ['calculateAvailableQuantity'];
    protected $beforeUpdate = ['calculateAvailableQuantity'];

    /**
     * Calculate available quantity
     */
    protected function calculateAvailableQuantity(array $data)
    {
        if (isset($data['data']['quantity']) && isset($data['data']['reserved_quantity'])) {
            $data['data']['available_quantity'] = $data['data']['quantity'] - $data['data']['reserved_quantity'];
        }
        return $data;
    }

    /**
     * Get inventory by product ID
     */
    public function getInventoryByProductId($productId)
    {
        return $this->where('product_id', $productId)
                    ->where('status', 'active')
                    ->findAll();
    }

    /**
     * Get total available quantity for a product
     */
    public function getTotalAvailableQuantity($productId)
    {
        $result = $this->selectSum('available_quantity')
                       ->where('product_id', $productId)
                       ->where('status', 'active')
                       ->get()
                       ->getRow();

        return $result->available_quantity ?? 0;
    }

    /**
     * Get total quantity for a product
     */
    public function getTotalQuantity($productId)
    {
        $result = $this->selectSum('quantity')
                       ->where('product_id', $productId)
                       ->where('status', 'active')
                       ->get()
                       ->getRow();

        return $result->quantity ?? 0;
    }

    /**
     * Reserve quantity for a product
     */
    public function reserveQuantity($productId, $quantity)
    {
        $inventory = $this->where('product_id', $productId)
                          ->where('status', 'active')
                          ->where('available_quantity >=', $quantity)
                          ->orderBy('delivery_date', 'ASC') // FIFO - First In, First Out
                          ->findAll();

        $remainingQuantity = $quantity;
        $reservedItems = [];

        foreach ($inventory as $item) {
            if ($remainingQuantity <= 0) break;

            $reserveAmount = min($remainingQuantity, $item['available_quantity']);
            
            $this->update($item['id'], [
                'reserved_quantity' => $item['reserved_quantity'] + $reserveAmount,
                'available_quantity' => $item['available_quantity'] - $reserveAmount
            ]);

            $reservedItems[] = [
                'inventory_id' => $item['id'],
                'quantity' => $reserveAmount
            ];

            $remainingQuantity -= $reserveAmount;
        }

        return [
            'success' => $remainingQuantity <= 0,
            'reserved_items' => $reservedItems,
            'remaining_quantity' => $remainingQuantity
        ];
    }

    /**
     * Release reserved quantity
     */
    public function releaseReservedQuantity($productId, $quantity)
    {
        $inventory = $this->where('product_id', $productId)
                          ->where('status', 'active')
                          ->where('reserved_quantity >', 0)
                          ->orderBy('delivery_date', 'DESC') // LIFO - Last In, First Out
                          ->findAll();

        $remainingQuantity = $quantity;

        foreach ($inventory as $item) {
            if ($remainingQuantity <= 0) break;

            $releaseAmount = min($remainingQuantity, $item['reserved_quantity']);
            
            $this->update($item['id'], [
                'reserved_quantity' => $item['reserved_quantity'] - $releaseAmount,
                'available_quantity' => $item['available_quantity'] + $releaseAmount
            ]);

            $remainingQuantity -= $releaseAmount;
        }

        return $remainingQuantity <= 0;
    }

    /**
     * Deduct quantity from inventory (for completed sales)
     */
    public function deductQuantity($productId, $quantity)
    {
        $inventory = $this->where('product_id', $productId)
                          ->where('status', 'active')
                          ->where('reserved_quantity >=', $quantity)
                          ->orderBy('delivery_date', 'ASC')
                          ->findAll();

        $remainingQuantity = $quantity;

        foreach ($inventory as $item) {
            if ($remainingQuantity <= 0) break;

            $deductAmount = min($remainingQuantity, $item['reserved_quantity']);
            
            $newQuantity = $item['quantity'] - $deductAmount;
            $newReservedQuantity = $item['reserved_quantity'] - $deductAmount;
            $newAvailableQuantity = $item['available_quantity'];

            // If quantity becomes 0, mark as inactive
            $status = $newQuantity <= 0 ? 'inactive' : $item['status'];

            $this->update($item['id'], [
                'quantity' => $newQuantity,
                'reserved_quantity' => $newReservedQuantity,
                'available_quantity' => $newAvailableQuantity,
                'status' => $status
            ]);

            $remainingQuantity -= $deductAmount;
        }

        return $remainingQuantity <= 0;
    }

    /**
     * Get expiring inventory
     */
    public function getExpiringInventory($days = 30)
    {
        $expiryDate = date('Y-m-d', strtotime("+{$days} days"));
        
        return $this->where('expiry_date <=', $expiryDate)
                    ->where('expiry_date >=', date('Y-m-d'))
                    ->where('status', 'active')
                    ->where('quantity >', 0)
                    ->findAll();
    }

    /**
     * Get low stock inventory
     */
    public function getLowStockInventory($threshold = 10)
    {
        return $this->where('available_quantity <=', $threshold)
                    ->where('status', 'active')
                    ->findAll();
    }

    /**
     * Update inventory status based on expiry dates
     */
    public function updateExpiredStatus()
    {
        $this->where('expiry_date <', date('Y-m-d'))
             ->where('status', 'active')
             ->set(['status' => 'expired'])
             ->update();
    }
}
