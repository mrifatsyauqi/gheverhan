{{-- Mobile Bottom Navigation --}}
<nav class="md:hidden fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-gray-100 z-40">
    <div class="grid grid-cols-4 h-16">
        {{-- Home --}}
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center gap-0.5 {{ request()->routeIs('home') ? 'text-primary' : 'text-gray-400' }}">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span class="text-[10px] font-medium">Home</span>
        </a>

        {{-- Shop --}}
        <a href="{{ route('shop') }}" class="flex flex-col items-center justify-center gap-0.5 {{ request()->routeIs('shop') ? 'text-primary' : 'text-gray-400' }}">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
            </svg>
            <span class="text-[10px] font-medium">Shop</span>
        </a>

        {{-- Cart --}}
        <a href="{{ route('cart.index') }}" class="flex flex-col items-center justify-center gap-0.5 relative {{ request()->routeIs('cart.index') ? 'text-primary' : 'text-gray-400' }}">
            <div class="relative">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                <span data-cart-count class="absolute -top-1.5 -right-1.5 bg-primary text-white text-[8px] font-bold w-3.5 h-3.5 rounded-full flex items-center justify-center {{ ($cartCount ?? 0) === 0 ? 'hidden' : '' }}">
                    {{ $cartCount ?? 0 }}
                </span>
            </div>
            <span class="text-[10px] font-medium">Keranjang</span>
        </a>

        {{-- Profile --}}
        @auth
        <a href="{{ route('profile.index') }}" class="flex flex-col items-center justify-center gap-0.5 {{ request()->routeIs('profile.*') ? 'text-primary' : 'text-gray-400' }}">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>
            <span class="text-[10px] font-medium">Profil</span>
        </a>
        @else
        <a href="{{ route('login') }}" class="flex flex-col items-center justify-center gap-0.5 text-gray-400">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>
            <span class="text-[10px] font-medium">Masuk</span>
        </a>
        @endauth
    </div>
</nav>
