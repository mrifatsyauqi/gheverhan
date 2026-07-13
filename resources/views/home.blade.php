<x-layouts.app :title="'Home'">

    {{-- Hero Section --}}
    @if($heroBanners->count() > 0)
    <section class="relative bg-white" x-data="{ activeSlide: 0, slides: {{ $heroBanners->count() }} }" x-init="setInterval(() => activeSlide = (activeSlide + 1) % slides, 5000)">
        <div class="relative w-full overflow-hidden">
            @foreach($heroBanners as $index => $banner)
            <div x-show="activeSlide === {{ $index }}" x-transition.opacity.duration.500ms class="{{ $index !== 0 ? 'absolute inset-0' : '' }} w-full">
                @if($banner->link_url)
                <a href="{{ $banner->link_url }}" class="block w-full h-full">
                @endif
                    
                    <img src="{{ $banner->image }}" 
                         alt="{{ $banner->title }}" 
                         class="w-full object-cover sm:object-contain object-center max-h-[80vh] bg-surface">
                         
                @if($banner->link_url)
                </a>
                @endif
            </div>
            @endforeach
        </div>
        
        <!-- Slider Dots -->
        @if($heroBanners->count() > 1)
        <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-20">
            @foreach($heroBanners as $index => $banner)
            <button @click="activeSlide = {{ $index }}" :class="activeSlide === {{ $index }} ? 'bg-primary w-6' : 'bg-gray-400 w-2 hover:bg-gray-600'" class="h-2 rounded-full transition-all duration-300"></button>
            @endforeach
        </div>
        @endif
    </section>
    @endif

    {{-- Shop by Category --}}
    <section id="categories" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-primary">Shop by Category</h2>
                <p class="text-sm text-gray-500 mt-1">Temukan koleksi sesuai kategori favorit</p>
            </div>
        </div>

        <div class="flex gap-4 overflow-x-auto pb-4 no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            @foreach($categories as $category)
                <a href="{{ route('products.category', $category->slug) }}"
                   class="flex-shrink-0 w-36 sm:w-auto group">
                    <div class="aspect-square bg-surface rounded-2xl overflow-hidden mb-3 group-hover:shadow-card-hover transition-all duration-300">
                        <img src="{{ $category->image ?? 'https://placehold.co/400x400/F2F2F2/111111?text=' . urlencode($category->name) }}"
                             alt="{{ $category->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             loading="lazy">
                    </div>
                    <h3 class="text-sm font-semibold text-center text-primary group-hover:underline decoration-1 underline-offset-2">
                        {{ $category->name }}
                    </h3>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Best Sellers --}}
    <section id="best-sellers" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-primary">Best Sellers</h2>
                <p class="text-sm text-gray-500 mt-1">Produk paling populer minggu ini</p>
            </div>
            <x-button variant="ghost" size="sm" href="{{ route('products.category', 'all') }}">
                Lihat Semua
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </x-button>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($bestSellers as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>

    {{-- Promo Banner --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-primary rounded-2xl overflow-hidden relative">
            <div class="px-8 sm:px-12 py-12 sm:py-16 relative z-10">
                <div class="max-w-lg">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400 mb-3">Limited Offer</p>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white leading-tight mb-4">
                        Dapatkan Diskon 20% untuk Pembelian Pertama
                    </h2>
                    <p class="text-gray-400 text-sm sm:text-base mb-6">
                        Gunakan kode <span class="text-white font-bold">GHEVERHAN20</span> saat checkout.
                    </p>
                    <x-button variant="secondary" size="lg" href="#best-sellers"
                              class="border-white text-white hover:bg-white hover:text-primary">
                        Belanja Sekarang
                    </x-button>
                </div>
            </div>
            {{-- Decorative --}}
            <div class="absolute top-0 right-0 w-1/3 h-full opacity-10">
                <svg viewBox="0 0 200 200" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="100" cy="100" r="100" fill="white"/>
                </svg>
            </div>
        </div>
    </section>

    {{-- Featured Products --}}
    @if($featuredProducts->count())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-primary">Featured</h2>
                <p class="text-sm text-gray-500 mt-1">Pilihan spesial dari tim kami</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($featuredProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>
    @endif

    @stack('scripts')
</x-layouts.app>
