<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\ProductImageModel;
use App\Models\ProductGalleryModel;

class StoreController extends BaseController
{
    protected $userModel;
    protected $categoryModel;
    protected $productModel;
    protected $productImageModel;
    protected $productGalleryModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
        $this->productImageModel = new ProductImageModel();
        $this->productGalleryModel = new ProductGalleryModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Store Dashboard',
            'subTitle' => 'Welcome to Store Management System',
            'totalUsers' => $this->userModel->countAll(),
            'totalCategories' => $this->categoryModel->countAll(),
            'totalProducts' => $this->productModel->countAll(),
            'featuredProducts' => $this->productModel->getFeaturedProducts(),
            'categories' => $this->categoryModel->getActiveCategories(),
        ];

        return view('store/dashboard', $data);
    }

    // API Endpoints for Products
    public function getProducts()
    {
        $products = $this->productModel->getActiveProducts();
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $products
        ]);
    }

    public function getProduct($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Product ID is required'
            ])->setStatusCode(400);
        }

        $product = $this->productModel->getProductWithImages($id);
        
        if (!$product) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Product not found'
            ])->setStatusCode(404);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $product
        ]);
    }

    public function getProductsWithImages()
    {
        $products = $this->productModel->getProductsWithImages('active');
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $products
        ]);
    }

    public function createProduct()
    {
        $rules = [
            'product_name' => 'required|min_length[2]|max_length[255]',
            'product_category' => 'required|integer',
            'price' => 'required|decimal',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }

        $data = [
            'product_name' => $this->request->getPost('product_name'),
            'product_category' => $this->request->getPost('product_category'),
            'description' => $this->request->getPost('description'),
            'short_description' => $this->request->getPost('short_description'),
            'price' => $this->request->getPost('price'),
            'sale_price' => $this->request->getPost('sale_price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'weight' => $this->request->getPost('weight'),
            'dimensions' => $this->request->getPost('dimensions'),
            'status' => $this->request->getPost('status') ?? 'active',
            'featured' => $this->request->getPost('featured') ?? false,
        ];

        $productId = $this->productModel->insert($data);
        
        if ($productId) {
            $product = $this->productModel->find($productId);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product created successfully',
                'data' => $product
            ])->setStatusCode(201);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to create product'
        ])->setStatusCode(500);
    }

    // API Endpoints for Categories
    public function getCategories()
    {
        $categories = $this->categoryModel->getActiveCategories();
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    public function getCategory($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Category ID is required'
            ])->setStatusCode(400);
        }

        $category = $this->categoryModel->getCategoryWithProducts($id);
        
        if (!$category) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Category not found'
            ])->setStatusCode(404);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $category
        ]);
    }

    public function createCategory()
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[255]',
            'status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'parent_id' => $this->request->getPost('parent_id'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status' => $this->request->getPost('status'),
        ];

        $categoryId = $this->categoryModel->insert($data);
        
        if ($categoryId) {
            $category = $this->categoryModel->find($categoryId);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Category created successfully',
                'data' => $category
            ])->setStatusCode(201);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to create category'
        ])->setStatusCode(500);
    }

    // API Endpoints for Users
    public function getUsers()
    {
        $users = $this->userModel->getActiveUsers();
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $users
        ]);
    }

    public function getUser($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User ID is required'
            ])->setStatusCode(400);
        }

        $user = $this->userModel->find($id);
        
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not found'
            ])->setStatusCode(404);
        }

        // Remove password from response
        unset($user['password']);

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $user
        ]);
    }

    // Search functionality
    public function searchProducts()
    {
        $searchTerm = $this->request->getGet('q');
        
        if (!$searchTerm) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Search term is required'
            ])->setStatusCode(400);
        }

        $products = $this->productModel->searchProducts($searchTerm);
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $products,
            'search_term' => $searchTerm
        ]);
    }

    // Dashboard statistics
    public function getStats()
    {
        $stats = [
            'total_users' => $this->userModel->countAll(),
            'total_categories' => $this->categoryModel->countAll(),
            'total_products' => $this->productModel->countAll(),
            'active_products' => $this->productModel->where('status', 'active')->countAllResults(),
            'featured_products' => $this->productModel->where('featured', true)->countAllResults(),
            'low_stock_products' => count($this->productModel->getLowStockProducts(10)),
        ];

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $stats
        ]);
    }

    // Product Image Management
    public function getProductImages($productId = null)
    {
        if (!$productId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Product ID is required'
            ])->setStatusCode(400);
        }

        $images = $this->productImageModel->getProductImages($productId);
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $images
        ]);
    }

    public function addProductImage()
    {
        $rules = [
            'product_id' => 'required|integer',
            'image_path' => 'required|max_length[255]',
            'image_name' => 'required|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }

        $data = [
            'product_id' => $this->request->getPost('product_id'),
            'image_path' => $this->request->getPost('image_path'),
            'image_name' => $this->request->getPost('image_name'),
            'alt_text' => $this->request->getPost('alt_text'),
            'is_primary' => $this->request->getPost('is_primary') ? 1 : 0,
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
        ];
        
        $imageId = $this->productImageModel->insert($data);
        
        if ($imageId) {
            $image = $this->productImageModel->find($imageId);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product image added successfully',
                'data' => $image
            ])->setStatusCode(201);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to add product image',
            'errors' => $this->productImageModel->errors()
        ])->setStatusCode(400);
    }

    public function deleteProductImage($imageId = null)
    {
        if (!$imageId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Image ID is required'
            ])->setStatusCode(400);
        }

        if ($this->productImageModel->delete($imageId)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product image deleted successfully'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to delete product image'
        ])->setStatusCode(400);
    }

    public function setPrimaryImage($imageId = null)
    {
        if (!$imageId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Image ID is required'
            ])->setStatusCode(400);
        }

        $image = $this->productImageModel->find($imageId);
        if (!$image) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Image not found'
            ])->setStatusCode(404);
        }
        
        if ($this->productImageModel->setPrimaryImage($imageId, $image['product_id'])) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Primary image set successfully'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to set primary image'
        ])->setStatusCode(400);
    }

    // Product Gallery Management
    public function getProductGallery($productId = null)
    {
        if (!$productId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Product ID is required'
            ])->setStatusCode(400);
        }

        $gallery = $this->productGalleryModel->getProductGallery($productId);
        $count = $this->productGalleryModel->getGalleryCount($productId);
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'gallery' => $gallery,
                'count' => $count,
                'can_add_more' => $count < 6
            ]
        ]);
    }

    public function addGalleryImage()
    {
        $rules = [
            'product_id' => 'required|integer',
            'image_path' => 'required|max_length[255]',
            'image_name' => 'required|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }

        $productId = $this->request->getPost('product_id');
        
        // Check if product can have more images
        if (!$this->productGalleryModel->canAddMoreImages($productId)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Maximum 6 gallery images allowed per product'
            ])->setStatusCode(400);
        }

        $data = [
            'product_id' => $productId,
            'image_path' => $this->request->getPost('image_path'),
            'image_name' => $this->request->getPost('image_name'),
            'alt_text' => $this->request->getPost('alt_text'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
        ];
        
        $imageId = $this->productGalleryModel->insert($data);
        
        if ($imageId) {
            $image = $this->productGalleryModel->find($imageId);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Gallery image added successfully',
                'data' => $image
            ])->setStatusCode(201);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to add gallery image',
            'errors' => $this->productGalleryModel->errors()
        ])->setStatusCode(400);
    }

    public function deleteGalleryImage($imageId = null)
    {
        if (!$imageId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Image ID is required'
            ])->setStatusCode(400);
        }

        if ($this->productGalleryModel->delete($imageId)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Gallery image deleted successfully'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to delete gallery image'
        ])->setStatusCode(400);
    }

    public function reorderGallery($productId = null)
    {
        if (!$productId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Product ID is required'
            ])->setStatusCode(400);
        }

        $imageIds = $this->request->getJSON(true);
        
        if (!is_array($imageIds)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Image IDs array is required'
            ])->setStatusCode(400);
        }

        if ($this->productGalleryModel->reorderGallery($productId, $imageIds)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Gallery reordered successfully'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to reorder gallery'
        ])->setStatusCode(400);
    }

    // Product Icon and Post Image Management
    public function updateProductIcon($productId = null)
    {
        if (!$productId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Product ID is required'
            ])->setStatusCode(400);
        }

        $imagePath = $this->request->getPost('image_path');
        
        if (!$imagePath) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Image path is required'
            ])->setStatusCode(400);
        }

        if ($this->productModel->updateIconImage($productId, $imagePath)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product icon updated successfully'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to update product icon'
        ])->setStatusCode(400);
    }

    public function updateProductPost($productId = null)
    {
        if (!$productId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Product ID is required'
            ])->setStatusCode(400);
        }

        $imagePath = $this->request->getPost('image_path');
        
        if (!$imagePath) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Image path is required'
            ])->setStatusCode(400);
        }

        if ($this->productModel->updatePostImage($productId, $imagePath)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product post image updated successfully'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to update product post image'
        ])->setStatusCode(400);
    }
}
