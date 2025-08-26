<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?> 

<div class="geex-content__section geex-content__form">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><?= $title ?></h2>
            <p class="text-muted mb-0"><?= $subTitle ?></p>
        </div>
        <div>
            <a href="/admin/products" class="btn btn-secondary">
                <i class="uil uil-arrow-left"></i> Back to Products
            </a>
            <a href="/admin/products/view/<?= $product['id'] ?>" class="btn btn-info">
                <i class="uil uil-eye"></i> View Product
            </a>
        </div>
    </div>

    <!-- Step-by-Step Edit Form -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            
            <!-- Progress Indicator -->
            <div class="step-progress p-4 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="step-indicator active" id="step1-indicator">
                        <div class="step-number">1</div>
                        <div class="step-label">Essential Information</div>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" id="progress-fill"></div>
                    </div>
                    <div class="step-indicator" id="step2-indicator">
                        <div class="step-number">2</div>
                        <div class="step-label">Additional Details</div>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="/admin/products/update/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
                
                <!-- Step 1: Essential Information -->
                <div class="step-content active" id="step1">
                    <div class="p-4">
                        <h4 class="mb-4 text-primary">
                            <i class="uil uil-info-circle"></i> Essential Product Information
                        </h4>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="product_name" class="form-label fw-bold">
                                    <i class="uil uil-tag-alt"></i> Product Name *
                                </label>
                                <input type="text" class="form-control form-control-lg <?= session()->getFlashdata('errors.product_name') ? 'is-invalid' : '' ?>" 
                                       id="product_name" name="product_name" 
                                       value="<?= old('product_name', $product['product_name']) ?>" 
                                       placeholder="Enter product name" required>
                                <?php if (session()->getFlashdata('errors.product_name')): ?>
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errors.product_name') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label for="product_category" class="form-label fw-bold">
                                    <i class="uil uil-layer-group"></i> Category *
                                </label>
                                <select class="form-select form-select-lg <?= session()->getFlashdata('errors.product_category') ? 'is-invalid' : '' ?>" 
                                        id="product_category" name="product_category" required>
                                    <option value="">Select Category</option>
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
                            </div>

                            <div class="col-md-6">
                                <label for="price" class="form-label fw-bold">
                                    <i class="uil uil-dollar-sign"></i> Price *
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" step="0.01" class="form-control <?= session()->getFlashdata('errors.price') ? 'is-invalid' : '' ?>" 
                                           id="price" name="price" 
                                           value="<?= old('price', $product['price']) ?>" 
                                           placeholder="0.00" required>
                                    <?php if (session()->getFlashdata('errors.price')): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('errors.price') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="image_icon" class="form-label fw-bold">
                                    <i class="uil uil-image-plus"></i> Main Product Photo *
                                </label>
                                <div class="upload-area" onclick="document.getElementById('image_icon').click()">
                                    <?php if ($product['image_icon']): ?>
                                        <div class="current-image mb-3">
                                            <img src="<?= base_url($product['image_icon']) ?>" alt="Current Icon" 
                                                 class="img-thumbnail" style="max-width: 120px; max-height: 120px;">
                                            <small class="d-block text-muted">Current Image (Click to change)</small>
                                        </div>
                                    <?php endif; ?>
                                    <div class="upload-content">
                                        <i class="uil uil-cloud-upload-alt"></i>
                                        <p class="mb-2">Click to upload or drag & drop</p>
                                        <small class="text-muted">PNG, JPG up to 2MB</small>
                                    </div>
                                </div>
                                <input type="file" class="d-none" id="image_icon" name="image_icon" 
                                       accept="image/*" onchange="handleImageUpload(this, 'icon-preview', 'icon')">
                                <div class="image-preview mt-2" id="icon-preview"></div>
                            </div>

                            <div class="col-12">
                                <label for="short_description" class="form-label fw-bold">
                                    <i class="uil uil-align-left"></i> Brief Description *
                                </label>
                                <textarea class="form-control form-control-lg" id="short_description" name="short_description" 
                                          rows="3" placeholder="Brief description of the product" required><?= old('short_description', $product['short_description']) ?></textarea>
                                <?php if (session()->getFlashdata('errors.short_description')): ?>
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errors.short_description') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary btn-lg px-4" onclick="nextStep()">
                                Continue to Details <i class="uil uil-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Additional Details -->
                <div class="step-content" id="step2">
                    <div class="p-4">
                        <h4 class="mb-4 text-success">
                            <i class="uil uil-plus-circle"></i> Additional Product Details
                        </h4>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="description" class="form-label fw-bold">
                                    <i class="uil uil-file-text-alt"></i> Full Description
                                </label>
                                <textarea class="form-control form-control-lg" id="description" name="description" 
                                          rows="5" placeholder="Detailed description of the product"><?= old('description', $product['description']) ?></textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="sale_price" class="form-label fw-bold">
                                    <i class="uil uil-percentage"></i> Sale Price
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price" 
                                           value="<?= old('sale_price', $product['sale_price']) ?>" 
                                           placeholder="0.00">
                                </div>
                                <small class="text-muted">Leave empty if no sale price</small>
                            </div>

                            <div class="col-md-6">
                                <label for="stock_quantity" class="form-label fw-bold">
                                    <i class="uil uil-box"></i> Stock Quantity
                                </label>
                                <input type="number" class="form-control form-control-lg" id="stock_quantity" name="stock_quantity" 
                                       value="<?= old('stock_quantity', $product['stock_quantity']) ?>" 
                                       placeholder="0" min="0">
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold">
                                    <i class="uil uil-toggle-on"></i> Product Status
                                </label>
                                <select class="form-select form-select-lg" id="status" name="status">
                                    <option value="active" <?= old('status', $product['status']) === 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= old('status', $product['status']) === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    <option value="draft" <?= old('status', $product['status']) === 'draft' ? 'selected' : '' ?>>Draft</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="sku" class="form-label fw-bold">
                                    <i class="uil uil-barcode"></i> SKU
                                </label>
                                <input type="text" class="form-control form-control-lg" id="sku" name="sku" 
                                       value="<?= old('sku', $product['sku']) ?>" 
                                       placeholder="Auto-generated if empty">
                            </div>

                            <div class="col-md-6">
                                <label for="weight" class="form-label fw-bold">
                                    <i class="uil uil-weight"></i> Weight (kg)
                                </label>
                                <input type="number" step="0.01" class="form-control form-control-lg" id="weight" name="weight" 
                                       value="<?= old('weight', $product['weight']) ?>" 
                                       placeholder="0.00">
                            </div>

                            <div class="col-md-6">
                                <label for="dimensions" class="form-label fw-bold">
                                    <i class="uil uil-ruler-combined"></i> Dimensions
                                </label>
                                <input type="text" class="form-control form-control-lg" id="dimensions" name="dimensions" 
                                       value="<?= old('dimensions', $product['dimensions']) ?>" 
                                       placeholder="L x W x H cm">
                            </div>

                            <div class="col-12">
                                <label for="image_post" class="form-label fw-bold">
                                    <i class="uil uil-image-plus"></i> Post Image
                                </label>
                                <div class="upload-area" onclick="document.getElementById('image_post').click()">
                                    <?php if ($product['image_post']): ?>
                                        <div class="current-image mb-3">
                                            <img src="<?= base_url($product['image_post']) ?>" alt="Current Post" 
                                                 class="img-thumbnail" style="max-width: 150px; max-height: 100px;">
                                            <small class="d-block text-muted">Current Image (Click to change)</small>
                                        </div>
                                    <?php endif; ?>
                                    <div class="upload-content">
                                        <i class="uil uil-cloud-upload-alt"></i>
                                        <p class="mb-2">Click to upload or drag & drop</p>
                                        <small class="text-muted">PNG, JPG up to 5MB</small>
                                    </div>
                                </div>
                                <input type="file" class="d-none" id="image_post" name="image_post" 
                                       accept="image/*" onchange="handleImageUpload(this, 'post-preview', 'post')">
                                <div class="image-preview mt-2" id="post-preview"></div>
                            </div>

                            <div class="col-12">
                                <label for="gallery_images" class="form-label fw-bold">
                                    <i class="uil uil-images"></i> Gallery Images
                                </label>
                                
                                <!-- Existing Gallery Images -->
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
                                
                                <div class="upload-area" onclick="document.getElementById('gallery_images').click()">
                                    <div class="upload-content">
                                        <i class="uil uil-cloud-upload-alt"></i>
                                        <p class="mb-2">Click to upload or drag & drop</p>
                                        <small class="text-muted">Up to 6 images, 10MB each</small>
                                    </div>
                                </div>
                                <input type="file" class="d-none" id="gallery_images" name="gallery_images[]" 
                                       accept="image/*" multiple onchange="previewGalleryImages(this)">
                                <div class="gallery-preview mt-2" id="gallery-preview"></div>
                            </div>

                            <div class="col-12">
                                <div class="form-check form-check-lg">
                                    <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" 
                                           <?= old('featured', $product['featured']) ? 'checked' : '' ?>>
                                    <label class="form-check-label fw-bold" for="featured">
                                        <i class="uil uil-star"></i> Featured Product
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary btn-lg px-4" onclick="previousStep()">
                                <i class="uil uil-arrow-left"></i> Back
                            </button>
                            <button type="submit" class="btn btn-success btn-lg px-4">
                                <i class="uil uil-save"></i> Update Product
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Preview" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('custom_scripts'); ?>
<script>
let currentStep = 1;

function nextStep() {
    if (validateStep1()) {
        document.getElementById('step1').classList.remove('active');
        document.getElementById('step2').classList.add('active');
        document.getElementById('step1-indicator').classList.remove('active');
        document.getElementById('step2-indicator').classList.add('active');
        document.getElementById('progress-fill').style.width = '100%';
        currentStep = 2;
    }
}

function previousStep() {
    document.getElementById('step2').classList.remove('active');
    document.getElementById('step1').classList.add('active');
    document.getElementById('step2-indicator').classList.remove('active');
    document.getElementById('step1-indicator').classList.add('active');
    document.getElementById('progress-fill').style.width = '50%';
    currentStep = 1;
}

function validateStep1() {
    const productName = document.getElementById('product_name').value.trim();
    const category = document.getElementById('product_category').value;
    const price = document.getElementById('price').value;
    const shortDescription = document.getElementById('short_description').value.trim();
    
    if (!productName) {
        alert('Please enter a product name');
        document.getElementById('product_name').focus();
        return false;
    }
    
    if (!category) {
        alert('Please select a category');
        document.getElementById('product_category').focus();
        return false;
    }
    
    if (!price || price <= 0) {
        alert('Please enter a valid price');
        document.getElementById('price').focus();
        return false;
    }
    
    if (!shortDescription) {
        alert('Please enter a brief description');
        document.getElementById('short_description').focus();
        return false;
    }
    
    return true;
}

// Image upload area click handlers
document.addEventListener('DOMContentLoaded', function() {
    const uploadAreas = document.querySelectorAll('.upload-area');
    uploadAreas.forEach(area => {
        area.addEventListener('click', function() {
            const input = this.querySelector('input[type="file"]') || this.nextElementSibling;
            if (input) input.click();
        });
    });
});

// Enhanced image handling with cropping
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
        
        const reader = new FileReader();
        reader.onload = function(e) {
            // Create cropping interface
            const cropContainer = document.createElement('div');
            cropContainer.className = 'crop-container';
            cropContainer.style.cssText = `
                max-width: 400px;
                margin: 0 auto;
                text-align: center;
            `;
            
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-fluid';
            img.style.cssText = `
                max-width: 100%;
                max-height: 300px;
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            `;
            
            // Add dimension info and crop controls
            const cropControls = document.createElement('div');
            cropControls.className = 'crop-controls mt-3';
            
            // Show dimension requirements
            const dimensionInfo = document.createElement('div');
            dimensionInfo.className = 'dimension-info mb-3 p-3 bg-light rounded';
            dimensionInfo.innerHTML = `
                <div class="row text-center">
                    <div class="col-6">
                        <strong>Required Size:</strong><br>
                        <span class="badge bg-primary">${type === 'icon' ? '200 × 200px' : '400 × 300px'}</span>
                    </div>
                    <div class="col-6">
                        <strong>Display:</strong><br>
                        <span class="text-muted">${type === 'icon' ? 'Product icon (square)' : 'Product post image'}</span>
                    </div>
                </div>
                <small class="text-muted d-block mt-2">
                    <i class="uil uil-info-circle"></i> 
                    ${type === 'icon' ? 'This will appear as a square icon on your product listings' : 'This will be displayed as a rectangular image on your product pages'}
                </small>
            `;
            
            cropControls.innerHTML = `
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-primary" onclick="rotateImage(this, -90)">
                        <i class="uil uil-undo"></i> Rotate Left
                    </button>
                    <button type="button" class="btn btn-outline-primary" onclick="rotateImage(this, 90)">
                        <i class="uil uil-redo"></i> Rotate Right
                    </button>
                </div>
                <div class="mt-2">
                    <button type="button" class="btn btn-success btn-sm" onclick="showCropInterface('${previewId}', '${type}')">
                        <i class="uil uil-crop"></i> Select Crop Area
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm ms-2" onclick="resetImage('${previewId}', '${input.id}')">
                        <i class="uil uil-refresh"></i> Reset
                    </button>
                </div>
            `;
            
            cropContainer.appendChild(dimensionInfo);
            cropContainer.appendChild(cropControls);
            
            cropContainer.appendChild(img);
            cropContainer.appendChild(cropControls);
            preview.appendChild(cropContainer);
            
            // Store original image data for rotation
            img.dataset.originalSrc = e.target.result;
            img.dataset.rotation = '0';
        };
        reader.readAsDataURL(file);
    }
}

// Rotate image function
function rotateImage(btn, degrees) {
    const img = btn.closest('.crop-container').querySelector('img');
    const currentRotation = parseInt(img.dataset.rotation) || 0;
    const newRotation = currentRotation + degrees;
    img.dataset.rotation = newRotation;
    img.style.transform = `rotate(${newRotation}deg)`;
}

// Show interactive crop interface
function showCropInterface(previewId, type) {
    const preview = document.getElementById(previewId);
    const img = preview.querySelector('img');
    const originalSrc = img.dataset.originalSrc;
    
    // Create crop overlay
    const cropOverlay = document.createElement('div');
    cropOverlay.className = 'crop-overlay';
    cropOverlay.style.cssText = `
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.7);
        z-index: 10;
    `;
    
    // Create crop frame
    const cropFrame = document.createElement('div');
    cropFrame.className = 'crop-frame';
    cropFrame.style.cssText = `
        position: absolute;
        border: 2px solid #00ff00;
        background: rgba(0,255,0,0.1);
        cursor: move;
        box-shadow: 0 0 20px rgba(0,255,0,0.5);
    `;
    
    // Set initial crop frame size and position
    const imgRect = img.getBoundingClientRect();
    const containerRect = preview.getBoundingClientRect();
    
    let frameWidth, frameHeight;
    if (type === 'icon') {
        frameWidth = Math.min(200, imgRect.width * 0.8);
        frameHeight = frameWidth; // Square
    } else {
        frameWidth = Math.min(400, imgRect.width * 0.8);
        frameHeight = frameWidth * 0.75; // 4:3 ratio
    }
    
    cropFrame.style.width = frameWidth + 'px';
    cropFrame.style.height = frameHeight + 'px';
    cropFrame.style.left = (imgRect.width - frameWidth) / 2 + 'px';
    cropFrame.style.top = (imgRect.height - frameHeight) / 2 + 'px';
    
    // Add resize handles
    const resizeHandle = document.createElement('div');
    resizeHandle.className = 'resize-handle';
    resizeHandle.style.cssText = `
        position: absolute;
        bottom: -10px;
        right: -10px;
        width: 20px;
        height: 20px;
        background: #00ff00;
        border-radius: 50%;
        cursor: nw-resize;
        border: 2px solid white;
    `;
    cropFrame.appendChild(resizeHandle);
    
    // Add crop controls
    const cropActions = document.createElement('div');
    cropActions.className = 'crop-actions';
    cropActions.style.cssText = `
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 20;
    `;
    cropActions.innerHTML = `
        <div class="btn-group">
            <button type="button" class="btn btn-success btn-sm" onclick="applyCrop('${previewId}', '${type}')">
                <i class="uil uil-check"></i> Apply Crop
            </button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="cancelCrop('${previewId}')">
                <i class="uil uil-times"></i> Cancel
            </button>
        </div>
    `;
    
    // Make crop frame draggable
    let isDragging = false;
    let startX, startY, startLeft, startTop;
    
    cropFrame.addEventListener('mousedown', function(e) {
        if (e.target === resizeHandle) return;
        isDragging = true;
        startX = e.clientX;
        startY = e.clientY;
        startLeft = parseInt(cropFrame.style.left);
        startTop = parseInt(cropFrame.style.top);
        cropFrame.style.cursor = 'grabbing';
    });
    
    document.addEventListener('mousemove', function(e) {
        if (!isDragging) return;
        
        const deltaX = e.clientX - startX;
        const deltaY = e.clientY - startY;
        
        let newLeft = startLeft + deltaX;
        let newTop = startTop + deltaY;
        
        // Constrain to image bounds
        newLeft = Math.max(0, Math.min(newLeft, imgRect.width - frameWidth));
        newTop = Math.max(0, Math.min(newTop, imgRect.height - frameHeight));
        
        cropFrame.style.left = newLeft + 'px';
        cropFrame.style.top = newTop + 'px';
    });
    
    document.addEventListener('mouseup', function() {
        isDragging = false;
        cropFrame.style.cursor = 'move';
    });
    
    // Make crop frame resizable
    let isResizing = false;
    let startResizeX, startResizeY, startWidth, startHeight;
    
    resizeHandle.addEventListener('mousedown', function(e) {
        e.stopPropagation();
        isResizing = true;
        startResizeX = e.clientX;
        startResizeY = e.clientY;
        startWidth = parseInt(cropFrame.style.width);
        startHeight = parseInt(cropFrame.style.height);
    });
    
    document.addEventListener('mousemove', function(e) {
        if (!isResizing) return;
        
        const deltaX = e.clientX - startResizeX;
        const deltaY = e.clientY - startResizeY;
        
        let newWidth = startWidth + deltaX;
        let newHeight = startHeight + deltaY;
        
        // Maintain aspect ratio
        if (type === 'icon') {
            newHeight = newWidth; // Square
        } else {
            newHeight = newWidth * 0.75; // 4:3 ratio
        }
        
        // Constrain minimum size
        newWidth = Math.max(100, newWidth);
        newHeight = Math.max(75, newHeight);
        
        // Constrain to image bounds
        const maxWidth = imgRect.width - parseInt(cropFrame.style.left);
        const maxHeight = imgRect.height - parseInt(cropFrame.style.top);
        newWidth = Math.min(newWidth, maxWidth);
        newHeight = Math.min(newHeight, maxHeight);
        
        cropFrame.style.width = newWidth + 'px';
        cropFrame.style.height = newHeight + 'px';
    });
    
    document.addEventListener('mouseup', function() {
        isResizing = false;
    });
    
    cropOverlay.appendChild(cropFrame);
    cropOverlay.appendChild(cropActions);
    
    // Position the container relatively for absolute positioning
    const container = preview.querySelector('.crop-container');
    container.style.position = 'relative';
    container.appendChild(cropOverlay);
    
    // Store crop data for later use
    cropFrame.dataset.cropData = JSON.stringify({
        left: parseInt(cropFrame.style.left),
        top: parseInt(cropFrame.style.top),
        width: parseInt(cropFrame.style.width),
        height: parseInt(cropFrame.style.height)
    });
}

// Apply the crop based on user selection
function applyCrop(previewId, type) {
    const preview = document.getElementById(previewId);
    const img = preview.querySelector('img');
    const cropFrame = preview.querySelector('.crop-frame');
    const cropOverlay = preview.querySelector('.crop-overlay');
    
    if (!cropFrame) return;
    
    const cropData = JSON.parse(cropFrame.dataset.cropData);
    const originalSrc = img.dataset.originalSrc;
    
    // Create canvas for cropping
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    
    // Set canvas size based on type
    if (type === 'icon') {
        canvas.width = 200;
        canvas.height = 200;
    } else {
        canvas.width = 400;
        canvas.height = 300;
    }
    
    // Create temporary image for processing
    const tempImg = new Image();
    tempImg.onload = function() {
        // Calculate crop dimensions relative to original image
        const imgRect = img.getBoundingClientRect();
        const scaleX = tempImg.width / imgRect.width;
        const scaleY = tempImg.height / imgRect.height;
        
        const cropX = cropData.left * scaleX;
        const cropY = cropData.top * scaleY;
        const cropWidth = cropData.width * scaleX;
        const cropHeight = cropData.height * scaleY;
        
        // Apply rotation and crop
        ctx.save();
        ctx.translate(canvas.width / 2, canvas.height / 2);
        ctx.rotate((parseInt(img.dataset.rotation) || 0) * Math.PI / 180);
        ctx.drawImage(tempImg, cropX, cropY, cropWidth, cropHeight, -canvas.width / 2, -canvas.height / 2, canvas.width, canvas.height);
        ctx.restore();
        
        // Convert to blob and create file
        canvas.toBlob(function(blob) {
            // Create a new file input with the cropped image
            const croppedFile = new File([blob], 'cropped_image.jpg', { type: 'image/jpeg' });
            
            // Update the file input
            const fileInput = preview.closest('.col-12').querySelector('input[type="file"]');
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            fileInput.files = dataTransfer.files;
            
            // Show final preview
            showFinalPreview(previewId, canvas.toDataURL(), type);
            
            // Remove crop overlay
            if (cropOverlay) cropOverlay.remove();
        }, 'image/jpeg', 0.9);
    };
    tempImg.src = originalSrc;
}

// Cancel crop operation
function cancelCrop(previewId) {
    const preview = document.getElementById(previewId);
    const cropOverlay = preview.querySelector('.crop-overlay');
    if (cropOverlay) cropOverlay.remove();
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
function previewGalleryImages(input) {
    const preview = document.getElementById('gallery-preview');
    preview.innerHTML = '';
    
    if (input.files) {
        const maxFiles = 6;
        const maxSize = 10 * 1024 * 1024; // 10MB
        
        if (input.files.length > maxFiles) {
            alert('Maximum ' + maxFiles + ' images allowed.');
            input.value = '';
            return;
        }
        
        for (let i = 0; i < input.files.length; i++) {
            const file = input.files[i];
            
            // Validate file size
            if (file.size > maxSize) {
                alert('File "' + file.name + '" is too large. Maximum 10MB allowed.');
                input.value = '';
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
        }
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

// Image modal function
function openImageModal(imageSrc, title) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModalLabel').textContent = title;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>

<style>
/* Enhanced image cropping styles */
.crop-container {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin: 15px 0;
    position: relative;
}

.dimension-info {
    border-left: 4px solid #007bff;
}

.crop-overlay {
    border-radius: 12px;
    overflow: hidden;
}

.crop-frame {
    transition: all 0.2s ease;
}

.crop-frame:hover {
    border-color: #00ff88;
    box-shadow: 0 0 25px rgba(0,255,136,0.6);
}

.resize-handle {
    transition: all 0.2s ease;
}

.resize-handle:hover {
    background: #00ff88 !important;
    transform: scale(1.2);
}

.crop-actions {
    background: rgba(0,0,0,0.8);
    padding: 10px 20px;
    border-radius: 25px;
    backdrop-filter: blur(10px);
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

/* Step-by-step form styling */
.step-content {
    display: none;
}

.step-content.active {
    display: block;
}

.step-progress {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
}

.step-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    opacity: 0.6;
    transition: all 0.3s ease;
}

.step-indicator.active {
    opacity: 1;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #6c757d;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
}

.step-indicator.active .step-number {
    background: linear-gradient(135deg, #007bff, #0056b3);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}

.step-label {
    font-size: 14px;
    font-weight: 500;
    color: #495057;
    text-align: center;
}

.step-indicator.active .step-label {
    color: #007bff;
    font-weight: 600;
}

.progress-bar {
    flex: 1;
    height: 4px;
    background: #e9ecef;
    border-radius: 2px;
    margin: 0 20px;
    position: relative;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-radius: 2px;
    width: 50%;
    transition: width 0.3s ease;
}

/* Card styling */
.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-body {
    background: #ffffff;
}

/* Form controls */
.form-control-lg, .form-select-lg, .input-group-lg {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control-lg:focus, .form-select-lg:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Buttons */
.btn-lg {
    border-radius: 10px;
    font-weight: 600;
    padding: 12px 24px;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
}

.btn-success {
    background: linear-gradient(135deg, #28a745, #1e7e34);
    border: none;
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
}

/* Image upload areas */
.upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 15px;
    padding: 30px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.upload-area:hover {
    border-color: #007bff;
    background: #e3f2fd;
    transform: translateY(-2px);
}

.upload-content i {
    font-size: 48px;
    color: #6c757d;
    margin-bottom: 15px;
}

.upload-area:hover .upload-content i {
    color: #007bff;
}

.upload-content p {
    margin: 0;
    font-weight: 500;
    color: #495057;
}

.upload-content small {
    color: #6c757d;
}

.current-image {
    text-align: center;
}

.current-image img {
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Form labels */
.form-label {
    color: #495057;
    margin-bottom: 8px;
}

.form-label i {
    margin-right: 8px;
    color: #007bff;
}

/* Checkbox styling */
.form-check-lg .form-check-input {
    width: 20px;
    height: 20px;
    margin-top: 0.2rem;
}

.form-check-lg .form-check-label {
    font-size: 16px;
    padding-left: 8px;
}

/* Mobile optimizations */
@media (max-width: 768px) {
    .step-progress {
        padding: 20px 15px;
    }
    
    .step-label {
        font-size: 12px;
    }
    
    .step-number {
        width: 35px;
        height: 35px;
        font-size: 16px;
    }
    
    .progress-bar {
        margin: 0 15px;
    }
    
    .card-body {
        padding: 20px 15px;
    }
    
    .upload-area {
        padding: 20px 15px;
    }
    
    .btn-lg {
        padding: 10px 20px;
        font-size: 16px;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 15px;
    }
    
    .d-flex.justify-content-between .btn {
        width: 100%;
    }
}

/* Gallery preview */
.gallery-preview img {
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Image preview */
.image-preview img {
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}
</style>
<?= $this->endSection(); ?>
