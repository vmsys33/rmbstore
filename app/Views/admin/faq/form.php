<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title"><?= $title ?></h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/faq') ?>">FAQ Management</a></li>
                    <li class="breadcrumb-item active"><?= $faq ? 'Edit FAQ' : 'Create FAQ' ?></li>
                </ul>
            </div>
            <div class="col-auto text-right float-right ml-auto">
                <a href="<?= base_url('admin/faq') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to FAQ List
                </a>
            </div>
        </div>
    </div>

    <!-- FAQ Form -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?= $faq ? 'Edit FAQ Entry' : 'Create New FAQ Entry' ?></h4>
                </div>
                <div class="card-body">
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger">
                            <?= esc(session('error')) ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= $faq ? base_url('admin/faq/update/' . $faq['id']) : base_url('admin/faq/store') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="query">Query/Keywords <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="query" name="query" 
                                           value="<?= old('query', $faq['query'] ?? '') ?>" 
                                           placeholder="e.g., store hours, return policy, macbook"
                                           required>
                                    <small class="form-text text-muted">
                                        Enter keywords that users might type to find this FAQ. Use simple, common terms.
                                    </small>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="category">Category <span class="text-danger">*</span></label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $key => $label): ?>
                                            <option value="<?= $key ?>" <?= old('category', $faq['category'] ?? '') == $key ? 'selected' : '' ?>>
                                                <?= $label ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="priority">Priority <span class="text-danger">*</span></label>
                                    <select class="form-control" id="priority" name="priority" required>
                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?= $i ?>" <?= old('priority', $faq['priority'] ?? 5) == $i ? 'selected' : '' ?>>
                                                <?= $i ?> <?= $i == 10 ? '(Highest)' : ($i == 1 ? '(Lowest)' : '') ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                    <small class="form-text text-muted">
                                        Higher priority FAQs appear first in search results.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="response">Response <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="response" name="response" rows="8" 
                                      placeholder="Enter the response that will be shown to users..."
                                      required><?= old('response', $faq['response'] ?? '') ?></textarea>
                            <small class="form-text text-muted">
                                You can use emojis, markdown-style formatting, and line breaks. Keep responses helpful and concise.
                            </small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" 
                                       value="1" <?= old('is_active', $faq['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="is_active">
                                    Active (visible to users)
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 
                                <?= $faq ? 'Update FAQ' : 'Create FAQ' ?>
                            </button>
                            <a href="<?= base_url('admin/faq') ?>" class="btn btn-secondary ml-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Tips -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-lightbulb text-warning"></i> FAQ Creation Tips
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Query/Keywords Tips:</h6>
                            <ul>
                                <li>Use common, everyday language that customers would type</li>
                                <li>Include synonyms and variations (e.g., "hours", "business hours", "open")</li>
                                <li>Keep keywords short and specific</li>
                                <li>Think about how customers ask questions naturally</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Response Tips:</h6>
                            <ul>
                                <li>Be helpful and informative</li>
                                <li>Use emojis to make responses friendly</li>
                                <li>Include relevant details but keep it concise</li>
                                <li>Use bullet points for lists</li>
                                <li>End with a helpful suggestion when appropriate</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6>Example Queries and Responses:</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Query</th>
                                            <th>Response</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>store hours</code></td>
                                            <td>🕒 <strong>Store Hours:</strong><br>• Monday - Friday: 9:00 AM - 6:00 PM<br>• Saturday: 10:00 AM - 4:00 PM<br>• Sunday: Closed</td>
                                        </tr>
                                        <tr>
                                            <td><code>return policy</code></td>
                                            <td>🔄 <strong>Return Policy:</strong><br>• 30-day return window for most items<br>• Electronics: 14-day return window<br>• Must have original receipt</td>
                                        </tr>
                                        <tr>
                                            <td><code>do you have macbooks</code></td>
                                            <td>📱 <strong>MacBooks Available:</strong><br>Yes! We carry the latest MacBook Air and MacBook Pro models. Check our product catalog for current inventory and pricing.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textarea
    const responseTextarea = document.getElementById('response');
    responseTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    // Set initial height
    responseTextarea.style.height = 'auto';
    responseTextarea.style.height = (responseTextarea.scrollHeight) + 'px';
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const query = document.getElementById('query').value.trim();
        const response = document.getElementById('response').value.trim();
        
        if (query.length < 3) {
            e.preventDefault();
            alert('Query must be at least 3 characters long.');
            document.getElementById('query').focus();
            return false;
        }
        
        if (response.length < 10) {
            e.preventDefault();
            alert('Response must be at least 10 characters long.');
            document.getElementById('response').focus();
            return false;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        submitBtn.disabled = true;
    });
    
    // Character counter for response
    const responseCounter = document.createElement('div');
    responseCounter.className = 'text-muted text-right mt-1';
    responseCounter.innerHTML = '<small>Characters: <span id="charCount">0</span></small>';
    responseTextarea.parentNode.appendChild(responseCounter);
    
    const charCountSpan = document.getElementById('charCount');
    responseTextarea.addEventListener('input', function() {
        charCountSpan.textContent = this.value.length;
        
        // Change color based on length
        if (this.value.length < 10) {
            charCountSpan.className = 'text-danger';
        } else if (this.value.length < 50) {
            charCountSpan.className = 'text-warning';
        } else {
            charCountSpan.className = 'text-success';
        }
    });
    
    // Set initial character count
    charCountSpan.textContent = responseTextarea.value.length;
});
</script>
<?= $this->endSection() ?>
