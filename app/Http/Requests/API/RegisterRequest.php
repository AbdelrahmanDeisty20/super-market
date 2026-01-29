<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'min:6',
                'confirmed'
            ],
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'phone' => [
                'required',
                'string',
                'max:255',
                'regex:/^\+201[0125][0-9]{8}$/'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            '*required' => __('this field is required'),
            '*email' => __('this field is email'),
            '*unique' => __('this field is already exist'),
            '*min' => __('this field is min'),
            '*confirmed' => __('this field is confirmed'),
            '*string' => __('this field is string'),
            '*max' => __('this field is max'),
            '*regex' => __('must be egyptian number with egyptian key'),
        ];
    }
}
