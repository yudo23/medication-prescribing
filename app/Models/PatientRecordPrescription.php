<?php

namespace App\Models;

use App\Enums\PatientRecordEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\FormatDates;
use Auth;

class PatientRecordPrescription extends Model
{
    use HasFactory, SoftDeletes, FormatDates;
    protected $table = "patient_record_prescriptions";
    protected $fillable = [
        'record_id',
        'medicine_id',
        'medicine_name',
        'price',
        'qty',
        'note',
    ];

    public function getPriceAttribute($value){
        return floatval($value);
    }

    public function getQtyAttribute($value){
        return floatval($value);
    }

    public function record()
    {
        return $this->belongsTo(PatientRecord::class, 'record_id', 'id');
    }

    public function total(){
        return floatval($this->qty * $this->price);
    }

}
