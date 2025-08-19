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

    <!-- Edit Form -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Product Information</h5>
        </div>
        <div class="card-body">
            <!-- Success/Error Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="/admin/products/update/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name *</label>
                            <input type="text" class="form-control <?= session()->getFlashdata('errors.product_name') ? 'is-invalid' : '' ?>" 
                                   id="product_name" name="product_name" 
                                   value="<?= old('product_name', $product['product_name']) ?>" required>
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
                                   value="<?= old('sku', $product['sku']) ?>" required>
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
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-select <?= session()->getFlashdata('errors.status') ? 'is-invalid' : '' ?>" id="status" name="status" required>
                                <option value="active" <?= old('status', $product['status']) === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= old('status', $product['status']) === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                <option value="draft" <?= old('status', $product['status']) === 'draft' ? 'selected' : '' ?>>Draft</option>
                            </select>
                            <?php if (session()->getFlashdata('errors.status')): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors.status') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="price" class="form-label">Price *</label>
                            <input type="number" step="0.01" class="form-control <?= session()->getFlashdata('errors.price') ? 'is-invalid' : '' ?>" 
                                   id="price" name="price" 
                                   value="<?= old('price', $product['price']) ?>" required>
                            <?php if (session()->getFlashdata('errors.price')): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors.price') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="sale_price" class="form-label">Sale Price</label>
                            <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price" 
                                   value="<?= old('sale_price', $product['sale_price']) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                            <input type="number" class="form-control <?= session()->getFlashdata('errors.stock_quantity') ? 'is-invalid' : '' ?>" 
                                   id="stock_quantity" name="stock_quantity" 
                                   value="<?= old('stock_quantity', $product['stock_quantity']) ?>" required>
                            <?php if (session()->getFlashdata('errors.stock_quantity')): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors.stock_quantity') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight" 
                                   value="<?= old('weight', $product['weight']) ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="dimensions" class="form-label">Dimensions</label>
                            <input type="text" class="form-control" id="dimensions" name="dimensions" 
                                   value="<?= old('dimensions', $product['dimensions']) ?>" placeholder="L x W x H cm">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="short_description" class="form-label">Short Description</label>
                    <textarea class="form-control" id="short_description" name="short_description" rows="3"><?= old('short_description', $product['short_description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5"><?= old('description', $product['description']) ?></textarea>
                </div>

                <!-- Images -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" 
                                       <?= old('featured', $product['featured']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="featured">
                                    Featured Product
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image_icon" class="form-label">Icon Image</label>
                                                         <div class="image-upload-container">
                                 <?php if ($product['image_icon']): ?>
                                     <div class="current-image mb-2">
                                         <img src="<?= base_url($product['image_icon']) ?>" alt="Current Icon" 
                                              class="img-thumbnail" style="max-width: 100px; max-height: 100px; cursor: pointer;"
                                              onclick="openImageModal('<?= base_url($product['image_icon']) ?>', 'Current Icon Image')">
                                         <small class="d-block text-muted">Current Icon Image (Click to preview)</small>
                                     </div>
                                 <?php endif; ?>
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
                                 <?php if ($product['image_post']): ?>
                                     <div class="current-image mb-2">
                                         <img src="<?= base_url($product['image_post']) ?>" alt="Current Post" 
                                              class="img-thumbnail" style="max-width: 150px; max-height: 100px; cursor: pointer;"
                                              onclick="openImageModal('<?= base_url($product['image_post']) ?>', 'Current Post Image')">
                                         <small class="d-block text-muted">Current Post Image (Click to preview)</small>
                                     </div>
                                 <?php endif; ?>
                                 <input type="file" class="form-control" id="image_post" name="image_post" 
                                        accept="image/*" onchange="previewImage(this, 'post-preview')">
                                 <div class="image-preview mt-2" id="post-preview"></div>
                                 <small class="text-muted">Recommended: 431x467px, Max: 5MB</small>
                             </div>
                        </div>
                    </div>
                </div>

                                 <!-- Gallery Images -->
                 <div class="row">
                     <div class="col-12">
                         <div class="mb-3">
                             <label for="gallery_images" class="form-label">Gallery Images</label>
                             
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
                                                          style="width: 100%; height: 100px; object-fit: cover; cursor: pointer;"
                                                          onclick="openImageModal('<?= base_url($galleryImage['image_path']) ?>', 'Gallery Image')">
                                                     <small class="d-block text-center mt-1 text-muted"><?= $galleryImage['image_name'] ?></small>
                                                 </div>
                                             </div>
                                         <?php endforeach; ?>
                                     </div>
                                 </div>
                             <?php endif; ?>
                             
                             <div class="image-upload-container">
                                 <input type="file" class="form-control" id="gallery_images" name="gallery_images[]" 
                                        accept="image/*" multiple onchange="previewGalleryImages(this)">
                                 <div class="gallery-preview mt-2" id="gallery-preview"></div>
                                 <small class="text-muted">Recommended: 1200x800px, Max: 6 images, 10MB each</small>
                             </div>
                         </div>
                     </div>
                 </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="/admin/products" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="uil uil-save"></i> Update Product
                    </button>
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
 // Image modal function
 function openImageModal(imageSrc, title) {
     document.getElementById('modalImage').src = imageSrc;
     document.getElementById('imageModalLabel').textContent = title;
     new bootstrap.Modal(document.getElementById('imageModal')).show();
 }
 
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
</script>
<?= $this->endSection(); ?>
