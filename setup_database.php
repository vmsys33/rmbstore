<?php
/**
 * Database Setup Script for Store Website
 * 
 * This script will help you set up the database for your store website.
 * Run this script in your browser or command line.
 */

echo "<h1>Store Website Database Setup</h1>\n";
echo "<p>Follow these steps to set up your database:</p>\n\n";

echo "<h2>Step 1: Create Database</h2>\n";
echo "<ol>\n";
echo "<li>Open phpMyAdmin: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a></li>\n";
echo "<li>Click 'New' to create a new database</li>\n";
echo "<li>Enter database name: <strong>rmbstore</strong></li>\n";
echo "<li>Click 'Create'</li>\n";
echo "</ol>\n\n";

echo "<h2>Step 2: Configure Environment</h2>\n";
echo "<p>Update your <code>.env</code> file with these database settings:</p>\n";
echo "<pre>\n";
echo "database.default.hostname = localhost\n";
echo "database.default.database = rmbstore\n";
echo "database.default.username = root\n";
echo "database.default.password = \n";
echo "database.default.DBDriver = MySQLi\n";
echo "database.default.DBPrefix = \n";
echo "database.default.port = 3306\n";
echo "</pre>\n\n";

echo "<h2>Step 3: Run Migrations</h2>\n";
echo "<p>Open your terminal/command prompt and run:</p>\n";
echo "<pre>php spark migrate</pre>\n\n";

echo "<h2>Step 4: Seed Database</h2>\n";
echo "<p>After migrations, run the seeder:</p>\n";
echo "<pre>php spark db:seed StoreSeeder</pre>\n\n";

echo "<h2>Step 5: Test Your API</h2>\n";
echo "<p>Test these endpoints in your browser:</p>\n";
echo "<ul>\n";
echo "<li><a href='http://localhost:8080/store/' target='_blank'>Store Dashboard</a></li>\n";
echo "<li><a href='http://localhost:8080/store/products' target='_blank'>Products API</a></li>\n";
echo "<li><a href='http://localhost:8080/store/categories' target='_blank'>Categories API</a></li>\n";
echo "<li><a href='http://localhost:8080/store/users' target='_blank'>Users API</a></li>\n";
echo "<li><a href='http://localhost:8080/store/stats' target='_blank'>Store Statistics</a></li>\n";
echo "</ul>\n\n";

echo "<h2>Database Structure</h2>\n";
echo "<h3>Users Table</h3>\n";
echo "<ul>\n";
echo "<li>id (Primary Key)</li>\n";
echo "<li>username (Unique)</li>\n";
echo "<li>email (Unique)</li>\n";
echo "<li>password (Hashed)</li>\n";
echo "<li>first_name</li>\n";
echo "<li>last_name</li>\n";
echo "<li>phone</li>\n";
echo "<li>address</li>\n";
echo "<li>role (admin/customer/staff)</li>\n";
echo "<li>status (active/inactive/banned)</li>\n";
echo "<li>email_verified_at</li>\n";
echo "<li>created_at</li>\n";
echo "<li>updated_at</li>\n";
echo "</ul>\n\n";

echo "<h3>Categories Table</h3>\n";
echo "<ul>\n";
echo "<li>id (Primary Key)</li>\n";
echo "<li>name (Unique)</li>\n";
echo "<li>slug (Unique, Auto-generated)</li>\n";
echo "<li>description</li>\n";
echo "<li>image</li>\n";
echo "<li>parent_id (Self-referencing for subcategories)</li>\n";
echo "<li>sort_order</li>\n";
echo "<li>status (active/inactive)</li>\n";
echo "<li>created_at</li>\n";
echo "<li>updated_at</li>\n";
echo "</ul>\n\n";

echo "<h3>Products Table</h3>\n";
echo "<ul>\n";
echo "<li>id (Primary Key)</li>\n";
echo "<li>product_name</li>\n";
echo "<li>slug (Unique, Auto-generated)</li>\n";
echo "<li>product_category (Foreign Key to categories)</li>\n";
echo "<li>description</li>\n";
echo "<li>short_description</li>\n";
echo "<li>price</li>\n";
echo "<li>sale_price</li>\n";
echo "<li>stock_quantity</li>\n";
echo "<li>sku (Unique, Auto-generated)</li>\n";
echo "<li>weight</li>\n";
echo "<li>dimensions</li>\n";
echo "<li>featured_image</li>\n";
echo "<li>gallery_images</li>\n";
echo "<li>meta_title</li>\n";
echo "<li>meta_description</li>\n";
echo "<li>meta_keywords</li>\n";
echo "<li>status (active/inactive/draft)</li>\n";
echo "<li>featured (boolean)</li>\n";
echo "<li>created_at</li>\n";
echo "<li>updated_at</li>\n";
echo "</ul>\n\n";

echo "<h2>Sample Data</h2>\n";
echo "<p>The seeder will create:</p>\n";
echo "<ul>\n";
echo "<li><strong>3 Users:</strong> Admin, Customer, Staff</li>\n";
echo "<li><strong>9 Categories:</strong> Electronics, Clothing, Books, Home & Garden, Sports (with subcategories)</li>\n";
echo "<li><strong>8 Products:</strong> iPhone, MacBook, Clothing, Books, Garden Tools, Basketball, etc.</li>\n";
echo "</ul>\n\n";

echo "<h2>Login Credentials</h2>\n";
echo "<table border='1' style='border-collapse: collapse; width: 100%;'>\n";
echo "<tr><th>Role</th><th>Username</th><th>Email</th><th>Password</th></tr>\n";
echo "<tr><td>Admin</td><td>admin</td><td>admin@store.com</td><td>admin123</td></tr>\n";
echo "<tr><td>Customer</td><td>customer1</td><td>customer1@store.com</td><td>customer123</td></tr>\n";
echo "<tr><td>Staff</td><td>staff1</td><td>staff1@store.com</td><td>staff123</td></tr>\n";
echo "</table>\n\n";

echo "<h2>API Endpoints</h2>\n";
echo "<table border='1' style='border-collapse: collapse; width: 100%;'>\n";
echo "<tr><th>Method</th><th>Endpoint</th><th>Description</th></tr>\n";
echo "<tr><td>GET</td><td>/store/</td><td>Store Dashboard</td></tr>\n";
echo "<tr><td>GET</td><td>/store/stats</td><td>Store Statistics</td></tr>\n";
echo "<tr><td>GET</td><td>/store/products</td><td>Get All Products</td></tr>\n";
echo "<tr><td>GET</td><td>/store/products/{id}</td><td>Get Specific Product</td></tr>\n";
echo "<tr><td>POST</td><td>/store/products</td><td>Create New Product</td></tr>\n";
echo "<tr><td>GET</td><td>/store/categories</td><td>Get All Categories</td></tr>\n";
echo "<tr><td>GET</td><td>/store/categories/{id}</td><td>Get Specific Category</td></tr>\n";
echo "<tr><td>POST</td><td>/store/categories</td><td>Create New Category</td></tr>\n";
echo "<tr><td>GET</td><td>/store/users</td><td>Get All Users</td></tr>\n";
echo "<tr><td>GET</td><td>/store/users/{id}</td><td>Get Specific User</td></tr>\n";
echo "<tr><td>GET</td><td>/store/search?q={term}</td><td>Search Products</td></tr>\n";
echo "</table>\n\n";

echo "<h2>Next Steps</h2>\n";
echo "<ol>\n";
echo "<li>Create the database in phpMyAdmin</li>\n";
echo "<li>Update your .env file with the database settings</li>\n";
echo "<li>Run the migrations: <code>php spark migrate</code></li>\n";
echo "<li>Seed the database: <code>php spark db:seed StoreSeeder</code></li>\n";
echo "<li>Test the API endpoints</li>\n";
echo "<li>Start building your store frontend!</li>\n";
echo "</ol>\n\n";

echo "<p><strong>Note:</strong> Make sure your XAMPP server is running and the CodeIgniter development server is started with <code>php spark serve</code></p>\n";

echo "<hr>\n";
echo "<p><em>Store Website Database Setup Complete!</em></p>\n";
?>
