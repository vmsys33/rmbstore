<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?>

<div class="geex-content__wrapper">
    <div class="geex-content__section-wrapper">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1"><?= $title ?></h2>
                <p class="text-muted mb-0">Edit slider: <?= esc($slider['title']) ?></p>
            </div>
            <div>
                <a href="<?= route_to('sliders') ?>" class="btn btn-outline-secondary">
                    <i class="uil uil-arrow-left"></i> Back to Sliders
                </a>
            </div>
        </div>

        <!-- Error Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Edit Form -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="<?= route_to('sliders.update', $slider['id']) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?= session()->getFlashdata('errors.title') ? 'is-invalid' : '' ?>" 
                                       id="title" 
                                       name="title" 
                                       value="<?= old('title', $slider['title']) ?>" 
                                       placeholder="Enter slider title"
                                       required>
                                <?php if (session()->getFlashdata('errors.title')): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors.title') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Subtitle -->
                            <div class="mb-3">
                                <label for="subtitle" class="form-label">Subtitle</label>
                                <textarea class="form-control <?= session()->getFlashdata('errors.subtitle') ? 'is-invalid' : '' ?>" 
                                          id="subtitle" 
                                          name="subtitle" 
                                          rows="3" 
                                          placeholder="Enter slider subtitle"><?= old('subtitle', $slider['subtitle']) ?></textarea>
                                <?php if (session()->getFlashdata('errors.subtitle')): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors.subtitle') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Button Text -->
                            <div class="mb-3">
                                <label for="button_text" class="form-label">Button Text</label>
                                <input type="text" 
                                       class="form-control <?= session()->getFlashdata('errors.button_text') ? 'is-invalid' : '' ?>" 
                                       id="button_text" 
                                       name="button_text" 
                                       value="<?= old('button_text', $slider['button_text']) ?>" 
                                       placeholder="e.g., Shop Now, Learn More">
                                <?php if (session()->getFlashdata('errors.button_text')): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors.button_text') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Button URL -->
                            <div class="mb-3">
                                <label for="button_url" class="form-label">Button URL</label>
                                <input type="url" 
                                       class="form-control <?= session()->getFlashdata('errors.button_url') ? 'is-invalid' : '' ?>" 
                                       id="button_url" 
                                       name="button_url" 
                                       value="<?= old('button_url', $slider['button_url']) ?>" 
                                       placeholder="e.g., https://example.com or /products">
                                <?php if (session()->getFlashdata('errors.button_url')): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors.button_url') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Sort Order -->
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" 
                                       class="form-control <?= session()->getFlashdata('errors.sort_order') ? 'is-invalid' : '' ?>" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="<?= old('sort_order', $slider['sort_order']) ?>" 
                                       placeholder="Enter sort order (lower numbers appear first)">
                                <?php if (session()->getFlashdata('errors.sort_order')): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors.sort_order') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="is_active" class="form-label">Status</label>
                                <select class="form-select <?= session()->getFlashdata('errors.is_active') ? 'is-invalid' : '' ?>" 
                                        id="is_active" 
                                        name="is_active">
                                    <option value="1" <?= old('is_active', $slider['is_active']) == '1' ? 'selected' : '' ?>>Active</option>
                                    <option value="0" <?= old('is_active', $slider['is_active']) == '0' ? 'selected' : '' ?>>Inactive</option>
                                </select>
                                <?php if (session()->getFlashdata('errors.is_active')): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors.is_active') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Current Image -->
                            <div class="mb-3">
                                <label class="form-label">Current Image</label>
                                <div class="border rounded p-3 text-center">
                                    <img src="<?= base_url($slider['image']) ?>" 
                                         alt="<?= esc($slider['title']) ?>" 
                                         class="img-fluid rounded" 
                                         style="max-height: 200px;">
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-3">
                                <label for="image" class="form-label">New Image (Optional)</label>
                                <input type="file" 
                                       class="form-control <?= session()->getFlashdata('errors.image') ? 'is-invalid' : '' ?>" 
                                       id="image" 
                                       name="image" 
                                       accept="image/*">
                                <?php if (session()->getFlashdata('errors.image')): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors.image') ?></div>
                                <?php endif; ?>
                                <div class="form-text">
                                    Leave empty to keep current image. Recommended size: 1200x600 pixels.
                                </div>
                            </div>

                            <!-- New Image Preview -->
                            <div class="mb-3">
                                <label class="form-label">New Image Preview</label>
                                <div class="border rounded p-3 text-center" id="imagePreview" style="min-height: 200px; display: none;">
                                    <img id="previewImg" class="img-fluid rounded" alt="Preview">
                                </div>
                                <div class="border rounded p-3 text-center text-muted" id="noImagePreview" style="min-height: 200px;">
                                    <i class="uil uil-image" style="font-size: 3rem;"></i>
                                    <p class="mt-2 mb-0">No new image selected</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= route_to('sliders') ?>" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="uil uil-save"></i> Update Slider
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Image preview functionality
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const noPreview = document.getElementById('noImagePreview');
    const previewImg = document.getElementById('previewImg');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
            noPreview.style.display = 'none';
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
        noPreview.style.display = 'block';
    }
});
</script>

<?= $this->endSection(); ?>
