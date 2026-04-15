<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                (filter_var($this->username, FILTER_VALIDATE_EMAIL)) ? 'exists:users,email' : 'exists:users,username',
            ],
            'password' => [
                'required',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Username harus diisi',
            'username.exists' => 'Username tidak ditemukan',
            'password.required' => 'Password harus diisi',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        if (!$this->wantsJson()) {
            $errors = implode('<br>', $validator->errors()->all());
            alert()->html('Gagal', $errors, 'error');
            $this->redirect = route('dashboard.auth.login.index');
        }

        parent::failedValidation($validator);
    }
}
