<?php

namespace App\Services;

use App\Services\BaseService;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Helpers\UploadHelper;
use App\Helpers\LogHelper;
use App\Enums\ImageEnum;
use App\Enums\LogUserEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Auth;
use DB;
use Illuminate\Http\Response;
use Throwable;

class UserService extends BaseService
{
    protected $user;
    protected $userCompany;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index(Request $request, bool $paginate = true)
    {
        $search = (empty($request->search)) ? null : trim(strip_tags($request->search));
        $roles = $request->roles;

        $table = $this->user;
        if (!empty($search)) {
            $table = $table->where(function ($query2) use ($search) {
                $query2->where('name', 'like', '%' . $search . '%');
                $query2->orWhere('email', 'like', '%' . $search . '%');
                $query2->orWhere('username', 'like', '%' . $search . '%');
            });
        }
        if (!empty($company_id)) {
            $table = $table->where("company_id",$company_id);
        }
        if (Auth::check()) {
            if (Auth::user()->hasRole([RoleEnum::ADMINISTRATOR])) {
                $table = $table->withTrashed();
            }
        }
        if (!empty($roles)) {
            $table = $table->role($roles);
        }
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
            $result = $this->user;
            $result = $result->where("id", $id);
            if (Auth::user()->hasRole([RoleEnum::ADMINISTRATOR])) {
                $result = $result->withTrashed();
            }
            $result = $result->first();

            if (!$result) {
                return $this->response(false, "Data tidak ditemukan");
            }

            return $this->response(true, 'Berhasil mendapatkan data', $result);
        } catch (Throwable $th) {
            Log::emergency($th->getMessage());

            return $this->response(false, "Internal server error", null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $name = (empty($request->name)) ? null : trim(strip_tags($request->name));
            $email = (empty($request->email)) ? null : trim(strip_tags($request->email));
            $username = (empty($request->username)) ? null : trim(strip_tags($request->username));
            $password = (empty($request->password)) ? null : trim(strip_tags($request->password));
            $roles = $request->roles;
            $avatar = $request->file("avatar");

            if ($avatar) {
                $upload = UploadHelper::upload_file($avatar, 'users', ImageEnum::EXT);

                if ($upload["IsError"] == TRUE) {
                    return $this->response(false, $upload["Message"]);
                }

                $avatar = $upload["Path"];
            }

            $create = $this->user->create([
                'name' => $name,
                'email' => $email,
                'username' => $username,
                'password' => bcrypt($password),
                'avatar' => $avatar,
            ]);

            $create->assignRole($roles);

            LogHelper::log(
                User::class,
                $create->id,
                LogUserEnum::INSERT,
                'Pengguna baru : ' . $email
            );

            DB::commit();

            return $this->response(true, 'Berhasil menambahkan data', $create);
        } catch (Throwable $th) {
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
            $email = (empty($request->email)) ? null : trim(strip_tags($request->email));
            $username = (empty($request->username)) ? null : trim(strip_tags($request->username));
            $password = (empty($request->password)) ? null : trim(strip_tags($request->password));
            $roles = $request->roles;
            $avatar = $request->file("avatar");

            $result = $this->user;
            $result = $result->findOrFail($id);

            if ($password) {
                $password = bcrypt($password);
            } else {
                $password = $result->password;
            }

            if ($avatar) {
                $upload = UploadHelper::upload_file($avatar, 'users', ImageEnum::EXT);

                if ($upload["IsError"] == TRUE) {
                    return $this->response(false, $upload["Message"]);
                }

                $avatar = $upload["Path"];
            } else {
                $avatar = $result->avatar;
            }

            $result->update([
                'name' => $name,
                'email' => $email,
                'username' => $username,
                'password' => $password,
                'avatar' => $avatar,
            ]);

            $result->syncRoles($roles);

            LogHelper::log(
                User::class,
                $id,
                LogUserEnum::UPDATE,
                "Ubah pengguna : ".$email
            );

            DB::commit();

            return $this->response(true, 'Berhasil mengubah data', $result);
        } catch (Throwable $th) {
            DB::rollback();;
            Log::emergency($th->getMessage());

            return $this->response(false, "Internal server error", null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $result = $this->user->findOrFail($id);

            LogHelper::log(
                User::class,
                $id,
                LogUserEnum::DELETE,
                'Hapus pengguna : ' . $result->email
            );

            $result->delete();

            DB::commit();

            return $this->response(true, 'Berhasil menghapus data');
        } catch (Throwable $th) {
            DB::rollBack();
            Log::emergency($th->getMessage());

            return $this->response(false, "Internal server error", null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();
        try {
            $result = $this->user->withTrashed()->findOrFail($id);

            LogHelper::log(
                User::class,
                $id,
                LogUserEnum::DELETE,
                'Restore pengguna : ' . $result->email
            );

            $result->restore();

            DB::commit();

            return $this->response(true, 'Berhasil mengebalikan data');
        } catch (Throwable $th) {
            DB::rollBack();
            Log::emergency($th->getMessage());

            return $this->response(false, "Internal server error", null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
