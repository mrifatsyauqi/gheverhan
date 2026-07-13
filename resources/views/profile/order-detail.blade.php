<x-profile.layout :title="'Pesanan ' . $order->order_number">
    <div>
        {{-- Back --}}
        <a href="{{ route('profile.orders') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-primary transition-colors mb-6">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            Kembali ke Pesanan
        </a>

        {{-- Order Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-8">
            <div>
                <h2 class="text-xl font-bold text-primary">{{ $order->order_number }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
            <x-badge :text="$order->status_label" :variant="match($order->status) {
                'pending' => 'default',
                'confirmed', 'processing' => 'warning',
                'shipped' => 'info',
                'delivered' => 'success',
                default => 'default',
            }" class="text-sm px-4 py-1.5" />
        </div>

        <div class="grid lg:grid-cols-5 gap-8">
            {{-- Order Tracking --}}
            <div class="lg:col-span-2 order-2 lg:order-1">
                <div class="bg-surface rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-primary mb-6">Status Pesanan</h3>
                    <x-stepper :steps="$order->statusHistories" :currentStatus="$order->status" />
                </div>

                {{-- Shipping Info --}}
                @if($order->shipping_method)
                <div class="bg-surface rounded-xl p-6 mt-4">
                    <h3 class="text-sm font-semibold text-primary mb-3">Info Pengiriman</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Kurir</span>
                            <span class="font-medium text-primary">{{ strtoupper($order->shipping_method) }}</span>
                        </div>
                        @if($order->tracking_number)
                        <div class="flex justify-between">
                            <span class="text-gray-500">No. Resi</span>
                            <span class="font-medium text-primary">{{ $order->tracking_number }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            {{-- Order Items & Summary --}}
            <div class="lg:col-span-3 order-1 lg:order-2">
                {{-- Items --}}
                <div class="border border-gray-100 rounded-xl overflow-hidden mb-6">
                    <div class="px-5 py-3 bg-surface border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-primary">Produk Dipesan</h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                            <div class="flex gap-4 p-4">
                                <div class="w-16 h-16 bg-surface rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ $item->product_image ?? $item->product->primary_image }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-primary">{{ $item->product_name }}</p>
                                    @if($item->variant_name)
                                        <p class="text-xs text-gray-500">{{ $item->variant_name }}</p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-1">{{ $item->quantity }} x {{ $item->formatted_price }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-primary">{{ $item->formatted_subtotal }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Shipping Address --}}
                @if($order->shipping_address_snapshot || $order->address)
                <div class="border border-gray-100 rounded-xl p-5 mb-6">
                    <h3 class="text-sm font-semibold text-primary mb-2">Alamat Pengiriman</h3>
                    <p class="text-sm text-gray-600">{{ $order->shipping_address_snapshot ?? $order->address?->formatted_address }}</p>
                </div>
                @endif

                {{-- Payment Summary --}}
                <div class="bg-surface rounded-xl p-5">
                    <h3 class="text-sm font-semibold text-primary mb-4">Rincian Pembayaran</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Metode Pembayaran</span>
                            <span class="font-medium text-primary">
                                {{ match($order->payment_method) {
                                    'bank_transfer' => 'Transfer Bank',
                                    'ewallet' => 'E-Wallet',
                                    'cod' => 'Cash on Delivery',
                                    default => ucfirst($order->payment_method ?? '-'),
                                } }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subtotal</span>
                            <span>{{ $order->formatted_subtotal }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Ongkir</span>
                            <span>{{ $order->formatted_shipping_cost }}</span>
                        </div>
                        <hr class="border-gray-200">
                        <div class="flex justify-between text-base">
                            <span class="font-semibold text-primary">Total</span>
                            <span class="font-bold text-primary">{{ $order->formatted_total }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-profile.layout>
