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
use App\Models\PatientRecordPrescription;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;
use Auth;
use DB;

class PatientRecordService extends BaseService
{
    protected $patientRecord;
    protected $patientRecordPrescription;

    public function __construct()
    {
        $this->patientRecord = new PatientRecord();
        $this->patientRecordPrescription = new PatientRecordPrescription();
    }

    public function index(Request $request, bool $paginate = true)
    {
        $search = (empty($request->search)) ? null : trim(strip_tags($request->search));
        $from_date = (empty($request->from_date)) ? null : trim(strip_tags($request->from_date));
        $to_date = (empty($request->to_date)) ? null : trim(strip_tags($request->to_date));
        $status = (!isset($request->status)) ? null : trim(strip_tags($request->status));

        $table = $this->patientRecord;
        if (!empty($search)) {
            $table = $table->where(function ($query2) use ($search) {
                $query2->where('name', 'like', '%' . $search . '%');
                $query2->orWhere('code', 'like', '%' . $search . '%');
                $query2->orWhere('nik', 'like', '%' . $search . '%');
            });
        }
        if(!empty($from_date)){
        	$table = $table->whereDate("examined_date",">=",$from_date);
        }
        if(!empty($to_date)){
        	$table = $table->whereDate("examined_date",">=",$to_date);
        }
        if(isset($status)){
            $table = $table->where("status",$status);
        }
        $table = $table->with(["doctor","prescriptions"]);
        $table = $table->orderBy('examined_date', 'DESC');

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
            $result = $result->with(["doctor","prescriptions"]);
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
            $examined_date = (empty($request->examined_date)) ? null : trim(strip_tags($request->examined_date));
            $height = (!isset($request->height)) ? null : trim(strip_tags($request->height));
            $weight = (!isset($request->weight)) ? null : trim(strip_tags($request->weight));
            $systole = (!isset($request->systole)) ? null : trim(strip_tags($request->systole));
            $diastole = (!isset($request->diastole)) ? null : trim(strip_tags($request->diastole));
            $heart_rate = (!isset($request->heart_rate)) ? null : trim(strip_tags($request->heart_rate));
            $respiration_rate = (!isset($request->respiration_rate)) ? null : trim(strip_tags($request->respiration_rate));
            $temperature = (!isset($request->temperature)) ? null : trim(strip_tags($request->temperature));
            $note = (!isset($request->note)) ? null : trim(strip_tags($request->note));
            $attachment = $request->file("attachment");
            $repeater = $request->repeater;

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
                'examined_date' => $examined_date,
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

            $create->update([
              'code' => sprintf("INV%06d", $create->id)  
            ]);

            foreach($repeater as $row){
                $this->patientRecordPrescription->create([
                    "record_id" => $create->id,
                    "medicine_id" => $row["medicine_id"] ?? null,
                    "medicine_name" => $row["medicine_name"] ?? 0,
                    "price" => $row["price"] ?? 0,
                    "qty" => $row["qty"] ?? 0,
                    "note" => $row["note"] ?? null,
                ]);
            }

            LogHelper::log(
                PatientRecord::class,
                $create->id,
                LogUserEnum::INSERT,
                'Tambah pemeriksaan #' . $create->code
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
            $examined_date = (empty($request->examined_date)) ? null : trim(strip_tags($request->examined_date));
            $height = (!isset($request->height)) ? null : trim(strip_tags($request->height));
            $weight = (!isset($request->weight)) ? null : trim(strip_tags($request->weight));
            $systole = (!isset($request->systole)) ? null : trim(strip_tags($request->systole));
            $diastole = (!isset($request->diastole)) ? null : trim(strip_tags($request->diastole));
            $heart_rate = (!isset($request->heart_rate)) ? null : trim(strip_tags($request->heart_rate));
            $respiration_rate = (!isset($request->respiration_rate)) ? null : trim(strip_tags($request->respiration_rate));
            $temperature = (!isset($request->temperature)) ? null : trim(strip_tags($request->temperature));
            $note = (!isset($request->note)) ? null : trim(strip_tags($request->note));
            $attachment = $request->file("attachment");
            $repeater = $request->repeater;

            $result = $this->patientRecord;
            $result = $result->findOrFail($id);

            if(!$result->canUpdate()){
                return $this->response(false, "Status tidak valid");
            }

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
                'examined_date' => $examined_date,
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

            $deletPrescriptions = $this->patientRecordPrescription->where("record_id",$id);
            $deletPrescriptions = $deletPrescriptions->delete();

            foreach($repeater as $row){
                $this->patientRecordPrescription->create([
                    "record_id" => $id,
                    "medicine_id" => $row["medicine_id"] ?? null,
                    "medicine_name" => $row["medicine_name"] ?? 0,
                    "price" => $row["price"] ?? 0,
                    "qty" => $row["qty"] ?? 0,
                    "note" => $row["note"] ?? null,
                ]);
            }

            LogHelper::log(
                PatientRecord::class,
                $id,
                LogUserEnum::UPDATE,
                "Ubah pemeriksaan #".$result->code
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

            if(!$result->canDelete()){
                return $this->response(false, "Status tidak valid");
            }

            LogHelper::log(
                PatientRecord::class,
                $id,
                LogUserEnum::DELETE,
                'Hapus pemeriksaan #' . $result->code
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
