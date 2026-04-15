<?php

namespace App\Services\Auth;

use App\Services\BaseService;
use Illuminate\Http\Request;
use App\Enums\RoleEnum;
use App\Enums\LogUserEnum;
use App\Helpers\LogHelper;
use App\Http\Requests\Auth\LoginRequest;
use Auth;
use Log;
use DB;
/**
 * Class LoginService.
 */
class LoginService extends BaseService
{

    public function login(LoginRequest $request)
    {
        DB::beginTransaction();
        try {
            $username = (empty($request->username)) ? null : trim(strip_tags($request->username));
            $password = (empty($request->password)) ? null : trim(strip_tags($request->password));
            $rememberme = (empty($request->rememberme)) ? false : true;

            $type = (filter_var($username, FILTER_VALIDATE_EMAIL)) ? "email" : "username";

            $field = [
                $type => $username,
                'password' => $password,
            ];

            if (!Auth::attempt($field, $rememberme)) {
                return $this->response(false, "Username / password tidak sesuai");
                if (!Auth::user()->hasRole([
                    RoleEnum::ADMINISTRATOR,
                    RoleEnum::DOKTER,
                    RoleEnum::APOTEKER,
                ])) {
                    Auth::logout();
                    return $this->response(true, "Anda tidak diperbolehkan mengakses halaman ini");
                }
            }

            LogHelper::log(
                User::class,
                Auth::id(),
                LogUserEnum::LOGIN,
                'Login : ' . Auth::user()->email
            );

            DB::commit();

            return $this->response(true, "Login berhasil");
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::emergency($th->getMessage());

            return $this->response(false, "Terjadi kesalahan saat memproses data");
        }
    }
}
