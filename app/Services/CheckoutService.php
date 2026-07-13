<?php

namespace App\Services;

use App\Repositories\Interfaces\AddressRepositoryInterface;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class CheckoutService
{
    public function __construct(
        protected AddressRepositoryInterface $addressRepository,
        protected CartService $cartService,
        protected OrderService $orderService
    ) {}

    public function getCheckoutData(): array
    {
        $cart = $this->cartService->getCart();
        $cart->load(['items.product', 'items.variant']);
        $addresses = $this->addressRepository->getByUser(Auth::id());

        return [
            'cart' => $cart,
            'addresses' => $addresses,
            'shippingMethods' => $this->orderService->getShippingMethods(),
            'paymentMethods' => $this->getPaymentMethods(),
        ];
    }

    public function getPaymentMethods(): array
    {
        return PaymentMethod::active()->orderBy('sort_order')->get()->map(function($method) {
            return [
                'code' => $method->code,
                'name' => $method->name,
                'description' => $method->description ?? $method->instructions,
                'icon' => $method->type == 'bank_transfer' ? 'landmark' : ($method->type == 'cod' ? 'banknote' : 'smartphone'),
                'logo' => $method->logo,
            ];
        })->toArray();
    }

    public function validateCheckoutStep(int $step, array $data): bool
    {
        return match ($step) {
            1 => !empty($data['address_id']),
            2 => !empty($data['shipping_method']),
            3 => !empty($data['payment_method']),
            default => false,
        };
    }
}
