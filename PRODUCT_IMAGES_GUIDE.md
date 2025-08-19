# Product Images System Guide

## 🖼️ **Overview**

Your store now has a complete **Product Images System** that allows you to:
- ✅ **Multiple images per product** (one-to-many relationship)
- ✅ **Primary image designation** (one main image per product)
- ✅ **Image ordering** (sort_order field)
- ✅ **Alt text for SEO** (accessibility and search optimization)
- ✅ **Status management** (active/inactive images)

## 🗄️ **Database Structure**

### **Product Images Table**
```sql
CREATE TABLE product_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    image_name VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255) NULL,
    sort_order INT DEFAULT 0,
    is_primary TINYINT(1) DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
```

## 🚀 **API Endpoints**

### **1. Get Products with Images**
```
GET /store/products-with-images
```
Returns all products with their primary images included.

### **2. Get Product with All Images**
```
GET /store/products/{id}
```
Returns a specific product with all its images and primary image.

### **3. Get Product Images**
```
GET /store/products/{product_id}/images
```
Returns all images for a specific product.

### **4. Add Product Image**
```
POST /store/product-images
```
Add a new image to a product.

**Parameters:**
- `product_id` (required): Product ID
- `image_path` (required): Path to the image file
- `image_name` (required): Name of the image
- `alt_text` (optional): Alt text for accessibility
- `is_primary` (optional): Set as primary image (0 or 1)
- `sort_order` (optional): Display order

### **5. Delete Product Image**
```
DELETE /store/product-images/{image_id}
```
Delete a specific product image.

### **6. Set Primary Image**
```
PUT /store/product-images/{image_id}/primary
```
Set an image as the primary image for its product.

## 📝 **Usage Examples**

### **Get All Products with Images**
```javascript
fetch('/store/products-with-images')
  .then(response => response.json())
  .then(data => {
    data.data.forEach(product => {
      console.log(`Product: ${product.product_name}`);
      if (product.primary_image) {
        console.log(`Primary Image: ${product.primary_image.image_path}`);
      }
    });
  });
```

### **Get Product with All Images**
```javascript
fetch('/store/products/1')
  .then(response => response.json())
  .then(data => {
    const product = data.data;
    console.log(`Product: ${product.product_name}`);
    
    // Primary image
    if (product.primary_image) {
      console.log(`Primary: ${product.primary_image.image_path}`);
    }
    
    // All images
    product.images.forEach(image => {
      console.log(`Image: ${image.image_name} - ${image.image_path}`);
    });
  });
```

### **Add Product Image**
```javascript
const formData = new FormData();
formData.append('product_id', '1');
formData.append('image_path', '/assets/img/products/new-image.jpg');
formData.append('image_name', 'New Product Image');
formData.append('alt_text', 'Product description for SEO');
formData.append('is_primary', '0');
formData.append('sort_order', '3');

fetch('/store/product-images', {
  method: 'POST',
  body: formData
})
.then(response => response.json())
.then(data => console.log(data));
```

## 🔧 **Model Methods**

### **ProductImageModel Methods**

```php
// Get all images for a product
$images = $productImageModel->getProductImages($productId);

// Get primary image for a product
$primaryImage = $productImageModel->getPrimaryImage($productId);

// Set an image as primary
$productImageModel->setPrimaryImage($imageId, $productId);

// Get image count for a product
$count = $productImageModel->getImageCount($productId);

// Delete all images for a product
$productImageModel->deleteProductImages($productId);
```

### **ProductModel Methods**

```php
// Get product with all images
$product = $productModel->getProductWithImages($productId);

// Get all products with primary images
$products = $productModel->getProductsWithImages();
```

## 🎯 **Features**

### **1. Primary Image Management**
- Only one image can be primary per product
- Automatically manages primary image conflicts
- Primary images appear first in listings

### **2. Image Ordering**
- Use `sort_order` field to control display order
- Lower numbers appear first
- Primary images are automatically prioritized

### **3. SEO Optimization**
- Alt text support for accessibility
- Image names for better organization
- Structured data ready

### **4. Status Management**
- Active/inactive image status
- Easy to hide/show images without deletion

## 🧪 **Testing**

After running the migration and data insertion, test these URLs:

1. **Products with Images**: http://localhost:8080/store/products-with-images
2. **Single Product with Images**: http://localhost:8080/store/products/1
3. **Product Images Only**: http://localhost:8080/store/products/1/images

## 📁 **File Structure**

```
app/
├── Database/
│   └── Migrations/
│       └── 2025-08-12-063110_CreateProductImagesTable.php
├── Models/
│   ├── ProductModel.php (updated)
│   └── ProductImageModel.php (new)
└── Controllers/
    └── StoreController.php (updated)
```

## 🔄 **Migration Commands**

```bash
# Run the new migration
php spark migrate

# If you need to rollback
php spark migrate:rollback

# Run the data insertion script
php insert_data.php
```

## 💡 **Best Practices**

1. **Image Paths**: Use consistent path structure (e.g., `/assets/img/products/`)
2. **File Names**: Use descriptive, SEO-friendly names
3. **Alt Text**: Always provide meaningful alt text for accessibility
4. **Primary Images**: Set the best quality image as primary
5. **Sort Order**: Use increments of 10 (10, 20, 30) for easy reordering

## 🎉 **Ready to Use!**

Your product images system is now fully functional and ready for your store website. The system provides a robust foundation for managing product images with all the features you need for a professional e-commerce platform.
