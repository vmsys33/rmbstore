@echo off
echo ========================================
echo    Store Website Database Setup
echo ========================================
echo.

echo Step 1: Checking PHP installation...
php --version
if %errorlevel% neq 0 (
    echo ERROR: PHP is not installed or not in PATH
    echo Please install PHP or add it to your PATH
    pause
    exit /b 1
)
echo.

echo Step 2: Checking Composer installation...
composer --version
if %errorlevel% neq 0 (
    echo ERROR: Composer is not installed or not in PATH
    echo Please install Composer or add it to your PATH
    pause
    exit /b 1
)
echo.

echo Step 3: Running database migrations...
echo Creating database tables...
php spark migrate
if %errorlevel% neq 0 (
    echo ERROR: Migrations failed
    echo Please check your database configuration
    pause
    exit /b 1
)
echo.

echo Step 4: Seeding database with sample data...
echo Adding sample users, categories, and products...
php spark db:seed StoreSeeder
if %errorlevel% neq 0 (
    echo ERROR: Seeding failed
    echo Please check if migrations ran successfully
    pause
    exit /b 1
)
echo.

echo ========================================
echo    Setup Complete!
echo ========================================
echo.
echo Your store database has been set up successfully!
echo.
echo Test these URLs in your browser:
echo - Store Dashboard: http://localhost:8080/store/
echo - Products API: http://localhost:8080/store/products
echo - Categories API: http://localhost:8080/store/categories
echo - Users API: http://localhost:8080/store/users
echo.
echo Login Credentials:
echo - Admin: admin / admin123
echo - Customer: customer1 / customer123
echo - Staff: staff1 / staff123
echo.
pause
