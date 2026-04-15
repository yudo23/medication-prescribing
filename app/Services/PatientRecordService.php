<?php

namespace App\Services;

use App\Services\BaseService;
use App\Http\Requests\PatientRecord\StoreRequest;
use App\Http\Requests\PatientRecord\UpdateRequest;
use App\Helpers\UploadHelper;
use App\Helpers\LogHelper;
use App\Enums\LogUserEnum;
use App\Enums\PatientRecordEnum;
use App\Models\PatientRecord;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;
use Auth;
use DB;

class PatientRecordService extends BaseService
{
    protected $patientRecord;

    public function __construct()
    {
        $this->patientRecord = new PatientRecord();
    }

    public function index(Request $request, bool $paginate = true)
    {
        $search = (empty($request->search)) ? null : trim(strip_tags($request->search));

        $table = $this->patientRecord;
        if (!empty($search)) {
            $table = $table->where(function ($query2) use ($search) {
                $query2->where('name', 'like', '%' . $search . '%');
                $query2->orWhere('nik', 'like', '%' . $search . '%');
            });
        }
        $table = $table->with(["doctor"]);
        $table = $table->orderBy('created_at', 'DESC');

        if ($paginate) {
            $table = $table->paginate(10);
            $table = $table->withQueryString();
        } else {
            $table = $table->get();
        }

        return $this->response(true, 'Berhasil mendapatkan data', $table);
    }

    public function show($id)
    {
        try {
            $result = $this->patientRecord;
            $result = $result->where("id", $id);
            $result = $result->with(["doctor"]);
            $result = $result->first();

            if (!$result) {
                return $this->response(false, "Data tidak ditemukan");
            }

            return $this->response(true, 'Berhasil mendapatkan data', $result);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return $this->response(false, "Internal server error", null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $name = (empty($request->name)) ? null : trim(strip_tags($request->name));
            $nik = (empty($request->nik)) ? null : trim(strip_tags($request->nik));
            $gender = (empty($request->gender)) ? null : trim(strip_tags($request->gender));
            $date_of_birth = (empty($request->date_of_birth)) ? null : trim(strip_tags($request->date_of_birth));
            $doctor_id = (empty($request->doctor_id)) ? null : trim(strip_tags($request->doctor_id));
            $examined_at = (empty($request->examined_at)) ? null : trim(strip_tags($request->examined_at));
            $height = (!isset($request->height)) ? null : trim(strip_tags($request->height));
            $weight = (!isset($request->weight)) ? null : trim(strip_tags($request->weight));
            $systole = (!isset($request->systole)) ? null : trim(strip_tags($request->systole));
            $diastole = (!isset($request->diastole)) ? null : trim(strip_tags($request->diastole));
            $heart_rate = (!isset($request->heart_rate)) ? null : trim(strip_tags($request->heart_rate));
            $respiration_rate = (!isset($request->respiration_rate)) ? null : trim(strip_tags($request->respiration_rate));
            $temperature = (!isset($request->temperature)) ? null : trim(strip_tags($request->temperature));
            $note = (!isset($request->note)) ? null : trim(strip_tags($request->note));
            $attachment = $request->file("attachment");

            if ($attachment) {
                $upload = UploadHelper::upload_file($attachment, 'patient-records');

                if ($upload["IsError"] == TRUE) {
                    return $this->response(false, $upload["Message"]);
                }

                $attachment = $upload["Path"];
            }

            $create = $this->patientRecord->create([
                'name' => $name,
                'nik' => $nik,
                'gender' => $gender,
                'date_of_birth' => $date_of_birth,
                'doctor_id' => $doctor_id,
                'examined_at' => $examined_at,
                'height' => $height,
                'weight' => $weight,
                'systole' => $systole,
                'diastole' => $diastole,
                'heart_rate' => $heart_rate,
                'respiration_rate' => $respiration_rate,
                'temperature' => $temperature,
                'note' => $note,
                'attachment' => $attachment,
                'status' => PatientRecordEnum::STATUS_UNPAID
            ]);

            LogHelper::log(
                PatientRecord::class,
                $create->id,
                LogUserEnum::INSERT,
                'Tambah pemeriksaan pasien : ' . $nik
            );

            DB::commit();

            return $this->response(true, 'Data berhasil ditambahkan', $create);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::emergency($th->getMessage());

            return $this->response(false, "Internal server error", null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $name = (empty($request->name)) ? null : trim(strip_tags($request->name));
            $nik = (empty($request->nik)) ? null : trim(strip_tags($request->nik));
            $gender = (empty($request->gender)) ? null : trim(strip_tags($request->gender));
            $date_of_birth = (empty($request->date_of_birth)) ? null : trim(strip_tags($request->date_of_birth));
            $doctor_id = (empty($request->doctor_id)) ? null : trim(strip_tags($request->doctor_id));
            $examined_at = (empty($request->examined_at)) ? null : trim(strip_tags($request->examined_at));
            $height = (!isset($request->height)) ? null : trim(strip_tags($request->height));
            $weight = (!isset($request->weight)) ? null : trim(strip_tags($request->weight));
            $systole = (!isset($request->systole)) ? null : trim(strip_tags($request->systole));
            $diastole = (!isset($request->diastole)) ? null : trim(strip_tags($request->diastole));
            $heart_rate = (!isset($request->heart_rate)) ? null : trim(strip_tags($request->heart_rate));
            $respiration_rate = (!isset($request->respiration_rate)) ? null : trim(strip_tags($request->respiration_rate));
            $temperature = (!isset($request->temperature)) ? null : trim(strip_tags($request->temperature));
            $note = (!isset($request->note)) ? null : trim(strip_tags($request->note));
            $attachment = $request->file("attachment");

            $result = $this->patientRecord;
            $result = $result->findOrFail($id);

            if ($attachment) {
                $upload = UploadHelper::upload_file($attachment, 'patient-records');

                if ($upload["IsError"] == TRUE) {
                    return $this->response(false, $upload["Message"]);
                }

                $attachment = $upload["Path"];
            } else {
                $attachment = $result->attachment;
            }

            $result->update([
                'name' => $name,
                'nik' => $nik,
                'gender' => $gender,
                'date_of_birth' => $date_of_birth,
                'doctor_id' => $doctor_id,
                'examined_at' => $examined_at,
                'height' => $height,
                'weight' => $weight,
                'systole' => $systole,
                'diastole' => $diastole,
                'heart_rate' => $heart_rate,
                'respiration_rate' => $respiration_rate,
                'temperature' => $temperature,
                'note' => $note,
                'attachment' => $attachment,
            ]);

            LogHelper::log(
                PatientRecord::class,
                $id,
                LogUserEnum::UPDATE,
                "Ubah pemeriksaan pasien : ".$nik
            );

            DB::commit();

            return $this->response(true, 'Data berhasil diperbarui', $result);
        } catch (\Throwable $th) {
            DB::rollback();;
            Log::emergency($th->getMessage());

            return $this->response(false, "Internal server error", null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $result = $this->patientRecord->findOrFail($id);

            LogHelper::log(
                PatientRecord::class,
                $id,
                LogUserEnum::DELETE,
                'Hapus pemeriksaan pasien : ' . $result->nik
            );

            $result->delete();

            DB::commit();

            return $this->response(true, 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::emergency($th->getMessage());

            return $this->response(false, "Internal server error", null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
