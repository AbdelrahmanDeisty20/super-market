<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ResendEmail extends FormRequest
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
            'email' => 'required|email|exists:users,email',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('messages.The email field is required.'),
            'email.email' => __('messages.The email must be a valid email address.'),
            'email.exists' => __('messages.The selected email is invalid.'),
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => __('messages.email'),
        ];
    }
}
