<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?> 

<div class="geex-content__section geex-content__form table-responsive">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><?= $title ?></h2>
            <p class="text-muted mb-0"><?= $subTitle ?></p>
        </div>
        <a href="/admin/products/create" class="btn btn-primary">
            <i class="uil uil-plus"></i> Add New Product
        </a>
    </div>

    <!-- Products Table -->
    <table class="table-reviews-geex-1">
        <thead>
            <tr style="width: 100%;">
                <th style="width: 15%;">Product</th>
                <th style="width: 20%;">Name</th>
                <th style="width: 15%;">Category</th>
                <th style="width: 12%;">Price</th>
                <th style="width: 10%;">Stock</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 18%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <div class="author-area">
                                <div class="profile-picture">
                                    <?php if (!empty($product['image_icon'])): ?>
                                        <img src="<?= base_url($product['image_icon']) ?>" alt="<?= $product['product_name'] ?>" style="height: 54px; width: auto; object-fit: cover;">
                                    <?php else: ?>
                                        <img src="<?= base_url('assets/img/avatar/user.svg') ?>" alt="Default Product" style="height: 54px; width: auto; object-fit: cover;">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p class="mb-1 fw-bold"><?= $product['product_name'] ?></p>
                                <small class="text-muted">SKU: <?= $product['sku'] ?></small>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">
                                <?php 
                                $category = null;
                                foreach ($categories as $cat) {
                                    if ($cat['id'] == $product['product_category']) {
                                        $category = $cat;
                                        break;
                                    }
                                }
                                echo $category ? $category['name'] : 'Unknown';
                                ?>
                            </span>
                        </td>
                        <td>
                            <span class="fw-bold text-success">
                                <?= $currencySymbol ?><?= number_format($product['price'], 2) ?>
                            </span>
                            <?php if (!empty($product['sale_price']) && $product['sale_price'] < $product['price']): ?>
                                <br><small class="text-danger">Sale: <?= $currencySymbol ?><?= number_format($product['sale_price'], 2) ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge <?= $product['stock_quantity'] > 10 ? 'bg-success' : ($product['stock_quantity'] > 0 ? 'bg-warning' : 'bg-danger') ?>">
                                <?= $product['stock_quantity'] ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge <?= $product['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                <?= ucfirst($product['status']) ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <!-- View Button -->
                                <a href="/admin/products/view/<?= $product['id'] ?>" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="View Product">
                                    <i class="uil uil-eye"></i>
                                </a>
                                
                                <!-- Edit Button -->
                                <a href="/admin/products/edit/<?= $product['id'] ?>" 
                                   class="btn btn-sm btn-outline-warning" 
                                   title="Edit Product">
                                    <i class="uil uil-edit"></i>
                                </a>
                                
                                <!-- Delete Button -->
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger" 
                                        title="Delete Product"
                                        onclick="confirmDelete(<?= $product['id'] ?>, '<?= $product['product_name'] ?>')">
                                    <i class="uil uil-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <div class="text-muted">
                            <i class="uil uil-box-open" style="font-size: 3rem;"></i>
                            <p class="mt-2">No products found</p>
                            <a href="/admin/products/create" class="btn btn-primary btn-sm">Add Your First Product</a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the product "<span id="productName"></span>"?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Delete Product</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('custom_scripts'); ?>
<script>
function confirmDelete(productId, productName) {
    document.getElementById('productName').textContent = productName;
            document.getElementById('confirmDeleteBtn').href = '/admin/products/delete/' + productId;
    
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
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
<?= $this->endSection(); ?>
