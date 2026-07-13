<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function getAll(): Collection;

    public function getActive(): Collection;

    public function findBySlug(string $slug): ?Category;

    public function findById(int $id): ?Category;
}
