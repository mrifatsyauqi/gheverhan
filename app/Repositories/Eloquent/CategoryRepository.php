<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(
        protected Category $model
    ) {}

    public function getAll(): Collection
    {
        return $this->model->ordered()->get();
    }

    public function getActive(): Collection
    {
        return $this->model->active()->ordered()->get();
    }

    public function findBySlug(string $slug): ?Category
    {
        return $this->model->with(['activeProducts' => fn ($q) => $q->latest()->limit(8)])
            ->where('slug', $slug)
            ->first();
    }

    public function findById(int $id): ?Category
    {
        return $this->model->find($id);
    }
}
