<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

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
            <form action="/admin/settings/update" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <!-- Store Information -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Store Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="store_name" class="form-label">Store Name</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="store_name" 
                                           name="store_name" 
                                           value="<?= old('store_name', $settings['store_name'] ?? '') ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="store_logo" class="form-label">Store Logo</label>
                                    <input type="file" 
                                           class="form-control" 
                                           id="store_logo" 
                                           name="store_logo" 
                                           accept="image/*"
                                           onchange="previewImage(this, 'logo-preview')">
                                    <div class="form-text">Recommended size: 300x100px. Max file size: 10MB</div>
                                    
                                    <?php if (!empty($settings['store_logo'])): ?>
                                        <div class="mt-2">
                                            <img src="<?= base_url($settings['store_logo']) ?>" 
                                                 alt="Current Store Logo" 
                                                 class="img-thumbnail" 
                                                 style="max-height: 100px;">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div id="logo-preview" class="mt-2"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="navicon" class="form-label">Navigation Icon</label>
                                    <input type="file" 
                                           class="form-control" 
                                           id="navicon" 
                                           name="navicon" 
                                           accept="image/*"
                                           onchange="previewImage(this, 'navicon-preview')">
                                    <div class="form-text">Recommended size: 32x32px. Max file size: 5MB</div>
                                    
                                    <?php if (!empty($settings['navicon'])): ?>
                                        <div class="mt-2">
                                            <img src="<?= base_url($settings['navicon']) ?>" 
                                                 alt="Current Navigation Icon" 
                                                 class="img-thumbnail" 
                                                 style="max-height: 32px;">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div id="navicon-preview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Information -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Admin Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="admin_name" class="form-label">Admin Name</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="admin_name" 
                                           name="admin_name" 
                                           value="<?= old('admin_name', $settings['admin_name'] ?? '') ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="admin_email" class="form-label">Admin Email</label>
                                    <input type="email" 
                                           class="form-control" 
                                           id="admin_email" 
                                           name="admin_email" 
                                           value="<?= old('admin_email', $settings['admin_email'] ?? '') ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="owner_photo" class="form-label">Owner Photo</label>
                                    <input type="file" 
                                           class="form-control" 
                                           id="owner_photo" 
                                           name="owner_photo" 
                                           accept="image/*"
                                           onchange="previewImage(this, 'owner-preview')">
                                    <div class="form-text">Recommended size: 400x400px. Max file size: 10MB</div>
                                    
                                    <?php if (!empty($settings['owner_photo'])): ?>
                                        <div class="mt-2">
                                            <img src="<?= base_url($settings['owner_photo']) ?>" 
                                                 alt="Current Owner Photo" 
                                                 class="img-thumbnail" 
                                                 style="max-height: 150px;">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div id="owner-preview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- About Us -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">About Us</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="about_us" class="form-label">About Us Content</label>
                            <textarea class="form-control" 
                                      id="about_us" 
                                      name="about_us" 
                                      rows="6"><?= old('about_us', $settings['about_us'] ?? '') ?></textarea>
                            <div class="form-text">Tell your customers about your store, mission, and values</div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_phone" class="form-label">Phone Number</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="contact_phone" 
                                           name="contact_phone" 
                                           value="<?= old('contact_phone', $settings['contact_phone'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_address" class="form-label">Address</label>
                                    <textarea class="form-control" 
                                              id="contact_address" 
                                              name="contact_address" 
                                              rows="3"><?= old('contact_address', $settings['contact_address'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Information -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Business Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="currency" class="form-label">Currency</label>
                                    <select class="form-select" id="currency" name="currency">
                                        <option value="USD" <?= old('currency', $settings['currency'] ?? 'USD') === 'USD' ? 'selected' : '' ?>>$ USD (US Dollar)</option>
                                        <option value="EUR" <?= old('currency', $settings['currency'] ?? 'USD') === 'EUR' ? 'selected' : '' ?>>€ EUR (Euro)</option>
                                        <option value="GBP" <?= old('currency', $settings['currency'] ?? 'USD') === 'GBP' ? 'selected' : '' ?>>£ GBP (British Pound)</option>
                                        <option value="JPY" <?= old('currency', $settings['currency'] ?? 'USD') === 'JPY' ? 'selected' : '' ?>>¥ JPY (Japanese Yen)</option>
                                        <option value="CAD" <?= old('currency', $settings['currency'] ?? 'USD') === 'CAD' ? 'selected' : '' ?>>$ CAD (Canadian Dollar)</option>
                                        <option value="AUD" <?= old('currency', $settings['currency'] ?? 'USD') === 'AUD' ? 'selected' : '' ?>>$ AUD (Australian Dollar)</option>
                                        <option value="CHF" <?= old('currency', $settings['currency'] ?? 'USD') === 'CHF' ? 'selected' : '' ?>>₣ CHF (Swiss Franc)</option>
                                        <option value="CNY" <?= old('currency', $settings['currency'] ?? 'USD') === 'CNY' ? 'selected' : '' ?>>¥ CNY (Chinese Yuan)</option>
                                        <option value="INR" <?= old('currency', $settings['currency'] ?? 'USD') === 'INR' ? 'selected' : '' ?>>₹ INR (Indian Rupee)</option>
                                        <option value="PHP" <?= old('currency', $settings['currency'] ?? 'USD') === 'PHP' ? 'selected' : '' ?>>₱ PHP (Philippine Peso)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tax_rate" class="form-label">Tax Rate (%)</label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="tax_rate" 
                                           name="tax_rate" 
                                           step="0.01" 
                                           min="0" 
                                           max="100"
                                           value="<?= old('tax_rate', $settings['tax_rate'] ?? '0') ?>">
                                    <div class="form-text">Default tax rate for products</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="shipping_cost" class="form-label">Default Shipping Cost</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="currency_symbol">$</span>
                                        <input type="number" 
                                               class="form-control" 
                                               id="shipping_cost" 
                                               name="shipping_cost" 
                                               step="0.01" 
                                               min="0"
                                               value="<?= old('shipping_cost', $settings['shipping_cost'] ?? '0') ?>">
                                    </div>
                                    <div class="form-text">Default shipping cost for orders</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="business_hours" class="form-label">Business Hours</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="business_hours" 
                                           name="business_hours" 
                                           placeholder="e.g., Mon-Fri 9AM-6PM, Sat 10AM-4PM"
                                           value="<?= old('business_hours', $settings['business_hours'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="timezone" class="form-label">Timezone</label>
                                    <select class="form-select" id="timezone" name="timezone">
                                        <option value="UTC" <?= old('timezone', $settings['timezone'] ?? 'UTC') === 'UTC' ? 'selected' : '' ?>>UTC (Coordinated Universal Time)</option>
                                        <option value="America/New_York" <?= old('timezone', $settings['timezone'] ?? 'UTC') === 'America/New_York' ? 'selected' : '' ?>>EST (Eastern Standard Time)</option>
                                        <option value="America/Chicago" <?= old('timezone', $settings['timezone'] ?? 'UTC') === 'America/Chicago' ? 'selected' : '' ?>>CST (Central Standard Time)</option>
                                        <option value="America/Denver" <?= old('timezone', $settings['timezone'] ?? 'UTC') === 'America/Denver' ? 'selected' : '' ?>>MST (Mountain Standard Time)</option>
                                        <option value="America/Los_Angeles" <?= old('timezone', $settings['timezone'] ?? 'UTC') === 'America/Los_Angeles' ? 'selected' : '' ?>>PST (Pacific Standard Time)</option>
                                        <option value="Europe/London" <?= old('timezone', $settings['timezone'] ?? 'UTC') === 'Europe/London' ? 'selected' : '' ?>>GMT (Greenwich Mean Time)</option>
                                        <option value="Europe/Paris" <?= old('timezone', $settings['timezone'] ?? 'UTC') === 'Europe/Paris' ? 'selected' : '' ?>>CET (Central European Time)</option>
                                        <option value="Asia/Tokyo" <?= old('timezone', $settings['timezone'] ?? 'UTC') === 'Asia/Tokyo' ? 'selected' : '' ?>>JST (Japan Standard Time)</option>
                                        <option value="Asia/Shanghai" <?= old('timezone', $settings['timezone'] ?? 'UTC') === 'Asia/Shanghai' ? 'selected' : '' ?>>CST (China Standard Time)</option>
                                        <option value="Asia/Manila" <?= old('timezone', $settings['timezone'] ?? 'UTC') === 'Asia/Manila' ? 'selected' : '' ?>>PHT (Philippine Time)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Social Media Links</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="social_facebook" class="form-label">Facebook URL</label>
                                    <input type="url" 
                                           class="form-control" 
                                           id="social_facebook" 
                                           name="social_facebook" 
                                           value="<?= old('social_facebook', $settings['social_facebook'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="social_instagram" class="form-label">Instagram URL</label>
                                    <input type="url" 
                                           class="form-control" 
                                           id="social_instagram" 
                                           name="social_instagram" 
                                           value="<?= old('social_instagram', $settings['social_instagram'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="social_twitter" class="form-label">Twitter URL</label>
                                    <input type="url" 
                                           class="form-control" 
                                           id="social_twitter" 
                                           name="social_twitter" 
                                           value="<?= old('social_twitter', $settings['social_twitter'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gallery Management -->
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Store Gallery</h5>
                        <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('gallery-upload').click()">
                            <i class="uil uil-plus"></i> Add Image
                        </button>
                    </div>
                    <div class="card-body">
                        <input type="file" 
                               id="gallery-upload" 
                               accept="image/*" 
                               multiple 
                               style="display: none;"
                               onchange="uploadGalleryImages(this)">
                        
                        <div id="gallery-container" class="row">
                            <?php if (!empty($gallery)): ?>
                                <?php foreach ($gallery as $image): ?>
                                    <div class="col-md-3 col-sm-4 col-6 mb-3 gallery-item" data-id="<?= $image['id'] ?>">
                                        <div class="card">
                                            <img src="<?= base_url($image['image_path']) ?>" 
                                                 class="card-img-top" 
                                                 alt="<?= esc($image['image_name']) ?>"
                                                 style="height: 150px; object-fit: cover;">
                                            <div class="card-body p-2">
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm w-100"
                                                        onclick="deleteGalleryImage(<?= $image['id'] ?>)">
                                                    <i class="uil uil-trash-alt"></i> Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12 text-center text-muted">
                                    <p>No gallery images uploaded yet.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="uil uil-save"></i>
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail';
            img.style.maxHeight = '150px';
            preview.appendChild(img);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function uploadGalleryImages(input) {
    const files = input.files;
    if (!files.length) return;

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const formData = new FormData();
        formData.append('image', file);

        fetch('/admin/settings/add-gallery-image', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                addGalleryImageToDOM(data.image);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error uploading image');
        });
    }
    
    input.value = '';
}

function addGalleryImageToDOM(image) {
    const container = document.getElementById('gallery-container');
    const emptyMessage = container.querySelector('.text-muted');
    if (emptyMessage) {
        emptyMessage.remove();
    }

    const col = document.createElement('div');
    col.className = 'col-md-3 col-sm-4 col-6 mb-3 gallery-item';
    col.setAttribute('data-id', image.id);
    
    col.innerHTML = `
        <div class="card">
            <img src="${image.path}" class="card-img-top" alt="${image.name}" style="height: 150px; object-fit: cover;">
            <div class="card-body p-2">
                <button type="button" class="btn btn-danger btn-sm w-100" onclick="deleteGalleryImage(${image.id})">
                    <i class="uil uil-trash-alt"></i> Delete
                </button>
            </div>
        </div>
    `;
    
    container.appendChild(col);
}

function deleteGalleryImage(imageId) {
    if (!confirm('Are you sure you want to delete this image?')) return;

    fetch(`/settings/delete-gallery-image/${imageId}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const element = document.querySelector(`[data-id="${imageId}"]`);
            if (element) {
                element.remove();
            }
            
            // Check if no images left
            const container = document.getElementById('gallery-container');
            if (container.children.length === 0) {
                container.innerHTML = '<div class="col-12 text-center text-muted"><p>No gallery images uploaded yet.</p></div>';
            }
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error deleting image');
    });
}

// Currency symbol mapping
const currencySymbols = {
    'USD': '$',
    'EUR': '€',
    'GBP': '£',
    'JPY': '¥',
    'CAD': '$',
    'AUD': '$',
    'CHF': '₣',
    'CNY': '¥',
    'INR': '₹',
    'PHP': '₱'
};

// Update currency symbol when currency changes
document.getElementById('currency').addEventListener('change', function() {
    const selectedCurrency = this.value;
    const currencySymbol = currencySymbols[selectedCurrency] || '$';
    document.getElementById('currency_symbol').textContent = currencySymbol;
});

// Initialize currency symbol on page load
document.addEventListener('DOMContentLoaded', function() {
    const currencySelect = document.getElementById('currency');
    if (currencySelect) {
        const selectedCurrency = currencySelect.value;
        const currencySymbol = currencySymbols[selectedCurrency] || '$';
        document.getElementById('currency_symbol').textContent = currencySymbol;
    }
});
</script>

<?= $this->endSection() ?>
