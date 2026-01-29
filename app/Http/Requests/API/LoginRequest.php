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
            "email"=>['required','email','exists:users,email'],
            "password"=>['required','string','min:6','max:255']
        ];
    }

    public function messages()
    {
        return [
            '*required' => __('this field is required'),
            'email.email' => __('Email must be a valid email address'),
            'email.exists' => __('Email does not exist'),
            '*string' => __('Password must be a string'),
            '*min' => __('Password must be at least :min characters', ['min' => 6]),
            '*max' => __('Password must be at most :max characters', ['max' => 255]),
        ];
    }
}
