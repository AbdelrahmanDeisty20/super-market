<?php

namespace App\Http\Resources\API\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'product' => new \App\Http\Resources\API\ProductResource($this->product),
            'quantity' => $this->quantity,
            'price' => $this->price,
            'item_total' => round($this->price * $this->quantity, 2),
        ];
    }
}
