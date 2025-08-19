# New Product Image Structure Guide

## 🖼️ **Overview**

Your store now has a **separated image structure** that provides better organization and flexibility:

- ✅ **Image Icon** - Single icon image per product (stored in products table)
- ✅ **Image Post** - Single post/featured image per product (stored in products table)  
- ✅ **Image Gallery** - Multiple gallery images per product (separate table, max 6 images)

## 🗄️ **Database Structure**

### **Products Table (Updated)**
```sql
ALTER TABLE products ADD COLUMN image_icon VARCHAR(255) NULL COMMENT 'Product icon image path';
ALTER TABLE products ADD COLUMN image_post VARCHAR(255) NULL COMMENT 'Product post/featured image path';
```

### **Product Gallery Table (New)**
```sql
CREATE TABLE product_gallery (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    image_name VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255) NULL,
    sort_order INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
```

## 🚀 **API Endpoints**

### **1. Product Gallery Management**
```
GET /store/products/{product_id}/gallery
```
Returns gallery images for a product with count and availability info.

```
POST /store/product-gallery
```
Add a new gallery image (max 6 per product).

```
DELETE /store/product-gallery/{image_id}
```
Delete a specific gallery image.

```
PUT /store/products/{product_id}/gallery/reorder
```
Reorder gallery images (send array of image IDs).

### **2. Product Icon & Post Images**
```
PUT /store/products/{product_id}/icon
```
Update product icon image.

```
PUT /store/products/{product_id}/post
```
Update product post image.

## 📝 **Usage Examples**

### **Get Product Gallery**
```javascript
fetch('/store/products/1/gallery')
  .then(response => response.json())
  .then(data => {
    console.log(`Gallery Images: ${data.data.count}/6`);
    console.log(`Can Add More: ${data.data.can_add_more}`);
    data.data.gallery.forEach(image => {
      console.log(`Image: ${image.image_name} - ${image.image_path}`);
    });
  });
```

### **Add Gallery Image**
```javascript
const formData = new FormData();
formData.append('product_id', '1');
formData.append('image_path', '/assets/img/products/gallery/new-image.jpg');
formData.append('image_name', 'New Gallery Image');
formData.append('alt_text', 'Product gallery image');
formData.append('sort_order', '3');

fetch('/store/product-gallery', {
  method: 'POST',
  body: formData
})
.then(response => response.json())
.then(data => console.log(data));
```

### **Update Product Icon**
```javascript
const formData = new FormData();
formData.append('image_path', '/assets/img/products/icon/product-icon.jpg');

fetch('/store/products/1/icon', {
  method: 'PUT',
  body: formData
})
.then(response => response.json())
.then(data => console.log(data));
```

### **Reorder Gallery Images**
```javascript
const imageIds = [3, 1, 2, 4]; // New order

fetch('/store/products/1/gallery/reorder', {
  method: 'PUT',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify(imageIds)
})
.then(response => response.json())
.then(data => console.log(data));
```

## 🔧 **Model Methods**

### **ProductGalleryModel Methods**
```php
// Get all gallery images for a product
$gallery = $productGalleryModel->getProductGallery($productId);

// Get gallery count
$count = $productGalleryModel->getGalleryCount($productId);

// Check if can add more images
$canAdd = $productGalleryModel->canAddMoreImages($productId);

// Add gallery image (auto-checks 6 image limit)
$imageId = $productGalleryModel->insert($data);

// Reorder gallery images
$productGalleryModel->reorderGallery($productId, $imageIds);
```

### **ProductModel Methods**
```php
// Get product with all image types
$product = $productModel->getProductWithAllImages($productId);

// Update icon image
$productModel->updateIconImage($productId, $imagePath);

// Update post image
$productModel->updatePostImage($productId, $imagePath);

// Get products with icons only
$products = $productModel->getProductsWithIcons();

// Get products with post images only
$products = $productModel->getProductsWithPostImages();
```

## 🎯 **Features**

### **1. Image Type Separation**
- **Icon**: Small thumbnail for listings, categories, etc.
- **Post**: Featured image for blog posts, social media, etc.
- **Gallery**: Multiple detailed images for product pages

### **2. Gallery Management**
- **Maximum 6 images** per product (enforced at model level)
- **Sort order** for custom arrangement
- **Status management** (active/inactive)
- **Automatic limit checking** before insertion

### **3. Flexible Usage**
- Each image type serves different purposes
- Easy to manage and organize
- Better performance (no need to load all images for listings)

## 🧪 **Testing**

Test these URLs after setup:

1. **Product Gallery**: http://localhost:8080/store/products/1/gallery
2. **Add Gallery Image**: POST to /store/product-gallery
3. **Update Icon**: PUT to /store/products/1/icon
4. **Update Post**: PUT to /store/products/1/post

## 📁 **File Structure**

```
app/
├── Database/
│   └── Migrations/
│       ├── 2025-08-12-063111_CreateProductGalleryTable.php
│       └── 2025-08-12-063112_AddImageFieldsToProductsTable.php
├── Models/
│   ├── ProductModel.php (updated)
│   └── ProductGalleryModel.php (new)
└── Controllers/
    └── StoreController.php (updated)
```

## 🔄 **Migration Commands**

```bash
# Run the new migrations
php spark migrate

# If you need to rollback
php spark migrate:rollback
```

## 💡 **Best Practices**

1. **Icon Images**: Use small, square images (e.g., 150x150px)
2. **Post Images**: Use medium-sized images (e.g., 600x400px)
3. **Gallery Images**: Use high-quality images (e.g., 1200x800px)
4. **File Naming**: Use descriptive names (e.g., `iphone-15-pro-icon.jpg`)
5. **Alt Text**: Always provide meaningful alt text for accessibility

## 🎉 **Benefits**

- ✅ **Better Organization**: Each image type has a specific purpose
- ✅ **Performance**: Load only needed images for different contexts
- ✅ **Flexibility**: Easy to manage different image types separately
- ✅ **Scalability**: Gallery can be extended without affecting main table
- ✅ **SEO Friendly**: Proper alt text and image organization

## 🚀 **Ready to Use!**

Your new image structure is now fully functional and provides a much better organization for managing product images. The separation allows for more efficient loading and better user experience across different parts of your store.
