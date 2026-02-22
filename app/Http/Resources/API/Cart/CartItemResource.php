<?php

namespace App\Http\Resources\API\Cart;

use App\Traits\HasImageUrls;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CartItemResource extends JsonResource
{
    use HasImageUrls;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = $this->product;

        // Get first image or default
        $imagePath = $product->images->first()?->image;
        $imageUrl = $this->getImageUrl($imagePath);

        $currentPrice = $product->discount_price > 0 ? $product->discount_price : $product->price;

        return [
            'id' => $this->id,
            'product' => new \App\Http\Resources\API\ProductListResource($product),
            'discount' => round(($product->price - $currentPrice) * $this->quantity, 2),
            'price' => (float)$currentPrice, // The actual price paid
            'quantity' => (int)$this->quantity,
            'item_total' => round($this->quantity * $currentPrice, 2),
        ];
    }
}
