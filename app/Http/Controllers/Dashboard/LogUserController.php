<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Services\LogUserService;
use Log;
use Auth;

class LogUserController extends Controller
{
    protected $route;
    protected $view;
    protected $logUserService;

    public function __construct()
    {
        $this->route = "dashboard.log-users.";
        $this->view = "dashboard.log-users.";
        $this->logUserService = new LogUserService();
    }

    public function index(Request $request)
    {
        $response = $this->logUserService->index($request);

        $data = [
            'table' => $response->data,
        ];

        return view($this->view . 'index', $data);
    }
}
