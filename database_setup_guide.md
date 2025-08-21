# Store Website Database Setup Guide

## ✅ Step 1: Database Created
You have successfully created the `rmbstore` database in phpMyAdmin.

## 🔧 Step 2: Configure Environment File

Create or update your `.env` file in the project root with these database settings:

```env
# Database Configuration
database.default.hostname = localhost
database.default.database = rmbstore
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix = 
database.default.port = 3306
database.default.charset = utf8mb4
database.default.DBCollat = utf8mb4_general_ci

# Environment
CI_ENVIRONMENT = development
```

## 🚀 Step 3: Run Database Commands

Open your terminal/command prompt in the project directory and run these commands:

### 3.1 Run Migrations (Create Tables)
```bash
php spark migrate
```

This will create:
- `users` table
- `categories` table  
- `products` table

### 3.2 Seed Database (Add Sample Data)
```bash
php spark db:seed StoreSeeder
```

This will add:
- 3 Users (Admin, Customer, Staff)
- 9 Categories (Electronics, Clothing, Books, etc.)
- 8 Products (iPhone, MacBook, etc.)

## 🧪 Step 4: Test Your Store API

After running the commands, test these endpoints:

### Store Dashboard
- **URL**: http://localhost:8080/store/
- **Description**: Main store dashboard with statistics

### Products API
- **URL**: http://localhost:8080/store/products
- **Description**: Get all products

### Categories API  
- **URL**: http://localhost:8080/store/categories
- **Description**: Get all categories

### Users API
- **URL**: http://localhost:8080/store/users
- **Description**: Get all users

### Store Statistics
- **URL**: http://localhost:8080/store/stats
- **Description**: Get store statistics

## 👤 Login Credentials

### Admin User
- **Username**: admin
- **Email**: admin@store.com
- **Password**: admin123

### Customer User
- **Username**: customer1
- **Email**: customer1@store.com
- **Password**: customer123

### Staff User
- **Username**: staff1
- **Email**: staff1@store.com
- **Password**: staff123

## 📊 Database Structure

### Users Table
- id (Primary Key)
- username (Unique)
- email (Unique)
- password (Hashed)
- first_name, last_name
- phone, address
- role (admin/customer/staff)
- status (active/inactive/banned)
- email_verified_at
- created_at, updated_at

### Categories Table
- id (Primary Key)
- name (Unique)
- slug (Unique, Auto-generated)
- description
- image
- parent_id (Self-referencing for subcategories)
- sort_order
- status (active/inactive)
- created_at, updated_at

### Products Table
- id (Primary Key)
- product_name
- slug (Unique, Auto-generated)
- product_category (Foreign Key to categories)
- description, short_description
- price, sale_price
- stock_quantity
- sku (Unique, Auto-generated)
- weight, dimensions
- featured_image, gallery_images
- meta_title, meta_description, meta_keywords
- status (active/inactive/draft)
- featured (boolean)
- created_at, updated_at

## 🔍 Troubleshooting

### If migrations fail:
1. Check database connection in `.env` file
2. Ensure MySQL service is running
3. Verify database `rmbstore` exists
4. Check user permissions

### If seeder fails:
1. Ensure migrations ran successfully
2. Check for duplicate data
3. Verify model validation rules

## 📝 Next Steps

1. ✅ Create database (DONE)
2. 🔧 Configure .env file
3. 🚀 Run migrations
4. 🌱 Seed database
5. 🧪 Test API endpoints
6. 🎨 Build frontend interface

## 🆘 Need Help?

If you encounter any issues:
1. Check the terminal output for error messages
2. Verify all configuration settings
3. Ensure XAMPP services are running
4. Check CodeIgniter logs in `writable/logs/`

---
**Store Website Database Setup Complete!** 🎉
