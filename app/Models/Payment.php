<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\FormatDates;
use Auth;

class Payment extends Model
{
    use HasFactory, SoftDeletes, FormatDates;
    protected $table = "payments";
    protected $fillable = [
        'record_id',
        'code',
        'date',
        'amount',
        'note',
        'apoteker_id',
        'author_id',
    ];

    public function getAmountAttribute($value){
        return floatval($value);
    }

    public function record()
    {
        return $this->belongsTo(PatientRecord::class, 'record_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function apoteker()
    {
        return $this->belongsTo(User::class, 'apoteker_id', 'id');
    }

    public function canDelete(){
        if(Auth::user()->hasRole([RoleEnum::ADMINISTRATOR])){
            return true;
        }
        return false;
    }

    public function canPrintReceipt(){
        if(Auth::user()->hasRole([RoleEnum::ADMINISTRATOR,RoleEnum::APOTEKER])){
            return true;
        }
        return false;
    }

}
