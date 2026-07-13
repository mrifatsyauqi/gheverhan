<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Order;

interface OrderRepositoryInterface
{
    public function create(array $data): Order;

    public function getByUser(int $userId, int $perPage = 10): LengthAwarePaginator;

    public function findByNumber(string $orderNumber): ?Order;

    public function findById(int $id): ?Order;

    public function updateStatus(Order $order, string $status, ?string $description = null): void;
}
