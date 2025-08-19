# POS System Documentation

## 📋 Table of Contents
1. [System Overview](#system-overview)
2. [Database Structure](#database-structure)
3. [Setup Instructions](#setup-instructions)
4. [Key Features](#key-features)
5. [Inventory Management](#inventory-management)
6. [Troubleshooting Guide](#troubleshooting-guide)
7. [Code Structure](#code-structure)
8. [Best Practices](#best-practices)

---

## 🎯 System Overview

### What is this POS System?
A complete Point of Sale system built with CodeIgniter 4 that handles:
- **Product Management**: Add, edit, and manage products with images
- **Sales Processing**: Process transactions with multiple payment methods
- **Inventory Tracking**: Real-time stock management and updates
- **Transaction History**: Complete sales records and reporting
- **Receipt Generation**: Print and preview receipts

### Key Components
- **Frontend**: HTML/CSS/JavaScript with responsive design
- **Backend**: CodeIgniter 4 PHP framework
- **Database**: MySQL with proper relationships
- **Features**: Autosuggest, real-time inventory, transaction history

---

## 🗄️ Database Structure

### Core Tables

#### 1. `products` Table
```sql
- id (Primary Key)
- product_name
- slug
- product_category
- description
- short_description
- price
- sale_price
- stock_quantity
- sku
- status
- image_icon
- image_post
- created_at
- updated_at
```

#### 2. `sales` Table
```sql
- id (Primary Key)
- sale_number (Auto-generated: YYYYMMDD0001)
- customer_name
- customer_email
- customer_phone
- subtotal
- tax_amount
- discount_amount
- total_amount
- payment_method (cash, card, bank_transfer, online)
- payment_status (pending, paid, failed, refunded)
- sale_status (completed, cancelled, refunded)
- notes
- sold_by (admin_id)
- created_at
- updated_at
```

#### 3. `sale_items` Table
```sql
- id (Primary Key)
- sale_id (Foreign Key to sales)
- product_id (Foreign Key to products)
- product_name
- product_sku
- quantity
- unit_price
- discount_percent
- discount_amount
- subtotal
- total_amount
- created_at
- updated_at
```

#### 4. `inventory` Table
```sql
- id (Primary Key)
- product_id (Foreign Key to products)
- batch_number
- quantity
- reserved_quantity
- available_quantity
- unit_cost
- delivery_date
- expiry_date
- supplier_name
- supplier_contact
- status (active, inactive, expired)
- notes
- created_at
- updated_at
```

#### 5. `inventory_transactions` Table
```sql
- id (Primary Key)
- product_id (Foreign Key to products)
- inventory_id (Foreign Key to inventory)
- transaction_type (in, out, reserve, release, adjustment)
- quantity
- unit_cost
- total_cost
- reference_type (sale, purchase, adjustment)
- reference_id
- reference_number
- batch_number
- notes
- performed_by
- created_at
- updated_at
```

---

## ⚙️ Setup Instructions

### 1. Database Setup
```bash
# Run all migrations
php spark migrate

# Seed initial data
php spark db:seed ProductSeeder
php spark db:seed InventorySeeder
```

### 2. Inventory Population
**CRITICAL**: The POS system requires complete inventory data to function properly.

```bash
# Populate inventory for all products
php spark db:seed InventorySeeder
```

### 3. Access the POS
- **URL**: `http://localhost:8080/admin/pos`
- **Requirements**: Must be logged in as admin

---

## 🚀 Key Features

### 1. Product Search & Autosuggest
- **Real-time search** as you type
- **Product images** with fallback handling
- **Price display** in suggestions
- **Click to add** products to cart

### 2. Shopping Cart Management
- **Add products** with quantity controls
- **Remove items** individually
- **Update quantities** with +/- buttons
- **Real-time total calculation**

### 3. Payment Processing
- **Multiple payment methods**: Cash, Card, Bank Transfer, Online
- **Tax calculation** (12% default)
- **Discount handling**
- **Receipt generation**

### 4. Inventory Integration
- **Stock validation** before sale
- **Automatic deduction** after successful sale
- **Reservation system** during transaction
- **Transaction logging** for audit trail

### 5. Transaction History
- **Recent sales** display
- **Sale details** with items
- **Preview functionality**
- **Print receipts**

---

## 📦 Inventory Management

### Why Inventory is Critical
The POS system **requires** complete inventory data because:

1. **Availability Checks**: Verifies stock before allowing sales
2. **Quantity Validation**: Prevents overselling
3. **Stock Updates**: Automatically deducts sold quantities
4. **Audit Trail**: Tracks all inventory movements

### Inventory Seeder Details
```php
// Creates inventory records for all products
- Batch Number: BATCH-YYYYMMDD-XXX
- Quantity: Based on product stock_quantity or default 50
- Unit Cost: 60% of selling price
- Status: Active
- Expiry: 1 year from creation
```

### Manual Inventory Management
```sql
-- Check inventory for a product
SELECT * FROM inventory WHERE product_id = [PRODUCT_ID];

-- Add inventory manually
INSERT INTO inventory (product_id, batch_number, quantity, unit_cost, status) 
VALUES ([PRODUCT_ID], 'BATCH-001', 100, 25.00, 'active');
```

---

## 🔧 Troubleshooting Guide

### Common Issues & Solutions

#### 1. "Transaction failed" Error
**Cause**: Missing inventory data
**Solution**: 
```bash
php spark db:seed InventorySeeder
```

#### 2. "Insufficient inventory" Error
**Cause**: Not enough stock for requested quantity
**Solution**: 
- Check inventory levels
- Add more inventory
- Reduce sale quantity

#### 3. Autosuggest Not Working
**Cause**: JavaScript not loading
**Solution**: 
- Check browser console for errors
- Verify `custom_scripts` section in layout
- Clear browser cache

#### 4. Product Images Not Displaying
**Cause**: Incorrect image paths
**Solution**: 
- Check `uploads/products/icons/` directory
- Verify image file exists
- Check path construction in code

#### 5. Session Issues
**Cause**: Admin not logged in
**Solution**: 
- Login as admin first
- Check session configuration
- Verify admin_id exists

### Debug Mode
Enable detailed error logging:
```php
// In app/Config/App.php
public $appTimezone = 'Asia/Manila';
public $charset = 'UTF-8';
public $forceGlobalSecureRequests = false;

// Enable debug
public $displayErrors = true;
```

---

## 📁 Code Structure

### Key Files

#### 1. Controller: `app/Controllers/PosController.php`
- **Main POS logic**
- **Sales processing**
- **Inventory management**
- **AJAX endpoints**

#### 2. View: `app/Views/pos/pos_interface.php`
- **POS interface HTML**
- **JavaScript functionality**
- **CSS styling**
- **Responsive design**

#### 3. Models
- **`SaleModel.php`**: Sales management
- **`SaleItemModel.php`**: Sale items
- **`InventoryModel.php`**: Inventory operations
- **`InventoryTransactionModel.php`**: Transaction logging

#### 4. JavaScript Functions
```javascript
// Key functions in pos_interface.php
- selectProduct(productId)     // Add product to cart
- updateQuantity(productId, change)  // Change quantity
- removeProduct(productId)     // Remove from cart
- processPayment(method)       // Process sale
- loadTransactions()          // Load sale history
- printReceipt()             // Generate receipt
```

---

## ✅ Best Practices

### 1. Inventory Management
- ✅ **Always maintain accurate inventory**
- ✅ **Run inventory seeder after adding products**
- ✅ **Check stock levels regularly**
- ✅ **Use batch numbers for tracking**

### 2. Data Validation
- ✅ **Validate all inputs**
- ✅ **Check inventory before sales**
- ✅ **Handle edge cases**
- ✅ **Log all transactions**

### 3. Error Handling
- ✅ **Use try-catch blocks**
- ✅ **Provide meaningful error messages**
- ✅ **Log errors for debugging**
- ✅ **Graceful degradation**

### 4. Security
- ✅ **Validate user permissions**
- ✅ **Sanitize all inputs**
- ✅ **Use CSRF protection**
- ✅ **Secure session management**

### 5. Performance
- ✅ **Optimize database queries**
- ✅ **Use proper indexing**
- ✅ **Cache frequently accessed data**
- ✅ **Minimize AJAX calls**

---

## 🚨 Critical Notes

### 1. Inventory Requirements
**NEVER** run the POS without complete inventory data. This will cause:
- Transaction failures
- System errors
- Data inconsistency

### 2. Database Backups
Always backup your database before:
- Running migrations
- Making structural changes
- Updating inventory

### 3. Testing
Test thoroughly before going live:
- Add products to cart
- Process payments
- Check inventory updates
- Verify transaction history

### 4. Monitoring
Regular monitoring is essential:
- Check error logs
- Monitor inventory levels
- Review transaction history
- Verify data integrity

---

## 📞 Support

### When You Need Help
1. **Check this documentation first**
2. **Review error logs** in `writable/logs/`
3. **Test with sample data**
4. **Verify database integrity**

### Common Commands
```bash
# Check migration status
php spark migrate:status

# Run specific seeder
php spark db:seed InventorySeeder

# Clear cache
php spark cache:clear

# Check routes
php spark routes
```

---

**Last Updated**: August 17, 2025
**Version**: 1.0
**Author**: POS System Development Team
