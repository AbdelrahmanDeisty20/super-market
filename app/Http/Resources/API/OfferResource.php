<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'title' => $this->title, // Localized title
            'description' => $this->description, // Localized description
            'image' => $this->getImageUrl($this->image),
            'type' => $this->type,
            'value' => (float) $this->value,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];
    }
}