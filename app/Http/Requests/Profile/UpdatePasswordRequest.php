<?php

namespace App\Http\Requests\Profile;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Exceptions\CustomValidationException;
use Auth;

class UpdatePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password_old' => [
                'required',
            ],
            'password' => [
                'nullable',
                'confirmed',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'password_old.required' => 'Password lama harus diisi',
            'password.required' => 'Password baru harus diisi',
            'password.min' => 'Password minimal :min',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new CustomValidationException($validator);
    }
}
