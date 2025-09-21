<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?> 

<div class="geex-content__section">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><?= $title ?></h2>
            <p class="text-muted mb-0"><?= $subTitle ?></p>
        </div>
        <div>
            <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary">
                <i class="uil uil-arrow-left"></i> Back to Products
            </a>
            <a href="<?= base_url('admin/products/view/' . $product['id']) ?>" class="btn btn-info">
                <i class="uil uil-eye"></i> View Product
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <!-- Using base_url() helper to prevent URL mismatch issues -->
    <form action="<?= base_url('admin/products/update/' . $product['id']) ?>" method="POST" enctype="multipart/form-data" id="productForm">
        <?= csrf_field() ?>
                     
        <!-- Product Name -->
        <div class="mb-4">
            <label for="product_name" class="form-label fw-bold">
                <i class="uil uil-tag me-2"></i>Product Name *
            </label>
            <input type="text" class="form-control form-control-lg <?= session()->getFlashdata('errors.product_name') ? 'is-invalid' : '' ?>" 
                   id="product_name" name="product_name" 
                   value="<?= old('product_name', $product['product_name']) ?>" 
                   placeholder="Enter your product name here..."
                   required>
            <?php if (session()->getFlashdata('errors.product_name')): ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors.product_name') ?>
                </div>
            <?php endif; ?>
            <small class="text-muted">This is what customers will see first</small>
        </div>

        <!-- Category -->
        <div class="mb-4">
            <label for="product_category" class="form-label fw-bold">
                <i class="uil uil-layer-group me-2"></i>Category *
            </label>
            <select class="form-select form-select-lg <?= session()->getFlashdata('errors.product_category') ? 'is-invalid' : '' ?>" 
                    id="product_category" name="product_category" required>
                <option value="">Choose a category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" 
                            <?= old('product_category', $product['product_category']) == $category['id'] ? 'selected' : '' ?>>
                        <?= $category['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (session()->getFlashdata('errors.product_category')): ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors.product_category') ?>
                </div>
            <?php endif; ?>
            <small class="text-muted">Help customers find your product</small>
        </div>

        <!-- Price -->
        <div class="mb-4">
            <label for="price" class="form-label fw-bold">
                <i class="uil uil-money me-2"></i>Price
            </label>
            <div class="input-group input-group-lg">
                <span class="input-group-text"><?= currency_symbol() ?></span>
                <input type="number" step="0.01" class="form-control <?= session()->getFlashdata('errors.price') ? 'is-invalid' : '' ?>" 
                       id="price" name="price" 
                       value="<?= old('price', $product['price']) ?>" 
                       placeholder="0.00">
            </div>
            <?php if (session()->getFlashdata('errors.price')): ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors.price') ?>
                </div>
            <?php endif; ?>
            <small class="text-muted">How much does this product cost? (Optional)</small>
        </div>

        <!-- Main Product Image for Frontend (image_post) - OPTIONAL for edit -->
        <div class="mb-4">
            <label for="image_post" class="form-label fw-bold">
                <i class="uil uil-image me-2"></i>Frontend Product Image (Optional)
            </label>
            <div class="image-upload-container">
                <!-- Show current image if exists -->
                <?php if (isset($product['image_post']) && $product['image_post']): ?>
                    <div class="current-image mb-3 text-center">
                        <img src="<?= base_url($product['image_post']) ?>" alt="Current Frontend Image" 
                             class="img-thumbnail" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                        <p class="text-muted mt-2 mb-0">Current Frontend Image</p>
                    </div>
                <?php endif; ?>
                
                <div class="upload-area" id="uploadAreaPost">
                    <i class="uil uil-cloud-upload upload-icon"></i>
                    <p class="upload-text">Tap here to change frontend image</p>
                    <p class="upload-hint">or drag and drop</p>
                    <small class="text-muted">Square (1:1) ratio, Max: 5MB</small>
                </div>
                <input type="file" class="form-control d-none" id="image_post" name="image_post" 
                       accept="image/*" onchange="handleImageUpload(this, 'post-preview', 'post')">
            </div>
            <div class="image-preview mt-3" id="post-preview"></div>
        </div>

        <!-- Product Icon for Admin Table (image_icon) - OPTIONAL -->
        <div class="mb-4">
            <label for="image_icon" class="form-label fw-bold">
                <i class="uil uil-image me-2"></i>Admin Table Icon (Optional)
            </label>
            <div class="image-upload-container">
                <!-- Show current image if exists -->
                <?php if (isset($product['image_icon']) && $product['image_icon']): ?>
                    <div class="current-image mb-3 text-center">
                        <img src="<?= base_url($product['image_icon']) ?>" alt="Current Icon" 
                             class="img-thumbnail" style="max-width: 120px; max-height: 120px; border-radius: 8px;">
                        <p class="text-muted mt-2 mb-0">Current Admin Icon</p>
                    </div>
                <?php endif; ?>
                
                <div class="upload-area" id="uploadAreaIcon">
                    <i class="uil uil-cloud-upload upload-icon"></i>
                    <p class="upload-text">Tap here to change admin icon</p>
                    <p class="upload-hint">or drag and drop</p>
                    <small class="text-muted">Square image, Max: 2MB</small>
                </div>
                <input type="file" class="form-control d-none" id="image_icon" name="image_icon" 
                       accept="image/*" onchange="handleImageUpload(this, 'icon-preview', 'icon')">
            </div>
            <div class="image-preview mt-3" id="icon-preview"></div>
        </div>

        <!-- Short Description -->
        <div class="mb-4">
            <label for="short_description" class="form-label fw-bold">
                <i class="uil uil-align-left me-2"></i>Brief Description
            </label>
            <textarea class="form-control form-control-lg" id="short_description" name="short_description" 
                      rows="3" 
                      placeholder="A short, catchy description that appears in product listings..."><?= old('short_description', $product['short_description']) ?></textarea>
            <small class="text-muted">Keep it short and sweet - this shows in product cards</small>
        </div>

         <!-- Hidden SKU field for auto-generation -->
         <input type="hidden" id="sku" name="sku" value="<?= old('sku', $product['sku']) ?>">

         <!-- Additional Fields -->
         <!-- Full Description -->
         <div class="mb-4">
             <label for="description" class="form-label fw-bold">
                 <i class="uil uil-file-text me-2"></i>Detailed Description
             </label>
             <textarea class="form-control" id="description" name="description" 
                       rows="4" 
                       placeholder="Tell customers everything they need to know about this product..."><?= old('description', $product['description']) ?></textarea>
             <small class="text-muted">Optional: More detailed information about features, benefits, etc.</small>
         </div>

         <!-- Sale Price -->
         <div class="mb-4">
             <label for="sale_price" class="form-label fw-bold">
                 <i class="uil uil-money me-2"></i>Sale Price
             </label>
             <div class="input-group input-group-lg">
                 <span class="input-group-text"><?= currency_symbol() ?></span>
                 <input type="number" step="0.01" class="form-control" 
                        id="sale_price" name="sale_price" 
                        value="<?= old('sale_price', $product['sale_price']) ?>" 
                        placeholder="0.00">
             </div>
             <small class="text-muted">Leave empty if no discount</small>
         </div>

         <!-- Stock Quantity -->
         <div class="mb-4">
             <label for="stock_quantity" class="form-label fw-bold">
                 <i class="uil uil-box me-2"></i>Stock Quantity
             </label>
             <input type="number" class="form-control form-control-lg" 
                    id="stock_quantity" name="stock_quantity" 
                    value="<?= old('stock_quantity', $product['stock_quantity']) ?>" 
                    placeholder="0">
             <small class="text-muted">How many do you have in stock?</small>
         </div>

         <!-- Status -->
         <div class="mb-4">
             <label for="status" class="form-label fw-bold">
                 <i class="uil uil-toggle-on me-2"></i>Product Status
             </label>
             <select class="form-select form-select-lg" id="status" name="status">
                 <option value="active" <?= old('status', $product['status']) === 'active' ? 'selected' : '' ?>>Active - Show to customers</option>
                 <option value="draft" <?= old('status', $product['status']) === 'draft' ? 'selected' : '' ?>>Draft - Save for later</option>
                 <option value="inactive" <?= old('status', $product['status']) === 'inactive' ? 'selected' : '' ?>>Inactive - Hide from customers</option>
             </select>
             <small class="text-muted">Choose when customers can see this product</small>
         </div>

         <!-- Gallery Images -->
         <div class="mb-4">
             <label for="gallery_images" class="form-label fw-bold">
                 <i class="uil uil-images me-2"></i>Additional Photos
             </label>
             
             <!-- Show existing gallery images -->
             <?php if (!empty($product['gallery_images'])): ?>
                 <div class="mb-3">
                     <h6 class="text-muted">Current Gallery Images</h6>
                     <div class="row">
                         <?php foreach ($product['gallery_images'] as $galleryImage): ?>
                             <div class="col-md-2 col-sm-3 col-4 mb-2">
                                 <div class="gallery-item position-relative">
                                     <img src="<?= base_url($galleryImage['image_path']) ?>" 
                                          alt="<?= $galleryImage['alt_text'] ?? 'Gallery Image' ?>" 
                                          class="img-fluid rounded border" 
                                          style="width: 100%; height: 100px; object-fit: cover;">
                                     <small class="d-block text-center mt-1 text-muted"><?= $galleryImage['image_name'] ?></small>
                                 </div>
                             </div>
                         <?php endforeach; ?>
                     </div>
                 </div>
             <?php endif; ?>
             
             <div class="image-upload-container">
                 <div class="upload-area" id="galleryUploadArea">
                     <i class="uil uil-image-plus upload-icon"></i>
                     <p class="upload-text">Add more photos</p>
                     <p class="upload-hint">Up to 6 images</p>
                     <small class="text-muted">Max: 10MB each</small>
                 </div>
                 <input type="file" class="form-control d-none" id="gallery_images" name="gallery_images[]" 
                        accept="image/*" multiple onchange="handleGalleryImages(this)">
             </div>
             <div class="gallery-preview mt-3" id="gallery-preview"></div>
         </div>

         <!-- Featured Product -->
         <div class="mb-4">
             <div class="form-check form-check-lg">
                 <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" 
                        <?= old('featured', $product['featured']) ? 'checked' : '' ?>>
                 <label class="form-check-label fw-bold" for="featured">
                     <i class="uil uil-star me-2"></i>Feature this product on homepage
                 </label>
             </div>
             <small class="text-muted">Highlight this product to get more attention</small>
         </div>

         <!-- Submit Button -->
         <div class="d-flex gap-2">
             <button type="submit" class="btn btn-success btn-lg flex-fill">
                 <i class="uil uil-check me-2"></i>Update Product
             </button>
         </div>
    </form>
</div>

<?= $this->endSection(); ?>

<?= $this->section('custom_scripts'); ?>
<!-- Image Cropper Library -->

<script>
// Auto-generate SKU from product name (only if SKU is empty)
document.getElementById('product_name').addEventListener('input', function() {
    const productName = this.value;
    const skuField = document.getElementById('sku');
    
    if (productName && !skuField.value) {
        const sku = productName
            .toUpperCase()
            .replace(/[^A-Z0-9]/g, '')
            .substring(0, 8);
        
        if (sku.length >= 3) {
            skuField.value = sku + '-' + Math.random().toString(36).substr(2, 4).toUpperCase();
        }
    }
});

// Image upload area click handlers
document.getElementById('uploadAreaPost').addEventListener('click', function() {
    document.getElementById('image_post').click();
});

document.getElementById('uploadAreaIcon').addEventListener('click', function() {
    document.getElementById('image_icon').click();
});

document.getElementById('galleryUploadArea').addEventListener('click', function() {
    document.getElementById('gallery_images').click();
});

        // Enhanced image handling with Cropper.js library
        function handleImageUpload(input, previewId, type) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file size
                const maxSize = type === 'icon' ? 2 * 1024 * 1024 : 5 * 1024 * 1024; // 2MB for icon, 5MB for post
                if (file.size > maxSize) {
                    alert(`File size too large. Maximum ${maxSize / 1024 / 1024}MB allowed.`);
                    input.value = '';
                    return;
                }
                
                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('Please select an image file.');
                    input.value = '';
                    return;
                }
                
                // Create preview image for cropping
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imagePreview = document.createElement('img');
                    imagePreview.src = e.target.result;
                    imagePreview.style.maxWidth = '100%';
                    imagePreview.style.maxHeight = '300px';
                    
                    // Clear preview and add image
                    preview.innerHTML = '';
                    preview.appendChild(imagePreview);

                    // Configure cropper options based on type
                    const aspectRatio = 1; // Square (1:1) for both icon and post images
                    
                    // Initialize Cropper.js
                    const cropper = new Cropper(imagePreview, {
                        aspectRatio: aspectRatio,
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 1,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                        minCropBoxWidth: 100,
                        minCropBoxHeight: 100,
                        strict: true,  // Strictly enforce aspect ratio
                    });

                    // Add crop button
                    const cropButton = document.createElement('button');
                    cropButton.type = 'button';
                    cropButton.className = 'btn btn-primary btn-sm mt-2 me-2';
                    cropButton.innerHTML = '<i class="uil uil-crop"></i> Crop Image';
                    cropButton.onclick = function() {
                        const canvas = cropper.getCroppedCanvas({
                            width: type === 'icon' ? 200 : 400,
                            height: type === 'icon' ? 200 : 400  // Square for both icon and post
                        });
                        
                        // Convert canvas to blob and update file input
                        canvas.toBlob(function(blob) {
                            const croppedFile = new File([blob], file.name, { type: file.type });
                            
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(croppedFile);
                            input.files = dataTransfer.files;
                            
                            // Show final preview
                            showImagePreview(previewId, canvas.toDataURL(), type);
                            
                            // Clean up cropper
                            cropper.destroy();
                            
                            // Add a small delay to ensure file is properly attached
                            setTimeout(() => {
                                // Force a DOM update to ensure the file input is properly synchronized
                                input.dispatchEvent(new Event('change', { bubbles: true }));
                            }, 100);
                        }, file.type);
                    };
                    
                    // Add cancel button
                    const cancelButton = document.createElement('button');
                    cancelButton.type = 'button';
                    cancelButton.className = 'btn btn-secondary btn-sm mt-2';
                    cancelButton.innerHTML = '<i class="uil uil-times"></i> Cancel';
                    cancelButton.onclick = function() {
                        cropper.destroy();
                        preview.innerHTML = '';
                        input.value = '';
                    };
                    
                    // Add buttons to preview
                    preview.appendChild(cropButton);
                    preview.appendChild(cancelButton);
                };
                
                reader.readAsDataURL(file);
            }
        }

// Show image preview after cropping
function showImagePreview(previewId, imageData, type) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    
    const container = document.createElement('div');
    container.className = 'image-preview-container text-center';
    
    const img = document.createElement('img');
    img.src = imageData;
    img.className = 'img-thumbnail';
    img.style.cssText = `
        max-width: ${type === 'icon' ? '150px' : '200px'};
        max-height: ${type === 'icon' ? '150px' : '150px'};
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    `;
    
    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'btn btn-sm btn-danger mt-2';
    removeBtn.innerHTML = '<i class="uil uil-trash-alt me-1"></i>Remove';
    removeBtn.onclick = function() {
        // Find the correct file input based on preview ID
        let fileInputId = '';
        if (previewId === 'post-preview') {
            fileInputId = 'image_post';
        } else if (previewId === 'icon-preview') {
            fileInputId = 'image_icon';
        }
        
        if (fileInputId) {
            const fileInput = document.getElementById(fileInputId);
            if (fileInput) {
                fileInput.value = '';
                
            }
        }
        preview.innerHTML = '';
    };
    
    container.appendChild(img);
    container.appendChild(document.createElement('br'));
    container.appendChild(removeBtn);
    preview.appendChild(container);
}

// Reset image function
function resetImage(previewId, inputId) {
    const preview = document.getElementById(previewId);
    const input = document.getElementById(inputId);
    input.value = '';
    preview.innerHTML = '';
}

// Show final cropped preview
function showFinalPreview(previewId, imageData, type) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    
    const finalContainer = document.createElement('div');
    finalContainer.className = 'final-preview text-center';
    
    const img = document.createElement('img');
    img.src = imageData;
    img.className = 'img-thumbnail';
    img.style.cssText = `
        max-width: ${type === 'icon' ? '150px' : '200px'};
        max-height: ${type === 'icon' ? '150px' : '150px'};
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    `;
    
    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'btn btn-sm btn-danger mt-2';
    removeBtn.innerHTML = '<i class="uil uil-trash-alt me-1"></i>Remove';
    removeBtn.onclick = function() {
        // Find the correct file input based on preview ID
        let fileInputId = '';
        if (previewId === 'post-preview') {
            fileInputId = 'image_post';
        } else if (previewId === 'icon-preview') {
            fileInputId = 'image_icon';
        }
        
        if (fileInputId) {
            const fileInput = document.getElementById(fileInputId);
            if (fileInput) {
                fileInput.value = '';
                
            }
        }
        preview.innerHTML = '';
    };
    
    finalContainer.appendChild(img);
    finalContainer.appendChild(document.createElement('br'));
    finalContainer.appendChild(removeBtn);
    preview.appendChild(finalContainer);
}

// Reset image function
function resetImage(previewId, inputId) {
    const preview = document.getElementById(previewId);
    const input = document.getElementById(inputId);
    input.value = '';
    preview.innerHTML = '';
}

// Enhanced gallery images handling
function handleGalleryImages(input) {
    const preview = document.getElementById('gallery-preview');
    preview.innerHTML = '';
    
    if (input.files) {
        const files = Array.from(input.files);
        
        // Limit to 6 images
        if (files.length > 6) {
            alert('Maximum 6 images allowed for gallery.');
            input.value = '';
            return;
        }
        
        files.forEach((file, index) => {
            // Validate file size (10MB max)
            if (file.size > 10 * 1024 * 1024) {
                alert('File "' + file.name + '" is too large. Maximum 10MB allowed.');
                return;
            }
            
            // Validate file type
            if (!file.type.match('image.*')) {
                alert('File "' + file.name + '" is not an image.');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.createElement('div');
                container.className = 'gallery-item d-inline-block me-2 mb-2';
                container.style.position = 'relative';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.cssText = `
                    width: 120px;
                    height: 80px;
                    object-fit: cover;
                    border-radius: 8px;
                    cursor: pointer;
                `;
                
                // Add click to enlarge
                img.onclick = function() {
                    showImageModal(e.target.result, 'Gallery Image');
                };
                
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-sm btn-danger';
                removeBtn.style.cssText = `
                    position: absolute;
                    top: -8px;
                    right: -8px;
                    border-radius: 50%;
                    width: 24px;
                    height: 24px;
                    padding: 0;
                    font-size: 14px;
                    line-height: 1;
                    border: 2px solid white;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                `;
                removeBtn.innerHTML = '×';
                removeBtn.onclick = function() {
                    container.remove();
                };
                
                container.appendChild(img);
                container.appendChild(removeBtn);
                preview.appendChild(container);
            };
            reader.readAsDataURL(file);
        });
    }
}

// Image modal for gallery images
function showImageModal(imageSrc, title) {
    const modal = document.createElement('div');
    modal.className = 'image-modal';
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    `;
    
    const modalContent = document.createElement('div');
    modalContent.style.cssText = `
        position: relative;
        max-width: 90%;
        max-height: 90%;
        text-align: center;
    `;
    
    const img = document.createElement('img');
    img.src = imageSrc;
    img.style.cssText = `
        max-width: 100%;
        max-height: 100%;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.5);
    `;
    
    const closeBtn = document.createElement('button');
    closeBtn.innerHTML = '×';
    closeBtn.style.cssText = `
        position: absolute;
        top: -40px;
        right: 0;
        background: none;
        border: none;
        color: white;
        font-size: 30px;
        cursor: pointer;
        padding: 0;
        width: 40px;
        height: 40px;
    `;
    closeBtn.onclick = function() {
        document.body.removeChild(modal);
    };
    
    modalContent.appendChild(img);
    modalContent.appendChild(closeBtn);
    modal.appendChild(modalContent);
    
    // Close on background click
    modal.onclick = function(e) {
        if (e.target === modal) {
            document.body.removeChild(modal);
        }
    };
    
    document.body.appendChild(modal);
}

// Form submission
document.getElementById('productForm').addEventListener('submit', function(e) {
    // Let the form submit naturally
    return true;
});



// Show success/error messages if any
$(document).ready(function() {
    <?php if (session()->getFlashdata('success')): ?>
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?= session()->getFlashdata('success') ?>',
                timer: 3000,
                showConfirmButton: false
            });
        } else {
            alert('<?= session()->getFlashdata('success') ?>');
        }
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '<?= session()->getFlashdata('error') ?>',
                confirmButtonColor: '#d33'
            });
        } else {
            alert('Error: <?= session()->getFlashdata('error') ?>');
        }
    <?php endif; ?>

    <?php if (session()->getFlashdata('validation_errors')): ?>
        let validationErrors = '';
        <?php foreach (session()->getFlashdata('validation_errors') as $field => $error): ?>
            validationErrors += '• <?= ucfirst(str_replace('_', ' ', $field)) ?>: <?= $error ?>\n';
        <?php endforeach; ?>
        
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Failed',
                text: validationErrors,
                confirmButtonColor: '#f39c12',
                confirmButtonText: 'Fix Errors'
            });
        } else {
            alert('Validation Failed:\n' + validationErrors);
        }
    <?php endif; ?>
});
</script>

<style>
/* Mobile viewport and responsive fixes */
* {
    box-sizing: border-box;
}

body {
    overflow-x: hidden;
    max-width: 100vw;
}

.geex-content__section {
    max-width: 100%;
    overflow-x: hidden;
}

/* Image preview styles */
.image-preview-container {
    margin: 15px 0;
}

.image-preview-container img {
    transition: transform 0.2s ease;
}

.image-preview-container img:hover {
    transform: scale(1.05);
}

.crop-controls .btn-group {
    margin-bottom: 10px;
}

.crop-controls .btn {
    font-size: 12px;
    padding: 6px 12px;
}

.final-preview img {
    transition: transform 0.2s ease;
}

.final-preview img:hover {
    transform: scale(1.05);
}

.gallery-item img {
    transition: transform 0.2s ease;
}

.gallery-item img:hover {
    transform: scale(1.1);
}

.image-modal {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Mobile-first responsive design */
.step-progress {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 30px;
}

.step-indicator {
    font-size: 14px;
    color: #6c757d;
    transition: all 0.3s ease;
}

.step-indicator.active {
    color: #0d6efd;
    font-weight: bold;
}

.step-indicator i {
    margin-right: 5px;
}

.step-content {
    transition: all 0.3s ease;
}

.card {
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 16px;
    overflow: hidden;
}

.card-header {
    padding: 20px;
    border-bottom: none;
}

.card-body {
    padding: 30px;
}

.form-label {
    font-size: 16px;
    margin-bottom: 10px;
}

.form-control, .form-select {
    border-radius: 12px;
    border: 2px solid #e9ecef;
    padding: 15px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.form-control-lg, .form-select-lg {
    padding: 18px 20px;
    font-size: 18px;
}

.btn {
    border-radius: 12px;
    padding: 15px 30px;
    font-size: 16px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-lg {
    padding: 18px 35px;
    font-size: 18px;
}

.image-upload-container {
    border: 3px dashed #dee2e6;
    border-radius: 16px;
    padding: 30px;
    text-align: center;
    background-color: #f8f9fa;
    transition: all 0.3s ease;
    cursor: pointer;
}

.image-upload-container:hover {
    border-color: #0d6efd;
    background-color: #f0f8ff;
}

.upload-area {
    cursor: pointer;
}

.upload-icon {
    font-size: 48px;
    color: #6c757d;
    margin-bottom: 15px;
}

.upload-text {
    font-size: 18px;
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
}

.upload-hint {
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 15px;
}

.image-preview, .gallery-preview {
    min-height: 50px;
}

.form-check-lg {
    padding-left: 2.5rem;
}

.form-check-input {
    width: 1.5rem;
    height: 1.5rem;
    margin-left: -2.5rem;
}

/* Mobile optimizations */
@media (max-width: 768px) {
    .geex-content__section {
        padding: 15px;
        margin: 0;
    }
    
    .card-body {
        padding: 15px;
    }
    
    .card {
        margin-bottom: 20px;
        border-radius: 12px;
    }
    
    .btn-lg {
        padding: 15px 25px;
        font-size: 16px;
        width: 100%;
    }
    
    .form-control-lg, .form-select-lg {
        padding: 15px 18px;
        font-size: 16px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }
    
    .input-group {
        width: 100%;
    }
    
    .input-group-text {
        font-size: 16px;
        padding: 15px 18px;
    }
    
    .image-upload-container {
        padding: 20px 15px;
        margin: 0;
        width: 100%;
        box-sizing: border-box;
    }
    
    .upload-icon {
        font-size: 36px;
    }
    
    .upload-text {
        font-size: 16px;
    }
    
    .upload-hint {
        font-size: 13px;
    }
    
    .step-progress {
        margin-bottom: 20px;
    }
    
    .step-indicator {
        font-size: 14px;
        padding: 8px 12px;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 15px;
    }
    
    .d-flex.justify-content-between > div {
        width: 100%;
        text-align: center;
    }
    
    .btn-secondary {
        width: 100%;
        margin-bottom: 15px;
    }
    
    .form-label {
        font-size: 16px;
        margin-bottom: 8px;
    }
    
    .text-muted {
        font-size: 14px;
    }
    
    .invalid-feedback {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .geex-content__section {
        padding: 10px;
    }
    
    .card-body {
        padding: 12px;
    }
    
    .image-upload-container {
        padding: 15px 10px;
    }
    
    .upload-icon {
        font-size: 32px;
    }
    
    .upload-text {
        font-size: 15px;
    }
    
    .step-indicator {
        font-size: 13px;
        padding: 6px 10px;
    }
    
    .btn-lg {
        padding: 12px 20px;
        font-size: 15px;
    }
    
    /* Prevent horizontal scrolling on very small screens */
    .container, .row, .col {
        max-width: 100%;
        padding-left: 5px;
        padding-right: 5px;
    }
    
    .card {
        margin-left: 5px;
        margin-right: 5px;
    }
    
    /* Ensure form elements fit properly */
    input, select, textarea {
        max-width: 100%;
        box-sizing: border-box;
    }
    
    /* Fix any potential overflow issues */
    .geex-content {
        overflow-x: hidden;
        max-width: 100vw;
    }
}

/* Progress bar animation */
.progress-bar {
    transition: width 0.5s ease;
}

/* Step transition animations */
.step-content {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
<?= $this->endSection(); ?>