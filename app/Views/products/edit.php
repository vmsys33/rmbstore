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
                                       accept="image/*" onchange="previewImage(this, 'icon-preview')">
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
                                       accept="image/*" onchange="previewImage(this, 'post-preview')">
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

// Image preview function
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file size
        const maxSize = input.id === 'image_icon' ? 2 * 1024 * 1024 : 5 * 1024 * 1024; // 2MB for icon, 5MB for post
        if (file.size > maxSize) {
            alert('File size too large. Maximum ' + (maxSize / 1024 / 1024) + 'MB allowed.');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '150px';
            img.style.maxHeight = '150px';
            img.className = 'img-thumbnail';
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    }
}

// Gallery images preview function
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
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '120px';
                img.style.maxHeight = '80px';
                img.className = 'img-thumbnail me-2 mb-2';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    }
}

// Image modal function
function openImageModal(imageSrc, title) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModalLabel').textContent = title;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>

<style>
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
