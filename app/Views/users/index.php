<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="geex-content__header__action">
    <a href="/users/create" class="btn btn-primary">
        <i class="uil uil-plus"></i>
        Add New User
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
                                    <th>Avatar</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)): ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No users found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?= $user['id'] ?></td>
                                            <td>
                                                <div class="avatar avatar-sm">
                                                    <img src="<?= base_url('assets/img/avatar/user.svg') ?>" 
                                                         alt="<?= esc($user['first_name'] . ' ' . $user['last_name']) ?>" 
                                                         class="rounded-circle"
                                                         width="40">
                                                </div>
                                            </td>
                                            <td>
                                                <strong><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></strong>
                                            </td>
                                            <td>
                                                <code><?= esc($user['username']) ?></code>
                                            </td>
                                            <td>
                                                <?= esc($user['email']) ?>
                                            </td>
                                            <td>
                                                <?php
                                                $roleColors = [
                                                    'admin' => 'bg-danger',
                                                    'customer' => 'bg-info',
                                                    'staff' => 'bg-warning'
                                                ];
                                                $roleColor = $roleColors[$user['role']] ?? 'bg-secondary';
                                                ?>
                                                <span class="badge <?= $roleColor ?>"><?= ucfirst($user['role']) ?></span>
                                            </td>
                                            <td>
                                                <?php if ($user['status'] === 'active'): ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= date('M d, Y', strtotime($user['created_at'])) ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="/users/view/<?= $user['id'] ?>" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="View">
                                                        <i class="uil uil-eye"></i>
                                                    </a>
                                                    <a href="/users/edit/<?= $user['id'] ?>" 
                                                       class="btn btn-sm btn-outline-warning" 
                                                       title="Edit">
                                                        <i class="uil uil-edit"></i>
                                                    </a>
                                                    <a href="/users/delete/<?= $user['id'] ?>" 
                                                       class="btn btn-sm btn-outline-danger" 
                                                       title="Delete"
                                                       onclick="return confirm('Are you sure you want to delete this user?')">
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
