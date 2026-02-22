<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string',
            'fcm_token' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => __('messages.The :attribute field is required'),
            'email' => __('messages.The :attribute must be a valid email address'),
            'exists' => __('messages.Email does not exist'),
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => __('messages.email'),
            'password' => __('messages.password'),
        ];
    }
}
