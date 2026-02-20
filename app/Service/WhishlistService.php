<?php

namespace App\Service;

use App\Models\Whishlist;
use App\Models\User;

class WhishlistService
{
    public function getUserWhishlist(User $user)
    {
        return Whishlist::with('product.images')->where('user_id', $user->id)->latest()->paginate(10);
    }

    public function toggleWhishlist(User $user, $productId)
    {
        $item = Whishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($item) {
            $item->delete();
            return ['status' => 'removed'];
        }

        Whishlist::create([
            'user_id' => $user->id,
            'product_id' => $productId,
        ]);

        return ['status' => 'added'];
    }

    public function clearWhishlist(User $user)
    {
        return Whishlist::where('user_id', $user->id)->delete();
    }
}