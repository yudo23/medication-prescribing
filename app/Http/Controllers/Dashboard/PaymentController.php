<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PatientRecordEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Http\Requests\Payment\StoreRequest;
use App\Services\PaymentService;
use App\Services\UserService;
use App\Enums\RoleEnum;
use App\Services\PatientRecordService;
use Barryvdh\DomPDF\Facade\Pdf;
use Log;

class PaymentController extends Controller
{
    protected $route;
    protected $view;
    protected $paymentService;
    protected $userService;
    protected $patientRecordService;

    public function __construct()
    {
        $this->route = "dashboard.payments.";
        $this->view = "dashboard.payments.";
        $this->paymentService = new PaymentService();
        $this->userService = new UserService();
        $this->patientRecordService = new PatientRecordService();
    }

    public function index(Request $request)
    {
        $response = $this->paymentService->index($request);

        $apotekers = $this->userService->index(new Request(["roles" => [RoleEnum::APOTEKER]]),false);
        $apotekers = $apotekers->data;

        $data = [
            'table' => $response->data,
            'apotekers' => $apotekers,
        ];

        return view($this->view . 'index', $data);
    }

    public function create()
    {
        $apotekers = $this->userService->index(new Request(["roles" => [RoleEnum::APOTEKER]]),false);
        $apotekers = $apotekers->data;

        $records = $this->patientRecordService->index(new Request(["status" => PatientRecordEnum::STATUS_UNPAID]),false);
        $records = $records->data;

        $data = [
            'apotekers' => $apotekers,
            'records' => $records,
        ];

        return view($this->view . "create",$data);
    }

    public function show($id)
    {
        $result = $this->paymentService->show($id);
        if (!$result->success) {
            alert()->error('Gagal', $result->message);
            return redirect()->route($this->route . 'index')->withInput();
        }
        $result = $result->data;

        $data = [
            'result' => $result
        ];

        return view($this->view . "show", $data);
    }

    public function store(StoreRequest $request)
    {
        try {
            $response = $this->paymentService->store($request);
            if (!$response->success) {
                return ResponseHelper::apiResponse(false, $response->message , null, null, $response->code);
            }

            return ResponseHelper::apiResponse(true, $response->message , $response->data , null, $response->code);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return ResponseHelper::apiResponse(false, $th->getMessage() , null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $response = $this->paymentService->delete($id);
            if (!$response->success) {
                alert()->error('Gagal', $response->message);
                return redirect()->route($this->route . 'index')->withInput();
            }

            alert()->html('Berhasil', $response->message, 'success');
            return redirect()->route($this->route . 'index');
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            alert()->error('Gagal', $th->getMessage());
            return redirect()->route($this->route . 'index')->withInput();
        }
    }

    public function printReceipt($id)
    {
        $result = $this->paymentService->show($id);
        if (!$result->success) {
            alert()->error('Gagal', $result->message);
            return redirect()->route($this->route . 'index')->withInput();
        }
        $result = $result->data;

        $data = [
            'result' => $result,
        ];

        $pdf = Pdf::loadview($this->view . 'print-receipt', $data)->setPaper('a4', 'potrait');

        return $pdf->stream();
    }
}
