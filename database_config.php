<?php
/**
 * Database Configuration for Store Website
 * 
 * This file contains the database setup instructions and configuration
 * for the CodeIgniter 4 store application.
 */

// Database Configuration
$database_config = [
    'hostname' => 'localhost',
    'username' => 'root',           // Default XAMPP username
    'password' => '',               // Default XAMPP password (empty)
    'database' => 'rmbstore',       // Database name for your store
    'DBDriver' => 'MySQLi',
    'DBPrefix' => '',
    'port' => 3306,
    'charset' => 'utf8mb4',
    'DBCollat' => 'utf8mb4_general_ci',
];

// Instructions for setting up the database:
echo "=== STORE WEBSITE DATABASE SETUP ===\n\n";

echo "1. Open phpMyAdmin (http://localhost/phpmyadmin)\n";
echo "2. Create a new database named: 'rmbstore'\n";
echo "3. Use the following configuration in your .env file:\n\n";

echo "database.default.hostname = localhost\n";
echo "database.default.database = rmbstore\n";
echo "database.default.username = root\n";
echo "database.default.password = \n";
echo "database.default.DBDriver = MySQLi\n";
echo "database.default.DBPrefix = \n";
echo "database.default.port = 3306\n\n";

echo "4. After creating the database, run these commands:\n";
echo "   php spark migrate\n";
echo "   php spark db:seed StoreSeeder\n\n";

echo "5. Test the API endpoints:\n";
echo "   - Store Dashboard: http://localhost:8080/store/\n";
echo "   - Products API: http://localhost:8080/store/products\n";
echo "   - Categories API: http://localhost:8080/store/categories\n";
echo "   - Users API: http://localhost:8080/store/users\n\n";

echo "=== DATABASE TABLES TO BE CREATED ===\n";
echo "- users (id, username, email, password, first_name, last_name, phone, address, role, status, etc.)\n";
echo "- categories (id, name, slug, description, image, parent_id, sort_order, status, etc.)\n";
echo "- products (id, product_name, slug, product_category, description, price, stock_quantity, etc.)\n\n";

echo "=== SAMPLE DATA INCLUDED ===\n";
echo "- 3 Users (Admin, Customer, Staff)\n";
echo "- 9 Categories (Electronics, Clothing, Books, etc.)\n";
echo "- 8 Products (iPhone, MacBook, Clothing, etc.)\n\n";

echo "=== API ENDPOINTS AVAILABLE ===\n";
echo "GET  /store/              - Store Dashboard\n";
echo "GET  /store/stats         - Store Statistics\n";
echo "GET  /store/products      - Get All Products\n";
echo "GET  /store/products/{id} - Get Specific Product\n";
echo "POST /store/products      - Create New Product\n";
echo "GET  /store/categories    - Get All Categories\n";
echo "GET  /store/categories/{id} - Get Specific Category\n";
echo "POST /store/categories    - Create New Category\n";
echo "GET  /store/users         - Get All Users\n";
echo "GET  /store/users/{id}    - Get Specific User\n";
echo "GET  /store/search?q={term} - Search Products\n\n";

echo "=== LOGIN CREDENTIALS ===\n";
echo "Admin User:\n";
echo "  Username: admin\n";
echo "  Email: admin@store.com\n";
echo "  Password: admin123\n\n";

echo "Customer User:\n";
echo "  Username: customer1\n";
echo "  Email: customer1@store.com\n";
echo "  Password: customer123\n\n";

echo "Staff User:\n";
echo "  Username: staff1\n";
echo "  Email: staff1@store.com\n";
echo "  Password: staff123\n\n";

echo "=== NEXT STEPS ===\n";
echo "1. Create the database in phpMyAdmin\n";
echo "2. Update your .env file with the database settings\n";
echo "3. Run the migrations and seeders\n";
echo "4. Test the API endpoints\n";
echo "5. Start building your store frontend!\n\n";

echo "For more help, check the CodeIgniter 4 documentation: https://codeigniter.com/user_guide/\n";
?>
