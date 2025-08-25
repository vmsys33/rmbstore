<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'product_name', 'slug', 'product_category', 'description', 'short_description',
        'price', 'sale_price', 'stock_quantity', 'sku', 'weight', 'dimensions',
        'featured_image', 'gallery_images', 'meta_title', 'meta_description',
        'meta_keywords', 'status', 'featured', 'image_icon', 'image_post'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'product_name' => 'required|min_length[2]|max_length[255]',
        'product_category' => 'required|integer|is_not_unique[categories.id]',
        'price' => 'required|decimal',
        'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
        'status' => 'required|in_list[active,inactive,draft]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateSlug', 'generateSku'];
    protected $beforeUpdate   = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        if (!isset($data['data']['product_name'])) {
            return $data;
        }

        $name = $data['data']['product_name'];
        $slug = url_title($name, '-', true);
        
        // Ensure slug is unique
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->where('slug', $slug)->where('id !=', $data['id'] ?? 0)->first()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        $data['data']['slug'] = $slug;
        return $data;
    }

    protected function generateSku(array $data)
    {
        if (!isset($data['data']['product_name']) || isset($data['data']['sku'])) {
            return $data;
        }

        $name = $data['data']['product_name'];
        $sku = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $name), 0, 8));
        $sku .= '-' . strtoupper(substr(md5(uniqid()), 0, 4));
        
        // Ensure SKU is unique
        $originalSku = $sku;
        $counter = 1;
        
        while ($this->where('sku', $sku)->where('id !=', $data['id'] ?? 0)->first()) {
            $sku = $originalSku . '-' . $counter;
            $counter++;
        }
        
        $data['data']['sku'] = $sku;
        return $data;
    }

    public function getActiveProducts()
    {
        return $this->where('status', 'active')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getFeaturedProducts()
    {
        return $this->where('status', 'active')
                    ->where('featured', true)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getProductsByCategory(int $categoryId)
    {
        return $this->where('status', 'active')
                    ->where('product_category', $categoryId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getProductWithCategory(int $productId)
    {
        $product = $this->find($productId);
        if (!$product) {
            return null;
        }

        // Load category information
        $categoryModel = new CategoryModel();
        $product['category'] = $categoryModel->find($product['product_category']);

        return $product;
    }

    public function findBySlug(string $slug)
    {
        return $this->where('slug', $slug)->where('status', 'active')->first();
    }

    public function searchProducts(string $searchTerm)
    {
        return $this->like('product_name', $searchTerm)
                    ->orLike('description', $searchTerm)
                    ->orLike('short_description', $searchTerm)
                    ->where('status', 'active')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getProductsByPriceRange(float $minPrice, float $maxPrice)
    {
        return $this->where('status', 'active')
                    ->where('price >=', $minPrice)
                    ->where('price <=', $maxPrice)
                    ->orderBy('price', 'ASC')
                    ->findAll();
    }

    public function getLowStockProducts(int $threshold = 10)
    {
        return $this->where('status', 'active')
                    ->where('stock_quantity <=', $threshold)
                    ->orderBy('stock_quantity', 'ASC')
                    ->findAll();
    }

    public function updateStock(int $productId, int $quantity)
    {
        $product = $this->find($productId);
        if (!$product) {
            return false;
        }

        $newStock = $product['stock_quantity'] + $quantity;
        if ($newStock < 0) {
            return false;
        }

        return $this->update($productId, ['stock_quantity' => $newStock]);
    }

    public function getProductPrice(int $productId)
    {
        $product = $this->find($productId);
        if (!$product) {
            return 0;
        }

        return $product['sale_price'] ?? $product['price'];
    }

    /**
     * Get product with images
     */
    public function getProductWithImages($productId, $status = 'active')
    {
        $product = $this->find($productId);
        
        if ($product && $product['status'] === $status) {
            $productImageModel = new \App\Models\ProductImageModel();
            $product['images'] = $productImageModel->getProductImages($productId, $status);
            $product['primary_image'] = $productImageModel->getPrimaryImage($productId);
        }
        
        return $product;
    }

    public function getAllProducts()
    {
        return $this->where('status', 'active')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getLatestProducts($limit = 8)
    {
        return $this->where('status', 'active')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getRelatedProducts($productId, $limit = 4)
    {
        $product = $this->find($productId);
        if (!$product) {
            return [];
        }

        return $this->where('status', 'active')
                    ->where('product_category', $product['product_category'])
                    ->where('id !=', $productId)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get all products with their primary images
     */
    public function getProductsWithImages($status = 'active', $limit = null)
    {
        $products = $this->where('status', $status)
                        ->orderBy('featured', 'DESC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit) {
            $products->limit($limit);
        }
        
        $products = $products->findAll();
        
        // Add primary images to each product
        $productImageModel = new \App\Models\ProductImageModel();
        foreach ($products as &$product) {
            $product['primary_image'] = $productImageModel->getPrimaryImage($product['id']);
        }
        
        return $products;
    }

    /**
     * Get product with all image types (icon, post, gallery)
     */
    public function getProductWithAllImages($productId, $status = 'active')
    {
        $product = $this->find($productId);
        
        if ($product && $product['status'] === $status) {
            // Add gallery images
            $productGalleryModel = new \App\Models\ProductGalleryModel();
            $product['gallery_images'] = $productGalleryModel->getProductGallery($productId, $status);
            $product['gallery_count'] = $productGalleryModel->getGalleryCount($productId, $status);
        }
        
        return $product;
    }

    /**
     * Get all products with icon and post images
     */
    public function getProductsWithIconAndPost($status = 'active', $limit = null)
    {
        $products = $this->where('status', $status)
                        ->orderBy('featured', 'DESC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit) {
            $products->limit($limit);
        }
        
        return $products->findAll();
    }

    /**
     * Update product icon image
     */
    public function updateIconImage($productId, $imagePath)
    {
        return $this->update($productId, ['image_icon' => $imagePath]);
    }

    /**
     * Update product post image
     */
    public function updatePostImage($productId, $imagePath)
    {
        return $this->update($productId, ['image_post' => $imagePath]);
    }

    /**
     * Get products with icon images only
     */
    public function getProductsWithIcons($status = 'active', $limit = null)
    {
        $products = $this->where('status', $status)
                        ->where('image_icon IS NOT NULL')
                        ->orderBy('featured', 'DESC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit) {
            $products->limit($limit);
        }
        
        return $products->findAll();
    }

    /**
     * Get products with post images only
     */
    public function getProductsWithPostImages($status = 'active', $limit = null)
    {
        $products = $this->where('status', $status)
                        ->where('image_post IS NOT NULL')
                        ->orderBy('featured', 'DESC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit) {
            $products->limit($limit);
        }
        
        return $products->findAll();
    }



    /**
     * Get products for POS with filters (no inventory)
     */
    public function getProductsForPos($categoryId = null, $search = null)
    {
        $builder = $this->builder();
        $builder->select('products.*, categories.name as category_name')
                ->join('categories', 'categories.id = products.product_category', 'left');

        if ($categoryId) {
            $builder->where('products.product_category', $categoryId);
        }

        if ($search) {
            $builder->groupStart()
                    ->like('products.product_name', $search)
                    ->orLike('products.sku', $search)
                    ->orLike('products.description', $search)
                    ->groupEnd();
        }

        $builder->orderBy('products.product_name', 'ASC');

        return $builder->get()->getResultArray();
    }
}
