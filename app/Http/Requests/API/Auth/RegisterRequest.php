<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'confirmed',
                \Illuminate\Validation\Rules\Password::min(8)
                    ->letters()
                    ->numbers(),
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^01[0125][0-9]{8}$/',
            ],
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'fcm_token' => 'nullable|string',
            'device_id' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => __('messages.The :attribute field is required'),
            'email' => __('messages.The :attribute must be a valid email address'),
            'unique' => __('messages.The :attribute has already been taken'),
            'confirmed' => __('messages.The :attribute confirmation does not match'),
            'string' => __('messages.The :attribute must be a string'),
            'max' => __('messages.The :attribute may not be greater than :max characters'),
            'min' => __('messages.The :attribute must be at least :min characters'),
            'regex' => __('messages.The :attribute format is invalid'),
            'phone.regex' => __('messages.The phone must be a valid Egyptian number (e.g., 01012345678)'),
            'password.min' => __('messages.The :attribute must be at least 8 characters'),
            'password.letters' => __('messages.The :attribute must contain at least one letter'),
            'password.numbers' => __('messages.The :attribute must contain at least one number'),
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => __('messages.email'),
            'password' => __('messages.password'),
            'name' => __('messages.name'),
            'phone' => __('messages.phone'),
        ];
    }
}
