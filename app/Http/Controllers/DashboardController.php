<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\DashboardService;

class DashboardController extends Controller
{

    private DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }
 public function index()
    {
        
    $user = auth()->user();
    $statistics = $this
        ->dashboardService
        ->getStatistics(
            $user->id,
            $user->role === 'admin'
        );

    return view(
        'dashboard.index',
        $statistics
    );
    }
}
