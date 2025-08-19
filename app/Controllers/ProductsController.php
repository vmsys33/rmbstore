<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductGalleryModel;
use App\Models\SettingsModel;
use App\Helpers\ImageUploadHelper;
use App\Helpers\CurrencyHelper;

class ProductsController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $settingsModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->productGalleryModel = new ProductGalleryModel();
        $this->settingsModel = new SettingsModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Products Management',
            'subTitle' => 'Manage your store products',
            'products' => $this->productModel->getActiveProducts(),
            'categories' => $this->categoryModel->getActiveCategories(),
            'currencySymbol' => CurrencyHelper::getCurrencySymbol(),
        ];

        return view('products/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add New Product',
            'subTitle' => 'Create a new product',
            'categories' => $this->categoryModel->getActiveCategories(),
            'currency' => CurrencyHelper::getCurrency(),
            'currencySymbol' => CurrencyHelper::getCurrencySymbol(),
        ];

        return view('products/create', $data);
    }

    public function store()
    {
        // Validate required fields
        $validation = \Config\Services::validation();
        $validation->setRules([
            'product_name' => 'required|min_length[3]|max_length[255]',
            'sku' => 'required|min_length[3]|max_length[50]|is_unique[products.sku]',
            'product_category' => 'required|numeric',
            'price' => 'required|numeric|greater_than[0]',
            'stock_quantity' => 'required|numeric|greater_than_equal_to[0]',
            'status' => 'required|in_list[active,inactive,draft]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle image uploads
        $imageIcon = null;
        $imagePost = null;

        // Upload icon image
        $iconFile = $this->request->getFile('image_icon');
        if ($iconFile && $iconFile->isValid()) {
            $uploadResult = ImageUploadHelper::uploadProductImage($iconFile, 'icon');
            if ($uploadResult['success']) {
                $imageIcon = $uploadResult['path'];
            } else {
                return redirect()->back()->withInput()->with('error', 'Icon image: ' . $uploadResult['message']);
            }
        }

        // Upload post image
        $postFile = $this->request->getFile('image_post');
        if ($postFile && $postFile->isValid()) {
            $uploadResult = ImageUploadHelper::uploadProductImage($postFile, 'post');
            if ($uploadResult['success']) {
                $imagePost = $uploadResult['path'];
            } else {
                return redirect()->back()->withInput()->with('error', 'Post image: ' . $uploadResult['message']);
            }
        }

        $data = [
            'product_name' => $this->request->getPost('product_name'),
            'sku' => $this->request->getPost('sku'),
            'product_category' => $this->request->getPost('product_category'),
            'price' => $this->request->getPost('price'),
            'sale_price' => $this->request->getPost('sale_price') ?: null,
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'weight' => $this->request->getPost('weight') ?: null,
            'dimensions' => $this->request->getPost('dimensions') ?: null,
            'short_description' => $this->request->getPost('short_description') ?: null,
            'description' => $this->request->getPost('description') ?: null,
            'status' => $this->request->getPost('status'),
            'featured' => $this->request->getPost('featured') ? 1 : 0,
            'image_icon' => $imageIcon,
            'image_post' => $imagePost,
        ];

        // Insert product
        $productId = $this->productModel->insert($data);
        if (!$productId) {
            return redirect()->back()->withInput()->with('error', 'Failed to create product');
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
            'currencySymbol' => CurrencyHelper::getCurrencySymbol(),
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
            'currency' => CurrencyHelper::getCurrency(),
            'currencySymbol' => CurrencyHelper::getCurrencySymbol(),
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

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'product_name' => 'required|min_length[3]|max_length[255]',
            'sku' => 'required|min_length[3]|max_length[50]|is_unique[products.sku,id,' . $id . ']',
            'product_category' => 'required|numeric',
            'price' => 'required|numeric|greater_than[0]',
            'stock_quantity' => 'required|numeric|greater_than_equal_to[0]',
            'status' => 'required|in_list[active,inactive,draft]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle image uploads
        $imageIcon = $currentProduct['image_icon']; // Keep existing image by default
        $imagePost = $currentProduct['image_post']; // Keep existing image by default

        // Upload icon image if provided
        $iconFile = $this->request->getFile('image_icon');
        if ($iconFile && $iconFile->isValid()) {
            $uploadResult = ImageUploadHelper::uploadProductImage($iconFile, 'icon');
            if ($uploadResult['success']) {
                // Delete old icon image if exists
                if ($currentProduct['image_icon'] && file_exists(FCPATH . $currentProduct['image_icon'])) {
                    unlink(FCPATH . $currentProduct['image_icon']);
                }
                $imageIcon = $uploadResult['path'];
            } else {
                return redirect()->back()->withInput()->with('error', 'Icon image: ' . $uploadResult['message']);
            }
        }

        // Upload post image if provided
        $postFile = $this->request->getFile('image_post');
        if ($postFile && $postFile->isValid()) {
            $uploadResult = ImageUploadHelper::uploadProductImage($postFile, 'post');
            if ($uploadResult['success']) {
                // Delete old post image if exists
                if ($currentProduct['image_post'] && file_exists(FCPATH . $currentProduct['image_post'])) {
                    unlink(FCPATH . $currentProduct['image_post']);
                }
                $imagePost = $uploadResult['path'];
            } else {
                return redirect()->back()->withInput()->with('error', 'Post image: ' . $uploadResult['message']);
            }
        }

        $data = [
            'product_name' => $this->request->getPost('product_name'),
            'sku' => $this->request->getPost('sku'),
            'product_category' => $this->request->getPost('product_category'),
            'price' => $this->request->getPost('price'),
            'sale_price' => $this->request->getPost('sale_price') ?: null,
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'weight' => $this->request->getPost('weight') ?: null,
            'dimensions' => $this->request->getPost('dimensions') ?: null,
            'short_description' => $this->request->getPost('short_description') ?: null,
            'description' => $this->request->getPost('description') ?: null,
            'status' => $this->request->getPost('status'),
            'featured' => $this->request->getPost('featured') ? 1 : 0,
            'image_icon' => $imageIcon,
            'image_post' => $imagePost,
        ];

        // Update product
        $updateResult = $this->productModel->update($id, $data);
        if ($updateResult) {
            // Handle gallery images if provided
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

        // Log the error for debugging
        log_message('error', 'Failed to update product ID: ' . $id . ' with data: ' . json_encode($data));
        return redirect()->to('/admin/products/edit/' . $id)->with('error', 'Failed to update product. Please check the form data and try again.');
    }
}
