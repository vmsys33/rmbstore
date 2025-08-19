<?php
/**
 * Simple Data Insertion Script
 * 
 * Run this script directly: php insert_data.php
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmbstore';

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Store Database Data Insertion ===\n\n";
    
    // Step 1: Insert Categories
    echo "Step 1: Inserting Categories...\n";
    
    $categories = [
        ['Electronics', 'electronics', 'Latest electronic gadgets and devices'],
        ['Clothing', 'clothing', 'Fashion and apparel for all ages'],
        ['Books', 'books', 'Books for education and entertainment'],
        ['Home & Garden', 'home-garden', 'Home improvement and garden supplies'],
        ['Sports', 'sports', 'Sports equipment and accessories']
    ];
    
    $categoryStmt = $pdo->prepare("INSERT INTO categories (name, slug, description, status, created_at, updated_at) VALUES (?, ?, ?, 'active', NOW(), NOW())");
    
    foreach ($categories as $category) {
        $categoryStmt->execute($category);
        echo "✓ Added category: {$category[0]}\n";
    }
    
    // Step 2: Insert Products
    echo "\nStep 2: Inserting Products...\n";
    
    $products = [
        ['iPhone 15 Pro', 'iphone-15-pro', 1, 'Latest iPhone with advanced features', 'Premium smartphone with cutting-edge technology', 999.99, 50, 'IPH15PRO001', 1],
        ['MacBook Air M2', 'macbook-air-m2', 1, 'Lightweight laptop with powerful M2 chip', 'Perfect for work and creativity', 1199.99, 25, 'MBAIRM2001', 1],
        ['Men\'s Casual T-Shirt', 'mens-casual-tshirt', 2, 'Comfortable cotton t-shirt for everyday wear', 'Soft and breathable fabric', 24.99, 100, 'TSHIRT001', 0],
        ['Women\'s Jeans', 'womens-jeans', 2, 'Stylish and comfortable jeans for women', 'Perfect fit and modern style', 59.99, 75, 'JEANS001', 0],
        ['Programming Fundamentals Book', 'programming-fundamentals', 3, 'Learn the basics of programming', 'Perfect for beginners', 39.99, 30, 'BOOK001', 0],
        ['Garden Tool Set', 'garden-tool-set', 4, 'Complete set of essential garden tools', 'Everything you need for gardening', 89.99, 20, 'GARDEN001', 0],
        ['Basketball', 'basketball', 5, 'Official size basketball for indoor/outdoor use', 'Professional quality basketball', 29.99, 40, 'BASKET001', 0],
        ['Wireless Headphones', 'wireless-headphones', 1, 'High-quality wireless headphones with noise cancellation', 'Crystal clear sound quality', 199.99, 35, 'HEADPH001', 1]
    ];
    
    $productStmt = $pdo->prepare("INSERT INTO products (product_name, slug, product_category, description, short_description, price, stock_quantity, sku, featured, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', NOW(), NOW())");
    
    foreach ($products as $product) {
        $productStmt->execute($product);
        echo "✓ Added product: {$product[0]}\n";
    }
    
    // Step 3: Insert Product Images
    echo "\nStep 3: Inserting Product Images...\n";
    
    $productImages = [
        // iPhone 15 Pro images
        [1, '/assets/img/products/iphone-15-pro-main.jpg', 'iPhone 15 Pro Main', 'iPhone 15 Pro main image', 1, 1],
        [1, '/assets/img/products/iphone-15-pro-side.jpg', 'iPhone 15 Pro Side', 'iPhone 15 Pro side view', 2, 0],
        [1, '/assets/img/products/iphone-15-pro-back.jpg', 'iPhone 15 Pro Back', 'iPhone 15 Pro back view', 3, 0],
        
        // MacBook Air M2 images
        [2, '/assets/img/products/macbook-air-m2-main.jpg', 'MacBook Air M2 Main', 'MacBook Air M2 main image', 1, 1],
        [2, '/assets/img/products/macbook-air-m2-keyboard.jpg', 'MacBook Air M2 Keyboard', 'MacBook Air M2 keyboard view', 2, 0],
        
        // T-Shirt images
        [3, '/assets/img/products/tshirt-main.jpg', 'Men\'s T-Shirt Main', 'Men\'s casual t-shirt main image', 1, 1],
        [3, '/assets/img/products/tshirt-detail.jpg', 'Men\'s T-Shirt Detail', 'Men\'s casual t-shirt detail view', 2, 0],
        
        // Jeans images
        [4, '/assets/img/products/jeans-main.jpg', 'Women\'s Jeans Main', 'Women\'s jeans main image', 1, 1],
        
        // Book images
        [5, '/assets/img/products/book-main.jpg', 'Programming Book Main', 'Programming fundamentals book main image', 1, 1],
        
        // Garden tools images
        [6, '/assets/img/products/garden-tools-main.jpg', 'Garden Tools Main', 'Garden tool set main image', 1, 1],
        
        // Basketball images
        [7, '/assets/img/products/basketball-main.jpg', 'Basketball Main', 'Basketball main image', 1, 1],
        
        // Headphones images
        [8, '/assets/img/products/headphones-main.jpg', 'Wireless Headphones Main', 'Wireless headphones main image', 1, 1],
        [8, '/assets/img/products/headphones-side.jpg', 'Wireless Headphones Side', 'Wireless headphones side view', 2, 0],
    ];
    
    $imageStmt = $pdo->prepare("INSERT INTO product_images (product_id, image_path, image_name, alt_text, sort_order, is_primary, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, 'active', NOW(), NOW())");
    
    foreach ($productImages as $image) {
        $imageStmt->execute($image);
        echo "✓ Added image: {$image[2]} for product ID {$image[0]}\n";
    }
    
    echo "\n=== ✅ Data Insertion Complete! ===\n";
    echo "Successfully added:\n";
    echo "- " . count($categories) . " Categories\n";
    echo "- " . count($products) . " Products\n";
    echo "- " . count($productImages) . " Product Images\n\n";
    
    echo "Test your API endpoints:\n";
    echo "- Categories: http://localhost:8080/store/categories\n";
    echo "- Products: http://localhost:8080/store/products\n";
    echo "- Products with Images: http://localhost:8080/store/products-with-images\n";
    echo "- Product Images: http://localhost:8080/store/products/1/images\n";
    echo "- Dashboard: http://localhost:8080/store/\n";
    
} catch (PDOException $e) {
    echo "❌ Database Error: " . $e->getMessage() . "\n";
    echo "Please check your database connection and try again.\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
