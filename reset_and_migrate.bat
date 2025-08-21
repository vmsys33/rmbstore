@echo off
echo ========================================
echo    Reset and Migrate Database
echo ========================================
echo.

echo Step 1: Resetting migrations...
php spark migrate:rollback
if %errorlevel% neq 0 (
    echo WARNING: Rollback failed, continuing anyway...
)
echo.

echo Step 2: Running fresh migrations...
php spark migrate
if %errorlevel% neq 0 (
    echo ERROR: Migrations failed
    echo Please check the error messages above
    pause
    exit /b 1
)
echo.

echo Step 3: Seeding database with sample data...
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
