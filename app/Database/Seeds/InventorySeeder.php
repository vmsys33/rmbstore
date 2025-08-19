<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run()
    {
        // Get all products
        $products = $this->db->table('products')->get()->getResultArray();
        
        foreach ($products as $product) {
            $inventoryData = [
                'product_id' => $product['id'],
                'batch_number' => 'BATCH-' . date('Ymd') . '-' . str_pad($product['id'], 3, '0', STR_PAD_LEFT),
                'quantity' => $product['stock_quantity'] ?? 50,
                'reserved_quantity' => 0,
                'available_quantity' => $product['stock_quantity'] ?? 50,
                'unit_cost' => ($product['price'] ?? 10) * 0.6, // 60% of selling price as cost
                'delivery_date' => date('Y-m-d', strtotime('-30 days')),
                'expiry_date' => date('Y-m-d', strtotime('+365 days')),
                'supplier_name' => 'Default Supplier',
                'supplier_contact' => 'supplier@example.com',
                'status' => 'active',
                'notes' => 'Auto-generated inventory for POS testing',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->db->table('inventory')->insert($inventoryData);
        }
        
        echo "Inventory data seeded successfully!\n";
    }
}
