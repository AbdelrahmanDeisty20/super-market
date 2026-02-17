<?php

namespace App\Http\Resources\API\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'status' => $this->status,
            'delivery_date' => $this->delivery_date,
            'delivery_time' => $this->delivery_time,
            'subtotal' => $this->subtotal,
            'delivery_fee' => $this->delivery_fee,
            'total' => $this->total,
            'address' => new \App\Http\Resources\API\UserAddressResource($this->whenLoaded('address')),
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'items_count' => $this->items_count ?? $this->items->count(),
            'created_at' => $this->created_at,
        ];
    }
}
