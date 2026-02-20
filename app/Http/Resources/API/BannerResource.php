<?php

namespace App\Http\Resources\API;

use App\Traits\HasImageUrls;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    use HasImageUrls;
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->getImageUrl($this->image),
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
        ];
    }
}
