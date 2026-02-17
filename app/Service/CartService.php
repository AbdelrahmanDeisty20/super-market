<?php

namespace App\Service;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CartService
{
    /**
     * Get or create cart for the user.
     */
    public function getCart(User $user)
    {
        return Cart::firstOrCreate(['user_id' => $user->id]);
    }

    /**
     * Add product to cart.
     */
    public function addToCart(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {
            $cart = $this->getCart($user);

            $cartItem = $cart->items()->where('product_id', $data['product_id'])->first();

            if ($cartItem) {
                // Item exists, update quantity
                $cartItem->update([
                    'quantity' => $cartItem->quantity + $data['quantity']
                ]);
            } else {
                // Create new item
                $cart->items()->create([
                    'product_id' => $data['product_id'],
                    'quantity' => $data['quantity']
                ]);
            }

            return $cart->load(['items.product']);
        });
    }

    /**
     * Update cart item quantity.
     */
    public function updateQuantity(User $user, $itemId, $quantity)
    {
        $cart = $this->getCart($user);
        $cartItem = $cart->items()->where('id', $itemId)->firstOrFail();

        $cartItem->update(['quantity' => $quantity]);

        return $cart->load(['items.product']);
    }

    /**
     * Remove item from cart.
     */
    public function removeItem(User $user, $itemId)
    {
        $cart = $this->getCart($user);
        $cartItem = $cart->items()->where('id', $itemId)->firstOrFail();

        $cartItem->delete();

        return $cart->load(['items.product']);
    }

    /**
     * Clear user's cart.
     */
    public function clearCart(User $user)
    {
        $cart = $this->getCart($user);
        $cart->items()->delete();

        return $cart->load(['items.product']);
    }
}