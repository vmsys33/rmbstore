<?php

namespace App\Services;

use App\Models\SaleModel;
use App\Models\DailyClosingModel;

class RealtimeService
{
    private $saleModel;
    private $dailyClosingModel;

    public function __construct()
    {
        $this->saleModel = new SaleModel();
        $this->dailyClosingModel = new DailyClosingModel();
    }

    /**
     * Get current store status
     */
    public function getStoreStatus()
    {
        $today = date('Y-m-d');
        $isClosed = $this->dailyClosingModel->isTodayClosed();
        
        if ($isClosed) {
            $closing = $this->dailyClosingModel->getTodayClosing();
            return [
                'is_open' => false,
                'status' => 'closed',
                'closed_at' => $closing['closed_at'] ?? null,
                'closed_by' => $closing['closed_by'] ?? null,
                'total_sales' => $closing['total_sales'] ?? 0,
                'total_transactions' => $closing['total_transactions'] ?? 0
            ];
        }

        // Check if store should be open (business hours)
        $currentHour = (int)date('H');
        $isBusinessHours = $currentHour >= 8 && $currentHour < 22; // 8 AM to 10 PM

        return [
            'is_open' => $isBusinessHours,
            'status' => $isBusinessHours ? 'open' : 'closed',
            'business_hours' => '8:00 AM - 10:00 PM',
            'current_time' => date('g:i A'),
            'current_date' => date('l, M d, Y')
        ];
    }

    /**
     * Get real-time dashboard data
     */
    public function getDashboardData()
    {
        $storeStatus = $this->getStoreStatus();
        $todaySales = $this->saleModel->getTodaySalesSummary();
        $recentSales = $this->saleModel->getRecentSales(5);
        $topDailyClosings = $this->dailyClosingModel->getTopDailyClosings(3);

        return [
            'store_status' => $storeStatus,
            'today_sales' => $todaySales,
            'recent_sales' => $recentSales,
            'top_daily_closings' => $topDailyClosings,
            'last_updated' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * Check if there are new sales since last check
     */
    public function checkForNewSales($lastCheckTime = null)
    {
        if (!$lastCheckTime) {
            $lastCheckTime = date('Y-m-d H:i:s', strtotime('-1 minute'));
        }

        $newSales = $this->saleModel->where('created_at >', $lastCheckTime)
                                   ->orderBy('created_at', 'DESC')
                                   ->findAll();

        return [
            'has_new_sales' => !empty($newSales),
            'new_sales_count' => count($newSales),
            'new_sales' => $newSales
        ];
    }
}
