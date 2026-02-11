<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Traits\HasImageUrls;

class BrandResource extends JsonResource
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
            'name' => $this->name, // Using the localized name from HasTranslations trait
            'image' => $this->getImageUrl($this->image),
        ];
    }
}
