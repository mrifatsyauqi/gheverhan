<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        protected Product $model
    ) {}

    public function getAll(array $filters = [], int $perPage = 12)
    {
        $query = $this->model->with(['category', 'variants'])
            ->active();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('category', fn ($cq) => $cq->where('name', 'LIKE', "%{$search}%"));
            });
        }

        if (!empty($filters['category_slug'])) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $filters['category_slug']));
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        if (!empty($filters['sort'])) {
            match ($filters['sort']) {
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'newest' => $query->latest(),
                'rating' => $query->orderBy('rating', 'desc'),
                default => $query->latest(),
            };
        } else {
            $query->latest();
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function getFeatured(int $limit = 8): Collection
    {
        return $this->model->with(['category'])
            ->featured()
            ->limit($limit)
            ->get();
    }

    public function getBestSellers(int $limit = 8): Collection
    {
        return $this->model->with(['category'])
            ->active()
            ->orderBy('rating', 'desc')
            ->orderBy('rating_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getByCategory(string $categorySlug, int $perPage = 12)
    {
        return $this->model->with(['category', 'variants'])
            ->active()
            ->whereHas('category', fn ($q) => $q->where('slug', $categorySlug))
            ->latest()
            ->paginate($perPage);
    }

    public function findBySlug(string $slug): ?Product
    {
        return $this->model->with(['category', 'variants' => fn ($q) => $q->where('is_active', true)])
            ->where('slug', $slug)
            ->first();
    }

    public function findById(int $id): ?Product
    {
        return $this->model->with(['category', 'variants'])->find($id);
    }

    public function getRelated(Product $product, int $limit = 4): Collection
    {
        return $this->model->with(['category'])
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function search(string $query, int $perPage = 12)
    {
        return $this->model->with(['category'])
            ->active()
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhereHas('category', fn ($cq) => $cq->where('name', 'LIKE', "%{$query}%"));
            })
            ->latest()
            ->paginate($perPage);
    }
}
