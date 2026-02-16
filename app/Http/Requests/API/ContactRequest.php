<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'regex:/^01[0125][0-9]{8}$/',
            ],
            'message' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => __('messages.The :attribute field is required'),
            'string' => __('messages.The :attribute must be a string'),
            'max' => __('messages.The :attribute may not be greater than :max characters'),
            'regex' => __('messages.The :attribute format is invalid'),
            'phone.regex' => __('messages.The phone must be a valid Egyptian number (e.g., 01012345678)'),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('messages.name'),
            'phone' => __('messages.phone'),
            'message' => __('messages.message'),
        ];
    }
}
