<x-layouts.app :title="'Daftar'">
    <div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-primary">Buat Akun Baru</h1>
                <p class="text-sm text-gray-500 mt-2">Bergabung dengan GHEVERHAN</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <x-input name="name" label="Nama Lengkap" :required="true"
                         :error="$errors->first('name')" :value="old('name')" placeholder="John Doe" />

                <x-input name="email" label="Email" type="email" :required="true"
                         :error="$errors->first('email')" :value="old('email')" placeholder="nama@email.com" />

                <x-input name="password" label="Password" type="password" :required="true"
                         :error="$errors->first('password')" placeholder="Minimal 8 karakter" />

                <x-input name="password_confirmation" label="Konfirmasi Password" type="password" :required="true"
                         placeholder="Ulangi password" />

                <x-button variant="primary" size="lg" type="submit" fullWidth>
                    Daftar
                </x-button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">Masuk</a>
            </p>
        </div>
    </div>
</x-layouts.app>
