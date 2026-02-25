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
        $items = $this->items;
        $totalItemsDiscount = $items->sum(function ($item) {
            // Note: $this->product->price is the base price, $this->price is the price stored at order time
            return (float) (($item->product->price - $item->price) * $item->quantity);
        });

        return [
            'id' => $this->id,
            'status' => $this->status,
            'delivery_date' => $this->delivery_date,
            'delivery_time' => $this->delivery_time,
            'items_count' => $this->items_count ?? $items->count(),
            'total_item_discount' => round($totalItemsDiscount, 2),
            'coupon_discount' => (float) $this->discount,
            'subtotal' => (float) $this->subtotal,
            'delivery_fee' => (float) $this->delivery_fee,
            'total' => (float) $this->total,
            'last_lat' => (float) $this->last_lat,
            'last_long' => (float) $this->last_long,
            'address' => new \App\Http\Resources\API\UserAddressResource($this->whenLoaded('address')),
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'created_at' => $this->created_at,
        ];
    }
}
