<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Http;
use Log;

class MedicineController extends Controller
{
    public function index()
    {
        try {
            $token = $this->getToken();

            if(!$token){
                return ResponseHelper::apiResponse(false, "Gagal mendapatkan token auth");
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$token
            ])->get('https://recruitment.rsdeltasurya.com/api/v1/medicines');

            if ($response->failed()) {
                return ResponseHelper::apiResponse(false,"Gagal mengambil data obat",null,null,$response->status()
                );
            }

            return ResponseHelper::apiResponse(true, "Berhasil mendapatkan data obat" , $response->json()["medicines"] ?? [] , null, Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return ResponseHelper::apiResponse(false, $th->getMessage() , null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function price($id, Request $request)
    {
        try {
            $date = $request->examined_date;

            if (!$date) {
                return ResponseHelper::apiResponse(false, "Tanggal wajib diisi", null);
            }

            $token = $this->getToken();

            if (!$token) {
                return ResponseHelper::apiResponse(false, "Gagal mendapatkan token");
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get("http://recruitment.rsdeltasurya.com/api/v1/medicines/{$id}/prices");

            if ($response->failed()) {
                return ResponseHelper::apiResponse(false, "Gagal ambil harga", null);
            }

            $prices = $response->json()['prices'] ?? [];

            $selectedPrice = null;

            foreach ($prices as $item) {
                $start = $item['start_date']['value'] ?? null;
                $end   = $item['end_date']['value'] ?? null;

                if ($start && $date >= $start) {
                    if (!$end || $date <= $end) {
                        $selectedPrice = $item['unit_price'];
                    }
                }
            }

            return ResponseHelper::apiResponse(true, "Berhasil mendapatkan harga obat", $selectedPrice ?? 0);

        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return ResponseHelper::apiResponse(false, $th->getMessage() , null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function getToken()
    {
        try {
            $response = Http::post('https://recruitment.rsdeltasurya.com/api/v1/auth', [
                'email' => 'yudo.dendy23@gmail.com',
                'password' => '089506383344'
            ]);

            if ($response->failed()) {
                return null;
            }

            return $response->json()['access_token'] ?? null;

        } catch (\Throwable $th) {
            Log::emergency('Error getToken: '.$th->getMessage());
            return null;
        }
    }
}
