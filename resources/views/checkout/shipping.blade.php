<x-layouts.app :title="'Checkout - Pengiriman'">

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
                <div class="w-8 sm:w-16 h-px bg-primary"></div>
                <span class="flex items-center gap-1.5 font-semibold text-primary">
                    <span class="w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                    <span class="hidden sm:inline">Pengiriman</span>
                </span>
                <div class="w-8 sm:w-16 h-px bg-gray-300"></div>
                <span class="flex items-center gap-1.5 text-gray-400">
                    <span class="w-6 h-6 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center text-xs font-bold">3</span>
                    <span class="hidden sm:inline">Pembayaran</span>
                </span>
            </div>
        </div>

        <h1 class="text-2xl font-bold text-primary mb-2">Pilih Metode Pengiriman</h1>

        {{-- Selected Address Summary --}}
        @if($selectedAddress)
        <div class="bg-surface rounded-xl p-4 mb-6">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Dikirim ke</p>
                    <p class="text-sm font-semibold text-primary">{{ $selectedAddress->recipient_name }}</p>
                    <p class="text-sm text-gray-500">{{ $selectedAddress->formatted_address }}</p>
                </div>
                <a href="{{ route('checkout.address') }}" class="text-xs text-primary font-medium hover:underline">Ubah</a>
            </div>
        </div>
        @endif

        {{-- Shipping Methods --}}
        <form action="{{ route('checkout.payment') }}" method="GET">
            <div class="space-y-3 mb-8">
                @foreach($shippingMethods as $method)
                    <label class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-primary hover:shadow-card transition-all duration-200 has-[:checked]:border-primary has-[:checked]:bg-surface/50">
                        <input type="radio" name="shipping_method" value="{{ $method['code'] }}"
                               {{ $loop->first ? 'checked' : '' }}
                               class="text-primary focus:ring-primary">
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-primary">{{ $method['name'] }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $method['description'] }}</p>
                                </div>
                                <span class="text-sm font-bold text-primary">{{ $method['formatted_cost'] }}</span>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="flex gap-3">
                <x-button variant="secondary" href="{{ route('checkout.address') }}" class="flex-shrink-0">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                    Kembali
                </x-button>
                <x-button variant="primary" size="lg" type="submit" fullWidth>
                    Lanjut ke Pembayaran
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </x-button>
            </div>
        </form>
    </div>
</x-layouts.app>
