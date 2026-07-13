<x-profile.layout title="Profil Saya">
    <div>
        <h2 class="text-xl font-bold text-primary mb-6">Profil Saya</h2>

        <!-- Avatar Section -->
        <div class="mb-8 flex items-center gap-6">
            <div class="shrink-0">
                <img class="h-24 w-24 object-cover rounded-full border border-gray-200" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" />
            </div>
            
            <div class="flex flex-col gap-2">
                <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-4">
                    @csrf
                    <div>
                        <input type="file" name="avatar" id="avatar" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-primary file:text-white
                            hover:file:bg-primary-hover
                            cursor-pointer" accept="image/jpeg,image/png,image/webp" required />
                        @error('avatar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <x-button variant="primary" type="submit" class="!py-2">Unggah</x-button>
                </form>

                @if($user->avatar)
                <form action="{{ route('profile.avatar.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:text-red-700 underline">
                        Hapus Avatar
                    </button>
                </form>
                @endif
            </div>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6 max-w-lg">
            @csrf
            @method('PUT')

            <x-input name="name" label="Nama Lengkap" :required="true"
                     :error="$errors->first('name')"
                     :value="old('name', $user->name)" />

            <x-input name="email" label="Email" type="email" :required="true"
                     :value="$user->email" disabled
                     hint="Email tidak dapat diubah." />

            <x-input name="phone" label="No. Telepon" type="tel" placeholder="08xxxxxxxxxx"
                     :error="$errors->first('phone')"
                     :value="old('phone', $user->phone)" />

            <x-button variant="primary" type="submit">
                Simpan Perubahan
            </x-button>
        </form>
    </div>

    <div class="mt-12 pt-8 border-t border-gray-200">
        <h2 class="text-xl font-bold text-primary mb-6">Keamanan Akun</h2>
        
        <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-6 max-w-lg">
            @csrf
            @method('PUT')

            <x-input name="current_password" type="password" label="Password Saat Ini" :required="true"
                     :error="$errors->first('current_password')" />

            <x-input name="password" type="password" label="Password Baru" :required="true"
                     :error="$errors->first('password')"
                     hint="Minimal 8 karakter." />

            <x-input name="password_confirmation" type="password" label="Konfirmasi Password Baru" :required="true"
                     :error="$errors->first('password_confirmation')" />

            <x-button variant="primary" type="submit">
                Ganti Password
            </x-button>
        </form>
    </div>
</x-profile.layout>
