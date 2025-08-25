<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="geex-content__header__action">
    <a href="<?= base_url('admin/faq/create') ?>" class="btn btn-primary">
        <i class="uil uil-plus"></i>
        Add New FAQ
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
                                    <th>Query</th>
                                    <th>Response</th>
                                    <th>Category</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($faqs)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No FAQs found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($faqs as $faq): ?>
                                        <tr>
                                            <td><?= $faq['id'] ?></td>
                                            <td>
                                                <strong><?= esc($faq['query']) ?></strong>
                                            </td>
                                            <td>
                                                <?php if ($faq['response']): ?>
                                                    <?= esc(substr($faq['response'], 0, 50)) ?>
                                                    <?= strlen($faq['response']) > 50 ? '...' : '' ?>
                                                <?php else: ?>
                                                    <span class="text-muted">No response</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= getCategoryBadgeClass($faq['category']) ?>">
                                                    <?= ucfirst(str_replace('_', ' ', $faq['category'])) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?= $faq['priority'] ?></span>
                                            </td>
                                            <td>
                                                <?php if ($faq['is_active']): ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= date('M d, Y', strtotime($faq['created_at'])) ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('admin/faq/edit/' . $faq['id']) ?>" 
                                                       class="btn btn-sm btn-outline-warning" 
                                                       title="Edit">
                                                        <i class="uil uil-edit"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/faq/delete/' . $faq['id']) ?>" 
                                                       class="btn btn-sm btn-outline-danger" 
                                                       title="Delete"
                                                       onclick="return confirm('Are you sure you want to delete this FAQ entry?')">
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



<?= $this->endSection() ?>

<?php
function getCategoryBadgeClass($category) {
    $classes = [
        'store_info' => 'primary',
        'products' => 'success',
        'policies' => 'warning',
        'services' => 'info',
        'general' => 'secondary'
    ];
    return $classes[$category] ?? 'secondary';
}
?>
