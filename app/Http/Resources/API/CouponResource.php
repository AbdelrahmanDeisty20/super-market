<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'type' => $this->type,
            'value' => (float) $this->value,
            'min_order_value' => (float) $this->min_order_value,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'usage_limit' => $this->usage_limit,
            'used_count' => $this->used_count,
            'is_active' => (bool) $this->is_active,
        ];
    }
}