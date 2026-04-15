<?php

namespace App\Models;

use App\Enums\LogUserEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\FormatDates;
use Auth;

class LogUser extends Model
{
    use HasFactory, SoftDeletes, FormatDates;
    protected $table = "log_users";
    protected $fillable = [
        'author_id',
        'reference_id',
        'model',
        'type',
        'note',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function reference()
	{
	    if (!$this->model || !$this->reference_id) {
	        return null;
	    }

	    $modelClass = $this->model;

	    if (!class_exists($modelClass)) {
	        return null;
	    }

	    return $modelClass::find($this->reference_id);
	}

	public function type()
    {
        $return = null;

        if($this->type == LogUserEnum::LOGIN){
            $return = (object) [
                'class' => 'warning',
                'msg' => 'Login',
            ];
        }
        else if($this->type == LogUserEnum::INSERT){
            $return = (object) [
                'class' => 'primary',
                'msg' => 'Insert',
            ];
        }
        else if($this->type == LogUserEnum::UPDATE){
            $return = (object) [
                'class' => 'info',
                'msg' => 'Update',
            ];
        }
        else if($this->type == LogUserEnum::DELETE){
            $return = (object) [
                'class' => 'danger',
                'msg' => 'Delete',
            ];
        }        else{
            $return = (object) [
                'class' => 'danger',
                'msg' => 'Unknown',
            ];
        }

        return $return;
    }

}
