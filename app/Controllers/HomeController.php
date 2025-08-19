<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Models\SaleModel;
use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $userModel;
    protected $saleModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->userModel = new UserModel();
        $this->saleModel = new SaleModel();
    }

    public function index()
    {
        // Get today's sales data
        $todaySales = $this->saleModel->getTodaySalesSummary();
        $recentSales = $this->saleModel->getRecentSales(5);
        
        $data = [
            'title' => 'Dashboard',
            'subTitle' => 'Welcome to RMB Store Admin Dashboard',
            'totalProducts' => $this->productModel->countAll(),
            'totalCategories' => $this->categoryModel->countAll(),
            'totalUsers' => $this->userModel->countAll(),
            'todaySales' => $todaySales,
            'recentSales' => $recentSales,
        ];
        return view('home/index', $data);
    }
    public function index2()
    {
        $data = [
            'title' => 'Banking',
            'subTitle' => 'Welcome to Geex Modern Admin Dashboard',
        ];
        return view('home/index2', $data);
    }
    public function index3()
    {
        $data = [
            'title' => 'Crypto',
            'subTitle' => 'Welcome to Geex Modern Admin Dashboard',
        ];
        return view('home/index3', $data);
    }
    public function index4()
    {
        $data = [
            'title' => 'Invoicing',
            'subTitle' => 'Welcome to Geex Modern Admin Dashboard',
        ];
        return view('home/index4', $data);
    }
}
