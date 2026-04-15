<?php

namespace App\Services;

use App\Services\BaseService;
use App\Http\Requests\Payment\StoreRequest;
use App\Helpers\UploadHelper;
use App\Helpers\LogHelper;
use App\Enums\LogUserEnum;
use App\Enums\PatientRecordEnum;
use App\Models\PatientRecord;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;
use Auth;
use DB;

class PaymentService extends BaseService
{
    protected $payment;
    protected $patientRecord;

    public function __construct()
    {
        $this->payment = new Payment();
        $this->patientRecord = new PatientRecord();
    }

    public function index(Request $request, bool $paginate = true)
    {
        $search = (empty($request->search)) ? null : trim(strip_tags($request->search));
        $from_date = (empty($request->from_date)) ? null : trim(strip_tags($request->from_date));
        $to_date = (empty($request->to_date)) ? null : trim(strip_tags($request->to_date));

        $table = $this->payment;
        if (!empty($search)) {
            $table = $table->where(function ($query2) use ($search) {
                $query2->where('code', 'like', '%' . $search . '%');
                $query2->orWhereHas("record",function($query3) use($search){
                    $query3->where('name', 'like', '%' . $search . '%');
                    $query3->orWhere('nik', 'like', '%' . $search . '%');
                });
            });
        }
        if(!empty($from_date)){
        	$table = $table->whereDate("date",">=",$from_date);
        }
        if(!empty($to_date)){
        	$table = $table->whereDate("date",">=",$to_date);
        }
        $table = $table->with(["record.prescriptions","author","apoteker"]);
        $table = $table->orderBy('date', 'DESC');

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
            $result = $this->payment;
            $result = $result->where("id", $id);
            $result = $result->with(["record.prescriptions","author","apoteker"]);
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
            $date = (empty($request->date)) ? null : trim(strip_tags($request->date));
            $amount = (empty($request->amount)) ? 0 : trim(strip_tags($request->amount));
            $record_id = (empty($request->record_id)) ? null : trim(strip_tags($request->record_id));
            $note = (empty($request->note)) ? null : trim(strip_tags($request->note));
            $apoteker_id = (empty($request->apoteker_id)) ? null : trim(strip_tags($request->apoteker_id));

            $record = $this->patientRecord->findOrFail($record_id);

            if($record->total() != $amount){
                DB::rollBack();
                return $this->response(false, 'Nominal pembayaran tidak sesuai');
            }

            $create = $this->payment->create([
                'date' => $date,
                'amount' => $amount,
                'record_id' => $record_id,
                'note' => $note,
                'apoteker_id' => $apoteker_id,
                'author_id' => Auth::user()->id
            ]);

            $create->update([
              'code' => sprintf("KW%06d", $create->id)  
            ]);

            $create->record->update([
                'status' => PatientRecordEnum::STATUS_PAID
            ]);

            LogHelper::log(
                Payment::class,
                $create->id,
                LogUserEnum::INSERT,
                'Pembayaran tagihan : ' . $create->record->code
            );

            DB::commit();

            return $this->response(true, 'Data berhasil ditambahkan', $create);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::emergency($th->getMessage());

            return $this->response(false, "Internal server error", null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $result = $this->payment->findOrFail($id);

            if(!$result->canDelete()){
                DB::rollBack();
                return $this->response(false, "Status tidak valid");
            }

            $result->record->update([
                'status' => PatientRecordEnum::STATUS_UNPAID
            ]);

            LogHelper::log(
                Payment::class,
                $id,
                LogUserEnum::DELETE,
                'Hapus pembayaran tagihan #' . $result->record->code
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
