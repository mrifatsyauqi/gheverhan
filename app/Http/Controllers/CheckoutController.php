<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceOrderRequest;
use App\Http\Requests\StoreAddressRequest;
use App\Services\CheckoutService;
use App\Services\OrderService;
use App\Repositories\Interfaces\AddressRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct(
        protected CheckoutService $checkoutService,
        protected OrderService $orderService,
        protected AddressRepositoryInterface $addressRepository
    ) {}

    public function step1()
    {
        $data = $this->checkoutService->getCheckoutData();

        return view('checkout.address', [
            'cart' => $data['cart'],
            'addresses' => $data['addresses'],
        ]);
    }

    public function storeAddress(StoreAddressRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        $this->addressRepository->create($validated);

        return redirect()->route('checkout.address')
            ->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function step2(Request $request)
    {
        $addressId = $request->input('address_id', session('checkout.address_id'));

        if (!$addressId) {
            return redirect()->route('checkout.address')
                ->with('error', 'Silakan pilih alamat pengiriman.');
        }

        session(['checkout.address_id' => $addressId]);

        $data = $this->checkoutService->getCheckoutData();
        $selectedAddress = $this->addressRepository->findById($addressId);

        return view('checkout.shipping', [
            'cart' => $data['cart'],
            'selectedAddress' => $selectedAddress,
            'shippingMethods' => $data['shippingMethods'],
        ]);
    }

    public function step3(Request $request)
    {
        $shippingMethod = $request->input('shipping_method', session('checkout.shipping_method'));

        if (!session('checkout.address_id')) {
            return redirect()->route('checkout.address');
        }

        if (!$shippingMethod) {
            return redirect()->route('checkout.shipping')
                ->with('error', 'Silakan pilih metode pengiriman.');
        }

        session(['checkout.shipping_method' => $shippingMethod]);

        $data = $this->checkoutService->getCheckoutData();
        $selectedAddress = $this->addressRepository->findById(session('checkout.address_id'));
        $shippingCost = $this->orderService->calculateShipping($shippingMethod);

        return view('checkout.payment', [
            'cart' => $data['cart'],
            'selectedAddress' => $selectedAddress,
            'shippingMethod' => $shippingMethod,
            'shippingCost' => $shippingCost,
            'paymentMethods' => $data['paymentMethods'],
        ]);
    }

    public function placeOrder(PlaceOrderRequest $request)
    {
        try {
            $address = $this->addressRepository->findById($request->validated('address_id'));

            $order = $this->orderService->placeOrder([
                'user_id' => Auth::id(),
                'address_id' => $request->validated('address_id'),
                'shipping_method' => $request->validated('shipping_method'),
                'payment_method' => $request->validated('payment_method'),
                'notes' => $request->validated('notes'),
                'address_snapshot' => $address?->formatted_address,
            ]);

            // Clear checkout session
            session()->forget(['checkout.address_id', 'checkout.shipping_method']);

            return redirect()->route('profile.order.detail', $order->order_number)
                ->with('success', 'Pesanan berhasil dibuat! Nomor pesanan: ' . $order->order_number);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
