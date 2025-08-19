<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run()
    {
        // Seed Users
        $this->seedUsers();
        
        // Seed Categories
        $this->seedCategories();
        
        // Seed Products
        $this->seedProducts();
    }

    private function seedUsers()
    {
        $userModel = new \App\Models\UserModel();
        
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@store.com',
                'password' => 'admin123',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'phone' => '+1234567890',
                'address' => '123 Admin Street, City, Country',
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'customer1',
                'email' => 'customer1@store.com',
                'password' => 'customer123',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'phone' => '+1234567891',
                'address' => '456 Customer Ave, City, Country',
                'role' => 'customer',
                'status' => 'active',
                'email_verified_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'staff1',
                'email' => 'staff1@store.com',
                'password' => 'staff123',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'phone' => '+1234567892',
                'address' => '789 Staff Road, City, Country',
                'role' => 'staff',
                'status' => 'active',
                'email_verified_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($users as $user) {
            $userModel->insert($user);
        }
    }

    private function seedCategories()
    {
        $categoryModel = new \App\Models\CategoryModel();
        
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and gadgets',
                'sort_order' => 1,
                'status' => 'active',
            ],
            [
                'name' => 'Clothing',
                'description' => 'Fashion and apparel',
                'sort_order' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'Books',
                'description' => 'Books and publications',
                'sort_order' => 3,
                'status' => 'active',
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home improvement and garden supplies',
                'sort_order' => 4,
                'status' => 'active',
            ],
            [
                'name' => 'Sports',
                'description' => 'Sports equipment and accessories',
                'sort_order' => 5,
                'status' => 'active',
            ],
            [
                'name' => 'Smartphones',
                'description' => 'Mobile phones and accessories',
                'parent_id' => 1, // Electronics
                'sort_order' => 1,
                'status' => 'active',
            ],
            [
                'name' => 'Laptops',
                'description' => 'Portable computers',
                'parent_id' => 1, // Electronics
                'sort_order' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'Men\'s Clothing',
                'description' => 'Clothing for men',
                'parent_id' => 2, // Clothing
                'sort_order' => 1,
                'status' => 'active',
            ],
            [
                'name' => 'Women\'s Clothing',
                'description' => 'Clothing for women',
                'parent_id' => 2, // Clothing
                'sort_order' => 2,
                'status' => 'active',
            ],
        ];

        foreach ($categories as $category) {
            $categoryModel->insert($category);
        }
    }

    private function seedProducts()
    {
        $productModel = new \App\Models\ProductModel();
        
        $products = [
            [
                'product_name' => 'iPhone 15 Pro',
                'product_category' => 6, // Smartphones
                'description' => 'Latest iPhone with advanced features and powerful performance.',
                'short_description' => 'Premium smartphone with cutting-edge technology',
                'price' => 999.99,
                'sale_price' => 899.99,
                'stock_quantity' => 50,
                'weight' => 0.187,
                'dimensions' => '146.7 x 71.5 x 7.8 mm',
                'status' => 'active',
                'featured' => true,
            ],
            [
                'product_name' => 'MacBook Pro 14"',
                'product_category' => 7, // Laptops
                'description' => 'Professional laptop with M3 chip for ultimate performance.',
                'short_description' => 'Powerful laptop for professionals',
                'price' => 1999.99,
                'stock_quantity' => 25,
                'weight' => 1.6,
                'dimensions' => '312.6 x 221.2 x 15.5 mm',
                'status' => 'active',
                'featured' => true,
            ],
            [
                'product_name' => 'Men\'s Casual T-Shirt',
                'product_category' => 8, // Men's Clothing
                'description' => 'Comfortable cotton t-shirt for everyday wear.',
                'short_description' => 'Comfortable and stylish t-shirt',
                'price' => 29.99,
                'sale_price' => 24.99,
                'stock_quantity' => 100,
                'weight' => 0.2,
                'dimensions' => 'Regular Fit',
                'status' => 'active',
                'featured' => false,
            ],
            [
                'product_name' => 'Women\'s Summer Dress',
                'product_category' => 9, // Women's Clothing
                'description' => 'Beautiful summer dress perfect for any occasion.',
                'short_description' => 'Elegant summer dress',
                'price' => 79.99,
                'stock_quantity' => 75,
                'weight' => 0.3,
                'dimensions' => 'Regular Fit',
                'status' => 'active',
                'featured' => true,
            ],
            [
                'product_name' => 'Programming Book: PHP Mastery',
                'product_category' => 3, // Books
                'description' => 'Comprehensive guide to PHP programming language.',
                'short_description' => 'Learn PHP from beginner to expert',
                'price' => 49.99,
                'sale_price' => 39.99,
                'stock_quantity' => 30,
                'weight' => 0.8,
                'dimensions' => 'Paperback',
                'status' => 'active',
                'featured' => false,
            ],
            [
                'product_name' => 'Garden Tool Set',
                'product_category' => 4, // Home & Garden
                'description' => 'Complete set of essential garden tools.',
                'short_description' => 'Essential tools for your garden',
                'price' => 89.99,
                'stock_quantity' => 40,
                'weight' => 2.5,
                'dimensions' => 'Tool Set',
                'status' => 'active',
                'featured' => false,
            ],
            [
                'product_name' => 'Basketball',
                'product_category' => 5, // Sports
                'description' => 'Professional basketball for indoor and outdoor use.',
                'short_description' => 'Professional basketball',
                'price' => 34.99,
                'stock_quantity' => 60,
                'weight' => 0.6,
                'dimensions' => 'Size 7',
                'status' => 'active',
                'featured' => false,
            ],
            [
                'product_name' => 'Samsung Galaxy S24',
                'product_category' => 6, // Smartphones
                'description' => 'Latest Samsung flagship with AI features.',
                'short_description' => 'AI-powered smartphone',
                'price' => 899.99,
                'stock_quantity' => 35,
                'weight' => 0.168,
                'dimensions' => '147.0 x 70.6 x 7.6 mm',
                'status' => 'active',
                'featured' => true,
            ],
        ];

        foreach ($products as $product) {
            $productModel->insert($product);
        }
    }
}
