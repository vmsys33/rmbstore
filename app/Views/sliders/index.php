<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?>

<div class="geex-content__wrapper">
    <div class="geex-content__section-wrapper">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1"><?= $title ?></h2>
                <p class="text-muted mb-0">Manage frontend slider content</p>
            </div>
            <div>
                <a href="<?= route_to('sliders.create') ?>" class="btn btn-primary">
                    <i class="uil uil-plus"></i> Add New Slider
                </a>
            </div>
        </div>

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

        <!-- Sliders Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <?php if (!empty($sliders)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>Button</th>
                                    <th>Sort Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sliders as $slider): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= base_url($slider['image']) ?>" 
                                                 alt="<?= esc($slider['title']) ?>" 
                                                 class="img-thumbnail" 
                                                 style="width: 80px; height: 60px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <strong><?= esc($slider['title']) ?></strong>
                                        </td>
                                        <td>
                                            <?= esc($slider['subtitle'] ?? 'No subtitle') ?>
                                        </td>
                                        <td>
                                            <?php if ($slider['button_text']): ?>
                                                <span class="badge bg-info">
                                                    <?= esc($slider['button_text']) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">No button</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?= $slider['sort_order'] ?></span>
                                        </td>
                                        <td>
                                            <?php if ($slider['is_active']): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= route_to('sliders.view', $slider['id']) ?>" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="View">
                                                    <i class="uil uil-eye"></i>
                                                </a>
                                                <a href="<?= route_to('sliders.edit', $slider['id']) ?>" 
                                                   class="btn btn-sm btn-outline-warning" 
                                                   title="Edit">
                                                    <i class="uil uil-edit"></i>
                                                </a>
                                                <a href="<?= route_to('sliders.toggleStatus', $slider['id']) ?>" 
                                                   class="btn btn-sm btn-outline-<?= $slider['is_active'] ? 'danger' : 'success' ?>" 
                                                   title="<?= $slider['is_active'] ? 'Deactivate' : 'Activate' ?>"
                                                   onclick="return confirm('Are you sure you want to <?= $slider['is_active'] ? 'deactivate' : 'activate' ?> this slider?')">
                                                    <i class="uil uil-<?= $slider['is_active'] ? 'eye-slash' : 'eye' ?>"></i>
                                                </a>
                                                <a href="<?= route_to('sliders.delete', $slider['id']) ?>" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   title="Delete"
                                                   onclick="return confirm('Are you sure you want to delete this slider? This action cannot be undone.')">
                                                    <i class="uil uil-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="uil uil-image-slash text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="text-muted">No sliders found</h5>
                        <p class="text-muted mb-4">Get started by adding your first slider.</p>
                        <a href="<?= route_to('sliders.create') ?>" class="btn btn-primary">
                            <i class="uil uil-plus"></i> Add First Slider
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
