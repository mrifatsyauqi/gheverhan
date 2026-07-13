<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface WishlistRepositoryInterface
{
    public function toggle(int $userId, int $productId): bool;

    public function getByUser(int $userId): Collection;

    public function isWishlisted(int $userId, int $productId): bool;
}
