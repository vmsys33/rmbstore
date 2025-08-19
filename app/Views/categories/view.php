<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="geex-content__header__action">
    <a href="<?= route_to('categories') ?>" class="btn btn-secondary">
        <i class="uil uil-arrow-left"></i>
        Back to Categories
    </a>
    <a href="<?= route_to('categories.edit', $category['id']) ?>" class="btn btn-warning">
        <i class="uil uil-edit"></i>
        Edit Category
    </a>
</div>

        <div class="geex-content__body">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Category Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Category Name:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <?= esc($category['name']) ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Slug:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <code><?= esc($category['slug']) ?></code>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Description:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <?php if ($category['description']): ?>
                                        <?= nl2br(esc($category['description'])) ?>
                                    <?php else: ?>
                                        <span class="text-muted">No description provided</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Status:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <?php if ($category['status'] === 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Created:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <?= date('F d, Y \a\t g:i A', strtotime($category['created_at'])) ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Last Updated:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <?= date('F d, Y \a\t g:i A', strtotime($category['updated_at'])) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="<?= route_to('categories.edit', $category['id']) ?>" class="btn btn-warning">
                                    <i class="uil uil-edit"></i>
                                    Edit Category
                                </a>
                                <a href="<?= route_to('categories.delete', $category['id']) ?>" 
                                   class="btn btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this category?')">
                                    <i class="uil uil-trash-alt"></i>
                                    Delete Category
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Category Statistics</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            $productModel = new \App\Models\ProductModel();
                            $productsCount = $productModel->where('product_category', $category['id'])->countAllResults();
                            ?>
                            <div class="text-center">
                                <h3 class="text-primary mb-0"><?= $productsCount ?></h3>
                                <p class="text-muted mb-0">Products in this category</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
