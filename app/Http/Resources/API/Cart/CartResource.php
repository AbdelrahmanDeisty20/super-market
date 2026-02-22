<?php

namespace App\Http\Resources\API\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $items = $this->items;
        $subTotal = $items->sum(function ($item) {
            $product = $item->product;
            $currentPrice = $product->discount_price > 0 ? $product->discount_price : $product->price;
            return $item->quantity * $currentPrice;
        });

        $totalDiscount = $items->sum(function ($item) {
            $product = $item->product;
            $discountPerItem = $product->price - ($product->discount_price > 0 ? $product->discount_price : $product->price);
            return $item->quantity * $discountPerItem;
        });

        $deliveryFee = (float) \App\Models\Setting::getValue('min_delivery_fee', 30);

        return [
            'id' => $this->id,
            'items' => CartItemResource::collection($items),
            'count' => $items->count(),
            'total_discount' => round($totalDiscount, 2),
            'sub_total' => round($subTotal, 2),
            'delivery_fee' => $deliveryFee,
            'total' => round($subTotal + $deliveryFee, 2),
        ];
    }
}
