<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingMethod;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        protected OrderRepositoryInterface $orderRepository,
        protected CartService $cartService
    ) {}

    public function placeOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $cart = $this->cartService->getCart();
            $cart->load(['items.product', 'items.variant']);

            if ($cart->items->isEmpty()) {
                throw new \RuntimeException('Keranjang belanja kosong.');
            }

            // Calculate totals
            $subtotal = $cart->items->sum(fn ($item) => $item->price * $item->quantity);
            $shippingCost = $this->calculateShipping($data['shipping_method'] ?? 'jne');

            $order = $this->orderRepository->create([
                'user_id' => $data['user_id'],
                'address_id' => $data['address_id'],
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount' => 0,
                'total' => $subtotal + $shippingCost,
                'shipping_method' => $data['shipping_method'] ?? null,
                'payment_method' => $data['payment_method'] ?? null,
                'payment_status' => 'unpaid',
                'notes' => $data['notes'] ?? null,
                'shipping_address_snapshot' => $data['address_snapshot'] ?? null,
            ]);

            // Create order items from cart
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_variant_id' => $cartItem->product_variant_id,
                    'product_name' => $cartItem->product->name,
                    'variant_name' => $cartItem->variant?->name,
                    'product_image' => $cartItem->product->primary_image,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'subtotal' => $cartItem->price * $cartItem->quantity,
                ]);

                // Decrease stock with lockForUpdate
                if ($cartItem->variant) {
                    $variant = \App\Models\ProductVariant::where('id', $cartItem->product_variant_id)->lockForUpdate()->first();
                    if (!$variant || $variant->stock < $cartItem->quantity) {
                        throw new \RuntimeException("Stok varian {$cartItem->variant_name} tidak mencukupi.");
                    }
                    $variant->decrement('stock', $cartItem->quantity);
                } else {
                    $product = \App\Models\Product::where('id', $cartItem->product_id)->lockForUpdate()->first();
                    if (!$product || $product->stock < $cartItem->quantity) {
                        throw new \RuntimeException("Stok produk {$cartItem->product_name} tidak mencukupi.");
                    }
                    $product->decrement('stock', $cartItem->quantity);
                }
            }

            // Record initial status history
            $this->orderRepository->updateStatus($order, 'pending', 'Pesanan berhasil dibuat');

            // Clear cart
            $this->cartService->clearCart();

            return $order->fresh(['items', 'statusHistories']);
        });
    }

    public function getOrdersByUser(int $userId, int $perPage = 10)
    {
        return $this->orderRepository->getByUser($userId, $perPage);
    }

    public function getOrderDetail(string $orderNumber): ?Order
    {
        return $this->orderRepository->findByNumber($orderNumber);
    }

    public function calculateShipping(string $methodCode): int
    {
        $method = ShippingMethod::active()->where('code', $methodCode)->first();
        return $method ? $method->base_cost : 15000;
    }

    public function getShippingMethods(): array
    {
        return ShippingMethod::active()->orderBy('sort_order')->get()->map(function($method) {
            return [
                'code' => $method->code,
                'name' => $method->name,
                'description' => 'Estimasi ' . ($method->estimated_days ?? '-'),
                'cost' => $method->base_cost,
                'formatted_cost' => $method->formatted_cost,
            ];
        })->toArray();
    }
}
