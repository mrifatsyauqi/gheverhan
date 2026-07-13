<?php

namespace App\Services;

use App\Repositories\Interfaces\WishlistRepositoryInterface;

class WishlistService
{
    public function __construct(
        protected WishlistRepositoryInterface $wishlistRepository
    ) {}

    public function toggle(int $userId, int $productId): bool
    {
        return $this->wishlistRepository->toggle($userId, $productId);
    }

    public function getUserWishlist(int $userId)
    {
        return $this->wishlistRepository->getByUser($userId);
    }

    public function isWishlisted(int $userId, int $productId): bool
    {
        return $this->wishlistRepository->isWishlisted($userId, $productId);
    }
}
