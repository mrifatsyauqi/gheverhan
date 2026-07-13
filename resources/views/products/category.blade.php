<x-layouts.app :title="$category->name">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Breadcrumb --}}
        <nav class="mb-6 text-sm">
            <ol class="flex items-center gap-2 text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a></li>
                <li>/</li>
                <li class="text-primary font-medium">{{ $category->name }}</li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-primary">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-gray-500 mt-2">{{ $category->description }}</p>
            @endif
        </div>

        {{-- Products Grid --}}
        @if($products->isEmpty())
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-surface rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-primary mb-2">Belum ada produk</h2>
                <p class="text-sm text-gray-500 mb-6">Kategori ini belum memiliki produk.</p>
                <x-button variant="primary" href="{{ route('home') }}">Kembali ke Beranda</x-button>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    @stack('scripts')
</x-layouts.app>
