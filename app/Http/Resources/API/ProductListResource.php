<?php

namespace App\Http\Resources\API;

use App\Models\Whishlist;
use App\Traits\HasImageUrls;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    use HasImageUrls;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {


        return [
            'id' => $this->id,
            'name' => $this->name, // Using localized name from HasTranslations trait
            'description' => $this->description, // Using localized description from HasTranslations trait
            'is_favourite' => $this->when(auth('sanctum')->check(), function () {
                return Whishlist::where('user_id', auth('sanctum')->id())
                    ->where('product_id', $this->id)
                    ->exists();
            }),
            'price' => (float) $this->price,
            'discount_price' => (float) $this->discount_price,
            'stock' => (int) $this->stock,
            'offers' => OfferResource::collection($this->whenLoaded('offers')),
            'unit' => new UnitResource($this->whenLoaded('unit')),
            // Main image if exists in the product table (assuming an 'image' column based on Service index)
            // or we use the first image from the images relationship
            "image" => $this->whenLoaded("images", function () {
                $images = $this->images->first();
                return $this->getImageUrl($images->image) ?? '';
            }),
        ];
    }
}
