<?php

namespace App\Http\Requests\Profile;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\CustomValidationException;
use Auth;

class UpdateAvatarRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'avatar' => [
                'required',
                'image',
                'max:2048',
                'mimes:jpeg,png,jpg,gif,webp',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.required' => 'Avatar harus diisi.',
            'avatar.image' => 'Avatar harus berupa gambar.',
            'avatar.mimes' => 'Avatar harus dalam format jpeg, png, jpg, gif atau webp.',
            'avatar.max' => 'Ukuran avatar tidak boleh melebihi 2MB.',
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
