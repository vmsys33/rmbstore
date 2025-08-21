<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Models\SaleModel;
use App\Models\DailyClosingModel;
use App\Services\RealtimeService;
use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $userModel;
    protected $saleModel;
    protected $dailyClosingModel;
    protected $realtimeService;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->userModel = new UserModel();
        $this->saleModel = new SaleModel();
        $this->dailyClosingModel = new DailyClosingModel();
        $this->realtimeService = new RealtimeService();
    }

    public function index()
    {
        // Get real-time dashboard data
        $dashboardData = $this->realtimeService->getDashboardData();
        
        $data = [
            'title' => 'Dashboard',
            'subTitle' => 'Welcome to RMB Store Admin Dashboard',
            'totalProducts' => $this->productModel->countAll(),
            'totalCategories' => $this->categoryModel->countAll(),
            'totalUsers' => $this->userModel->countAll(),
            'todaySales' => $dashboardData['today_sales'],
            'recentSales' => $dashboardData['recent_sales'],
            'topDailyClosings' => $dashboardData['top_daily_closings'],
            'storeStatus' => $dashboardData['store_status'],
            'lastUpdated' => $dashboardData['last_updated'],
        ];
        return view('home/index', $data);
    }

    /**
     * Get real-time dashboard data via AJAX
     */
    public function getRealtimeData()
    {
        $dashboardData = $this->realtimeService->getDashboardData();
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $dashboardData
        ]);
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
