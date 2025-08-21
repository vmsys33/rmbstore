<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?>

<div class="geex-content__wrapper">
    <div class="geex-content__section-wrapper">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1"><?= $title ?></h2>
                <p class="text-muted mb-0">View slider details</p>
            </div>
            <div>
                <a href="<?= route_to('sliders') ?>" class="btn btn-outline-secondary">
                    <i class="uil uil-arrow-left"></i> Back to Sliders
                </a>
            </div>
        </div>

        <!-- Slider Details -->
        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0">Slider Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Title</label>
                                    <p class="mb-0"><?= esc($slider['title']) ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <p class="mb-0">
                                        <?php if ($slider['is_active']): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Subtitle</label>
                            <p class="mb-0"><?= esc($slider['subtitle'] ?? 'No subtitle') ?></p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Button Text</label>
                                    <p class="mb-0"><?= esc($slider['button_text'] ?? 'No button') ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Button URL</label>
                                    <p class="mb-0">
                                        <?php if ($slider['button_url']): ?>
                                            <a href="<?= esc($slider['button_url']) ?>" target="_blank">
                                                <?= esc($slider['button_url']) ?>
                                            </a>
                                        <?php else: ?>
                                            No URL
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Sort Order</label>
                                    <p class="mb-0"><?= $slider['sort_order'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Created</label>
                                    <p class="mb-0"><?= date('F j, Y g:i A', strtotime($slider['created_at'])) ?></p>
                                </div>
                            </div>
                        </div>

                        <?php if ($slider['updated_at'] && $slider['updated_at'] !== $slider['created_at']): ?>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Last Updated</label>
                                <p class="mb-0"><?= date('F j, Y g:i A', strtotime($slider['updated_at'])) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0">Slider Image</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="<?= base_url($slider['image']) ?>" 
                             alt="<?= esc($slider['title']) ?>" 
                             class="img-fluid rounded" 
                             style="max-width: 100%;">
                    </div>
                </div>

                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0">Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?= route_to('sliders.edit', $slider['id']) ?>" 
                               class="btn btn-warning">
                                <i class="uil uil-edit"></i> Edit Slider
                            </a>
                            <a href="<?= route_to('sliders.toggleStatus', $slider['id']) ?>" 
                               class="btn btn-<?= $slider['is_active'] ? 'danger' : 'success' ?>"
                               onclick="return confirm('Are you sure you want to <?= $slider['is_active'] ? 'deactivate' : 'activate' ?> this slider?')">
                                <i class="uil uil-<?= $slider['is_active'] ? 'eye-slash' : 'eye' ?>"></i> 
                                <?= $slider['is_active'] ? 'Deactivate' : 'Activate' ?>
                            </a>
                            <a href="<?= route_to('sliders.delete', $slider['id']) ?>" 
                               class="btn btn-danger"
                               onclick="return confirm('Are you sure you want to delete this slider? This action cannot be undone.')">
                                <i class="uil uil-trash-alt"></i> Delete Slider
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
