{{-- Footer --}}
<footer class="bg-primary text-white mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12 mb-12">
            <!-- Brand -->
            <div class="space-y-4">
                @if(\App\Models\StoreSetting::get('store_logo'))
                    <img src="{{ \App\Models\StoreSetting::get('store_logo') }}" alt="Logo" class="h-8 invert opacity-90">
                @else
                    <a href="{{ route('home') }}" class="text-2xl font-extrabold tracking-tight text-white">{{ \App\Models\StoreSetting::get('store_name', 'GHEVERHAN') }}</a>
                @endif
                <p class="text-gray-400 text-sm leading-relaxed pr-4">
                    {{ \App\Models\StoreSetting::get('store_description', 'Mendefinisikan ulang gaya kasual dengan kualitas premium dan desain kontemporer untuk individu modern.') }}
                </p>
                <div class="flex space-x-4 pt-2">
                    @if(\App\Models\StoreSetting::get('instagram_url'))
                    <a href="{{ \App\Models\StoreSetting::get('instagram_url') }}" target="_blank" class="text-gray-400 hover:text-white transition-colors p-2 -ml-2">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                    </a>
                    @endif
                    @if(\App\Models\StoreSetting::get('tiktok_url'))
                    <a href="{{ \App\Models\StoreSetting::get('tiktok_url') }}" target="_blank" class="text-gray-400 hover:text-white transition-colors p-2">
                        <span class="sr-only">TikTok</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.24-1.76.15-3.54 1.11-5.01 1.07-1.68 2.78-2.85 4.73-3.22 1.54-.29 3.12-.2 4.62.24.12.04.22.09.34.13v4.11c-.42-.23-.87-.4-1.34-.49-.86-.17-1.75-.05-2.54.34-1.14.54-1.99 1.56-2.22 2.8-.23 1.24.11 2.53.94 3.48.86.99 2.21 1.48 3.53 1.29 1.34-.19 2.52-1.02 3.07-2.24.4-.87.56-1.83.56-2.79.03-4.73.02-9.47.02-14.21z"/></svg>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Shop -->
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Shop</h3>
                <ul class="space-y-4">
                    <li><a href="{{ route('products.category', 'all') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Semua Produk</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Terbaru</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Populer</a></li>
                </ul>
            </div>

            <!-- Bantuan -->
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Bantuan</h3>
                <ul class="space-y-4">
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Cara Pemesanan</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Pengiriman</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Kebijakan Pengembalian</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">FAQ</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Hubungi Kami</h3>
                <ul class="space-y-4">
                    <li class="flex items-start text-sm text-gray-400">
                        <svg class="h-5 w-5 mr-3 text-gray-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ \App\Models\StoreSetting::get('address', 'Jakarta, Indonesia') }}</span>
                    </li>
                    <li class="flex items-center text-sm text-gray-400">
                        <svg class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>{{ \App\Models\StoreSetting::get('contact_phone', '+62 812-3456-7890') }}</span>
                    </li>
                    <li class="flex items-center text-sm text-gray-400">
                        <svg class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>{{ \App\Models\StoreSetting::get('contact_email', 'hello@gheverhan.com') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8 mt-8 text-sm text-gray-500 flex flex-col md:flex-row justify-between items-center gap-4">
            <p>&copy; {{ date('Y') }} {{ \App\Models\StoreSetting::get('store_name', 'GHEVERHAN') }}. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</footer>
