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
            <a href="/admin/products/edit/<?= $product['id'] ?>" class="btn btn-warning">
                <i class="uil uil-edit"></i> Edit Product
            </a>
        </div>
    </div>

    <!-- Product Details -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Product Images</h6>
                </div>
                <div class="card-body">
                    <!-- Icon Image -->
                    <div class="mb-3">
                        <h6 class="text-muted">Icon Image</h6>
                        <?php if (!empty($product['image_icon'])): ?>
                            <img src="<?= base_url($product['image_icon']) ?>" 
                                 alt="<?= $product['product_name'] ?> Icon" 
                                 class="img-fluid rounded border" 
                                 style="max-height: 150px; cursor: pointer;"
                                 onclick="openImageModal('<?= base_url($product['image_icon']) ?>', 'Icon Image')">
                        <?php else: ?>
                            <div class="text-center p-3 border rounded bg-light">
                                <i class="uil uil-image-plus" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-2">No Icon Image</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Post Image -->
                    <div class="mb-3">
                        <h6 class="text-muted">Post Image</h6>
                        <?php if (!empty($product['image_post'])): ?>
                            <img src="<?= base_url($product['image_post']) ?>" 
                                 alt="<?= $product['product_name'] ?> Post" 
                                 class="img-fluid rounded border" 
                                 style="max-height: 200px; cursor: pointer;"
                                 onclick="openImageModal('<?= base_url($product['image_post']) ?>', 'Post Image')">
                        <?php else: ?>
                            <div class="text-center p-3 border rounded bg-light">
                                <i class="uil uil-image-plus" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-2">No Post Image</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <h4 class="mt-3"><?= $product['product_name'] ?></h4>
                    <p class="text-muted">SKU: <?= $product['sku'] ?></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Product Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> <?= $product['product_name'] ?></p>
                            <p><strong>SKU:</strong> <?= $product['sku'] ?></p>
                            <p><strong>Price:</strong> $<?= number_format($product['price'], 2) ?></p>
                            <?php if (!empty($product['sale_price']) && $product['sale_price'] < $product['price']): ?>
                                <p><strong>Sale Price:</strong> $<?= number_format($product['sale_price'], 2) ?></p>
                            <?php endif; ?>
                            <p><strong>Stock:</strong> <?= $product['stock_quantity'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong> 
                                <span class="badge <?= $product['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= ucfirst($product['status']) ?>
                                </span>
                            </p>
                            <p><strong>Featured:</strong> 
                                <span class="badge <?= $product['featured'] ? 'bg-primary' : 'bg-light text-dark' ?>">
                                    <?= $product['featured'] ? 'Yes' : 'No' ?>
                                </span>
                            </p>
                            <p><strong>Created:</strong> <?= date('M d, Y', strtotime($product['created_at'])) ?></p>
                            <p><strong>Updated:</strong> <?= date('M d, Y', strtotime($product['updated_at'])) ?></p>
                        </div>
                    </div>
                    
                    <?php if (!empty($product['short_description'])): ?>
                        <hr>
                        <h6>Short Description</h6>
                        <p><?= $product['short_description'] ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($product['description'])): ?>
                        <hr>
                        <h6>Description</h6>
                        <p><?= $product['description'] ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Images -->
    <?php if (!empty($product['gallery_images'])): ?>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Gallery Images (<?= count($product['gallery_images']) ?>)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($product['gallery_images'] as $galleryImage): ?>
                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                    <div class="gallery-item">
                                        <img src="<?= base_url($galleryImage['image_path']) ?>" 
                                             alt="<?= $galleryImage['alt_text'] ?? 'Gallery Image' ?>" 
                                             class="img-fluid rounded border" 
                                             style="width: 100%; height: 150px; object-fit: cover; cursor: pointer;"
                                             onclick="openImageModal('<?= base_url($galleryImage['image_path']) ?>', 'Gallery Image')">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
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
function openImageModal(imageSrc, title) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModalLabel').textContent = title;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>
<?= $this->endSection(); ?>
