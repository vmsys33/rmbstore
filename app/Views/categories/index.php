<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="geex-content__header__action">
    <a href="<?= route_to('categories.create') ?>" class="btn btn-primary">
        <i class="uil uil-plus"></i>
        Add New Category
    </a>
</div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="geex-content__body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Icon</th>
                                    <th>Category Name</th>
                                    <th>Slug</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($categories)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No categories found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($categories as $category): ?>
                                        <tr>
                                            <td><?= $category['id'] ?></td>
                                            <td>
                                                <i class="<?= $category['category_icon'] ?? 'fa fa-tag' ?>" style="font-size: 1.2em; color: #007bff;"></i>
                                            </td>
                                            <td>
                                                <strong><?= esc($category['name']) ?></strong>
                                            </td>
                                            <td>
                                                <code><?= esc($category['slug']) ?></code>
                                            </td>
                                            <td>
                                                <?php if ($category['description']): ?>
                                                    <?= esc(substr($category['description'], 0, 50)) ?>
                                                    <?= strlen($category['description']) > 50 ? '...' : '' ?>
                                                <?php else: ?>
                                                    <span class="text-muted">No description</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($category['status'] === 'active'): ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= date('M d, Y', strtotime($category['created_at'])) ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= route_to('categories.view', $category['id']) ?>" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="View">
                                                        <i class="uil uil-eye"></i>
                                                    </a>
                                                    <a href="<?= route_to('categories.edit', $category['id']) ?>" 
                                                       class="btn btn-sm btn-outline-warning" 
                                                       title="Edit">
                                                        <i class="uil uil-edit"></i>
                                                    </a>
                                                    <a href="<?= route_to('categories.delete', $category['id']) ?>" 
                                                       class="btn btn-sm btn-outline-danger" 
                                                       title="Delete"
                                                       onclick="return confirm('Are you sure you want to delete this category?')">
                                                        <i class="uil uil-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
