<?php
/**
 * Stock on Hand System Setup Script
 * Run this script to set up the stock management system
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmbstore';

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to database successfully\n";
    
    // Read and execute SQL file
    $sqlFile = 'database_stock_on_hand.sql';
    
    if (!file_exists($sqlFile)) {
        echo "❌ SQL file not found: $sqlFile\n";
        exit(1);
    }
    
    $sql = file_get_contents($sqlFile);
    
    // Split SQL into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    echo "📋 Executing database setup...\n";
    
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            try {
                $pdo->exec($statement);
                echo "✅ Executed: " . substr($statement, 0, 50) . "...\n";
            } catch (PDOException $e) {
                // Skip if table/view already exists
                if (strpos($e->getMessage(), 'already exists') !== false) {
                    echo "⚠️  Skipped (already exists): " . substr($statement, 0, 50) . "...\n";
                } else {
                    echo "❌ Error: " . $e->getMessage() . "\n";
                }
            }
        }
    }
    
    echo "\n🎉 Stock on Hand system setup completed!\n";
    echo "\n📊 What was created:\n";
    echo "   • stock_on_hand table\n";
    echo "   • product_stock_summary view\n";
    echo "   • Updated products and sales tables\n";
    echo "\n🔗 Access the system at:\n";
    echo "   • Stock Summary: /admin/stock-on-hand\n";
    echo "   • Add stock in product edit page\n";
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>
