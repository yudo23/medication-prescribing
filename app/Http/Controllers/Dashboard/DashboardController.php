<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Log;

class DashboardController extends Controller
{
    protected $view;
    protected $dashboardService;

    public function __construct()
    {
        $this->view ="dashboard.dashboard";
        $this->dashboardService = new DashboardService();
    }

    public function index(Request $request)
    {

        $chart = $this->dashboardService->chart();
        $chart = $chart->data;

        $summary = $this->dashboardService->summary();
        $summary = $summary->data;

    	$data = [
            'chart' => $chart,
            'summary' => $summary,
    	];

        return view($this->view,$data);
    }
}
