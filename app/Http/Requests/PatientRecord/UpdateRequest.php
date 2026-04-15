<?php

namespace App\Http\Requests\PatientRecord;

use App\Enums\RoleEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\CustomValidationException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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
        ];
    }

    public function messages(): array
    {
        return [
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
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new CustomValidationException($validator);
    }
}
