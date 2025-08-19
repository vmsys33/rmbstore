<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="geex-content__header__action">
    <a href="/users" class="btn btn-secondary">
        <i class="uil uil-arrow-left"></i>
        Back to Users
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
                    <form action="/users/store" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control <?= session()->getFlashdata('errors.first_name') ? 'is-invalid' : '' ?>" 
                                                   id="first_name" 
                                                   name="first_name" 
                                                   value="<?= old('first_name') ?>" 
                                                   required>
                                            <?php if (session()->getFlashdata('errors.first_name')): ?>
                                                <div class="invalid-feedback">
                                                    <?= session()->getFlashdata('errors.first_name') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control <?= session()->getFlashdata('errors.last_name') ? 'is-invalid' : '' ?>" 
                                                   id="last_name" 
                                                   name="last_name" 
                                                   value="<?= old('last_name') ?>" 
                                                   required>
                                            <?php if (session()->getFlashdata('errors.last_name')): ?>
                                                <div class="invalid-feedback">
                                                    <?= session()->getFlashdata('errors.last_name') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control <?= session()->getFlashdata('errors.username') ? 'is-invalid' : '' ?>" 
                                           id="username" 
                                           name="username" 
                                           value="<?= old('username') ?>" 
                                           required>
                                    <?php if (session()->getFlashdata('errors.username')): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('errors.username') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control <?= session()->getFlashdata('errors.email') ? 'is-invalid' : '' ?>" 
                                           id="email" 
                                           name="email" 
                                           value="<?= old('email') ?>" 
                                           required>
                                    <?php if (session()->getFlashdata('errors.email')): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('errors.email') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                            <input type="password" 
                                                   class="form-control <?= session()->getFlashdata('errors.password') ? 'is-invalid' : '' ?>" 
                                                   id="password" 
                                                   name="password" 
                                                   required>
                                            <?php if (session()->getFlashdata('errors.password')): ?>
                                                <div class="invalid-feedback">
                                                    <?= session()->getFlashdata('errors.password') ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="form-text">Minimum 6 characters</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" 
                                                   class="form-control <?= session()->getFlashdata('errors.confirm_password') ? 'is-invalid' : '' ?>" 
                                                   id="confirm_password" 
                                                   name="confirm_password" 
                                                   required>
                                            <?php if (session()->getFlashdata('errors.confirm_password')): ?>
                                                <div class="invalid-feedback">
                                                    <?= session()->getFlashdata('errors.confirm_password') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                    <select class="form-select <?= session()->getFlashdata('errors.role') ? 'is-invalid' : '' ?>" 
                                            id="role" 
                                            name="role" 
                                            required>
                                        <option value="">Select Role</option>
                                        <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="customer" <?= old('role') === 'customer' ? 'selected' : '' ?>>Customer</option>
                                        <option value="staff" <?= old('role') === 'staff' ? 'selected' : '' ?>>Staff</option>
                                    </select>
                                    <?php if (session()->getFlashdata('errors.role')): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('errors.role') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select <?= session()->getFlashdata('errors.status') ? 'is-invalid' : '' ?>" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="">Select Status</option>
                                        <option value="active" <?= old('status') === 'active' ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                    <?php if (session()->getFlashdata('errors.status')): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('errors.status') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">User Information</h6>
                                        <ul class="list-unstyled mb-0">
                                            <li><strong>Created:</strong> <span class="text-muted"><?= date('M d, Y H:i') ?></span></li>
                                            <li><strong>Password:</strong> <span class="text-muted">Will be encrypted</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="/users" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="uil uil-save"></i>
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
