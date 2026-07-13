<x-layouts.app :title="'Checkout - Pembayaran'">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Checkout Steps --}}
        <div class="flex items-center justify-center mb-10">
            <div class="flex items-center gap-2 sm:gap-4 text-sm">
                <span class="flex items-center gap-1.5 text-green-600">
                    <span class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    </span>
                    <span class="hidden sm:inline font-medium">Alamat</span>
                </span>
                <div class="w-8 sm:w-16 h-px bg-green-600"></div>
                <span class="flex items-center gap-1.5 text-green-600">
                    <span class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    </span>
                    <span class="hidden sm:inline font-medium">Pengiriman</span>
                </span>
                <div class="w-8 sm:w-16 h-px bg-primary"></div>
                <span class="flex items-center gap-1.5 font-semibold text-primary">
                    <span class="w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                    <span class="hidden sm:inline">Pembayaran</span>
                </span>
            </div>
        </div>

        <div class="grid lg:grid-cols-5 gap-8">
            {{-- Payment Methods --}}
            <div class="lg:col-span-3">
                <h1 class="text-2xl font-bold text-primary mb-6">Metode Pembayaran</h1>

                <form action="{{ route('checkout.placeOrder') }}" method="POST" id="checkout-form">
                    @csrf
                    <input type="hidden" name="address_id" value="{{ session('checkout.address_id') }}">
                    <input type="hidden" name="shipping_method" value="{{ $shippingMethod }}">

                    <div class="space-y-3 mb-6">
                        @foreach($paymentMethods as $method)
                            <label class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-primary hover:shadow-card transition-all duration-200 has-[:checked]:border-primary has-[:checked]:bg-surface/50">
                                <input type="radio" name="payment_method" value="{{ $method['code'] }}"
                                       {{ $loop->first ? 'checked' : '' }}
                                       class="text-primary focus:ring-primary">
                                <div class="w-10 h-10 bg-surface rounded-lg flex items-center justify-center flex-shrink-0">
                                    @if(!empty($method['logo']))
                                        <img src="{{ $method['logo'] }}" alt="Logo" class="w-8 h-8 object-contain">
                                    @elseif($method['icon'] === 'landmark')
                                        <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="3" x2="21" y1="22" y2="22"/><line x1="6" x2="6" y1="18" y2="11"/><line x1="10" x2="10" y1="18" y2="11"/><line x1="14" x2="14" y1="18" y2="11"/><line x1="18" x2="18" y1="18" y2="11"/><polygon points="12 2 20 7 4 7"/></svg>
                                    @elseif($method['icon'] === 'smartphone')
                                        <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect width="14" height="20" x="5" y="2" rx="2"/><path d="M12 18h.01"/></svg>
                                    @elseif($method['icon'] === 'banknote')
                                        <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-primary">{{ $method['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $method['description'] }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    {{-- Notes --}}
                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-primary mb-1.5">Catatan (opsional)</label>
                        <textarea name="notes" id="notes" rows="2" placeholder="Catatan untuk penjual..."
                            class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-primary placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/10"></textarea>
                    </div>

                    <div class="flex gap-3">
                        <x-button variant="secondary" href="{{ route('checkout.shipping', ['shipping_method' => $shippingMethod]) }}" class="flex-shrink-0">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                            Kembali
                        </x-button>
                        <x-button variant="primary" size="lg" type="submit" fullWidth>
                            Buat Pesanan
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        </x-button>
                    </div>
                </form>
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-2">
                <div class="bg-surface rounded-xl p-6 lg:sticky lg:top-24">
                    <h3 class="text-sm font-semibold text-primary mb-4">Ringkasan Pesanan</h3>

                    {{-- Items --}}
                    <div class="space-y-3 mb-4 max-h-48 overflow-y-auto">
                        @foreach($cart->items as $item)
                            <div class="flex gap-3">
                                <div class="w-12 h-12 bg-white rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ $item->product->primary_image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-primary truncate">{{ $item->product->name }}</p>
                                    <p class="text-xs text-gray-400">x{{ $item->quantity }}</p>
                                </div>
                                <p class="text-xs font-semibold text-primary">{{ $item->formatted_subtotal }}</p>
                            </div>
                        @endforeach
                    </div>

                    <hr class="border-gray-200 my-4">

                    {{-- Address --}}
                    @if($selectedAddress)
                    <div class="mb-4">
                        <p class="text-xs text-gray-400 mb-1">Alamat Pengiriman</p>
                        <p class="text-xs font-medium text-primary">{{ $selectedAddress->recipient_name }}</p>
                        <p class="text-xs text-gray-500">{{ Str::limit($selectedAddress->formatted_address, 60) }}</p>
                    </div>
                    @endif

                    {{-- Totals --}}
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Ongkir ({{ strtoupper($shippingMethod) }})</span>
                            <span class="font-medium">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                        </div>
                        <hr class="border-gray-200">
                        <div class="flex justify-between">
                            <span class="font-semibold text-primary">Total</span>
                            <span class="text-lg font-bold text-primary">Rp {{ number_format($cart->total + $shippingCost, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
