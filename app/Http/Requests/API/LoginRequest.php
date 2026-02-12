<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => ['required', 'email', 'exists:users,email'],
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => __('messages.The :attribute field is required'),
            'email.email' => __('messages.Email must be a valid email address'),
            'email.exists' => __('messages.Email does not exist'),
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
