<?php

namespace App\Models;

use CodeIgniter\Model;

class StockOnHandModel extends Model
{
    protected $table = 'stock_on_hand';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_id', 'quantity', 'status', 'notes'];
    protected $useTimestamps = true;
    protected $createdField = 'date_added';
    protected $updatedField = 'date_updated';

    /**
     * Get stock summary for all products
     */
    public function getStockSummary()
    {
        $db = \Config\Database::connect();
        
        $sql = "SELECT 
                    p.id,
                    p.product_name,
                    p.category,
                    p.price,
                    p.featured_image,
                    COALESCE(soh.quantity, 0) as stock_on_hand,
                    COALESCE(sold.total_sold, 0) as total_sold,
                    GREATEST(COALESCE(soh.quantity, 0) - COALESCE(sold.total_sold, 0), 0) as remaining_quantity,
                    soh.status as stock_status,
                    soh.date_updated as last_stock_update,
                    CASE 
                        WHEN COALESCE(soh.quantity, 0) = 0 THEN 'Out of Stock'
                        WHEN COALESCE(soh.quantity, 0) - COALESCE(sold.total_sold, 0) <= 0 THEN 'Sold Out'
                        WHEN COALESCE(soh.quantity, 0) - COALESCE(sold.total_sold, 0) <= 5 THEN 'Low Stock'
                        ELSE 'In Stock'
                    END as availability_status
                FROM products p
                LEFT JOIN stock_on_hand soh ON p.stock_on_hand_id = soh.id
                LEFT JOIN (
                    SELECT 
                        product_id,
                        SUM(quantity) as total_sold
                    FROM sales 
                    GROUP BY product_id
                ) sold ON p.id = sold.product_id
                ORDER BY p.product_name";
        
        return $db->query($sql)->getResultArray();
    }

    /**
     * Get stock summary for a specific product
     */
    public function getProductStockSummary($productId)
    {
        $db = \Config\Database::connect();
        
        $sql = "SELECT 
                    p.id,
                    p.product_name,
                    p.category,
                    p.price,
                    p.featured_image,
                    COALESCE(soh.quantity, 0) as stock_on_hand,
                    COALESCE(sold.total_sold, 0) as total_sold,
                    GREATEST(COALESCE(soh.quantity, 0) - COALESCE(sold.total_sold, 0), 0) as remaining_quantity,
                    soh.status as stock_status,
                    soh.date_updated as last_stock_update,
                    soh.notes,
                    CASE 
                        WHEN COALESCE(soh.quantity, 0) = 0 THEN 'Out of Stock'
                        WHEN COALESCE(soh.quantity, 0) - COALESCE(sold.total_sold, 0) <= 0 THEN 'Sold Out'
                        WHEN COALESCE(soh.quantity, 0) - COALESCE(sold.total_sold, 0) <= 5 THEN 'Low Stock'
                        ELSE 'In Stock'
                    END as availability_status
                FROM products p
                LEFT JOIN stock_on_hand soh ON p.stock_on_hand_id = soh.id
                LEFT JOIN (
                    SELECT 
                        product_id,
                        SUM(quantity) as total_sold
                    FROM sales 
                    GROUP BY product_id
                ) sold ON p.id = sold.product_id
                WHERE p.id = ?";
        
        return $db->query($sql, [$productId])->getRowArray();
    }

    /**
     * Add or update stock for a product
     */
    public function addOrUpdateStock($productId, $quantity, $notes = '')
    {
        // Check if stock record exists
        $existingStock = $this->where('product_id', $productId)->first();
        
        if ($existingStock) {
            // Update existing stock
            $newQuantity = $existingStock['quantity'] + $quantity;
            $status = $newQuantity > 0 ? 'active' : 'depleted';
            
            $this->update($existingStock['id'], [
                'quantity' => $newQuantity,
                'status' => $status,
                'notes' => $notes ?: $existingStock['notes']
            ]);
            
            // Update product table reference
            $this->updateProductStockReference($productId, $existingStock['id']);
            
            return $existingStock['id'];
        } else {
            // Create new stock record
            $status = $quantity > 0 ? 'active' : 'depleted';
            
            $stockId = $this->insert([
                'product_id' => $productId,
                'quantity' => $quantity,
                'status' => $status,
                'notes' => $notes
            ]);
            
            // Update product table reference
            $this->updateProductStockReference($productId, $stockId);
            
            return $stockId;
        }
    }

    /**
     * Update product table to reference stock_on_hand
     */
    private function updateProductStockReference($productId, $stockId)
    {
        $db = \Config\Database::connect();
        $db->table('products')
            ->where('id', $productId)
            ->update(['stock_on_hand_id' => $stockId]);
    }

    /**
     * Get low stock products (remaining quantity <= 5)
     */
    public function getLowStockProducts()
    {
        $db = \Config\Database::connect();
        
        $sql = "SELECT 
                    p.id,
                    p.product_name,
                    p.category,
                    p.price,
                    COALESCE(soh.quantity, 0) as stock_on_hand,
                    COALESCE(sold.total_sold, 0) as total_sold,
                    GREATEST(COALESCE(soh.quantity, 0) - COALESCE(sold.total_sold, 0), 0) as remaining_quantity
                FROM products p
                LEFT JOIN stock_on_hand soh ON p.stock_on_hand_id = soh.id
                LEFT JOIN (
                    SELECT 
                        product_id,
                        SUM(quantity) as total_sold
                    FROM sales 
                    GROUP BY product_id
                ) sold ON p.id = sold.product_id
                HAVING remaining_quantity <= 5 AND remaining_quantity > 0
                ORDER BY remaining_quantity ASC";
        
        return $db->query($sql)->getResultArray();
    }

    /**
     * Get out of stock products
     */
    public function getOutOfStockProducts()
    {
        $db = \Config\Database::connect();
        
        $sql = "SELECT 
                    p.id,
                    p.product_name,
                    p.category,
                    p.price,
                    COALESCE(soh.quantity, 0) as stock_on_hand,
                    COALESCE(sold.total_sold, 0) as total_sold,
                    GREATEST(COALESCE(soh.quantity, 0) - COALESCE(sold.total_sold, 0), 0) as remaining_quantity
                FROM products p
                LEFT JOIN stock_on_hand soh ON p.stock_on_hand_id = soh.id
                LEFT JOIN (
                    SELECT 
                        product_id,
                        SUM(quantity) as total_sold
                    FROM sales 
                    GROUP BY product_id
                ) sold ON p.id = sold.product_id
                HAVING remaining_quantity <= 0
                ORDER BY p.product_name";
        
        return $db->query($sql)->getResultArray();
    }
}
