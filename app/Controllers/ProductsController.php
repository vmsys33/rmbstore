<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductGalleryModel;
use App\Helpers\ImageUploadHelper;

class ProductsController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $productGalleryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->productGalleryModel = new ProductGalleryModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Products Management',
            'subTitle' => 'Manage your store products',
            'products' => $this->productModel->getActiveProducts(),
            'categories' => $this->categoryModel->getActiveCategories(),
        ];

        return view('products/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add New Product',
            'subTitle' => 'Create a new product',
            'categories' => $this->categoryModel->getActiveCategories(),
        ];

        return view('products/create', $data);
    }

        public function store()
    {
        $rules = [
            'product_name' => 'required|min_length[3]|max_length[255]',
            'product_category' => 'required|numeric',
            'price' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            return redirect()->back()->withInput()->with('validation_errors', $errors);
        }

        // Check for image_post file manually (more flexible than validation rule)
        $postFile = $this->request->getFile('image_post');
        if (!$postFile || !$postFile->isValid()) {
            return redirect()->back()->withInput()->with('error', 'Please upload a valid frontend product image.');
        }

        // Handle image uploads
        $imageIcon = null;

        // Upload icon image (optional)
        $iconFile = $this->request->getFile('image_icon');
        if ($iconFile && $iconFile->isValid() && !$iconFile->hasMoved()) {
            try {
                $newName = $iconFile->getRandomName();
                $iconFile->move(ROOTPATH . 'public/uploads/products/icons', $newName);
                $imageIcon = 'uploads/products/icons/' . $newName;
            } catch (\Exception $e) {
                log_message('error', 'Icon image upload failed: ' . $e->getMessage());
                // Continue without icon - it's optional
            }
        }

        // Handle post image upload (required) - we already validated it exists above
        $imagePost = '';
        try {
            $newName = $postFile->getRandomName();
            $postFile->move(ROOTPATH . 'public/uploads/products/posts', $newName);
            $imagePost = 'uploads/products/posts/' . $newName;
        } catch (\Exception $e) {
            log_message('error', 'Post image upload failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Post image upload failed: ' . $e->getMessage());
        }

        // Auto-generate SKU if not provided
        $sku = $this->request->getPost('sku');
        if (!$sku) {
            $productName = $this->request->getPost('product_name');
            $sku = strtoupper(preg_replace('/[^A-Z0-9]/', '', $productName));
            $sku = substr($sku, 0, 8) . '-' . strtoupper(substr(md5(uniqid()), 0, 4));
        }

        $data = [
            'product_name' => $this->request->getPost('product_name'),
            'sku' => $sku,
            'product_category' => $this->request->getPost('product_category'),
            'price' => $this->request->getPost('price') ?: null,
            'sale_price' => $this->request->getPost('sale_price') ?: null,
            'stock_quantity' => $this->request->getPost('stock_quantity') ?: 0,
            'weight' => $this->request->getPost('weight') ?: null,
            'dimensions' => $this->request->getPost('dimensions') ?: null,
            'short_description' => $this->request->getPost('short_description') ?: null,
            'description' => $this->request->getPost('description') ?: null,
            'status' => $this->request->getPost('status') ?: 'active',
            'featured' => $this->request->getPost('featured') ? 1 : 0,
            'image_icon' => $imageIcon,
            'image_post' => $imagePost,
        ];


        // Insert product
        try {
            $productId = $this->productModel->insert($data);
            if (!$productId) {
                return redirect()->back()->withInput()->with('error', 'Failed to create product: Database insert returned false. Check server logs for details.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create product: ' . $e->getMessage());
        }

        // Handle gallery images
        $galleryFiles = $this->request->getFileMultiple('gallery_images');
        if ($galleryFiles) {
            foreach ($galleryFiles as $file) {
                if ($file && $file->isValid()) {
                    $uploadResult = ImageUploadHelper::uploadProductImage($file, 'gallery', $productId);
                    if ($uploadResult['success']) {
                        $galleryData = [
                            'product_id' => $productId,
                            'image_path' => $uploadResult['path'],
                            'image_name' => $file->getClientName(),
                            'alt_text' => $file->getClientName(),
                            'sort_order' => 0,
                            'status' => 'active'
                        ];
                        $this->productGalleryModel->insert($galleryData);
                    }
                }
            }
        }

        return redirect()->to('/admin/products')->with('success', 'Product created successfully');
    }

    public function view($id = null)
    {
        if (!$id) {
            return redirect()->to('/admin/products')->with('error', 'Product ID is required');
        }

        $product = $this->productModel->getProductWithAllImages($id);
        
        if (!$product) {
            return redirect()->to('/admin/products')->with('error', 'Product not found');
        }

        $data = [
            'title' => 'View Product',
            'subTitle' => 'Product Details',
            'product' => $product,
        ];

        return view('products/view', $data);
    }

    public function edit($id = null)
    {
        if (!$id) {
            return redirect()->to('/admin/products')->with('error', 'Product ID is required');
        }

        $product = $this->productModel->find($id);
        
        if (!$product) {
            return redirect()->to('/admin/products')->with('error', 'Product not found');
        }

        $data = [
            'title' => 'Edit Product',
            'subTitle' => 'Update Product Information',
            'product' => $product,
            'categories' => $this->categoryModel->getActiveCategories(),
        ];

        return view('products/edit', $data);
    }

    public function delete($id = null)
    {
        if (!$id) {
            return redirect()->to('/admin/products')->with('error', 'Product ID is required');
        }

        if ($this->productModel->delete($id)) {
            return redirect()->to('/admin/products')->with('success', 'Product deleted successfully');
        }

        return redirect()->to('/admin/products')->with('error', 'Failed to delete product');
    }

    public function update($id = null)
    {
        if (!$id) {
            return redirect()->to('/admin/products')->with('error', 'Product ID is required');
        }

        // Get current product data
        $currentProduct = $this->productModel->find($id);
        if (!$currentProduct) {
            return redirect()->to('/admin/products')->with('error', 'Product not found');
        }

        // Use same validation approach as create method
        $rules = [
            'product_name' => 'required|min_length[3]|max_length[255]',
            'product_category' => 'required|numeric',
            'price' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            return redirect()->back()->withInput()->with('validation_errors', $errors);
        }

        // Handle image uploads - keep existing images by default
        $imageIcon = $currentProduct['image_icon'];
        $imagePost = $currentProduct['image_post'];

        // Upload icon image (optional) - same approach as create method
        $iconFile = $this->request->getFile('image_icon');
        if ($iconFile && $iconFile->isValid() && !$iconFile->hasMoved()) {
            try {
                $newName = $iconFile->getRandomName();
                $iconFile->move(ROOTPATH . 'public/uploads/products/icons', $newName);
                
                // Delete old icon image if exists
                if ($currentProduct['image_icon'] && file_exists(ROOTPATH . 'public/' . $currentProduct['image_icon'])) {
                    unlink(ROOTPATH . 'public/' . $currentProduct['image_icon']);
                }
                
                $imageIcon = 'uploads/products/icons/' . $newName;
            } catch (\Exception $e) {
                log_message('error', 'Icon image upload failed: ' . $e->getMessage());
                // Continue without updating icon - it's optional
            }
        }

        // Upload post image (optional for updates) - same approach as create method
        $postFile = $this->request->getFile('image_post');
        if ($postFile && $postFile->isValid() && !$postFile->hasMoved()) {
            try {
                $newName = $postFile->getRandomName();
                $postFile->move(ROOTPATH . 'public/uploads/products/posts', $newName);
                
                // Delete old post image if exists
                if ($currentProduct['image_post'] && file_exists(ROOTPATH . 'public/' . $currentProduct['image_post'])) {
                    unlink(ROOTPATH . 'public/' . $currentProduct['image_post']);
                }
                
                $imagePost = 'uploads/products/posts/' . $newName;
            } catch (\Exception $e) {
                log_message('error', 'Post image upload failed: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Post image upload failed: ' . $e->getMessage());
            }
        }

        $data = [
            'product_name' => $this->request->getPost('product_name'),
            'sku' => $this->request->getPost('sku'),
            'product_category' => $this->request->getPost('product_category'),
            'price' => $this->request->getPost('price') ?: null,
            'sale_price' => $this->request->getPost('sale_price') ?: null,
            'stock_quantity' => $this->request->getPost('stock_quantity') ?: 0,
            'weight' => $this->request->getPost('weight') ?: null,
            'dimensions' => $this->request->getPost('dimensions') ?: null,
            'short_description' => $this->request->getPost('short_description') ?: null,
            'description' => $this->request->getPost('description') ?: null,
            'status' => $this->request->getPost('status') ?: 'active',
            'featured' => $this->request->getPost('featured') ? 1 : 0,
            'image_icon' => $imageIcon,
            'image_post' => $imagePost,
        ];

        // Update product - same approach as create method
        try {
            $updateResult = $this->productModel->update($id, $data);
            if (!$updateResult) {
                return redirect()->back()->withInput()->with('error', 'Failed to update product: Database update returned false. Check server logs for details.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update product: ' . $e->getMessage());
        }

        // Handle gallery images - same approach as create method
        $galleryFiles = $this->request->getFileMultiple('gallery_images');
        if ($galleryFiles) {
            foreach ($galleryFiles as $file) {
                if ($file && $file->isValid()) {
                    $uploadResult = ImageUploadHelper::uploadProductImage($file, 'gallery', $id);
                    if ($uploadResult['success']) {
                        $galleryData = [
                            'product_id' => $id,
                            'image_path' => $uploadResult['path'],
                            'image_name' => $file->getClientName(),
                            'alt_text' => $file->getClientName(),
                            'sort_order' => 0,
                            'status' => 'active'
                        ];
                        $this->productGalleryModel->insert($galleryData);
                    }
                }
            }
        }

        return redirect()->to('/admin/products')->with('success', 'Product updated successfully');
    }
}
