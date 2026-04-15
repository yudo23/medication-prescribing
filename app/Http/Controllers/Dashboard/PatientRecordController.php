<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Http\Requests\PatientRecord\StoreRequest;
use App\Http\Requests\PatientRecord\UpdateRequest;
use App\Services\PatientRecordService;
use App\Services\UserService;
use App\Enums\RoleEnum;
use Log;

class PatientRecordController extends Controller
{
    protected $route;
    protected $view;
    protected $patientRecordService;
    protected $userService;

    public function __construct()
    {
        $this->route = "dashboard.patient-records.";
        $this->view = "dashboard.patient-records.";
        $this->patientRecordService = new PatientRecordService();
        $this->userService = new UserService();
    }

    public function index(Request $request)
    {
        $response = $this->patientRecordService->index($request);

        $doctors = $this->userService->index(new Request(["roles" => [RoleEnum::DOKTER]]),false);
        $doctors = $doctors->data;

        $data = [
            'table' => $response->data,
            'doctors' => $doctors,
        ];

        return view($this->view . 'index', $data);
    }

    public function create()
    {
        $doctors = $this->userService->index(new Request(["roles" => [RoleEnum::DOKTER]]),false);
        $doctors = $doctors->data;

        $data = [
            'doctors' => $doctors
        ];

        return view($this->view . "create",$data);
    }

    public function show($id)
    {
        $result = $this->patientRecordService->show($id);
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

    public function edit($id)
    {
        $result = $this->patientRecordService->show($id);
        if (!$result->success) {
            alert()->error('Gagal', $result->message);
            return redirect()->route($this->route . 'index')->withInput();
        }
        $result = $result->data;

        $doctors = $this->userService->index(new Request(["roles" => [RoleEnum::DOKTER]]),false);
        $doctors = $doctors->data;

        $data = [
            'result' => $result,
            'doctors' => $doctors
        ];

        return view($this->view . "edit", $data);
    }

    public function store(StoreRequest $request)
    {
        try {
            $response = $this->patientRecordService->store($request);
            if (!$response->success) {
                return ResponseHelper::apiResponse(false, $response->message , null, null, $response->code);
            }

            return ResponseHelper::apiResponse(true, $response->message , $response->data , null, $response->code);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return ResponseHelper::apiResponse(false, $th->getMessage() , null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $response = $this->patientRecordService->update($request, $id);
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
            $response = $this->patientRecordService->delete($id);
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
}
