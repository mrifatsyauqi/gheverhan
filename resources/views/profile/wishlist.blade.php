<x-profile.layout title="Wishlist">
    <div>
        <h2 class="text-xl font-bold text-primary mb-6">Wishlist Saya</h2>

        @if($wishlists->isEmpty())
            <div class="text-center py-12 bg-surface rounded-xl">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                    </svg>
                </div>
                <p class="text-gray-500 mb-4">Belum ada produk di wishlist.</p>
                <x-button variant="primary" href="{{ route('home') }}">Jelajahi Produk</x-button>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach($wishlists as $wishlist)
                    <x-product-card :product="$wishlist->product" />
                @endforeach
            </div>
        @endif
    </div>

    @stack('scripts')
</x-profile.layout>
