<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="geex-content__header__action">
    <a href="/users" class="btn btn-secondary">
        <i class="uil uil-arrow-left"></i>
        Back to Users
    </a>
    <a href="/users/edit/<?= $user['id'] ?>" class="btn btn-warning">
        <i class="uil uil-edit"></i>
        Edit User
    </a>
</div>

        <div class="geex-content__body">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">User Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Full Name:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <?= esc($user['first_name'] . ' ' . $user['last_name']) ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Username:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <code><?= esc($user['username']) ?></code>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Email:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <a href="mailto:<?= esc($user['email']) ?>"><?= esc($user['email']) ?></a>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Role:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $roleColors = [
                                        'admin' => 'bg-danger',
                                        'customer' => 'bg-info',
                                        'staff' => 'bg-warning'
                                    ];
                                    $roleColor = $roleColors[$user['role']] ?? 'bg-secondary';
                                    ?>
                                    <span class="badge <?= $roleColor ?>"><?= ucfirst($user['role']) ?></span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Status:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <?php if ($user['status'] === 'active'): ?>
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
                                    <?= date('F d, Y \a\t g:i A', strtotime($user['created_at'])) ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Last Updated:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <?= date('F d, Y \a\t g:i A', strtotime($user['updated_at'])) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">User Avatar</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="<?= base_url('assets/img/avatar/user.svg') ?>" 
                                 alt="<?= esc($user['first_name'] . ' ' . $user['last_name']) ?>" 
                                 class="rounded-circle mb-3"
                                 width="120">
                            <h6><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></h6>
                            <p class="text-muted"><?= ucfirst($user['role']) ?></p>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="/users/edit/<?= $user['id'] ?>" class="btn btn-warning">
                                    <i class="uil uil-edit"></i>
                                    Edit User
                                </a>
                                <a href="/users/delete/<?= $user['id'] ?>" 
                                   class="btn btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="uil uil-trash-alt"></i>
                                    Delete User
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
