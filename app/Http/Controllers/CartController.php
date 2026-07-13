<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function index()
    {
        $cart = $this->cartService->getCart();
        $cart->load(['items.product', 'items.variant']);

        return view('cart.index', [
            'cart' => $cart,
        ]);
    }

    public function addItem(AddToCartRequest $request)
    {
        try {
            $this->cartService->addItem(
                $request->validated('product_id'),
                $request->validated('variant_id'),
                $request->validated('quantity', 1)
            );

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk ditambahkan ke keranjang!',
                    'cartCount' => $this->cartService->getCartCount(),
                ]);
            }

            return back()->with('success', 'Produk ditambahkan ke keranjang!');
        } catch (\RuntimeException $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateItem(Request $request, int $itemId)
    {
        $request->validate(['quantity' => 'required|integer|min:0|max:10']);

        $this->cartService->updateQuantity($itemId, $request->quantity);

        if ($request->wantsJson()) {
            $cart = $this->cartService->getCart();
            $cart->load(['items.product', 'items.variant']);
            return response()->json([
                'success' => true,
                'cartCount' => $this->cartService->getCartCount(),
                'cartTotal' => 'Rp ' . number_format($cart->total, 0, ',', '.'),
            ]);
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function removeItem(Request $request, int $itemId)
    {
        $this->cartService->removeItem($itemId);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk dihapus dari keranjang.',
                'cartCount' => $this->cartService->getCartCount(),
            ]);
        }

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
