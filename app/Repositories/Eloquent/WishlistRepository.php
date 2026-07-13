<?php

namespace App\Repositories\Eloquent;

use App\Models\Wishlist;
use App\Repositories\Interfaces\WishlistRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class WishlistRepository implements WishlistRepositoryInterface
{
    public function __construct(
        protected Wishlist $model
    ) {}

    public function toggle(int $userId, int $productId): bool
    {
        $existing = $this->model
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            return false; // Removed from wishlist
        }

        $this->model->create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        return true; // Added to wishlist
    }

    public function getByUser(int $userId): Collection
    {
        return $this->model
            ->with(['product.category'])
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function isWishlisted(int $userId, int $productId): bool
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    }
}
