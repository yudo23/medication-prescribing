<?php

namespace App\Services;

use App\Services\BaseService;
use App\Helpers\LogHelper;
use App\Models\LogUser;
use App\Enums\LogEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Auth;
use DB;
use Illuminate\Http\Response;
use Throwable;

class LogUserService extends BaseService
{
    protected $logUser;

    public function __construct()
    {
        $this->logUser = new LogUser();
    }

    public function index(Request $request, bool $paginate = true)
    {
        $from_date = (empty($request->from_date)) ? null : trim(strip_tags($request->from_date));
        $to_date = (empty($request->to_date)) ? null : trim(strip_tags($request->to_date));
        $type = (empty($request->type)) ? null : trim(strip_tags($request->type));

        $table = $this->logUser;
        if(!empty($from_date)){
        	$table = $table->whereDate("created_at",">=",$from_date);
        }
        if(!empty($to_date)){
        	$table = $table->whereDate("created_at",">=",$to_date);
        }
        if(!empty($type)){
        	$table = $table->where("type",$type);
        }
        $table = $table->with(["author"]);
        $table = $table->orderBy('created_at', 'DESC');

        if ($paginate) {
            $table = $table->paginate(10);
            $table = $table->withQueryString();
        } else {
            $table = $table->get();
        }

        return $this->response(true, 'Berhasil mendapatkan data', $table);
    }
}
