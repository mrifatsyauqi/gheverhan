<?php

namespace App\Repositories\Interfaces;

use App\Models\Cart;

interface CartRepositoryInterface
{
    public function getOrCreateForUser(int $userId): Cart;

    public function getOrCreateForSession(string $sessionId): Cart;

    public function addItem(Cart $cart, int $productId, ?int $variantId, int $quantity, int $price): void;

    public function updateItemQuantity(int $cartItemId, int $quantity): void;

    public function removeItem(int $cartItemId): void;

    public function clear(Cart $cart): void;

    public function mergeGuestCart(string $sessionId, int $userId): void;

    public function getItemCount(Cart $cart): int;
}
