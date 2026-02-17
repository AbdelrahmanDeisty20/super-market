<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class WhishlistRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => __('messages.The :attribute field is required'),
            'exists' => __('messages.The selected :attribute is invalid'),
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => __('messages.product'),
        ];
    }
}
