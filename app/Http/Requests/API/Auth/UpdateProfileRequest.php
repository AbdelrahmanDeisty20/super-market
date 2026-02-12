<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'phone' => [
                'nullable',
                'string',
                'regex:/^01[0125][0-9]{8}$/',
            ],
            'password' => [
                'nullable',
                'string',
                'confirmed',
                \Illuminate\Validation\Rules\Password::min(8)
                    ->letters()
                    ->numbers(),
            ],
            'current_password' => 'required_with:password|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => __('messages.The :attribute field is required'),
            'string' => __('messages.The :attribute must be a string'),
            'max' => __('messages.The :attribute may not be greater than :max characters'),
            'min' => __('messages.The :attribute must be at least :min characters'),
            'regex' => __('messages.The :attribute format is invalid'),
            'phone.regex' => __('messages.The phone must be a valid Egyptian number (e.g., 01012345678)'),
            'password.min' => __('messages.The :attribute must be at least 8 characters'),
            'password.letters' => __('messages.The :attribute must contain at least one letter'),
            'password.numbers' => __('messages.The :attribute must contain at least one number'),
            'confirmed' => __('messages.The :attribute confirmation does not match'),
            'required_with' => __('messages.The :attribute field is required when :values is present'),
        ];
    }

    public function attributes(): array
    {
        return [
            'password' => __('messages.password'),
            'name' => __('messages.name'),
            'phone' => __('messages.phone'),
            'current_password' => __('messages.current_password'),
        ];
    }
}
