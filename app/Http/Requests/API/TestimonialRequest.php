<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => __('messages.The :attribute field is required'),
            'integer' => __('messages.The :attribute must be an integer'),
            'min' => __('messages.The :attribute must be at least :min'),
            'max' => __('messages.The :attribute may not be greater than :max'),
        ];
    }

    public function attributes(): array
    {
        return [
            'rating' => __('messages.rating'),
            'comment' => __('messages.comment'),
        ];
    }
}