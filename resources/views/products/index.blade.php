<x-layouts.app>
    <x-slot name="title">Shop - Semua Produk</x-slot>

    <div class="max-w-[1400px] mx-auto px-4 md:px-6 py-4 md:py-6" x-data="{ mobileFiltersOpen: false }">
        
        {{-- Breadcrumb (Desktop Only) --}}
        <nav class="hidden md:flex text-xs text-gray-500 mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        <span class="text-gray-900 font-medium">Shop</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Mobile Action Row (Filter & Sort) --}}
        <div class="flex items-center justify-between gap-3 md:hidden mb-4">
            <button type="button" class="flex-1 flex items-center justify-center gap-2 border border-gray-300 rounded-lg py-2 text-sm font-bold text-gray-800 bg-white shadow-sm" @click="mobileFiltersOpen = true">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                Filter
            </button>
            <div class="flex-1 relative">
                <form id="mobile-sort-form" method="GET" action="{{ route('shop') }}" class="inline">
                    @foreach(request()->except('sort', 'page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select name="sort" onchange="document.getElementById('mobile-sort-form').submit()" 
                            class="w-full border border-gray-300 rounded-lg py-2 pl-3 pr-8 text-xs font-bold text-gray-800 bg-white focus:ring-primary focus:border-primary shadow-sm">
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                    </select>
                </form>
            </div>
        </div>

        <style>
            @media (min-width: 1024px) {
                .desktop-shop-grid {
                    display: grid !important;
                    grid-template-columns: 280px 1fr !important;
                }
            }
        </style>
        <div class="grid grid-cols-1 gap-6 desktop-shop-grid">
            {{-- Desktop Sidebar Filters --}}
            <aside class="hidden lg:block">
                <form id="filter-form" action="{{ route('shop') }}" method="GET" x-data="{ activeAccordion: 'category' }">
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    {{-- Categories Accordion --}}
                    <div class="border-b border-gray-200 py-3">
                        <button type="button" @click="activeAccordion = activeAccordion === 'category' ? null : 'category'" class="w-full flex items-center justify-between text-xs font-bold text-gray-900 uppercase tracking-wider">
                            <span>Kategori</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{'rotate-180': activeAccordion === 'category'}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="activeAccordion === 'category'" style="display: none;" class="pt-4 space-y-1">
                            <button type="submit" name="category" value="" 
                                   class="w-full flex items-center justify-between px-2 py-2 text-xs rounded-md transition-colors {{ !request('category') ? 'bg-primary text-white font-semibold' : 'text-gray-600 hover:bg-gray-100 font-medium' }}">
                                <span>Semua Kategori</span>
                                <span class="{{ !request('category') ? 'text-gray-200' : 'text-gray-400' }}">({{ $products->total() }})</span>
                            </button>
                            @foreach($categories as $category)
                            <button type="submit" name="category" value="{{ $category->slug }}" 
                                   class="w-full flex items-center justify-between px-2 py-2 text-xs rounded-md transition-colors {{ request('category') == $category->slug ? 'bg-primary text-white font-semibold' : 'text-gray-600 hover:bg-gray-100 font-medium' }}">
                                <span>{{ $category->name }}</span>
                                <span class="{{ request('category') == $category->slug ? 'text-gray-200' : 'text-gray-400' }}">({{ $category->products_count ?? 0 }})</span>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Price Range Accordion --}}
                    <div class="border-b border-gray-200 py-3">
                        <button type="button" @click="activeAccordion = activeAccordion === 'price' ? null : 'price'" class="w-full flex items-center justify-between text-xs font-bold text-gray-900 uppercase tracking-wider">
                            <span>Filter Harga</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{'rotate-180': activeAccordion === 'price'}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="activeAccordion === 'price'" style="display: none;" class="pt-4">
                            <div class="grid grid-cols-2 gap-2 mb-3">
                                <div>
                                    <label for="min_price" class="sr-only">Min</label>
                                    <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" placeholder="Min"
                                           class="w-full rounded-md border-gray-300 focus:border-primary focus:ring-primary text-xs py-1.5 text-center bg-gray-50">
                                </div>
                                <div>
                                    <label for="max_price" class="sr-only">Max</label>
                                    <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" placeholder="Max"
                                           class="w-full rounded-md border-gray-300 focus:border-primary focus:ring-primary text-xs py-1.5 text-center bg-gray-50">
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-primary text-white rounded-md py-2 text-xs font-bold hover:bg-primary-dark transition-colors">
                                Terapkan
                            </button>
                        </div>
                    </div>

                    {{-- Sizes Accordion (Mock for UI) --}}
                    <div class="border-b border-gray-200 py-3">
                        <button type="button" @click="activeAccordion = activeAccordion === 'size' ? null : 'size'" class="w-full flex items-center justify-between text-xs font-bold text-gray-900 uppercase tracking-wider">
                            <span>Ukuran</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{'rotate-180': activeAccordion === 'size'}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="activeAccordion === 'size'" style="display: none;" class="pt-4 space-y-2.5">
                            @foreach(['XS' => 12, 'S' => 28, 'M' => 48, 'L' => 48, 'XL' => 36, 'XXL' => 16] as $size => $count)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="size-{{ $size }}" name="size[]" value="{{ $size }}" type="checkbox" 
                                           class="h-3.5 w-3.5 rounded border-gray-300 text-primary focus:ring-primary cursor-pointer">
                                    <label for="size-{{ $size }}" class="ml-2.5 text-xs text-gray-600 cursor-pointer">{{ $size }}</label>
                                </div>
                                <span class="text-[10px] text-gray-400">({{ $count }})</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    {{-- Reset Filter Button --}}
                    @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'sort']))
                    <a href="{{ route('shop') }}" class="mt-4 block text-center w-full bg-gray-100 text-gray-700 rounded-md py-2 text-xs font-semibold hover:bg-gray-200 transition-colors">
                        Reset Filter
                    </a>
                    @endif
                </form>
            </aside>

            {{-- Main Content (Grid) --}}
            <section>
                {{-- Product Header --}}
                <div class="hidden md:flex items-center justify-between mb-4 pb-3 border-b border-gray-200">
                    <span class="text-xs text-gray-700 font-medium">Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} Produk</span>
                    <div class="relative" x-data="{ open: false }">
                        <form id="sort-form" method="GET" action="{{ route('shop') }}" class="inline">
                            @foreach(request()->except('sort', 'page') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <select name="sort" onchange="document.getElementById('sort-form').submit()" 
                                    class="border-gray-200 rounded-md py-1.5 pl-3 pr-8 text-xs font-medium text-gray-700 focus:ring-primary focus:border-primary cursor-pointer shadow-sm">
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                            </select>
                        </form>
                    </div>
                </div>

                @if($products->isEmpty())
                    <div class="text-center py-16 bg-surface rounded-xl border border-gray-100">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="text-sm font-medium text-gray-900">Produk tidak ditemukan</h3>
                        <p class="mt-1 text-xs text-gray-500">Coba sesuaikan filter atau pencarian Anda.</p>
                        <div class="mt-4">
                            <a href="{{ route('shop') }}" class="inline-flex items-center rounded-md border border-transparent bg-primary px-3 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                Reset Filter
                            </a>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <div class="mt-12">
                        {{ $products->links() }}
                    </div>
                @endif
            </section>
        </div>

        {{-- Mobile Filter Dialog (Alpine) --}}
        <div x-show="mobileFiltersOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true" style="display: none;">
            <div x-show="mobileFiltersOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black bg-opacity-25 backdrop-blur-sm" @click="mobileFiltersOpen = false"></div>

            <div class="fixed inset-x-0 bottom-0 z-40 flex">
                <div x-show="mobileFiltersOpen"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="translate-y-full"
                     x-transition:enter-end="translate-y-0"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="translate-y-0"
                     x-transition:leave-end="translate-y-full"
                     class="relative flex w-full max-h-[85vh] flex-col overflow-y-auto bg-white py-4 pb-24 shadow-2xl rounded-t-3xl">
                    
                    <div class="flex items-center justify-between px-4">
                        <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                        <button type="button" class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400" @click="mobileFiltersOpen = false">
                            <span class="sr-only">Close menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form class="mt-4 border-t border-gray-200 px-4 py-6" action="{{ route('shop') }}" method="GET">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        {{-- Mobile Sort --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-900 mb-2">Urutkan</label>
                            <select name="sort" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring-primary text-sm py-2">
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                            </select>
                        </div>

                        {{-- Mobile Category --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-900 mb-2">Kategori</label>
                            <select name="category" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring-primary text-sm py-2">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->products_count ?? 0 }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Mobile Price --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-900 mb-2">Rentang Harga</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full rounded-xl border-gray-300 text-sm py-2">
                                <span>-</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full rounded-xl border-gray-300 text-sm py-2">
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col gap-3">
                            <button type="submit" class="w-full bg-primary text-white rounded-xl py-3 text-sm font-semibold">Terapkan Filter</button>
                            <a href="{{ route('shop') }}" class="w-full text-center bg-gray-100 text-gray-700 rounded-xl py-3 text-sm font-semibold">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Features Bar --}}
        <div class="mt-12 border-t border-gray-200 pt-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">Gratis Ongkir</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Min. belanja Rp 250.000</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">Garansi 7 Hari</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Uang kembali 100%</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">Pembayaran Aman</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Metode pembayaran terpercaya</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75v-4.5m0 4.5h4.5m-4.5 0l6-6m-3 18c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 014.5 2.25h13.5A2.25 2.25 0 0120.25 4.5v11.25m-18 0c0 4.14 3.36 7.5 7.5 7.5h1.5m-1.5-7.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-10.5h4.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-4.375" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">CS 24/7</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Siap membantu kapan saja</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
