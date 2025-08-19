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
            <a href="/products" class="btn btn-secondary">
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
                                <span class="input-group-text">$</span>
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
                                <span class="input-group-text">$</span>
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

                <!-- Images -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image_icon" class="form-label">Icon Image</label>
                            <div class="image-upload-container">
                                <input type="file" class="form-control" id="image_icon" name="image_icon" 
                                       accept="image/*" onchange="previewImage(this, 'icon-preview')">
                                <div class="image-preview mt-2" id="icon-preview"></div>
                                <small class="text-muted">Recommended: 54x54px, Max: 2MB</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image_post" class="form-label">Post Image</label>
                            <div class="image-upload-container">
                                <input type="file" class="form-control" id="image_post" name="image_post" 
                                       accept="image/*" onchange="previewImage(this, 'post-preview')">
                                <div class="image-preview mt-2" id="post-preview"></div>
                                <small class="text-muted">Recommended: 431x467px, Max: 5MB</small>
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
                            <label for="gallery_images" class="form-label">Gallery Images</label>
                            <div class="image-upload-container">
                                <input type="file" class="form-control" id="gallery_images" name="gallery_images[]" 
                                       accept="image/*" multiple onchange="previewGalleryImages(this)">
                                <div class="gallery-preview mt-2" id="gallery-preview"></div>
                                <small class="text-muted">Recommended: 1200x800px, Max: 6 images, 10MB each</small>
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

<?= $this->endSection(); ?>

<?= $this->section('custom_scripts'); ?>
<script>
// Auto-generate SKU from product name
document.getElementById('product_name').addEventListener('input', function() {
    const productName = this.value;
    const skuField = document.getElementById('sku');
    
    if (productName && !skuField.value) {
        // Generate SKU from product name
        const sku = productName
            .toUpperCase()
            .replace(/[^A-Z0-9]/g, '')
            .substring(0, 8);
        
        if (sku.length >= 3) {
            skuField.value = sku + '-' + Math.random().toString(36).substr(2, 4).toUpperCase();
        }
    }
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
        
        // Validate file type
        if (!file.type.match('image.*')) {
            alert('Please select an image file.');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '150px';
            img.style.maxHeight = '150px';
            img.style.borderRadius = '8px';
            img.style.border = '2px solid #ddd';
            
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-sm btn-danger mt-1';
            removeBtn.innerHTML = '<i class="uil uil-trash-alt"></i> Remove';
            removeBtn.onclick = function() {
                input.value = '';
                preview.innerHTML = '';
            };
            
            preview.appendChild(img);
            preview.appendChild(document.createElement('br'));
            preview.appendChild(removeBtn);
        };
        reader.readAsDataURL(file);
    }
}

// Gallery images preview function
function previewGalleryImages(input) {
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
                container.className = 'd-inline-block me-2 mb-2';
                container.style.position = 'relative';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100px';
                img.style.height = '100px';
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
                    // Note: This doesn't remove from input.files, but it's a limitation of HTML5
                };
                
                container.appendChild(img);
                container.appendChild(removeBtn);
                preview.appendChild(container);
            };
            reader.readAsDataURL(file);
        });
    }
}

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
</style>
<?= $this->endSection(); ?>
