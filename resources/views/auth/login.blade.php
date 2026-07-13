<x-layouts.app :title="'Masuk'">
    <div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-primary">Selamat Datang Kembali</h1>
                <p class="text-sm text-gray-500 mt-2">Masuk ke akun GHEVERHAN Anda</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <x-input name="email" label="Email" type="email" :required="true"
                         :error="$errors->first('email')" :value="old('email')" placeholder="nama@email.com" />

                <x-input name="password" label="Password" type="password" :required="true"
                         :error="$errors->first('password')" placeholder="••••••••" />

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary focus:ring-primary">
                        <span class="text-sm text-gray-600">Ingat saya</span>
                    </label>
                </div>

                <x-button variant="primary" size="lg" type="submit" fullWidth>
                    Masuk
                </x-button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-primary font-semibold hover:underline">Daftar sekarang</a>
            </p>
        </div>
    </div>
</x-layouts.app>
