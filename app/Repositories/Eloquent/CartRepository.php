<?php

namespace App\Repositories\Eloquent;

use App\Models\Cart;
use App\Models\CartItem;
use App\Repositories\Interfaces\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    public function getOrCreateForUser(int $userId): Cart
    {
        return Cart::firstOrCreate(
            ['user_id' => $userId],
            ['user_id' => $userId]
        )->load(['items.product', 'items.variant']);
    }

    public function getOrCreateForSession(string $sessionId): Cart
    {
        return Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['session_id' => $sessionId]
        )->load(['items.product', 'items.variant']);
    }

    public function addItem(Cart $cart, int $productId, ?int $variantId, int $quantity, int $price): void
    {
        $existing = $cart->items()
            ->where('product_id', $productId)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($existing) {
            $existing->update([
                'quantity' => $existing->quantity + $quantity,
                'price' => $price, // Update to latest price
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'product_variant_id' => $variantId,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        }
    }

    public function updateItemQuantity(int $cartItemId, int $quantity): void
    {
        CartItem::where('id', $cartItemId)->update(['quantity' => $quantity]);
    }

    public function removeItem(int $cartItemId): void
    {
        CartItem::destroy($cartItemId);
    }

    public function clear(Cart $cart): void
    {
        $cart->items()->delete();
    }

    public function mergeGuestCart(string $sessionId, int $userId): void
    {
        $guestCart = Cart::where('session_id', $sessionId)->first();
        if (!$guestCart) {
            return;
        }

        $userCart = $this->getOrCreateForUser($userId);

        foreach ($guestCart->items as $item) {
            $this->addItem($userCart, $item->product_id, $item->product_variant_id, $item->quantity, $item->price);
        }

        $guestCart->items()->delete();
        $guestCart->delete();
    }

    public function getItemCount(Cart $cart): int
    {
        return $cart->items()->sum('quantity');
    }
}
