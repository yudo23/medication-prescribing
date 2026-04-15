<?php

namespace App\Services;

use App\Services\BaseService;
use App\Helpers\UploadHelper;
use App\Enums\ImageEnum;
use App\Http\Requests\Profile\UpdateAvatarRequest;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateRequest;
use Auth;
use Illuminate\Http\Response;
use Log;

class ProfileService extends BaseService
{

    public function index()
    {
        try {
            $result = Auth::user();

            return $this->response(true, 'Data berhasil didapatkan', $result);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return $this->response(false, "Internal server error",null,Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateRequest $request)
    {
        try {
            $result = Auth::user();

            $name = (empty($request->name)) ? null : trim(strip_tags($request->name));
            $username = (empty($request->username)) ? null : trim(strip_tags($request->username));
            $email = (empty($request->email)) ? null : trim(strip_tags($request->email));

            $result->update([
                'name' => $name,
                'username' => $username,
                'email' => $email,
            ]);

            return $this->response(true, "Berhasil mengubah profile");
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());
            return $this->response(false, "Internal server error", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateAvatar(UpdateAvatarRequest $request)
    {
        try {
            $result = Auth::user();
            $avatar = $request->file("avatar");

            if ($avatar) {
                $upload = UploadHelper::upload_file($avatar, 'users', ImageEnum::EXT, 2097152, true, true, 500, null, true);

                if ($upload["IsError"] == TRUE) {
                    return $this->response(false, $upload["Message"]);
                }

                $avatar = $upload["Path"];
            }

            $result->update([
                'avatar' => $avatar,
            ]);

            return $this->response(true, "Berhasil mengubah foto profil" , $result);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());
            return $this->response(false, "Internal server error", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $result = Auth::user();

            $password_old = (empty($request->password_old)) ? null : trim(strip_tags($request->password_old));
            $password = (empty($request->password)) ? null : trim(strip_tags($request->password));

            if (!password_verify($password_old, $result->password)) {
                return $this->response(false,"Password lama tidak sesuai",null);
            }

            $result->update([
                'password' => bcrypt($password),
            ]);

            return $this->response(true, "Password berhasil diubah");
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());
            return $this->response(false, "Internal server error", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
