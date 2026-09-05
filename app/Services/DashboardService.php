<?php

namespace App\Services;

use App\Repositories\DashboardRepository;

class DashboardService
{
    
    public function __construct (private DashboardRepository $dashboardRepository
    )
        
    {

    }

    /**
     * Mendapatkan seluruh statistik dashboard.
     */
public function getStatistics(?int $userId = null, bool $isAdmin = false): array
{
    return [
        'totalVisits' => $this->dashboardRepository
            ->getTotalVisits($userId, $isAdmin),

        'todayVisits' => $this->dashboardRepository
            ->getTodayVisits($userId, $isAdmin),

        'thisMonthVisits' => $this->dashboardRepository
            ->getThisMonthVisits($userId, $isAdmin),

        'lastMonthVisits' => $this->dashboardRepository
            ->getLastMonthVisits($userId, $isAdmin),

        'totalSales' => $this->dashboardRepository
            ->getTotalSales(),

        'totalInstitutions' => $this->dashboardRepository
            ->getTotalInstitutions(),

        'visitResults' => $this->dashboardRepository
            ->getVisitResults($userId, $isAdmin),

        'visitResultSummary' => $this->dashboardRepository
            ->getVisitResultSummary($userId, $isAdmin),

        'visitsBySales' => $this->dashboardRepository
            ->getVisitsBySales($userId, $isAdmin),

        'recentVisits' => $this->dashboardRepository
            ->getRecentVisits($userId, $isAdmin),

        'visitsLast7Days' => $this->dashboardRepository
            ->getVisitsLast7Days($userId, $isAdmin),
    ];
}
}