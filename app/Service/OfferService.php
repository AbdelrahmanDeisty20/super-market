<?php

namespace App\Service;

use App\Models\Offer;
use App\Http\Resources\API\OfferResource;

class OfferService
{
    /**
     * Get all active offers.
     *
     * @return array
     */
    public function getOffers()
    {
        $offers = Offer::where('is_active', true)->paginate(10);

        if ($offers->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.No offers found'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.Offers fetched successfully'),
            'data' => $offers
        ];
    }

    /**
     * Get single offer by ID.
     *
     * @param int|string $id
     * @return array
     */
    public function getOfferById($id)
    {
        $offer = Offer::with(['products.unit', 'products.images'])->find($id);

        if (!$offer) {
            return [
                'status' => false,
                'message' => __('messages.Offer not found'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.Offer fetched successfully'),
            'data' => new OfferResource($offer)
        ];
    }
}