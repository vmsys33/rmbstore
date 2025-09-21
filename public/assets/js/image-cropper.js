/**
 * Reusable Image Cropper Library
 * Based on the user's tested and working Cropper.js implementation
 */
class ImageCropper {
    constructor(options = {}) {
        this.options = {
            aspectRatio: options.aspectRatio || 1,
            viewMode: options.viewMode || 1,
            dragMode: options.dragMode || 'move',
            autoCropArea: options.autoCropArea || 0.8,
            minCropBoxWidth: options.minCropBoxWidth || 200,
            minCropBoxHeight: options.minCropBoxHeight || 200,
            outputWidth: options.outputWidth || 2000,
            outputHeight: options.outputHeight || 2000,
            quality: options.quality || 0.9,
            format: options.format || 'image/jpeg',
            onCrop: options.onCrop || null,
            onCancel: options.onCancel || null
        };
        
        this.cropper = null;
        this.currentFile = null;
        this.ready = false;
        this.init();
    }

    init() {
        console.log('ImageCropper: Initializing...');
        
        // Add Cropper.js CSS if not already loaded
        if (!document.querySelector('link[href*="cropper.min.css"]')) {
            console.log('ImageCropper: Loading Cropper.js CSS...');
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css';
            document.head.appendChild(link);
        }

        // Add Cropper.js script if not already loaded
        if (typeof Cropper === 'undefined') {
            console.log('ImageCropper: Loading Cropper.js script...');
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js';
            script.onload = () => {
                console.log('ImageCropper: Cropper.js script loaded successfully');
                this.ready = true;
                this.setupStyles();
            };
            script.onerror = () => {
                // Fallback to alternative CDN
                console.log('Primary CDN failed, trying alternative...');
                const fallbackScript = document.createElement('script');
                fallbackScript.src = 'https://unpkg.com/cropperjs@1.6.1/dist/cropper.min.js';
                fallbackScript.onload = () => {
                    console.log('ImageCropper: Fallback CDN loaded successfully');
                    this.ready = true;
                    this.setupStyles();
                };
                fallbackScript.onerror = () => {
                    console.error('All CDNs failed to load Cropper.js');
                    alert('Image cropper library failed to load. Please check your internet connection and refresh the page.');
                };
                document.head.appendChild(fallbackScript);
            };
            document.head.appendChild(script);
        } else {
            console.log('ImageCropper: Cropper.js already available');
            this.ready = true;
            this.setupStyles();
        }
    }

    setupStyles() {
        // Add custom styles if not already present
        if (!document.getElementById('image-cropper-styles')) {
            const style = document.createElement('style');
            style.id = 'image-cropper-styles';
            style.textContent = `
                .image-cropper-modal {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.8);
                    z-index: 9999;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    padding: 20px;
                    box-sizing: border-box;
                }

                .image-cropper-container {
                    background: #ffffff;
                    border-radius: 16px;
                    padding: 1.5rem;
                    max-width: 80vw;
                    max-height: 85vh;
                    width: 500px;
                    text-align: center;
                    position: relative;
                    overflow: visible;
                }

                .image-cropper-header {
                    color: #333;
                    margin-bottom: 1.5rem;
                    font-size: 1.5rem;
                    font-weight: 600;
                }

                .image-cropper-area {
                    width: 100%;
                    max-height: 300px;
                    margin: 1rem 0;
                    overflow: hidden;
                }

                .image-cropper-preview {
                    max-width: 100%;
                    max-height: 280px;
                    height: auto;
                    display: block;
                }

                .image-cropper-buttons {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    gap: 0.75rem;
                    margin-top: 1rem;
                }

                .image-cropper-btn {
                    padding: 0.75rem 1.5rem;
                    border: none;
                    border-radius: 8px;
                    cursor: pointer;
                    font-weight: bold;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }

                .image-cropper-btn:hover {
                    transform: translateY(-2px);
                }

                .image-cropper-btn-primary {
                    background-color: #007bff;
                    color: #ffffff;
                }

                .image-cropper-btn-primary:hover {
                    background-color: #0056b3;
                }

                .image-cropper-btn-secondary {
                    background-color: #6c757d;
                    color: #ffffff;
                }

                .image-cropper-btn-secondary:hover {
                    background-color: #5a6268;
                }

                .image-cropper-close {
                    position: absolute;
                    top: 15px;
                    right: 20px;
                    background: none;
                    border: none;
                    font-size: 24px;
                    cursor: pointer;
                    color: #666;
                    padding: 0;
                    width: 30px;
                    height: 30px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .image-cropper-close:hover {
                    color: #333;
                }

                @media (max-width: 768px) {
                    .image-cropper-container {
                        padding: 1rem;
                        margin: 10px;
                        max-height: 85vh;
                        width: 95vw;
                        max-width: 95vw;
                    }
                    
                    .image-cropper-area {
                        max-height: 250px;
                    }
                    
                    .image-cropper-preview {
                        max-height: 230px;
                    }
                    
                    .image-cropper-buttons {
                        flex-direction: column;
                        gap: 0.5rem;
                    }
                    
                    .image-cropper-btn {
                        width: 100%;
                        padding: 0.75rem 1rem;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }

    show(file, title = 'Crop Image') {
        return new Promise((resolve, reject) => {
            if (!file || !file.type.startsWith('image/')) {
                reject(new Error('Invalid file type. Please select an image.'));
                return;
            }

            // Wait for cropper to be ready
            this.waitForReady().then(() => {
                this.currentFile = file;
                this.createModal(title);
                
                const reader = new FileReader();
                reader.onload = (event) => {
                    this.setupCropper(event.target.result, resolve, reject);
                };
                reader.onerror = () => reject(new Error('Failed to read file'));
                reader.readAsDataURL(file);
            }).catch(reject);
        });
    }

    waitForReady() {
        return new Promise((resolve) => {
            if (this.ready && typeof Cropper !== 'undefined') {
                resolve();
                return;
            }
            
            const checkInterval = setInterval(() => {
                if (this.ready && typeof Cropper !== 'undefined') {
                    clearInterval(checkInterval);
                    resolve();
                }
            }, 100);
            
            // Timeout after 10 seconds
            setTimeout(() => {
                clearInterval(checkInterval);
                resolve();
            }, 10000);
        });
    }

    createModal(title) {
        // Remove existing modal if any
        const existingModal = document.querySelector('.image-cropper-modal');
        if (existingModal) {
            existingModal.remove();
        }

        const modal = document.createElement('div');
        modal.className = 'image-cropper-modal';
        modal.innerHTML = `
            <div class="image-cropper-container">
                <button class="image-cropper-close">×</button>
                <h2 class="image-cropper-header">${title}</h2>
                <div class="image-cropper-area">
                    <img class="image-cropper-preview" src="#" alt="Image Preview">
                </div>
                <div class="image-cropper-buttons">
                    <button class="image-cropper-btn image-cropper-btn-primary" id="cropConfirmBtn">Crop & Save</button>
                    <button class="image-cropper-btn image-cropper-btn-secondary" id="cropCancelBtn">Cancel</button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Store modal reference
        this.modal = modal;
        
        // Add close button event listener
        const closeBtn = modal.querySelector('.image-cropper-close');
        closeBtn.addEventListener('click', () => {
            this.close();
        });
    }

    setupCropper(imageSrc, resolve, reject) {
        const img = this.modal.querySelector('.image-cropper-preview');
        img.src = imageSrc;

        // Wait for image to load
        img.onload = () => {
            console.log('Image loaded, setting up cropper...');
            console.log('Cropper available:', typeof Cropper !== 'undefined');
            
            // Destroy previous cropper if exists
            if (this.cropper) {
                this.cropper.destroy();
            }

            // Check if we're on mobile
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            console.log('Is mobile:', isMobile);
            
                        // Initialize new cropper with mobile-optimized settings
            try {
                this.cropper = new Cropper(img, {
                    aspectRatio: this.options.aspectRatio,
                    viewMode: this.options.viewMode,
                    dragMode: this.options.dragMode,
                    autoCropArea: this.options.autoCropArea,
                    minCropBoxWidth: this.options.minCropBoxWidth,
                    minCropBoxHeight: this.options.minCropBoxHeight,
                    // Mobile-specific options
                    touchDragZoom: true,
                    wheelZoomRatio: isMobile ? 0.1 : 0.1,
                    zoomOnTouch: true,
                    zoomOnWheel: true,
                    // Better mobile responsiveness
                    responsive: true,
                    restore: false,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false
                });
                console.log('Cropper initialized successfully');
            } catch (error) {
                console.error('Error initializing cropper:', error);
                reject(error);
                return;
            }

            // Setup button handlers
            this.setupButtonHandlers(resolve, reject);
        };
    }

    setupButtonHandlers(resolve, reject) {
        const confirmBtn = this.modal.querySelector('#cropConfirmBtn');
        const cancelBtn = this.modal.querySelector('#cropCancelBtn');

        confirmBtn.onclick = () => {
            if (this.cropper) {
                const canvas = this.cropper.getCroppedCanvas({
                    width: this.options.outputWidth,
                    height: this.options.outputHeight,
                });

                canvas.toBlob((blob) => {
                    // Create a new file from the cropped blob
                    const croppedFile = new File([blob], this.currentFile.name, {
                        type: this.options.format,
                        lastModified: Date.now()
                    });

                    // Call onCrop callback if provided
                    if (this.options.onCrop) {
                        this.options.onCrop(croppedFile, canvas.toDataURL(this.options.format, this.options.quality));
                    }

                    this.close();
                    resolve(croppedFile);
                }, this.options.format, this.options.quality);
            }
        };

        cancelBtn.onclick = () => {
            if (this.options.onCancel) {
                this.options.onCancel();
            }
            this.close();
            reject(new Error('Crop cancelled'));
        };
    }

    close() {
        if (this.cropper) {
            this.cropper.destroy();
            this.cropper = null;
        }
        if (this.modal) {
            this.modal.remove();
            this.modal = null;
        }
        this.currentFile = null;
    }

    // Static method for easy usage
    static crop(file, options = {}) {
        const cropper = new ImageCropper(options);
        return cropper.show(file, options.title || 'Crop Image');
    }
}

// Global function for easy access
window.ImageCropper = ImageCropper;
