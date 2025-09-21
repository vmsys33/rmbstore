# RMB Store Project Changelog

## Project Overview
- **Project Name**: RMB Store
- **Location**: C:\xampp\htdocs\rmbstore
- **Framework**: CodeIgniter 4
- **Database**: MySQL (via XAMPP)
- **Purpose**: E-commerce/Point of Sale system with AI chatbot integration

## Recent Changes

### 2025-01-27
- **Initial Setup**: Created project changelog and documentation
- **Project Structure**: Analyzed existing codebase structure
  - Controllers: Admin, Products, Categories, Chatbot, POS, etc.
  - Models: 13 model files
  - Views: 85+ view files
  - Database: Migrations and seeds
  - AI Integration: Google AI/CiciAI chatbot functionality
  - Features: Multi-currency support, stock management, sales tracking
- **Frontend Enhancement**: Implemented 1:1 aspect ratio for product images
  - Added CSS classes for square product images
  - Updated featured products section with square aspect ratio
  - Updated latest products carousel with square aspect ratio
  - Applied 1:1 aspect ratio to product listing page images
  - Applied 1:1 aspect ratio to product details page images
  - Applied 1:1 aspect ratio to related products images
  - Improved image consistency and easier image sourcing across all pages
- **Admin Cropper Fix**: Updated product creation/editing cropper to use 1:1 aspect ratio
  - Changed frontend image cropper from 4:3 to 1:1 (square) aspect ratio
  - Updated form hints to reflect square image requirements
  - Fixed canvas output dimensions to ensure strict square cropping (400x400 for post images)
  - Added strict aspect ratio enforcement with `strict: true` option
  - Ensures consistent image cropping between admin and frontend display

## Key Features Identified
- Admin authentication system
- Product management with image uploads
- Category management
- Point of Sale (POS) system
- Stock on hand tracking
- Sales summary reporting
- AI chatbot with FAQ integration
- Multi-currency support
- Slider management
- User management

## Technical Stack
- **Backend**: PHP 8+ with CodeIgniter 4
- **Frontend**: HTML, CSS, JavaScript
- **Database**: MySQL
- **AI**: Google AI integration for chatbot
- **File Uploads**: Product images, settings, sliders
- **Session Management**: CodeIgniter sessions
- **Authentication**: Admin auth filter

## Manual Startup Instructions

### Prerequisites
- XAMPP installed and running
- PHP 8.0+ 
- MySQL database
- Composer (for dependencies)

### Step-by-Step Startup Process

1. **Start XAMPP Services**
   ```
   - Open XAMPP Control Panel
   - Start Apache service
   - Start MySQL service
   ```

2. **Database Setup**
   ```
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create database: rmbstore
   - Import any existing SQL files if available
   - Run migrations: php spark migrate
   ```

3. **Install Dependencies**
   ```
   cd C:\xampp\htdocs\rmbstore
   composer install
   ```

4. **Environment Configuration**
   ```
   - Copy env file and configure database settings
   - Set base URL in app/Config/App.php
   - Configure any API keys (Google AI, etc.)
   ```

5. **Set Permissions**
   ```
   - Ensure writable/ directory has proper permissions
   - Check uploads/ directory permissions
   ```

6. **Access the Application**
   ```
   Frontend Store: http://localhost/rmbstore
   Admin Panel: http://localhost/rmbstore/admin
   ```

### Quick Start Commands
```bash
# Navigate to project
cd C:\xampp\htdocs\rmbstore

# Run migrations
php spark migrate

# Seed database (if seeds exist)
php spark db:seed

# Start CodeIgniter development server
php spark serve
# Default: http://localhost:8080

# Start with custom port
php spark serve --port=3000

# Start with custom host and port
php spark serve --host=0.0.0.0 --port=8080


### Alternative Access Methods
- **XAMPP Apache**: http://localhost/rmbstore (Recommended - serves CSS/JS properly)
- **CodeIgniter Server**: http://localhost:8080 (via `php spark serve`)

### CSS Not Loading Issue with `php spark serve`
**Problem**: CodeIgniter's built-in server doesn't serve static assets (CSS, JS, images) by default.

**Solutions**:
1. **Use XAMPP instead** (Recommended):
   ```
   http://localhost/rmbstore
   ```

2. **Fix baseURL in app/Config/App.php**:
   ```php
   public string $baseURL = 'http://localhost:8080/';
   ```

3. **Use Apache/Nginx** for production-like environment

### Troubleshooting
- Check XAMPP error logs if services won't start
- Verify database connection in app/Config/Database.php
- Ensure all required PHP extensions are enabled
- Check file permissions on writable/ and uploads/ directories

## Notes
- Project appears to be a complete e-commerce solution
- Has both frontend store and admin panel
- Includes real-time features and AI chatbot
- Multi-language support (English)
- Comprehensive logging and debugging tools
