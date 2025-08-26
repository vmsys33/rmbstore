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
            <a href="/products" class="btn btn-secondary">
                <i class="uil uil-arrow-left"></i> Back to Products
            </a>
        </div>
    </div>

    <!-- Step Progress Indicator -->
    <div class="step-progress mb-4">
        <div class="progress" style="height: 8px;">
            <div class="progress-bar" id="progressBar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="d-flex justify-content-between mt-2">
            <span class="step-indicator active" id="step1Indicator">
                <i class="uil uil-check-circle"></i> Basic Info (3 required)
            </span>
            <span class="step-indicator" id="step2Indicator">
                <i class="uil uil-circle"></i> Additional Details
            </span>
        </div>
    </div>

    <!-- Create Form -->
    <form action="/admin/products/store" method="POST" enctype="multipart/form-data" id="productForm">
        <!-- Step 1: Essential Information -->
        <div class="step-content" id="step1">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="uil uil-info-circle me-2"></i>
                        Step 1: Basic Product Information
                    </h5>
                    <small>Fill in the essential details to get your product online quickly (Only Product Name, Category, and Photo are required)</small>
                </div>
                <div class="card-body">
                    <!-- Product Name -->
                    <div class="mb-4">
                        <label for="product_name" class="form-label fw-bold">
                            <i class="uil uil-tag me-2"></i>Product Name *
                        </label>
                        <input type="text" class="form-control form-control-lg <?= session()->getFlashdata('errors.product_name') ? 'is-invalid' : '' ?>" 
                               id="product_name" name="product_name" 
                               value="<?= old('product_name') ?>" 
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
                            <i class="uil uil-folder me-2"></i>Category *
                        </label>
                        <select class="form-select form-select-lg <?= session()->getFlashdata('errors.product_category') ? 'is-invalid' : '' ?>" 
                                id="product_category" name="product_category" required>
                            <option value="">Choose a category...</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" 
                                        <?= old('product_category') == $category['id'] ? 'selected' : '' ?>>
                                    <?= esc($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session()->getFlashdata('errors.product_category')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errors.product_category') ?>
                            </div>
                        <?php endif; ?>
                        <small class="text-muted">Where should customers find this product?</small>
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label for="price" class="form-label fw-bold">
                            <i class="uil uil-dollar-sign me-2"></i>Price
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control <?= session()->getFlashdata('errors.price') ? 'is-invalid' : '' ?>" 
                                   id="price" name="price" 
                                   value="<?= old('price') ?>" 
                                   placeholder="0.00">
                        </div>
                        <?php if (session()->getFlashdata('errors.price')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errors.price') ?>
                            </div>
                        <?php endif; ?>
                        <small class="text-muted">How much does this product cost? (Optional)</small>
                    </div>

                    <!-- Main Product Image -->
                    <div class="mb-4">
                        <label for="image_icon" class="form-label fw-bold">
                            <i class="uil uil-image me-2"></i>Main Product Photo *
                        </label>
                        <div class="image-upload-container">
                            <div class="upload-area" id="uploadArea">
                                <i class="uil uil-cloud-upload upload-icon"></i>
                                <p class="upload-text">Tap here to add a photo</p>
                                <p class="upload-hint">or drag and drop</p>
                                <small class="text-muted">Recommended: Square image, Max: 2MB</small>
                            </div>
                            <input type="file" class="form-control d-none" id="image_icon" name="image_icon" 
                                   accept="image/*" onchange="handleImageUpload(this, 'icon-preview', 'icon')" required>
                        </div>
                        <div class="image-preview mt-3" id="icon-preview"></div>
                    </div>

                                         <!-- Short Description -->
                     <div class="mb-4">
                         <label for="short_description" class="form-label fw-bold">
                             <i class="uil uil-comment me-2"></i>Brief Description
                         </label>
                         <textarea class="form-control" id="short_description" name="short_description" 
                                   rows="3" 
                                   placeholder="Describe your product in 2-3 sentences... (Optional)"><?= old('short_description') ?></textarea>
                         <small class="text-muted">Keep it short and appealing to customers (Optional)</small>
                     </div>

                     <!-- Hidden SKU field for auto-generation -->
                     <input type="hidden" id="sku" name="sku" value="">

                    <!-- Step 1 Actions -->
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary btn-lg" onclick="nextStep()">
                            <i class="uil uil-arrow-right me-2"></i>Continue to Details
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Additional Details -->
        <div class="step-content d-none" id="step2">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="uil uil-plus-circle me-2"></i>
                        Step 2: Additional Details (Optional)
                    </h5>
                    <small>Add more information to make your product stand out</small>
                </div>
                <div class="card-body">
                    <!-- Full Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">
                            <i class="uil uil-file-text me-2"></i>Detailed Description
                        </label>
                        <textarea class="form-control" id="description" name="description" 
                                  rows="4" 
                                  placeholder="Tell customers everything they need to know about this product..."><?= old('description') ?></textarea>
                        <small class="text-muted">Optional: More detailed information about features, benefits, etc.</small>
                    </div>

                    <!-- Sale Price -->
                    <div class="mb-4">
                        <label for="sale_price" class="form-label fw-bold">
                            <i class="uil uil-percentage me-2"></i>Sale Price
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control" 
                                   id="sale_price" name="sale_price" 
                                   value="<?= old('sale_price') ?>" 
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
                               value="<?= old('stock_quantity') ?: '0' ?>" 
                               placeholder="0">
                        <small class="text-muted">How many do you have in stock?</small>
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="form-label fw-bold">
                            <i class="uil uil-toggle-on me-2"></i>Product Status
                        </label>
                        <select class="form-select form-select-lg" id="status" name="status">
                            <option value="active" <?= old('status') === 'active' ? 'selected' : '' ?>>Active - Show to customers</option>
                            <option value="draft" <?= old('status') === 'draft' ? 'selected' : '' ?>>Draft - Save for later</option>
                            <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>Inactive - Hide from customers</option>
                        </select>
                        <small class="text-muted">Choose when customers can see this product</small>
                    </div>

                    <!-- Post Image -->
                    <div class="mb-4">
                        <label for="image_post" class="form-label fw-bold">
                            <i class="uil uil-image-plus me-2"></i>Post Image
                        </label>
                        <div class="image-upload-container">
                            <div class="upload-area" id="postUploadArea">
                                <i class="uil uil-image-plus upload-icon"></i>
                                <p class="upload-text">Add a post image</p>
                                <p class="upload-hint">Recommended: 400x300px</p>
                                <small class="text-muted">Max: 5MB</small>
                            </div>
                            <input type="file" class="form-control d-none" id="image_post" name="image_post" 
                                   accept="image/*" onchange="handleImageUpload(this, 'post-preview', 'post')">
                        </div>
                        <div class="image-preview mt-3" id="post-preview"></div>
                    </div>

                    <!-- Gallery Images -->
                    <div class="mb-4">
                        <label for="gallery_images" class="form-label fw-bold">
                            <i class="uil uil-images me-2"></i>Additional Photos
                        </label>
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
                                   <?= old('featured') ? 'checked' : '' ?>>
                            <label class="form-check-label fw-bold" for="featured">
                                <i class="uil uil-star me-2"></i>Feature this product on homepage
                            </label>
                        </div>
                        <small class="text-muted">Highlight this product to get more attention</small>
                    </div>

                    <!-- Step 2 Actions -->
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-secondary btn-lg flex-fill" onclick="previousStep()">
                            <i class="uil uil-arrow-left me-2"></i>Back
                        </button>
                        <button type="submit" class="btn btn-success btn-lg flex-fill">
                            <i class="uil uil-check me-2"></i>Create Product
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>

<?= $this->section('custom_scripts'); ?>
<!-- Image Cropper Library -->
<script src="<?= base_url('assets/js/image-cropper.js') ?>"></script>
<script>
let currentStep = 1;

// Step navigation functions
function nextStep() {
    if (validateStep1()) {
        document.getElementById('step1').classList.add('d-none');
        document.getElementById('step2').classList.remove('d-none');
        document.getElementById('step1Indicator').classList.remove('active');
        document.getElementById('step2Indicator').classList.add('active');
        document.getElementById('progressBar').style.width = '100%';
        currentStep = 2;
        window.scrollTo(0, 0);
    }
}

function previousStep() {
    document.getElementById('step2').classList.add('d-none');
    document.getElementById('step1').classList.remove('d-none');
    document.getElementById('step2Indicator').classList.remove('active');
    document.getElementById('step1Indicator').classList.add('active');
    document.getElementById('progressBar').style.width = '50%';
    currentStep = 1;
    window.scrollTo(0, 0);
}

// Validation for step 1
function validateStep1() {
    const requiredFields = ['product_name', 'product_category', 'image_icon'];
    let isValid = true;
    
    // Check required fields
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    // Validate price if provided
    const priceField = document.getElementById('price');
    if (priceField.value.trim() && parseFloat(priceField.value) <= 0) {
        priceField.classList.add('is-invalid');
        isValid = false;
        alert('Price must be greater than 0 if provided.');
        return false;
    } else {
        priceField.classList.remove('is-invalid');
    }
    
    // Validate short description if provided
    const descField = document.getElementById('short_description');
    if (descField.value.trim() && descField.value.trim().length < 10) {
        descField.classList.add('is-invalid');
        isValid = false;
        alert('Brief description must be at least 10 characters if provided.');
        return false;
    } else {
        descField.classList.remove('is-invalid');
    }
    
    if (!isValid) {
        alert('Please fill in all required fields before continuing.\n\nRequired: Product Name, Category, and Photo');
        window.scrollTo(0, 0);
    }
    
    return isValid;
}

// Auto-generate SKU from product name
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
document.getElementById('uploadArea').addEventListener('click', function() {
    document.getElementById('image_icon').click();
});

document.getElementById('galleryUploadArea').addEventListener('click', function() {
    document.getElementById('gallery_images').click();
});

document.getElementById('postUploadArea').addEventListener('click', function() {
    document.getElementById('image_post').click();
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
        
        // Configure cropper options based on type
        const cropperOptions = {
            aspectRatio: type === 'icon' ? 1 : 4/3, // Square for icon, 4:3 for post
            title: type === 'icon' ? 'Crop Product Icon' : 'Crop Product Image',
            outputWidth: type === 'icon' ? 200 : 400,
            outputHeight: type === 'icon' ? 200 : 300,
            onCrop: function(croppedFile, dataUrl) {
                // Update the file input with the cropped file
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(croppedFile);
                input.files = dataTransfer.files;
                
                // Show preview
                showImagePreview(previewId, dataUrl, type);
            },
            onCancel: function() {
                // Reset the input if user cancels
                input.value = '';
                preview.innerHTML = '';
            }
        };
        
        // Show cropper
        ImageCropper.crop(file, cropperOptions).catch(error => {
            console.log('Cropping cancelled or failed:', error.message);
        });
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
        const fileInput = preview.closest('.col-12').querySelector('input[type="file"]');
        fileInput.value = '';
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
        const fileInput = preview.closest('.col-12').querySelector('input[type="file"]');
        fileInput.value = '';
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
    if (!validateStep1()) {
        e.preventDefault();
        alert('Please complete Step 1 before submitting.');
        return false;
    }
});

// Show success/error messages if any
<?php if (session()->getFlashdata('success')): ?>
    // You can add toast notification here
    console.log('Success: <?= session()->getFlashdata('success') ?>');
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    // You can add toast notification here
    console.log('Error: <?= session()->getFlashdata('error') ?>');
<?php endif; ?>
</script>

<style>
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
    .card-body {
        padding: 20px;
    }
    
    .btn-lg {
        padding: 15px 25px;
        font-size: 16px;
    }
    
    .form-control-lg, .form-select-lg {
        padding: 15px 18px;
        font-size: 16px;
    }
    
    .image-upload-container {
        padding: 20px;
    }
    
    .upload-icon {
        font-size: 36px;
    }
    
    .upload-text {
        font-size: 16px;
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
