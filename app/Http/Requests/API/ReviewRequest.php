<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => __('messages.The :attribute field is required'),
            'exists' => __('messages.The selected :attribute is invalid'),
            'integer' => __('messages.The :attribute must be an integer'),
            'min' => __('messages.The :attribute must be at least :min'),
            'max' => __('messages.The :attribute may not be greater than :max'),
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => __('messages.product'),
            'rating' => __('messages.rating'),
            'comment' => __('messages.comment'),
        ];
    }
}
