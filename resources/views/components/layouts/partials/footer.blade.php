{{-- Footer --}}
<footer class="bg-primary text-white mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            {{-- Brand --}}
            <div class="md:col-span-1">
                <span class="text-xl font-extrabold tracking-tight">GHEVERHAN</span>
                <p class="mt-3 text-sm text-gray-400 leading-relaxed">
                    Elevate Your Everyday Style. Premium fashion untuk gaya hidup modern Anda.
                </p>
            </div>

            {{-- Shop --}}
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider mb-4">Shop</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">New Arrivals</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Best Sellers</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Categories</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Sale</a></li>
                </ul>
            </div>

            {{-- Help --}}
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider mb-4">Bantuan</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">FAQ</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Pengiriman</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Pengembalian</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Hubungi Kami</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider mb-4">Kontak</h4>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        hello@gheverhan.com
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        +62 812-3456-7890
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-10 pt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-xs text-gray-500">&copy; {{ date('Y') }} GHEVERHAN. All rights reserved.</p>
            <div class="flex items-center space-x-4">
                <a href="#" class="text-gray-500 hover:text-white transition-colors" aria-label="Instagram">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect width="20" height="20" x="2" y="2" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                </a>
                <a href="#" class="text-gray-500 hover:text-white transition-colors" aria-label="Twitter">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
                </a>
            </div>
        </div>
    </div>
</footer>
