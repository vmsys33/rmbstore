# RMB Store - Project Documentation

## **Overview**
RMB Store is a CodeIgniter 4-based e-commerce application with admin management system and frontend customer interface.

## **Features**
- **Admin Panel**: Product management, categories, users, sales tracking
- **Frontend Store**: Product browsing, search, responsive design
- **Image Management**: Advanced cropping with Cropper.js
- **POS System**: Point of sale functionality
- **Inventory Management**: Stock tracking and management

---

## **🚨 QUICK DEBUGGING REFERENCE**

### **Most Common Issues (Check These First!)**

#### **1. 404 Errors - URL/Route Mismatches**
- **Problem**: Form submits to wrong URL
- **Check**: Form `action` attribute vs. route definition
- **Solution**: Use `<?= base_url('admin/products/store') ?>` instead of hardcoded paths
- **Example**: Route: `admin/products/store` → Form action must be `admin/products/store`

#### **2. Product Not Saving**
- **Problem**: Form submits but no database entry
- **Check**: Form action URL, database connection, validation rules
- **Solution**: Verify form points to correct admin route

#### **3. Image Cropper Not Working**
- **Problem**: "Cropper is not defined" error
- **Check**: CDN loading, timing issues, mobile compatibility
- **Solution**: Ensure Cropper.js loads before usage

#### **4. Database Connection Failed**
- **Problem**: "Connection refused" errors
- **Check**: MySQL service status, credentials, port settings
- **Solution**: Start MySQL service, verify database config

---

## **System Requirements**
- PHP 8.0+
- MySQL 5.7+
- CodeIgniter 4.6.3
- Modern web browser with JavaScript enabled

## **Installation**
1. Clone repository to web server directory
2. Configure database settings in `app/Config/Database.php`
3. Run database migrations: `php spark migrate`
4. Start development server: `php spark serve`

## **Configuration**
- **Base URL**: Set in `app/Config/App.php`
- **Database**: Configure in `app/Config/Database.php`
- **Upload Paths**: Set in `app/Config/App.php`

## **File Structure**
```
rmbstore/
├── app/
│   ├── Config/          # Configuration files
│   ├── Controllers/     # Application controllers
│   ├── Models/          # Database models
│   ├── Views/           # View templates
│   └── Helpers/         # Helper functions
├── public/              # Public assets (CSS, JS, images)
├── writable/            # Logs, cache, uploads
└── vendor/              # Composer dependencies
```

## **Key Controllers**
- **ProductsController**: Product CRUD operations
- **CategoriesController**: Category management
- **UsersController**: User management
- **PosController**: Point of sale functionality
- **FrontendController**: Customer-facing pages

## **Database Tables**
- `products`: Product information and metadata
- `categories`: Product categories
- `users`: User accounts and authentication
- `sales`: Sales transactions
- `sale_items`: Individual sale line items

## **Frontend Features**
- Responsive product grid
- Category-based browsing
- Product search functionality
- Mobile-optimized navigation
- Image galleries and zoom

## **Admin Features**
- Dashboard with real-time statistics
- Product management with image cropping
- Category and user management
- Sales tracking and reporting
- POS system for in-store sales

## **Image Management**
- **Cropper.js Integration**: Advanced image cropping
- **Multiple Formats**: Support for JPG, PNG, GIF
- **Size Optimization**: Automatic resizing and compression
- **Gallery Support**: Multiple images per product

## **Security Features**
- Admin authentication system
- CSRF protection
- Input validation and sanitization
- File upload security
- Session management

## **Development Workflow**
1. **Local Development**: Use `php spark serve` for development
2. **Database Changes**: Create migrations for schema changes
3. **Testing**: Test on multiple devices and browsers
4. **Deployment**: Ensure proper file permissions and configuration

## **Troubleshooting**
- **Logs**: Check `writable/logs/` for error messages
- **Database**: Verify MySQL service is running
- **Permissions**: Ensure upload directories are writable
- **Routes**: Verify URL structures match route definitions

## **Performance Optimization**
- Image compression and optimization
- Database query optimization
- Asset minification and caching
- CDN integration for external libraries

## **Mobile Optimization**
- Responsive design principles
- Touch-friendly interface elements
- Mobile-specific JavaScript handling
- Optimized image loading for mobile

---

## **📚 Additional Resources**
- **Debugging Guide**: `DEBUGGING_COMMON_ERRORS.md` - Comprehensive troubleshooting
- **API Documentation**: Available in controller files
- **Database Schema**: See migration files in `app/Database/Migrations/`

---

*Last Updated: August 28, 2025*
*Version: 2.0*
