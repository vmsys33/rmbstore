# Manual Database Setup Instructions

## 🚨 **IMPORTANT: Terminal Issues Detected**

Since the terminal is not responding and the `.env` file is blocked, follow these manual steps:

## 📝 **Step 1: Create .env File Manually**

1. **Open Notepad** or any text editor
2. **Create a new file** in your project root directory (`C:\xampp\htdocs\rmbstore\`)
3. **Save it as `.env`** (with the dot, no extension)
4. **Copy and paste this content:**

```env
#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------
CI_ENVIRONMENT = development

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------
app.baseURL = 'http://localhost:8080/'
app.indexPage = ''
app.appTimezone = 'Asia/Jakarta'

#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------
database.default.hostname = localhost
database.default.database = rmbstore
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix = 
database.default.port = 3306
database.default.charset = utf8mb4
database.default.DBCollat = utf8mb4_general_ci
```

## 🖥️ **Step 2: Open Command Prompt**

1. **Press `Windows + R`**
2. **Type `cmd`** and press Enter
3. **Navigate to your project:**
   ```cmd
   cd C:\xampp\htdocs\rmbstore
   ```

## 🚀 **Step 3: Run Database Commands**

### 3.1 Check PHP Installation
```cmd
php --version
```

### 3.2 Run Migrations (Create Tables)
```cmd
php spark migrate
```

**Expected Output:**
```
Running: 2025-08-12-063107_CreateUsersTable
Running: 2025-08-12-063108_CreateCategoriesTable  
Running: 2025-08-12-063109_CreateProductsTable
Done.
```

### 3.3 Seed Database (Add Sample Data)
```cmd
php spark db:seed StoreSeeder
```

**Expected Output:**
```
Seeding: StoreSeeder
Done.
```

## 🧪 **Step 4: Test Your Store**

After successful setup, test these URLs in your browser:

### Store Dashboard
- **URL**: http://localhost:8080/store/
- **Expected**: JSON response with store statistics

### Products API
- **URL**: http://localhost:8080/store/products
- **Expected**: JSON array of products

### Categories API
- **URL**: http://localhost:8080/store/categories
- **Expected**: JSON array of categories

### Users API
- **URL**: http://localhost:8080/store/users
- **Expected**: JSON array of users

## 🔍 **Troubleshooting**

### If "php" command not found:
1. **Add PHP to PATH:**
   - Open System Properties → Advanced → Environment Variables
   - Add `C:\xampp\php` to PATH variable
   - Restart Command Prompt

### If database connection fails:
1. **Check XAMPP:**
   - Open XAMPP Control Panel
   - Start Apache and MySQL services
   - Verify MySQL is running on port 3306

### If migrations fail:
1. **Check database exists:**
   - Open phpMyAdmin: http://localhost/phpmyadmin
   - Verify `rmbstore` database exists
   - Check user permissions

### If seeder fails:
1. **Check migrations ran:**
   - Look for error messages
   - Verify tables were created in phpMyAdmin

## 📊 **Database Structure Created**

### Users Table
- id, username, email, password
- first_name, last_name, phone, address
- role, status, email_verified_at
- created_at, updated_at

### Categories Table
- id, name, slug, description
- image, parent_id, sort_order, status
- created_at, updated_at

### Products Table
- id, product_name, slug, product_category
- description, price, stock_quantity
- featured_image, status, featured
- created_at, updated_at

## 👤 **Sample Login Credentials**

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

## ✅ **Success Indicators**

1. **Migrations successful**: No error messages
2. **Seeder successful**: "Done." message
3. **API endpoints working**: JSON responses in browser
4. **Database tables visible**: Check phpMyAdmin

## 🆘 **Need Help?**

If you encounter issues:
1. **Check XAMPP services** are running
2. **Verify database connection** in .env file
3. **Look for error messages** in command prompt
4. **Check CodeIgniter logs** in `writable/logs/`

---
**Follow these steps carefully and your store database will be ready!** 🎉
