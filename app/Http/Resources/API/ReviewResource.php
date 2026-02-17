<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user') ?: $this->user),
            'product' => new ProductListResource($this->whenLoaded('product')),
            'comment' => $this->comment,
            'rating' => $this->rating,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
