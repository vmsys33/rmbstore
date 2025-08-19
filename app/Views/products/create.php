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
        </div>
    </div>

    <!-- Create Form -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Add New Product</h5>
        </div>
        <div class="card-body">
            <form action="/admin/products/store" method="POST" enctype="multipart/form-data">
                <!-- Basic Information -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name *</label>
                            <input type="text" class="form-control <?= session()->getFlashdata('errors.product_name') ? 'is-invalid' : '' ?>" 
                                   id="product_name" name="product_name" 
                                   value="<?= old('product_name') ?>" required>
                            <?php if (session()->getFlashdata('errors.product_name')): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors.product_name') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU *</label>
                            <input type="text" class="form-control <?= session()->getFlashdata('errors.sku') ? 'is-invalid' : '' ?>" 
                                   id="sku" name="sku" 
                                   value="<?= old('sku') ?>" required>
                            <?php if (session()->getFlashdata('errors.sku')): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors.sku') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="product_category" class="form-label">Category *</label>
                            <select class="form-select <?= session()->getFlashdata('errors.product_category') ? 'is-invalid' : '' ?>" 
                                    id="product_category" name="product_category" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" 
                                            <?= old('product_category') == $category['id'] ? 'selected' : '' ?>>
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
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-select <?= session()->getFlashdata('errors.status') ? 'is-invalid' : '' ?>" 
                                    id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="active" <?= old('status') === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                <option value="draft" <?= old('status') === 'draft' ? 'selected' : '' ?>>Draft</option>
                            </select>
                            <?php if (session()->getFlashdata('errors.status')): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors.status') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="price" class="form-label">Price *</label>
                            <div class="input-group">
                                <span class="input-group-text"><?= $currencySymbol ?></span>
                                <input type="number" step="0.01" class="form-control <?= session()->getFlashdata('errors.price') ? 'is-invalid' : '' ?>" 
                                       id="price" name="price" 
                                       value="<?= old('price') ?>" required>
                                <?php if (session()->getFlashdata('errors.price')): ?>
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errors.price') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="sale_price" class="form-label">Sale Price</label>
                            <div class="input-group">
                                <span class="input-group-text"><?= $currencySymbol ?></span>
                                <input type="number" step="0.01" class="form-control" 
                                       id="sale_price" name="sale_price" 
                                       value="<?= old('sale_price') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                            <input type="number" class="form-control <?= session()->getFlashdata('errors.stock_quantity') ? 'is-invalid' : '' ?>" 
                                   id="stock_quantity" name="stock_quantity" 
                                   value="<?= old('stock_quantity') ?>" required>
                            <?php if (session()->getFlashdata('errors.stock_quantity')): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors.stock_quantity') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Physical Properties -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" step="0.01" class="form-control" 
                                   id="weight" name="weight" 
                                   value="<?= old('weight') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="dimensions" class="form-label">Dimensions</label>
                            <input type="text" class="form-control" 
                                   id="dimensions" name="dimensions" 
                                   value="<?= old('dimensions') ?>" placeholder="L x W x H cm">
                        </div>
                    </div>
                </div>

                <!-- Descriptions -->
                <div class="mb-3">
                    <label for="short_description" class="form-label">Short Description</label>
                    <textarea class="form-control" id="short_description" name="short_description" 
                              rows="3" placeholder="Brief description of the product"><?= old('short_description') ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Full Description</label>
                    <textarea class="form-control" id="description" name="description" 
                              rows="5" placeholder="Detailed description of the product"><?= old('description') ?></textarea>
                </div>

                <!-- Images with Auto-Cropping -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image_icon" class="form-label">Icon Image (54×54px)</label>
                            <div class="image-upload-container">
                                <input type="file" class="form-control" id="image_icon" name="image_icon" 
                                       accept="image/*" onchange="handleImageUpload(this, 'icon', 54, 54)">
                                <div class="image-preview mt-2" id="icon-preview"></div>
                                <small class="text-muted">Will be automatically cropped to 54×54px</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image_post" class="form-label">Post Image (431×467px)</label>
                            <div class="image-upload-container">
                                <input type="file" class="form-control" id="image_post" name="image_post" 
                                       accept="image/*" onchange="handleImageUpload(this, 'post', 431, 467)">
                                <div class="image-preview mt-2" id="post-preview"></div>
                                <small class="text-muted">Will be automatically cropped to 431×467px</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" 
                                       <?= old('featured') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="featured">
                                    Featured Product
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gallery Images -->
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="gallery_images" class="form-label">Gallery Images (1200×800px)</label>
                            <div class="image-upload-container">
                                <input type="file" class="form-control" id="gallery_images" name="gallery_images[]" 
                                       accept="image/*" multiple onchange="handleGalleryUpload(this)">
                                <div class="gallery-preview mt-2" id="gallery-preview"></div>
                                <small class="text-muted">Will be automatically cropped to 1200×800px (Max: 6 images)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="/admin/products" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="uil uil-save"></i> Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Cropping Modal -->
<div class="modal fade" id="croppingModal" tabindex="-1" aria-labelledby="croppingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="croppingModalLabel">Crop Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="cropper-container">
                            <div id="cropper-wrapper" class="position-relative">
                                <img id="cropper-image" src="" alt="Crop Image" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cropper-controls">
                            <h6>Target Size: <span id="target-size"></span></h6>
                            <div class="mb-3">
                                <label class="form-label">Zoom</label>
                                <input type="range" class="form-range" id="zoom-slider" min="0.5" max="3" step="0.1" value="1">
                                <small class="text-muted">Use pinch gestures on mobile</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rotation</label>
                                <input type="range" class="form-range" id="rotation-slider" min="-180" max="180" step="1" value="0">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary" id="crop-btn">
                                    <i class="uil uil-crop"></i> Crop & Save
                                </button>
                                <button type="button" class="btn btn-secondary" id="reset-btn">
                                    <i class="uil uil-refresh"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('custom_scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">

<script>
let cropper = null;
let currentUploadType = null;
let currentTargetWidth = 0;
let currentTargetHeight = 0;

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

// Handle image upload with auto-cropping
function handleImageUpload(input, type, targetWidth, targetHeight) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file type
        if (!file.type.match('image.*')) {
            alert('Please select an image file.');
            input.value = '';
            return;
        }
        
        // Validate file size
        const maxSize = type === 'icon' ? 2 * 1024 * 1024 : 5 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('File size too large. Maximum ' + (maxSize / 1024 / 1024) + 'MB allowed.');
            input.value = '';
            return;
        }
        
        // Set current upload type and dimensions
        currentUploadType = type;
        currentTargetWidth = targetWidth;
        currentTargetHeight = targetHeight;
        
        // Show cropping modal
        const modal = new bootstrap.Modal(document.getElementById('croppingModal'));
        document.getElementById('target-size').textContent = `${targetWidth}×${targetHeight}px`;
        
        // Load image into cropper
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('cropper-image');
            img.src = e.target.result;
            
            modal.show();
            
            // Initialize cropper after modal is shown
            setTimeout(() => {
                initCropper(targetWidth, targetHeight);
            }, 300);
        };
        reader.readAsDataURL(file);
    }
}

// Handle gallery upload
function handleGalleryUpload(input) {
    if (input.files) {
        const maxFiles = 6;
        const maxSize = 10 * 1024 * 1024; // 10MB
        
        if (input.files.length > maxFiles) {
            alert('Maximum ' + maxFiles + ' images allowed.');
            input.value = '';
            return;
        }
        
        // Process each gallery image
        Array.from(input.files).forEach((file, index) => {
            if (file.size > maxSize) {
                alert('File "' + file.name + '" is too large. Maximum 10MB allowed.');
                return;
            }
            
            if (!file.type.match('image.*')) {
                alert('File "' + file.name + '" is not an image.');
                return;
            }
            
            // For gallery images, we'll crop them to 1200x800
            currentUploadType = 'gallery';
            currentTargetWidth = 1200;
            currentTargetHeight = 800;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('cropper-image');
                img.src = e.target.result;
                
                const modal = new bootstrap.Modal(document.getElementById('croppingModal'));
                document.getElementById('target-size').textContent = '1200×800px';
                modal.show();
                
                setTimeout(() => {
                    initCropper(1200, 800);
                }, 300);
            };
            reader.readAsDataURL(file);
        });
    }
}

// Initialize cropper
function initCropper(targetWidth, targetHeight) {
    const image = document.getElementById('cropper-image');
    
    if (cropper) {
        cropper.destroy();
    }
    
    cropper = new Cropper(image, {
        aspectRatio: targetWidth / targetHeight,
        viewMode: 2,
        dragMode: 'move',
        autoCropArea: 1,
        restore: false,
        guides: true,
        center: true,
        highlight: false,
        cropBoxMovable: true,
        cropBoxResizable: true,
        toggleDragModeOnDblclick: false,
        responsive: true,
        zoomable: true,
        zoomOnTouch: true,
        zoomOnWheel: true,
        wheelZoomRatio: 0.1,
        touchDragZoom: true,
        mouseWheelZoom: true,
        ready: function() {
            // Set initial zoom and position
            cropper.zoomTo(1);
        }
    });
    
    // Handle zoom slider
    document.getElementById('zoom-slider').addEventListener('input', function() {
        cropper.zoomTo(parseFloat(this.value));
    });
    
    // Handle rotation slider
    document.getElementById('rotation-slider').addEventListener('input', function() {
        cropper.rotateTo(parseFloat(this.value));
    });
}

// Crop and save button
document.getElementById('crop-btn').addEventListener('click', function() {
    if (cropper) {
        const canvas = cropper.getCroppedCanvas({
            width: currentTargetWidth,
            height: currentTargetHeight,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high'
        });
        
        // Convert canvas to blob
        canvas.toBlob(function(blob) {
            // Create a new file input with the cropped image
            const croppedFile = new File([blob], 'cropped_image.jpg', { type: 'image/jpeg' });
            
            // Create a new FileList-like object
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            
            // Update the appropriate input
            if (currentUploadType === 'icon') {
                document.getElementById('image_icon').files = dataTransfer.files;
                showCroppedPreview('icon-preview', canvas.toDataURL());
            } else if (currentUploadType === 'post') {
                document.getElementById('image_post').files = dataTransfer.files;
                showCroppedPreview('post-preview', canvas.toDataURL());
            } else if (currentUploadType === 'gallery') {
                // For gallery, we'll add to the existing files
                addGalleryImage(canvas.toDataURL());
            }
            
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('croppingModal')).hide();
        }, 'image/jpeg', 0.9);
    }
});

// Reset button
document.getElementById('reset-btn').addEventListener('click', function() {
    if (cropper) {
        cropper.reset();
        document.getElementById('zoom-slider').value = 1;
        document.getElementById('rotation-slider').value = 0;
    }
});

// Show cropped preview
function showCroppedPreview(previewId, dataUrl) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    
    const img = document.createElement('img');
    img.src = dataUrl;
    img.style.maxWidth = '150px';
    img.style.maxHeight = '150px';
    img.style.borderRadius = '8px';
    img.style.border = '2px solid #ddd';
    
    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'btn btn-sm btn-danger mt-1';
    removeBtn.innerHTML = '<i class="uil uil-trash-alt"></i> Remove';
    removeBtn.onclick = function() {
        if (currentUploadType === 'icon') {
            document.getElementById('image_icon').value = '';
        } else if (currentUploadType === 'post') {
            document.getElementById('image_post').value = '';
        }
        preview.innerHTML = '';
    };
    
    preview.appendChild(img);
    preview.appendChild(document.createElement('br'));
    preview.appendChild(removeBtn);
}

// Add gallery image
function addGalleryImage(dataUrl) {
    const preview = document.getElementById('gallery-preview');
    
    const container = document.createElement('div');
    container.className = 'd-inline-block me-2 mb-2';
    container.style.position = 'relative';
    
    const img = document.createElement('img');
    img.src = dataUrl;
    img.style.width = '100px';
    img.style.height = '80px';
    img.style.objectFit = 'cover';
    img.style.borderRadius = '8px';
    img.style.border = '2px solid #ddd';
    
    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'btn btn-sm btn-danger';
    removeBtn.style.position = 'absolute';
    removeBtn.style.top = '-5px';
    removeBtn.style.right = '-5px';
    removeBtn.style.borderRadius = '50%';
    removeBtn.style.width = '25px';
    removeBtn.style.height = '25px';
    removeBtn.style.padding = '0';
    removeBtn.innerHTML = '×';
    removeBtn.onclick = function() {
        container.remove();
    };
    
    container.appendChild(img);
    container.appendChild(removeBtn);
    preview.appendChild(container);
}

// Clean up cropper when modal is closed
document.getElementById('croppingModal').addEventListener('hidden.bs.modal', function() {
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
});

// Show success/error messages if any
<?php if (session()->getFlashdata('success')): ?>
    console.log('Success: <?= session()->getFlashdata('success') ?>');
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    console.log('Error: <?= session()->getFlashdata('error') ?>');
<?php endif; ?>
</script>

<style>
.image-upload-container {
    border: 2px dashed #ddd;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    background-color: #f8f9fa;
    transition: border-color 0.3s ease;
}

.image-upload-container:hover {
    border-color: #007bff;
}

.image-preview {
    min-height: 50px;
}

.gallery-preview {
    min-height: 120px;
}

.cropper-container {
    max-height: 500px;
    overflow: hidden;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.cropper-controls {
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 8px;
    height: fit-content;
}

/* Mobile responsive styles */
@media (max-width: 768px) {
    .modal-xl {
        margin: 10px;
        max-width: calc(100% - 20px);
    }
    
    .cropper-container {
        max-height: 300px;
    }
    
    .cropper-controls {
        margin-top: 15px;
    }
    
    .form-range {
        width: 100%;
    }
}

/* Touch-friendly controls for mobile */
@media (max-width: 768px) {
    .btn {
        padding: 12px 20px;
        font-size: 16px;
    }
    
    .cropper-controls .d-grid {
        gap: 10px !important;
    }
}
</style>
<?= $this->endSection(); ?>
