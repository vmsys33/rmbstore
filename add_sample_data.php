<?php
/**
 * Manual Data Insertion Script
 * 
 * This script will add sample categories and products to your store database.
 * Run this script in your browser: http://localhost:8080/add_sample_data.php
 */

// Load CodeIgniter
require_once 'vendor/autoload.php';

// Initialize CodeIgniter
$app = new \CodeIgniter\CodeIgniter(new \Config\Paths());
$app->initialize();

// Get database connection
$db = \Config\Database::connect();

echo "<h1>Adding Sample Data to Store Database</h1>";

try {
    // Step 1: Add Categories
    echo "<h2>Step 1: Adding Categories</h2>";
    
    $categories = [
        [
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Latest electronic gadgets and devices',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Clothing',
            'slug' => 'clothing',
            'description' => 'Fashion and apparel for all ages',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Books',
            'slug' => 'books',
            'description' => 'Books for education and entertainment',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Home & Garden',
            'slug' => 'home-garden',
            'description' => 'Home improvement and garden supplies',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Sports',
            'slug' => 'sports',
            'description' => 'Sports equipment and accessories',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]
    ];

    foreach ($categories as $category) {
        $db->table('categories')->insert($category);
        echo "✓ Added category: {$category['name']}<br>";
    }

    // Step 2: Add Products
    echo "<h2>Step 2: Adding Products</h2>";
    
    $products = [
        [
            'product_name' => 'iPhone 15 Pro',
            'slug' => 'iphone-15-pro',
            'product_category' => 1, // Electronics
            'description' => 'Latest iPhone with advanced features',
            'short_description' => 'Premium smartphone with cutting-edge technology',
            'price' => 999.99,
            'stock_quantity' => 50,
            'sku' => 'IPH15PRO001',
            'status' => 'active',
            'featured' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'product_name' => 'MacBook Air M2',
            'slug' => 'macbook-air-m2',
            'product_category' => 1, // Electronics
            'description' => 'Lightweight laptop with powerful M2 chip',
            'short_description' => 'Perfect for work and creativity',
            'price' => 1199.99,
            'stock_quantity' => 25,
            'sku' => 'MBAIRM2001',
            'status' => 'active',
            'featured' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'product_name' => 'Men\'s Casual T-Shirt',
            'slug' => 'mens-casual-tshirt',
            'product_category' => 2, // Clothing
            'description' => 'Comfortable cotton t-shirt for everyday wear',
            'short_description' => 'Soft and breathable fabric',
            'price' => 24.99,
            'stock_quantity' => 100,
            'sku' => 'TSHIRT001',
            'status' => 'active',
            'featured' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'product_name' => 'Women\'s Jeans',
            'slug' => 'womens-jeans',
            'product_category' => 2, // Clothing
            'description' => 'Stylish and comfortable jeans for women',
            'short_description' => 'Perfect fit and modern style',
            'price' => 59.99,
            'stock_quantity' => 75,
            'sku' => 'JEANS001',
            'status' => 'active',
            'featured' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'product_name' => 'Programming Fundamentals Book',
            'slug' => 'programming-fundamentals',
            'product_category' => 3, // Books
            'description' => 'Learn the basics of programming',
            'short_description' => 'Perfect for beginners',
            'price' => 39.99,
            'stock_quantity' => 30,
            'sku' => 'BOOK001',
            'status' => 'active',
            'featured' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'product_name' => 'Garden Tool Set',
            'slug' => 'garden-tool-set',
            'product_category' => 4, // Home & Garden
            'description' => 'Complete set of essential garden tools',
            'short_description' => 'Everything you need for gardening',
            'price' => 89.99,
            'stock_quantity' => 20,
            'sku' => 'GARDEN001',
            'status' => 'active',
            'featured' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'product_name' => 'Basketball',
            'slug' => 'basketball',
            'product_category' => 5, // Sports
            'description' => 'Official size basketball for indoor/outdoor use',
            'short_description' => 'Professional quality basketball',
            'price' => 29.99,
            'stock_quantity' => 40,
            'sku' => 'BASKET001',
            'status' => 'active',
            'featured' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'product_name' => 'Wireless Headphones',
            'slug' => 'wireless-headphones',
            'product_category' => 1, // Electronics
            'description' => 'High-quality wireless headphones with noise cancellation',
            'short_description' => 'Crystal clear sound quality',
            'price' => 199.99,
            'stock_quantity' => 35,
            'sku' => 'HEADPH001',
            'status' => 'active',
            'featured' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]
    ];

    foreach ($products as $product) {
        $db->table('products')->insert($product);
        echo "✓ Added product: {$product['product_name']}<br>";
    }

    echo "<h2>✅ Data Insertion Complete!</h2>";
    echo "<p>Successfully added:</p>";
    echo "<ul>";
    echo "<li><strong>" . count($categories) . " Categories</strong></li>";
    echo "<li><strong>" . count($products) . " Products</strong></li>";
    echo "</ul>";

    echo "<h3>Test Your API:</h3>";
    echo "<ul>";
    echo "<li><a href='http://localhost:8080/store/categories' target='_blank'>Categories API</a></li>";
    echo "<li><a href='http://localhost:8080/store/products' target='_blank'>Products API</a></li>";
    echo "<li><a href='http://localhost:8080/store/' target='_blank'>Store Dashboard</a></li>";
    echo "</ul>";

} catch (Exception $e) {
    echo "<h2>❌ Error Occurred</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    echo "<p>Please check your database connection and try again.</p>";
}
?>
