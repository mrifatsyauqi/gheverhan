@props([
    'product',
    'showWishlist' => true,
])

<div class="group card-hover bg-white rounded-xl overflow-hidden h-full flex flex-col">
    {{-- Image Container --}}
    <div class="relative aspect-square bg-surface overflow-hidden">
        <a href="{{ route('products.show', $product->slug) }}">
            <img src="{{ $product->primary_image }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
                 loading="lazy">
        </a>

        {{-- Discount Badge --}}
        @if($product->discount_percentage)
            <div class="absolute top-2 left-2 bg-primary text-white text-[9px] font-bold px-1.5 py-0.5 rounded">
                -{{ $product->discount_percentage }}%
            </div>
        @endif

        {{-- Wishlist Button --}}
        @if($showWishlist)
            <button
                onclick="window.toggleWishlist({{ $product->id }}, this, '{{ route('wishlist.toggle') }}', '{{ route('login') }}', {{ auth()->check() ? 'true' : 'false' }})"
                class="absolute top-2 right-2 w-6 h-6 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center
                       shadow-sm hover:bg-white hover:shadow-md transition-all duration-200 group/heart"
                aria-label="Add to wishlist">
                <svg class="w-4 h-4 transition-colors duration-200 {{ auth()->check() && auth()->user()->hasWishlisted($product->id) ? 'fill-red-500 text-red-500' : 'text-gray-500 group-hover/heart:text-red-500' }}"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none">
                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                </svg>
            </button>
        @endif
    </div>

    <div class="p-2 flex-1 flex flex-col justify-between">
        <div>
            {{-- Name --}}
            <a href="{{ route('products.show', $product->slug) }}">
                <h3 class="text-xs sm:text-sm font-semibold text-primary leading-tight mb-0 truncate group-hover:underline decoration-1 underline-offset-2">
                    {{ $product->name }}
                </h3>
            </a>

            {{-- Rating --}}
            @if($product->rating > 0)
                <div class="flex items-center gap-1 mb-0">
                    <x-rating :value="$product->rating" size="xs" />
                    <span class="text-[9px] text-gray-400">({{ $product->rating_count }})</span>
                </div>
            @endif
        </div>

        {{-- Price & Cart Button Row --}}
        <div class="flex items-center justify-between mt-1">
            <div class="flex flex-col leading-tight">
                <span class="text-xs sm:text-sm font-extrabold text-primary">{{ $product->formatted_price }}</span>
                @if($product->formatted_compare_price)
                    <span class="text-[9px] text-gray-400 line-through">{{ $product->formatted_compare_price }}</span>
                @endif
            </div>

            {{-- Mobile Cart Button (Small Square) --}}
            <form action="{{ route('cart.add') }}" method="POST" class="sm:hidden">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="bg-primary text-white w-8 h-8 rounded-md flex items-center justify-center hover:bg-primary-dark transition-colors" aria-label="Tambah ke keranjang">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </button>
            </form>
        </div>

        {{-- Desktop Cart Button (Full Width) --}}
        <form action="{{ route('cart.add') }}" method="POST" class="hidden sm:block mt-2">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="w-full bg-primary text-white text-[10px] sm:text-xs font-bold py-2 rounded-md flex items-center justify-center gap-1 hover:bg-primary-dark transition-colors">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Keranjang
            </button>
        </form>
    </div>
</div>


