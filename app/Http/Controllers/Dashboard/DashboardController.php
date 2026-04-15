<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;

class DashboardController extends Controller
{
    protected $view;

    public function __construct()
    {
        $this->view ="dashboard.dashboard";
    }

    public function index(Request $request)
    {

    	$data = [
    	];

        return view($this->view,$data);
    }
}
