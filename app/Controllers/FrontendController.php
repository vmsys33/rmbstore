<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SettingsModel;
use App\Models\SliderModel;

class FrontendController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $settingsModel;
    protected $sliderModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->settingsModel = new SettingsModel();
        $this->sliderModel = new SliderModel();
    }

    public function index()
    {
        try {
            // Get settings
            $settings = $this->settingsModel->getSettings() ?: [];
            
            // Get categories
            $categories = $this->categoryModel->getActiveCategories() ?: [];
            
            // Get featured products
            $featuredProducts = $this->productModel->getFeaturedProducts() ?: [];
            
            // Get latest products
            $latestProducts = $this->productModel->getLatestProducts(8) ?: [];
            
            // Get active sliders
            $sliders = $this->sliderModel->getActiveSliders() ?: [];
            
            $data = [
                'settings' => $settings,
                'categories' => $categories,
                'featured_products' => $featuredProducts,
                'latest_products' => $latestProducts,
                'sliders' => $sliders
            ];
            
            return view('frontend/index', $data);
        } catch (\Exception $e) {
            // Log the error
            log_message('error', 'FrontendController index error: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            
            // Return a simple error page
            return view('errors/html/error_500', ['message' => $e->getMessage()]);
        }
    }

    public function products()
    {
        $data = [
            'title' => 'All Products',
            'settings' => $this->settingsModel->getSettings(),
            'products' => $this->productModel->getAllProducts(),
            'categories' => $this->categoryModel->getActiveCategories()
        ];

        return view('frontend/products', $data);
    }

    public function product($id)
    {
        $data = [
            'title' => 'Product Details',
            'settings' => $this->settingsModel->getSettings(),
            'categories' => $this->categoryModel->getActiveCategories(),
            'product' => $this->productModel->getProductWithAllImages($id),
            'related_products' => $this->productModel->getRelatedProducts($id)
        ];

        return view('frontend/product-details', $data);
    }

    public function category($id)
    {
        $data = [
            'title' => 'Category Products',
            'settings' => $this->settingsModel->getSettings(),
            'categories' => $this->categoryModel->getActiveCategories(),
            'category' => $this->categoryModel->find($id),
            'products' => $this->productModel->getProductsByCategory($id)
        ];

        return view('frontend/category', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About Us',
            'settings' => $this->settingsModel->getSettings()
        ];

        return view('frontend/about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact Us',
            'settings' => $this->settingsModel->getSettings()
        ];

        return view('frontend/contact', $data);
    }
}
