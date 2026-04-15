<?php

namespace App\Http\Requests\Payment;

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

        if(Auth::user()->hasRole([RoleEnum::APOTEKER])){
            $data["apoteker_id"] = Auth::user()->id;
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
            'date' => [
                'required',
                'date_format:Y-m-d'
            ],
            'record_id' => [
                'required',
                Rule::exists("patient_records","id")
            ],
            'amount' => [
                'required',
                'numeric',
                'min:1'
            ],
            'apoteker_id' => [
                'required',
                Rule::exists("users","id")
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'Tanggal wajib diisi',
            'date.date_format' => 'Format tanggal tidak valid',
            'record_id.required' => 'Pemeriksaan wajib diisi',
            'record_id.exists' => 'Pemeriksaan tidak ditemukan',
            'amount.required' => 'Nominal wajib diisi',
            'amount.numeric' => 'Nominal harus berupa angka',
            'amount.min' => 'Nominal minimal 1',
            'apoteker_id.required' => 'Apoteker wajib diisi',
            'apoteker_id.exists' => 'Apoteker tidak ditemukan',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new CustomValidationException($validator);
    }
}
