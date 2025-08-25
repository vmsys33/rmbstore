<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ChatbotProductsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Premium Laptop',
                'description' => 'High-performance laptop with 16GB RAM, 512GB SSD, and dedicated graphics card.',
                'price' => 1299.99,
                'price_formatted' => '$1,299.99',
                'image_url' => 'assets/img/products/laptop.jpg',
                'category' => 'Electronics',
                'keywords' => 'laptop,computer,premium,high-performance',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Wireless Headphones',
                'description' => 'Noise-cancelling wireless headphones with 30-hour battery life.',
                'price' => 199.99,
                'price_formatted' => '$199.99',
                'image_url' => 'assets/img/products/headphones.jpg',
                'category' => 'Electronics',
                'keywords' => 'headphones,wireless,audio,noise-cancelling',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness tracker and smartwatch with heart rate monitoring and GPS.',
                'price' => 249.99,
                'price_formatted' => '$249.99',
                'image_url' => 'assets/img/products/smartwatch.jpg',
                'category' => 'Wearables',
                'keywords' => 'watch,smart,fitness,tracker,wearable',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Bluetooth Speaker',
                'description' => 'Portable waterproof Bluetooth speaker with 20-hour battery life.',
                'price' => 79.99,
                'price_formatted' => '$79.99',
                'image_url' => 'assets/img/products/speaker.jpg',
                'category' => 'Audio',
                'keywords' => 'speaker,bluetooth,portable,audio,waterproof',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Wireless Charger',
                'description' => 'Fast wireless charging pad compatible with all Qi-enabled devices.',
                'price' => 39.99,
                'price_formatted' => '$39.99',
                'image_url' => 'assets/img/products/charger.jpg',
                'category' => 'Accessories',
                'keywords' => 'charger,wireless,fast,accessory',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert data into the chatbot_products table
        $this->db->table('chatbot_products')->insertBatch($data);
    }
}