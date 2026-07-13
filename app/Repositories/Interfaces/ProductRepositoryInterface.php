<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Product;

interface ProductRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 12);

    public function getFeatured(int $limit = 8): Collection;

    public function getBestSellers(int $limit = 8): Collection;

    public function getByCategory(string $categorySlug, int $perPage = 12);

    public function findBySlug(string $slug): ?Product;

    public function findById(int $id): ?Product;

    public function getRelated(Product $product, int $limit = 4): Collection;

    public function search(string $query, int $perPage = 12);
}
