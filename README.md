# 🚀 RMB Store - Upload Package

## 📦 What's Included
This folder contains all the necessary files to upload your CodeIgniter 4 POS system to web hosting.

### ✅ Files Included:
- `app/` - Core application (controllers, models, views, config)
- `public/` - Public assets (CSS, JS, images, uploads)
- `index.php` - Main entry point
- `.htaccess` - URL rewriting rules
- `.env` - Environment configuration
- `UPLOAD_CHECKLIST.md` - Deployment checklist

## 🌐 Upload Instructions

### 1. Upload to Web Host
- Upload all files to your web hosting's `public_html` or `www` folder
- Maintain the folder structure as is

### 2. Database Setup
- Create a MySQL database on your hosting
- Update database credentials in `.env` file:
  ```
  database.default.hostname = your_db_host
  database.default.database = your_db_name
  database.default.username = your_db_user
  database.default.password = your_db_password
  ```

### 3. URL Configuration
- Update the base URL in `.env`:
  ```
  app.baseURL = 'https://yourdomain.com/'
  ```

### 4. Run Database Setup
Via SSH or hosting terminal:
```bash
php spark migrate
php spark db:seed
```

### 5. Set Permissions
- `writable/` folder: 755 or 775
- `public/uploads/` folder: 755
- `.env` file: 644

## 🎯 Access URLs

- **Store Frontend**: `https://yourdomain.com/`
- **Admin Login**: `https://yourdomain.com/admin/login`
- **POS System**: `https://yourdomain.com/admin/pos`

## 🔑 Default Admin Login
- **Email**: admin@example.com
- **Password**: admin123

## ⚠️ Important Notes
- This is a preliminary version for presentation
- Auto-suggest in POS may need debugging on live server
- Some features are still in development
- Test thoroughly before presentation

## 🆘 Troubleshooting
- Check file permissions if uploads don't work
- Verify database connection in `.env`
- Check error logs if pages don't load
- Ensure mod_rewrite is enabled on hosting

---
**Created**: August 13, 2025  
**Version**: Preliminary Presentation  
**Status**: Ready for Upload
