<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function __construct(
        protected CartRepositoryInterface $cartRepository
    ) {}

    public function getCart(): Cart
    {
        if (Auth::check()) {
            return $this->cartRepository->getOrCreateForUser(Auth::id());
        }

        return $this->cartRepository->getOrCreateForSession(session()->getId());
    }

    public function addItem(int $productId, ?int $variantId, int $quantity = 1): void
    {
        $cart = $this->getCart();
        $product = Product::findOrFail($productId);

        $price = $product->price;

        if ($variantId) {
            $variant = ProductVariant::findOrFail($variantId);
            $price = $product->price + $variant->price_adjustment;

            // Validate stock
            if ($variant->stock < $quantity) {
                throw new \RuntimeException('Stok varian tidak mencukupi.');
            }
        } else {
            if ($product->stock < $quantity) {
                throw new \RuntimeException('Stok produk tidak mencukupi.');
            }
        }

        $this->cartRepository->addItem($cart, $productId, $variantId, $quantity, $price);
    }

    public function updateQuantity(int $cartItemId, int $quantity): void
    {
        if ($quantity < 1) {
            $this->cartRepository->removeItem($cartItemId);
            return;
        }

        $this->cartRepository->updateItemQuantity($cartItemId, $quantity);
    }

    public function removeItem(int $cartItemId): void
    {
        $this->cartRepository->removeItem($cartItemId);
    }

    public function clearCart(): void
    {
        $cart = $this->getCart();
        $this->cartRepository->clear($cart);
    }

    public function getCartCount(): int
    {
        try {
            $cart = $this->getCart();
            return $this->cartRepository->getItemCount($cart);
        } catch (\Exception) {
            return 0;
        }
    }

    public function mergeGuestCartOnLogin(): void
    {
        if (Auth::check()) {
            $sessionId = session()->getId();
            $this->cartRepository->mergeGuestCart($sessionId, Auth::id());
        }
    }
}
