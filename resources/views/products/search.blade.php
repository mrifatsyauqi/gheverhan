<x-layouts.app :title="'Pencarian: ' . $query">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Search Header --}}
        <div class="mb-8">
            @if($query)
                <h1 class="text-2xl sm:text-3xl font-bold text-primary">
                    Hasil pencarian untuk "<span class="text-gray-500">{{ $query }}</span>"
                </h1>
                <p class="text-sm text-gray-500 mt-2">{{ $products->total() }} produk ditemukan</p>
            @else
                <h1 class="text-2xl sm:text-3xl font-bold text-primary">Cari Produk</h1>
            @endif
        </div>

        {{-- Search Bar --}}
        <form action="{{ route('products.search') }}" method="GET" class="mb-8">
            <div class="relative max-w-xl">
                <input type="text" name="q" value="{{ $query }}" placeholder="Cari produk..."
                       class="w-full pl-12 pr-4 py-3 bg-surface rounded-xl border-0 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all duration-200"
                       autofocus>
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                </svg>
            </div>
        </form>

        {{-- Results --}}
        @if($products->isEmpty() && $query)
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-surface rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-primary mb-2">Produk tidak ditemukan</h2>
                <p class="text-sm text-gray-500 mb-6">Coba gunakan kata kunci yang berbeda.</p>
                <x-button variant="primary" href="{{ route('home') }}">Kembali ke Beranda</x-button>
            </div>
        @elseif($products->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->appends(['q' => $query])->links() }}
            </div>
        @endif
    </div>

    @stack('scripts')
</x-layouts.app>
