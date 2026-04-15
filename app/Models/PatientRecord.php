<?php

namespace App\Models;

use App\Enums\PatientRecordEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\FormatDates;
use Auth;

class PatientRecord extends Model
{
    use HasFactory, SoftDeletes, FormatDates;
    protected $table = "patient_records";
    protected $fillable = [
        'code',
        'name',
        'nik',
        'gender',
        'date_of_birth',
        'doctor_id',
        'examined_date',
        'height',
        'weight',
        'systole',
        'diastole',
        'heart_rate',
        'respiration_rate',
        'temperature',
        'note',
        'attachment',
        'status'
    ];

    public function getHeightAttribute($value){
        if(isset($value)){
            return floatval($value);
        }

        return null;
    }

    public function getWeightAttribute($value){
        if(isset($value)){
            return floatval($value);
        }

        return null;
    }

    public function getSystoleAttribute($value){
        if(isset($value)){
            return floatval($value);
        }

        return null;
    }

    public function getDiastoleAttribute($value){
        if(isset($value)){
            return floatval($value);
        }

        return null;
    }

    public function getHeartRateAttribute($value){
        if(isset($value)){
            return floatval($value);
        }

        return null;
    }

    public function getRespirationRateAttribute($value){
        if(isset($value)){
            return floatval($value);
        }

        return null;
    }

    public function getTemperatureAttribute($value){
        if(isset($value)){
            return floatval($value);
        }

        return null;
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function prescriptions()
    {
        return $this->hasMany(PatientRecordPrescription::class, 'record_id', 'id');
    }

    public function status(){
        $data = null;

        if($this->status == PatientRecordEnum::STATUS_PAID){
            $data = (object) [
                'class' => 'primary',
                'msg' => 'Sudah Bayar',
            ];
        }
        else{
            $data = (object) [
                'class' => 'warning',
                'msg' => 'Belum Bayar',
            ];
        }
        return $data;
    }

    public function total(){
        $total = 0;

        foreach($this->prescriptions as $p){
            $total += $p->total();
        }

        return round($total);
    }

    public function canUpdate(){
        if(Auth::user()->hasRole([RoleEnum::ADMINISTRATOR])){
            return true;
        }

        if($this->status == PatientRecordEnum::STATUS_UNPAID){
            return true;
        }
        return false;
    }

    public function canDelete(){
        if(Auth::user()->hasRole([RoleEnum::ADMINISTRATOR])){
            return true;
        }
        
        if($this->status == PatientRecordEnum::STATUS_UNPAID){
            return true;
        }
        return false;
    }

    public function canPrintInvoice(){
        if(Auth::user()->hasRole([RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER])){
            return true;
        }
        return false;
    }

}
