<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(
        protected Order $model
    ) {}

    public function create(array $data): Order
    {
        return $this->model->create($data);
    }

    public function getByUser(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->with(['items.product'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }

    public function findByNumber(string $orderNumber): ?Order
    {
        return $this->model
            ->with(['items.product', 'items.variant', 'statusHistories', 'address'])
            ->where('order_number', $orderNumber)
            ->first();
    }

    public function findById(int $id): ?Order
    {
        return $this->model
            ->with(['items.product', 'items.variant', 'statusHistories', 'address'])
            ->find($id);
    }

    public function updateStatus(Order $order, string $status, ?string $description = null): void
    {
        $order->update(['status' => $status]);

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'status' => $status,
            'description' => $description,
            'changed_at' => now(),
        ]);

        // Update timestamp fields based on status
        match ($status) {
            'shipped' => $order->update(['shipped_at' => now()]),
            'delivered' => $order->update(['delivered_at' => now()]),
            default => null,
        };
    }
}
