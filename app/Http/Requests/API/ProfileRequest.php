<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'min:3', 'max:255'],
            'email' => ['nullable', 'email', 'unique:users,email,' . auth()->id()],
            'password' => ['nullable', 'string', 'min:6', 'max:255'],
            'phone' => ['nullable', 'string', 'regex:/^(\+20|0020|20)1[0125][0-9]{8}$/']
        ];
    }

    public function messages()
    {
        return [
            'name.string' => __('messages.Name must be a string'),
            'name.min' => __('messages.Name must be at least :min characters', ['min' => 3]),
            'name.max' => __('messages.Name must be at most :max characters', ['max' => 255]),
            'email.email' => __('messages.Email must be a valid email address'),
            'password.string' => __('messages.Password must be a string'),
            'password.min' => __('messages.Password must be at least :min characters', ['min' => 6]),
            'password.max' => __('messages.Password must be at most :max characters', ['max' => 255]),
            'phone.string' => __('messages.Phone must be a string'),
            'phone.regex' => __('messages.Phone must be a valid Egyptian number with country code (e.g., +2010..., 002010..., or 2010...)'),
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
