<x-layouts.app :title="$product->name">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Breadcrumb --}}
        <nav class="mb-6 text-sm">
            <ol class="flex items-center gap-2 text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a></li>
                <li>/</li>
                <li><a href="{{ route('products.category', $product->category->slug) }}" class="hover:text-primary transition-colors">{{ $product->category->name }}</a></li>
                <li>/</li>
                <li class="text-primary font-medium truncate max-w-[200px]">{{ $product->name }}</li>
            </ol>
        </nav>

        {{-- Product Section --}}
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12" x-data="productDetail({
            productId: {{ $product->id }},
            price: {{ $product->price }},
            variants: {{ $product->activeVariants->toJson() }},
            images: {{ json_encode($product->images ?? []) }},
            cartAddUrl: '{{ route('cart.add') }}'
        })">

            {{-- Image Gallery --}}
            <div class="space-y-4">
                {{-- Main Image --}}
                <div class="aspect-square bg-surface rounded-2xl overflow-hidden cursor-zoom-in" @click="zoomOpen = true">
                    <img :src="currentImage" alt="{{ $product->name }}"
                         class="w-full h-full object-cover object-center transition-transform duration-500"
                         :class="{ 'scale-110': hovering }"
                         @mouseenter="hovering = true" @mouseleave="hovering = false">
                </div>

                {{-- Thumbnails --}}
                @if($product->images && count($product->images) > 1)
                <div class="flex gap-3 overflow-x-auto no-scrollbar">
                    @foreach($product->images as $index => $image)
                        <button @click="currentImage = '{{ $image }}'; currentImageIndex = {{ $index }}"
                                class="flex-shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-lg overflow-hidden border-2 transition-all duration-200"
                                :class="currentImageIndex === {{ $index }} ? 'border-primary' : 'border-transparent hover:border-gray-300'">
                            <img src="{{ $image }}" alt="Thumbnail {{ $index + 1 }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Product Info --}}
            <div class="lg:sticky lg:top-24 lg:self-start space-y-6">
                {{-- Category --}}
                <p class="text-xs uppercase tracking-[0.15em] text-gray-400 font-semibold">{{ $product->category->name }}</p>

                {{-- Name --}}
                <h1 class="text-2xl sm:text-3xl font-bold text-primary leading-tight">{{ $product->name }}</h1>

                {{-- Rating --}}
                @if($product->rating > 0)
                <div class="flex items-center gap-2">
                    <x-rating :value="$product->rating" size="md" />
                    <span class="text-sm text-gray-500">({{ $product->rating_count }} ulasan)</span>
                </div>
                @endif

                {{-- Price --}}
                <div class="flex items-end gap-3">
                    <span class="text-2xl sm:text-3xl font-extrabold text-primary" x-text="formatCurrency(currentPrice)">{{ $product->formatted_price }}</span>
                    @if($product->compare_price)
                        <span class="text-lg text-gray-400 line-through mb-0.5">{{ $product->formatted_compare_price }}</span>
                        <x-badge variant="danger" :text="'-' . $product->discount_percentage . '%'" />
                    @endif
                </div>

                {{-- Divider --}}
                <hr class="border-gray-100">

                {{-- Color Selector --}}
                @if(count($product->available_colors) > 0)
                <div>
                    <label class="block text-sm font-semibold text-primary mb-3">
                        Warna: <span class="font-normal text-gray-500" x-text="selectedColor || 'Pilih warna'"></span>
                    </label>
                    <div class="flex gap-3">
                        @foreach($product->available_colors as $color)
                            <button @click="selectColor('{{ $color }}')"
                                    class="color-swatch"
                                    :class="{ 'active': selectedColor === '{{ $color }}' }"
                                    style="background-color: {{ $color }}"
                                    title="{{ $color }}"
                                    aria-label="Color {{ $color }}">
                            </button>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Size Selector --}}
                @if(count($product->available_sizes) > 0)
                <div>
                    <label class="block text-sm font-semibold text-primary mb-3">
                        Ukuran: <span class="font-normal text-gray-500" x-text="selectedSize || 'Pilih ukuran'"></span>
                    </label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->available_sizes as $size)
                            @php
                                $sizeVariants = $product->activeVariants->where('size', $size);
                                $hasStock = $sizeVariants->where('stock', '>', 0)->count() > 0;
                            @endphp
                            <button @click="{{ $hasStock ? "selectSize('$size')" : '' }}"
                                    class="pill-btn {{ !$hasStock ? 'disabled' : '' }}"
                                    :class="{ 'active': selectedSize === '{{ $size }}' }"
                                    {{ !$hasStock ? 'disabled' : '' }}>
                                {{ $size }}
                            </button>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Quantity --}}
                <div>
                    <label class="block text-sm font-semibold text-primary mb-3">Jumlah</label>
                    <div class="inline-flex items-center border border-gray-200 rounded-lg">
                        <button @click="quantity > 1 ? quantity-- : null"
                                class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-primary transition-colors">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/></svg>
                        </button>
                        <span class="w-12 h-10 flex items-center justify-center text-sm font-semibold border-x border-gray-200" x-text="quantity"></span>
                        <button @click="quantity < 10 ? quantity++ : null"
                                class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-primary transition-colors">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Add to Cart --}}
                <div class="flex gap-3 pt-2">
                    <x-button variant="primary" size="lg" fullWidth
                              x-on:click="addToCart()"
                              x-bind:disabled="!canAddToCart"
                              class="flex-1">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/>
                            <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                        </svg>
                        <span x-text="addingToCart ? 'Menambahkan...' : 'Tambah ke Keranjang'">Tambah ke Keranjang</span>
                    </x-button>
                </div>

                {{-- Description --}}
                @if($product->description)
                <div class="pt-4">
                    <h3 class="text-sm font-semibold text-primary mb-2">Deskripsi Produk</h3>
                    <div class="text-sm text-gray-600 leading-relaxed prose prose-sm max-w-none">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->count())
        <section class="mt-16 pt-16 border-t border-gray-100">
            <h2 class="text-2xl font-bold text-primary mb-8">Produk Terkait</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($relatedProducts as $related)
                    <x-product-card :product="$related" />
                @endforeach
            </div>
        </section>
        @endif
    </div>

    @push('scripts')
    @endpush

    @stack('scripts')
</x-layouts.app>
