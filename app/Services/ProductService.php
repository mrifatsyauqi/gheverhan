<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {}

    public function getHomePageProducts(): array
    {
        return [
            'featured' => $this->productRepository->getFeatured(8),
            'bestSellers' => $this->productRepository->getBestSellers(8),
        ];
    }

    public function getProductsWithFilters(array $filters = [], int $perPage = 12)
    {
        return $this->productRepository->getAll($filters, $perPage);
    }

    public function getProductBySlug(string $slug): ?Product
    {
        return $this->productRepository->findBySlug($slug);
    }

    public function getProductsByCategory(string $categorySlug, int $perPage = 12)
    {
        return $this->productRepository->getByCategory($categorySlug, $perPage);
    }

    public function getRelatedProducts(Product $product, int $limit = 4): Collection
    {
        return $this->productRepository->getRelated($product, $limit);
    }

    public function searchProducts(string $query, int $perPage = 12)
    {
        return $this->productRepository->search($query, $perPage);
    }
}
