<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run()
    {
        $inventoryModel = new \App\Models\InventoryModel();
        $productModel = new \App\Models\ProductModel();
        
        // Get all products
        $products = $productModel->findAll();
        
        if (empty($products)) {
            echo "No products found. Please run ProductSeeder first.\n";
            return;
        }
        
        $inventoryData = [];
        
        foreach ($products as $product) {
            // Create multiple inventory entries for each product with different delivery dates
            $inventoryData[] = [
                'product_id' => $product['id'],
                'batch_number' => 'BATCH-' . $product['id'] . '-001',
                'quantity' => rand(50, 200),
                'reserved_quantity' => 0,
                'available_quantity' => rand(50, 200),
                'unit_cost' => $product['price'] * 0.6, // 40% margin
                'delivery_date' => date('Y-m-d', strtotime('-' . rand(1, 30) . ' days')),
                'expiry_date' => date('Y-m-d', strtotime('+' . rand(60, 365) . ' days')),
                'supplier_name' => 'Supplier ' . rand(1, 5),
                'supplier_contact' => '+63' . rand(900000000, 999999999),
                'status' => 'active',
                'notes' => 'Initial inventory for ' . $product['product_name'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Add a second batch for some products
            if (rand(1, 3) == 1) {
                $inventoryData[] = [
                    'product_id' => $product['id'],
                    'batch_number' => 'BATCH-' . $product['id'] . '-002',
                    'quantity' => rand(20, 100),
                    'reserved_quantity' => 0,
                    'available_quantity' => rand(20, 100),
                    'unit_cost' => $product['price'] * 0.65, // 35% margin
                    'delivery_date' => date('Y-m-d', strtotime('-' . rand(1, 15) . ' days')),
                    'expiry_date' => date('Y-m-d', strtotime('+' . rand(60, 365) . ' days')),
                    'supplier_name' => 'Supplier ' . rand(1, 5),
                    'supplier_contact' => '+63' . rand(900000000, 999999999),
                    'status' => 'active',
                    'notes' => 'Additional batch for ' . $product['product_name'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
        }
        
        // Insert inventory data
        $inventoryModel->insertBatch($inventoryData);
        
        echo "Inventory seeded successfully!\n";
        echo "Created " . count($inventoryData) . " inventory records.\n";
    }
}
