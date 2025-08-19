# 🚀 UPLOAD CHECKLIST - Preliminary Presentation

## 📁 Files to Upload to Web Host

### ✅ Core Application Files
- [ ] `app/` folder (entire folder)
- [ ] `public/` folder (entire folder)
- [ ] `index.php` (root file)
- [ ] `.htaccess` (URL rewriting)

### ✅ Configuration Files
- [ ] `app/Config/` folder
- [ ] `app/Database/` folder (migrations, seeds)
- [ ] `env` file (rename to `.env` on server)

### ❌ Files NOT to Upload (Development Only)
- [ ] `tests/` folder
- [ ] `build/` folder
- [ ] `*.bat` files
- [ ] `*.php` files in root (setup files)
- [ ] `spark` file

## 🔧 Server Configuration

### 1. Database Setup
- [ ] Create MySQL database on hosting
- [ ] Update database credentials in `.env` file
- [ ] Run migrations: `php spark migrate`
- [ ] Run seeders: `php spark db:seed`

### 2. File Permissions
- [ ] `writable/` folder: 755 or 775
- [ ] `public/uploads/` folder: 755
- [ ] `.env` file: 644

### 3. URL Configuration
- [ ] Update `app.baseURL` in `.env` to your domain
- [ ] Set `app.indexPage = ''` for clean URLs

## 🌐 Quick Upload Steps

1. **Zip the project** (excluding development files)
2. **Upload to hosting** via FTP/cPanel
3. **Extract files** in public_html or www folder
4. **Create database** and update `.env`
5. **Run migrations** via SSH or hosting terminal
6. **Test the application**

## 🎯 Presentation URLs

- **Frontend**: `https://yourdomain.com/`
- **Admin Login**: `https://yourdomain.com/admin/login`
- **POS System**: `https://yourdomain.com/admin/pos`

## 🔑 Default Admin Login
- **Email**: admin@example.com
- **Password**: admin123

## ⚠️ Important Notes

- This is a **preliminary version** - not production ready
- Auto-suggest in POS may need debugging on live server
- Image uploads need proper permissions
- Database should be backed up before presentation

## 🐛 Known Issues (To Fix Later)
- Auto-suggest functionality needs testing on live server
- Image paths may need adjustment
- Some features may need optimization
- Security hardening needed for production


