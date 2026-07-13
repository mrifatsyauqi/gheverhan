<x-layouts.app :title="'Keranjang Belanja'">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-primary mb-8">Keranjang Belanja</h1>

        @if($cart->items->isEmpty())
            {{-- Empty Cart --}}
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-surface rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/>
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-primary mb-2">Keranjang Anda kosong</h2>
                <p class="text-sm text-gray-500 mb-6">Belum ada produk di keranjang. Yuk mulai belanja!</p>
                <x-button variant="primary" href="{{ route('home') }}">
                    Mulai Belanja
                </x-button>
            </div>
        @else
            <div class="space-y-4" x-data="cartPage()">
                {{-- Cart Items --}}
                @foreach($cart->items as $item)
                    <div class="flex gap-4 p-4 bg-white border border-gray-100 rounded-xl hover:shadow-card transition-all duration-200"
                         id="cart-item-{{ $item->id }}">
                        {{-- Image --}}
                        <div class="w-20 h-20 sm:w-24 sm:h-24 flex-shrink-0 bg-surface rounded-lg overflow-hidden">
                            <img src="{{ $item->product->primary_image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                        </div>

                        {{-- Details --}}
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('products.show', $item->product->slug) }}"
                               class="text-sm font-semibold text-primary hover:underline line-clamp-1">
                                {{ $item->product->name }}
                            </a>
                            @if($item->variant)
                                <p class="text-xs text-gray-500 mt-0.5">{{ $item->variant->name }}</p>
                            @endif
                            <p class="text-sm font-bold text-primary mt-2">{{ $item->formatted_price }}</p>

                            {{-- Quantity & Remove --}}
                            <div class="flex items-center justify-between mt-3">
                                <div class="inline-flex items-center border border-gray-200 rounded-lg">
                                    <button onclick="updateCartItem({{ $item->id }}, {{ max(0, $item->quantity - 1) }})"
                                            class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-primary transition-colors">
                                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/></svg>
                                    </button>
                                    <span class="w-8 h-8 flex items-center justify-center text-xs font-semibold border-x border-gray-200">{{ $item->quantity }}</span>
                                    <button onclick="updateCartItem({{ $item->id }}, {{ $item->quantity + 1 }})"
                                            class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-primary transition-colors">
                                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                    </button>
                                </div>

                                <button onclick="removeCartItem({{ $item->id }})"
                                        class="p-1.5 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Subtotal (desktop) --}}
                        <div class="hidden sm:flex flex-col items-end justify-center">
                            <p class="text-sm font-bold text-primary">{{ $item->formatted_subtotal }}</p>
                        </div>
                    </div>
                @endforeach

                {{-- Summary --}}
                <div class="bg-surface rounded-xl p-6 mt-6">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal ({{ $cart->item_count }} item)</span>
                            <span class="font-semibold text-primary" id="cart-total">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Ongkir</span>
                            <span class="text-gray-500">Dihitung saat checkout</span>
                        </div>
                        <hr class="border-gray-200">
                        <div class="flex justify-between">
                            <span class="font-semibold text-primary">Total</span>
                            <span class="text-lg font-bold text-primary" id="cart-grand-total">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        @auth
                            <x-button variant="primary" size="lg" fullWidth href="{{ route('checkout.address') }}">
                                Lanjut ke Checkout
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </x-button>
                        @else
                            <x-button variant="primary" size="lg" fullWidth href="{{ route('login') }}">
                                Masuk untuk Checkout
                            </x-button>
                        @endauth
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
    function cartPage() {
        return {};
    }
    </script>
</x-layouts.app>
