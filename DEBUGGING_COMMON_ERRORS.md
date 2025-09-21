# 🚨 Common Debugging Errors & Solutions Guide

## **Overview**
This document serves as a quick reference for the most common and time-consuming debugging issues encountered during development. These errors are often hard to detect and can waste hours of development time.

---

## **🔴 CRITICAL: URL/Route Mismatches (Most Common)**

### **Problem Description**
Form submissions or links return 404 errors due to mismatched URLs between:
- Route definitions in `app/Config/Routes.php`
- Form `action` attributes in views
- Link `href` attributes in views

### **Symptoms**
- 404 "Page Not Found" errors
- Forms submit but don't reach the intended controller
- Navigation links redirect to wrong pages
- Silent failures with no error messages

### **Root Causes**
1. **Hardcoded paths** instead of using `base_url()` helper
2. **Missing route prefixes** (e.g., missing `/admin/` for admin routes)
3. **Copy-paste errors** from different contexts
4. **Route changes** without updating corresponding views

### **Debugging Steps**
1. **Check browser Network tab** - See what URL is actually being requested
2. **Check form `action` attribute** - Must match route exactly
3. **Check `Routes.php`** - Verify route exists and is correct
4. **Check `base_url()` usage** - Ensure no hardcoded paths
5. **Check route prefixes** - Admin vs. frontend routes

### **Examples**

#### ❌ **WRONG - Hardcoded paths**
```php
// View file
<form action="/products/store">
<a href="/admin/products">
```

#### ✅ **CORRECT - Using base_url() helper**
```php
// View file
<form action="<?= base_url('admin/products/store') ?>">
<a href="<?= base_url('admin/products') ?>">
```

### **Route Structure Reference**
```php
// Frontend Routes
$routes->get('products', 'FrontendController::products');
$routes->get('product/(:num)', 'FrontendController::product/$1');

// Admin Routes (Protected)
$routes->group('admin', ['filter' => 'adminAuth'], function($routes) {
    $routes->get('products', 'ProductsController::index');
    $routes->post('products/store', 'ProductsController::store');
    $routes->get('products/create', 'ProductsController::create');
});
```

### **Prevention Best Practices**
- **Never hardcode URLs** - Always use `base_url()` helper
- **Route naming convention** - Admin routes: `/admin/controller/action`
- **Consistent structure** - Keep all admin routes under `/admin/` prefix
- **Test navigation flow** - Click through all links to catch mismatches early

---

## **🔴 Database Connection Issues**

### **Problem Description**
Database connection failures preventing data operations.

### **Symptoms**
- "No connection could be made" errors
- Database queries failing
- Server logs showing connection refused

### **Debugging Steps**
1. **Check MySQL service status** - Ensure `mysqld` is running
2. **Verify database credentials** in `app/Config/Database.php`
3. **Check port configuration** - Default MySQL port is 3306
4. **Check firewall settings** - Ensure port isn't blocked

### **Common Solutions**
```bash
# Start MySQL service (Windows)
net start "MySQL"

# Check MySQL process
tasklist | findstr mysqld

# Test database connection
mysql -u root -p
```

---

## **🔴 JavaScript Library Loading Issues**

### **Problem Description**
JavaScript libraries (like Cropper.js) not loading before they're used.

### **Symptoms**
- "Cropper is not defined" errors
- Library functions unavailable
- Timing-related failures

### **Debugging Steps**
1. **Check CDN availability** - Verify external libraries are accessible
2. **Check loading order** - Ensure libraries load before usage
3. **Check network requests** - Verify files are downloaded successfully
4. **Check console errors** - Look for 404s or failed requests

### **Solutions**
```javascript
// Wait for library to be ready
class ImageCropper {
    constructor() {
        this.ready = false;
        this.init();
    }
    
    async waitForReady() {
        while (!this.ready || typeof Cropper === 'undefined') {
            await new Promise(resolve => setTimeout(resolve, 100));
        }
    }
    
    async show() {
        await this.waitForReady();
        // Proceed with library usage
    }
}
```

---

## **🔴 Form Submission Issues**

### **Problem Description**
Forms not submitting or data not reaching controllers.

### **Symptoms**
- Form submits but no data in controller
- JavaScript validation preventing submission
- Silent failures with no feedback

### **Debugging Steps**
1. **Check form `method`** - Must be POST for data submission
2. **Check form `enctype`** - Must be `multipart/form-data` for file uploads
3. **Check JavaScript validation** - Ensure it's not blocking submission
4. **Check browser console** - Look for JavaScript errors
5. **Check server logs** - Look for PHP errors or validation failures

### **Common Issues**
```php
// ❌ Missing enctype for file uploads
<form action="..." method="POST">

// ✅ Correct enctype for file uploads
<form action="..." method="POST" enctype="multipart/form-data">
```

---

## **🔴 File Upload Issues**

### **Problem Description**
Files not uploading or not being processed correctly.

### **Symptoms**
- Files appear to upload but aren't saved
- File size validation errors
- File type validation errors
- Upload directories not writable

### **Debugging Steps**
1. **Check file permissions** - Ensure upload directories are writable
2. **Check file size limits** - Verify PHP `upload_max_filesize` and `post_max_size`
3. **Check file type validation** - Ensure correct MIME type checking
4. **Check upload path** - Verify files are being saved to correct location

### **PHP Configuration Check**
```php
// Check upload settings
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "post_max_size: " . ini_get('post_max_size') . "\n";
echo "max_file_uploads: " . ini_get('max_file_uploads') . "\n";
```

---

## **🔴 Session & Authentication Issues**

### **Problem Description**
Users losing authentication or sessions not persisting.

### **Symptoms**
- Users logged out unexpectedly
- Session data not available
- Authentication checks failing

### **Debugging Steps**
1. **Check session configuration** in `app/Config/App.php`
2. **Check session storage** - File vs. database vs. Redis
3. **Check session lifetime** - Ensure sessions don't expire too quickly
4. **Check cookie settings** - Domain, path, secure flags

---

## **🔴 CSS/JavaScript Loading Issues**

### **Problem Description**
Styles or scripts not loading correctly.

### **Symptoms**
- Broken layouts
- Missing functionality
- Console errors about missing files

### **Debugging Steps**
1. **Check file paths** - Ensure assets are in correct directories
2. **Check base_url()** - Verify asset URLs are correct
3. **Check file permissions** - Ensure files are readable
4. **Check browser Network tab** - Verify files are being requested

---

## **🔴 Mobile/Responsive Issues**

### **Problem Description**
Functionality not working on mobile devices.

### **Symptoms**
- Touch events not responding
- Layout broken on small screens
- JavaScript errors on mobile browsers

### **Debugging Steps**
1. **Test on actual devices** - Don't rely only on browser dev tools
2. **Check viewport meta tag** - Ensure proper mobile rendering
3. **Check touch event handling** - Verify mobile-specific JavaScript
4. **Check CSS media queries** - Ensure responsive styles are applied

---

## **🔴 Performance Issues**

### **Problem Description**
Slow page loads or poor user experience.

### **Symptoms**
- Long loading times
- Unresponsive interface
- High memory usage

### **Debugging Steps**
1. **Check database queries** - Look for N+1 query problems
2. **Check asset loading** - Minimize HTTP requests
3. **Check caching** - Implement appropriate caching strategies
4. **Check server resources** - Monitor CPU, memory, and disk usage

---

## **🔴 Environment-Specific Issues**

### **Problem Description**
Issues that only occur in specific environments (development, staging, production).

### **Symptoms**
- Works locally but not on server
- Different behavior between environments
- Configuration-related errors

### **Debugging Steps**
1. **Check environment files** - `.env` vs. production settings
2. **Check server configuration** - Apache/Nginx settings
3. **Check PHP version** - Ensure compatibility
4. **Check database differences** - Schema, data, or configuration

---

## **🛠️ General Debugging Workflow**

### **1. Reproduce the Issue**
- Document exact steps to reproduce
- Note any error messages or unexpected behavior
- Check if issue is consistent or intermittent

### **2. Check Logs**
- **Browser Console** - JavaScript errors, network requests
- **Server Logs** - PHP errors, database errors
- **Application Logs** - CodeIgniter logs in `writable/logs/`

### **3. Isolate the Problem**
- Comment out suspect code sections
- Test individual components separately
- Use debugging tools (var_dump, console.log, etc.)

### **4. Verify Fixes**
- Test the specific issue
- Test related functionality
- Test in different browsers/devices if applicable

---

## **📚 Useful Debugging Tools**

### **Browser Tools**
- **Developer Tools** - Console, Network, Elements tabs
- **Extensions** - React DevTools, Vue DevTools, etc.

### **PHP Tools**
- **var_dump()** - Quick variable inspection
- **error_log()** - Write to server logs
- **Xdebug** - Advanced debugging and profiling

### **Database Tools**
- **phpMyAdmin** - Database inspection and query testing
- **MySQL Workbench** - Advanced database management

---

## **🚨 Emergency Debugging Checklist**

When facing a critical issue, check these in order:

1. **Check browser console** for JavaScript errors
2. **Check server logs** for PHP/database errors
3. **Verify file paths** and URL structures
4. **Check database connection** and service status
5. **Verify form submissions** and data flow
6. **Check file permissions** for uploads and logs
7. **Verify environment configuration** and settings

---

## **💡 Prevention Tips**

1. **Use framework helpers** - Always use `base_url()`, `url_to()`, etc.
2. **Follow naming conventions** - Consistent route and file naming
3. **Test early and often** - Don't wait until the end to test
4. **Document changes** - Keep track of what was modified
5. **Use version control** - Commit frequently to track changes
6. **Implement logging** - Add strategic log statements for debugging

---

*Last Updated: August 28, 2025*
*Version: 1.0*

