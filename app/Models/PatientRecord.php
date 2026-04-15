<?php

namespace App\Models;

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
        'name',
        'nik',
        'gender',
        'date_of_birth',
        'doctor_id',
        'examined_at',
        'height',
        'weight',
        'sytole',
        'diastole',
        'heart_rate',
        'respiration_rate',
        'temperature',
        'note',
        'attachment'
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

}
