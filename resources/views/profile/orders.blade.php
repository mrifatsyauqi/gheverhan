<x-profile.layout title="Pesanan Saya">
    <div>
        <h2 class="text-xl font-bold text-primary mb-6">Pesanan Saya</h2>

        @if($orders->isEmpty())
            <div class="text-center py-12 bg-surface rounded-xl">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                    </svg>
                </div>
                <p class="text-gray-500 mb-4">Belum ada pesanan.</p>
                <x-button variant="primary" href="{{ route('home') }}">Mulai Belanja</x-button>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                    <a href="{{ route('profile.order.detail', $order->order_number) }}"
                       class="block p-4 sm:p-5 border border-gray-100 rounded-xl hover:shadow-card hover:border-gray-200 transition-all duration-200">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                <p class="text-sm font-semibold text-primary">{{ $order->order_number }}</p>
                            </div>
                            <x-badge :text="$order->status_label" :variant="match($order->status) {
                                'pending' => 'default',
                                'confirmed', 'processing' => 'warning',
                                'shipped' => 'info',
                                'delivered' => 'success',
                                'cancelled', 'refunded' => 'danger',
                                default => 'default',
                            }" />
                        </div>

                        {{-- Items preview --}}
                        <div class="flex items-center gap-3 mb-3">
                            @foreach($order->items->take(3) as $item)
                                <div class="w-12 h-12 bg-surface rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ $item->product_image ?? $item->product->primary_image }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                            @if($order->items->count() > 3)
                                <span class="text-xs text-gray-400">+{{ $order->items->count() - 3 }} lainnya</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500">{{ $order->items->sum('quantity') }} produk</span>
                            <span class="text-sm font-bold text-primary">{{ $order->formatted_total }}</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-profile.layout>
