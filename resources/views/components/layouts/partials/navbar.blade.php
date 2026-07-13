{{-- Navbar --}}
<nav x-data="{ mobileMenu: false, searchOpen: false }" class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex-shrink-0">
                <span class="text-xl font-extrabold tracking-tight text-primary">GHEVERHAN</span>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-sm font-medium text-gray-700 hover:text-primary transition-colors duration-200">Home</a>
                <a href="{{ route('shop') }}" class="text-sm font-medium text-gray-700 hover:text-primary transition-colors duration-200">Shop</a>
                <a href="#categories" class="text-sm font-medium text-gray-700 hover:text-primary transition-colors duration-200">Categories</a>
            </div>

            {{-- Search Bar (Desktop) --}}
            <div class="hidden md:flex flex-1 max-w-md mx-8">
                <form action="{{ route('shop') }}" method="GET" class="w-full relative">
                    <input type="text" name="search" placeholder="Cari produk..."
                           class="w-full pl-10 pr-4 py-2 bg-surface rounded-lg border-0 text-sm
                                  focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all duration-200"
                           value="{{ request('search') }}">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                    </svg>
                </form>
            </div>

            {{-- Right Icons --}}
            <div class="flex items-center space-x-1 sm:space-x-3">
                {{-- Mobile Search Toggle --}}
                <button @click="searchOpen = !searchOpen" class="md:hidden p-2 text-gray-600 hover:text-primary transition-colors" aria-label="Search">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                    </svg>
                </button>

                {{-- Wishlist --}}
                @auth
                <a href="{{ route('wishlist.index') }}" class="p-2 text-gray-600 hover:text-primary transition-colors relative" aria-label="Wishlist">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                    </svg>
                </a>
                @endauth

                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="p-2 text-gray-600 hover:text-primary transition-colors relative" aria-label="Cart">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/>
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                    </svg>
                    <span data-cart-count class="absolute -top-0.5 -right-0.5 bg-primary text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center {{ ($cartCount ?? 0) === 0 ? 'hidden' : '' }}">
                        {{ $cartCount ?? 0 }}
                    </span>
                </a>

                {{-- User Menu --}}
                @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="p-2 text-gray-600 hover:text-primary transition-colors" aria-label="Account">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-modal border border-gray-100 py-1 z-50">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-sm font-semibold text-primary truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-surface transition-colors">Profil Saya</a>
                        <a href="{{ route('profile.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-surface transition-colors">Pesanan</a>
                        <a href="{{ route('wishlist.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-surface transition-colors">Wishlist</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-200">
                    Masuk
                </a>
                <a href="{{ route('login') }}" class="sm:hidden p-2 text-gray-600 hover:text-primary transition-colors" aria-label="Login">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/>
                    </svg>
                </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Mobile Search Bar --}}
    <div x-show="searchOpen" x-transition class="md:hidden border-t border-gray-100 px-4 py-3">
        <form action="{{ route('shop') }}" method="GET" class="relative">
            <input type="text" name="search" placeholder="Cari produk..."
                   class="w-full pl-10 pr-4 py-2.5 bg-surface rounded-lg border-0 text-sm focus:ring-2 focus:ring-primary/20"
                   value="{{ request('search') }}" autofocus>
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
            </svg>
        </form>
    </div>
</nav>
