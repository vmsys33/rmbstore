<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Seed categories table
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and gadgets',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Clothing',
                'description' => 'Apparel and fashion items',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home improvement and garden supplies',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('categories')->insertBatch($categories);

        // Seed products table
        $products = [
            [
                'product_name' => 'Test Smartphone',
                'sku' => 'SMART001-ABCD',
                'product_category' => 1, // Electronics
                'price' => 599.99,
                'sale_price' => 549.99,
                'stock_quantity' => 50,
                'weight' => 0.2,
                'dimensions' => '15x7x0.8',
                'short_description' => 'High-quality smartphone for testing',
                'description' => 'This is a test smartphone with advanced features for testing purposes.',
                'status' => 'active',
                'featured' => 1,
                'image_icon' => 'uploads/products/icons/test_phone_icon.jpg',
                'image_post' => 'uploads/products/posts/test_phone_post.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_name' => 'Test T-Shirt',
                'sku' => 'TSHIR001-EFGH',
                'product_category' => 2, // Clothing
                'price' => 29.99,
                'sale_price' => null,
                'stock_quantity' => 100,
                'weight' => 0.15,
                'dimensions' => 'M',
                'short_description' => 'Comfortable cotton t-shirt for testing',
                'description' => 'A high-quality cotton t-shirt perfect for testing the product system.',
                'status' => 'active',
                'featured' => 0,
                'image_icon' => 'uploads/products/icons/test_tshirt_icon.jpg',
                'image_post' => 'uploads/products/posts/test_tshirt_post.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('products')->insertBatch($products);
    }
}
