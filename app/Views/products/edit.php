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
                            <div class="input-group">
                                <span class="input-group-text"><?= $currencySymbol ?></span>
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
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="sale_price" class="form-label">Sale Price</label>
                            <div class="input-group">
                                <span class="input-group-text"><?= $currencySymbol ?></span>
                                <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price" 
                                       value="<?= old('sale_price', $product['sale_price']) ?>">
                            </div>
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
                            <label for="image_icon" class="form-label">Icon Image (54×54px)</label>
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
                                <?php if ($product['image_post']): ?>
                                    <div class="current-image mb-2">
                                        <img src="<?= base_url($product['image_post']) ?>" alt="Current Post" 
                                             class="img-thumbnail" style="max-width: 150px; max-height: 100px; cursor: pointer;"
                                             onclick="openImageModal('<?= base_url($product['image_post']) ?>', 'Current Post Image')">
                                        <small class="d-block text-muted">Current Post Image (Click to preview)</small>
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" id="image_post" name="image_post" 
                                       accept="image/*" onchange="handleImageUpload(this, 'post', 431, 467)">
                                <div class="image-preview mt-2" id="post-preview"></div>
                                <small class="text-muted">Will be automatically cropped to 431×467px</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gallery Images -->
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="gallery_images" class="form-label">Gallery Images (1200×800px)</label>
                            
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
                                       accept="image/*" multiple onchange="handleGalleryUpload(this)">
                                <div class="gallery-preview mt-2" id="gallery-preview"></div>
                                <small class="text-muted">Will be automatically cropped to 1200×800px (Max: 6 images)</small>
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

 // Image modal function
 function openImageModal(imageSrc, title) {
     document.getElementById('modalImage').src = imageSrc;
     document.getElementById('imageModalLabel').textContent = title;
     new bootstrap.Modal(document.getElementById('imageModal')).show();
 }
 
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
     img.className = 'img-thumbnail';
     preview.appendChild(img);
 }

 // Add gallery image
 function addGalleryImage(dataUrl) {
     const preview = document.getElementById('gallery-preview');
     
     const container = document.createElement('div');
     container.className = 'd-inline-block me-2 mb-2';
     container.style.position = 'relative';
     
     const img = document.createElement('img');
     img.src = dataUrl;
     img.style.maxWidth = '120px';
     img.style.maxHeight = '80px';
     img.className = 'img-thumbnail';
     
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
 </script>

 <style>
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
