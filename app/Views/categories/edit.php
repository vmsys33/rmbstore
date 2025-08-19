<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="geex-content__header__action">
    <a href="<?= route_to('categories') ?>" class="btn btn-secondary">
        <i class="uil uil-arrow-left"></i>
        Back to Categories
    </a>
</div>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="geex-content__body">
            <div class="card">
                <div class="card-body">
                    <form action="<?= route_to('categories.update', $category['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control <?= session()->getFlashdata('errors.name') ? 'is-invalid' : '' ?>" 
                                           id="name" 
                                           name="name" 
                                           value="<?= old('name', $category['name']) ?>" 
                                           required>
                                    <?php if (session()->getFlashdata('errors.name')): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('errors.name') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control <?= session()->getFlashdata('errors.description') ? 'is-invalid' : '' ?>" 
                                              id="description" 
                                              name="description" 
                                              rows="4"><?= old('description', $category['description']) ?></textarea>
                                    <?php if (session()->getFlashdata('errors.description')): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('errors.description') ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-text">Brief description of the category (optional)</div>
                                </div>

                                <div class="mb-3">
                                    <label for="category_icon" class="form-label">Category Icon</label>
                                    <select class="form-select <?= session()->getFlashdata('errors.category_icon') ? 'is-invalid' : '' ?>" 
                                            id="category_icon" 
                                            name="category_icon">
                                        <option value="fa fa-tag" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-tag' ? 'selected' : '' ?>>Tag (Default)</option>
                                        <option value="fa fa-mobile" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-mobile' ? 'selected' : '' ?>>Mobile Phone</option>
                                        <option value="fa fa-female" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-female' ? 'selected' : '' ?>>Fashion/Clothing</option>
                                        <option value="fa fa-cutlery" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-cutlery' ? 'selected' : '' ?>>Food/Restaurant</option>
                                        <option value="fa fa-futbol-o" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-futbol-o' ? 'selected' : '' ?>>Sports/Fitness</option>
                                        <option value="fa fa-car" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-car' ? 'selected' : '' ?>>Automotive</option>
                                        <option value="fa fa-camera-retro" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-camera-retro' ? 'selected' : '' ?>>Camera/Photo</option>
                                        <option value="fa fa-book" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-book' ? 'selected' : '' ?>>Books/Education</option>
                                        <option value="fa fa-home" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-home' ? 'selected' : '' ?>>Home/Furniture</option>
                                        <option value="fa fa-diamond" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-diamond' ? 'selected' : '' ?>>Beauty/Cosmetics</option>
                                        <option value="fa fa-gamepad" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-gamepad' ? 'selected' : '' ?>>Games/Toys</option>
                                        <option value="fa fa-laptop" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-laptop' ? 'selected' : '' ?>>Electronics</option>
                                        <option value="fa fa-gift" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-gift' ? 'selected' : '' ?>>Gifts</option>
                                        <option value="fa fa-heart" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-heart' ? 'selected' : '' ?>>Health/Medical</option>
                                        <option value="fa fa-leaf" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-leaf' ? 'selected' : '' ?>>Nature/Outdoor</option>
                                        <option value="fa fa-music" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-music' ? 'selected' : '' ?>>Music/Entertainment</option>
                                        <option value="fa fa-paint-brush" <?= old('category_icon', $category['category_icon'] ?? 'fa fa-tag') === 'fa fa-paint-brush' ? 'selected' : '' ?>>Arts/Crafts</option>
                                    </select>
                                    <?php if (session()->getFlashdata('errors.category_icon')): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('errors.category_icon') ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-text">Choose an icon for this category</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select <?= session()->getFlashdata('errors.status') ? 'is-invalid' : '' ?>" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="">Select Status</option>
                                        <option value="active" <?= old('status', $category['status']) === 'active' ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= old('status', $category['status']) === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                    <?php if (session()->getFlashdata('errors.status')): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('errors.status') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Category Information</h6>
                                        <ul class="list-unstyled mb-0">
                                            <li><strong>ID:</strong> <span class="text-muted"><?= $category['id'] ?></span></li>
                                            <li><strong>Slug:</strong> <span id="slug-preview" class="text-muted"><?= $category['slug'] ?></span></li>
                                            <li><strong>Created:</strong> <span class="text-muted"><?= date('M d, Y H:i', strtotime($category['created_at'])) ?></span></li>
                                            <li><strong>Updated:</strong> <span class="text-muted"><?= date('M d, Y H:i', strtotime($category['updated_at'])) ?></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= route_to('categories') ?>" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="uil uil-save"></i>
                                Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
document.getElementById('name').addEventListener('input', function() {
    const categoryName = this.value;
    const slugPreview = document.getElementById('slug-preview');
    
    if (categoryName) {
        const slug = categoryName.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        slugPreview.textContent = slug;
    } else {
        slugPreview.textContent = 'Will be auto-generated';
    }
});
</script>

<?= $this->endSection() ?>
