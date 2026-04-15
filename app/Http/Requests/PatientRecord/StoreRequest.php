<?php

namespace App\Http\Requests\PatientRecord;

use App\Enums\RoleEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\CustomValidationException;
use Illuminate\Validation\Rule;
use Auth;

class StoreRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $data = [];

        if(Auth::user()->hasRole([RoleEnum::DOKTER])){
            $data["doctor_id"] = Auth::user()->id;
        }

        $this->merge($data);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id' => [
                'required',
                Rule::exists("users","id")
            ],
            'name' => [
                'required',
            ],
            'nik' => [
                'required',
                'numeric',
            ],
            'gender' => [
                'required',
                Rule::in([
                    "L",
                    "P",
                ]),
            ],
            'date_of_birth' => [
                'required',
                'date_format:Y-m-d'
            ],
            'examined_date' => [
                'required',
                'date_format:Y-m-d'
            ],
            'height' => [
                'nullable',
                'numeric',
            ],
            'weight' => [
                'nullable',
                'numeric',
            ],
            'systole' => [
                'nullable',
                'numeric',
            ],
            'diastole' => [
                'nullable',
                'numeric',
            ],
            'heart_rate' => [
                'nullable',
                'numeric',
            ],
            'respiration_rate' => [
                'nullable',
                'numeric',
            ],
            'temperature' => [
                'nullable',
                'numeric',
            ],
            'attachment' => [
                'nullable',
                'file',
                'max:2048',
            ],
            'repeater' => [
                'required',
                'array',
            ],
            'repeater.*.medicine_name' => [
                'required',
            ],
            'repeater.*.medicine_id' => [
                'required',
            ],
            'repeater.*.price' => [
                'required',
                'numeric',
            ],
            'repeater.*.qty' => [
                'required',
                'numeric',
                'min:1',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Dokter wajib diisi',
            'doctor_id.exists' => 'Dokter tidak ditemukan',
            'name.required' => 'Nama pasien wajib diisi',
            'nik.required' => 'NIK pasien wajib diisi',
            'nik.numeric' => 'NIK pasien harus berupa angka',
            'gender.required' => 'Jenis kelamin wajib diisi',
            'gender.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan)',
            'date_of_birth.required' => 'Tanggal lahir wajib diisi',
            'date_of_birth.date_format' => 'Format tanggal lahir harus YYYY-MM-DD',
            'examined_date.required' => 'Tanggal pemeriksaan wajib diisi',
            'examined_date.date_format' => 'Format tanggal pemeriksaan harus YYYY-MM-DD',
            'height.numeric' => 'Tinggi badan harus berupa angka',
            'weight.numeric' => 'Berat badan harus berupa angka',
            'systole.numeric' => 'Systole harus berupa angka',
            'diastole.numeric' => 'Diastole harus berupa angka',
            'heart_rate.numeric' => 'Heart rate harus berupa angka',
            'respiration_rate.numeric' => 'Respiration rate harus berupa angka',
            'temperature.numeric' => 'Suhu tubuh harus berupa angka',
            'attachment.file' => 'File lampiran harus berupa file yang valid',
            'attachment.max' => 'Ukuran file maksimal 2MB',
            'repeater.required' => 'Obat wajib diisi minimal 1 item',
            'repeater.array' => 'Data obat tidak valid',
            'repeater.*.medicine_name.required' => 'Obat wajib dipilih',
            'repeater.*.medicine_id.required' => 'Obat wajib dipilih',
            'repeater.*.price.required' => 'Harga obat wajib diisi',
            'repeater.*.price.numeric' => 'Harga obat harus berupa angka',
            'repeater.*.qty.required' => 'Qty wajib diisi',
            'repeater.*.qty.numeric' => 'Qty harus berupa angka',
            'repeater.*.qty.min' => 'Qty minimal 1',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new CustomValidationException($validator);
    }
}
