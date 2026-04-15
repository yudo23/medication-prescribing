<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Log;

class NotificationController extends Controller
{
    protected $view;
    protected $notificationService;

    public function __construct()
    {
        $this->view ="dashboard.notification";
        $this->notificationService = new NotificationService();    
    }

    public function notification()
    {
        $table = $this->notificationService->index();
        if (!$table->success) {
            alert()->error('Gagal', $table->message);
            return redirect()->route('dashboard.index')->withInput();
        }

        $data = [
            'notifications' => $table->data["notifications"],
            'unread' => $table->data["unread"],
        ];

        return view($this->view, $data);
    }

    public function notificationRead($id)
    {
        try {
            $table = $this->notificationService->show($id);
            if (!$table->success) {
                alert()->error('Gagal', $table->message);
                return redirect()->route('dashboard.index')->withInput();
            }
            $table = $table->data;

            return redirect()->to($table["data"]["url"]);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            alert()->error('Gagal', $th->getMessage());
            return redirect()->route('dashboard.index')->withInput();
        }
    }

    public function markAsRead()
    {
        try {
            $table = $this->notificationService->readAll();
            if (!$table->success) {
                alert()->error('Gagal', $table->message);
                return redirect()->route('dashboard.index')->withInput();
            }

            return redirect()->route("dashboard.notification");
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            alert()->error('Gagal', $th->getMessage());
            return redirect()->route('dashboard.index')->withInput();
        }
    }
}
