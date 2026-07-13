<x-layouts.app :title="'Checkout - Alamat Pengiriman'">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Checkout Steps --}}
        <div class="flex items-center justify-center mb-10">
            <div class="flex items-center gap-2 sm:gap-4 text-sm">
                <span class="flex items-center gap-1.5 font-semibold text-primary">
                    <span class="w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                    <span class="hidden sm:inline">Alamat</span>
                </span>
                <div class="w-8 sm:w-16 h-px bg-gray-300"></div>
                <span class="flex items-center gap-1.5 text-gray-400">
                    <span class="w-6 h-6 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center text-xs font-bold">2</span>
                    <span class="hidden sm:inline">Pengiriman</span>
                </span>
                <div class="w-8 sm:w-16 h-px bg-gray-300"></div>
                <span class="flex items-center gap-1.5 text-gray-400">
                    <span class="w-6 h-6 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center text-xs font-bold">3</span>
                    <span class="hidden sm:inline">Pembayaran</span>
                </span>
            </div>
        </div>

        <h1 class="text-2xl font-bold text-primary mb-6">Pilih Alamat Pengiriman</h1>

        {{-- Address List --}}
        <form action="{{ route('checkout.shipping') }}" method="GET">
            <div class="space-y-3 mb-6">
                @forelse($addresses as $address)
                    <label class="flex items-start gap-4 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-primary hover:shadow-card transition-all duration-200 has-[:checked]:border-primary has-[:checked]:bg-surface/50">
                        <input type="radio" name="address_id" value="{{ $address->id }}"
                               {{ $address->is_default ? 'checked' : '' }}
                               class="mt-1 text-primary focus:ring-primary">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-semibold text-primary">{{ $address->label }}</span>
                                @if($address->is_default)
                                    <x-badge variant="primary" text="Utama" />
                                @endif
                            </div>
                            <p class="text-sm font-medium text-primary">{{ $address->recipient_name }}</p>
                            <p class="text-sm text-gray-500">{{ $address->phone }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $address->formatted_address }}</p>
                        </div>
                    </label>
                @empty
                    <div class="text-center py-8 bg-surface rounded-xl">
                        <p class="text-gray-500 mb-4">Belum ada alamat tersimpan.</p>
                    </div>
                @endforelse
            </div>

            {{-- Add New Address --}}
            <button type="button" @click="$dispatch('open-modal-add-address')"
                    class="flex items-center gap-2 text-sm font-medium text-primary hover:underline mb-8">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                Tambah Alamat Baru
            </button>

            @if($addresses->count())
                <x-button variant="primary" size="lg" type="submit" fullWidth>
                    Lanjut Pilih Pengiriman
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </x-button>
            @endif
        </form>
    </div>

    {{-- Add Address Modal --}}
    <x-modal name="add-address" title="Tambah Alamat Baru" maxWidth="lg">
        <form action="{{ route('checkout.address.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <x-input name="label" label="Label" placeholder="Rumah, Kantor..." :required="true" :error="$errors->first('label')" value="{{ old('label') }}" />
                <x-input name="recipient_name" label="Nama Penerima" :required="true" :error="$errors->first('recipient_name')" value="{{ old('recipient_name') }}" />
            </div>
            <x-input name="phone" label="No. Telepon" type="tel" placeholder="08xxxxxxxxxx" :required="true" :error="$errors->first('phone')" value="{{ old('phone') }}" />
            <div class="grid grid-cols-2 gap-4">
                <x-input name="province" label="Provinsi" :required="true" :error="$errors->first('province')" value="{{ old('province') }}" />
                <x-input name="city" label="Kota/Kabupaten" :required="true" :error="$errors->first('city')" value="{{ old('city') }}" />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <x-input name="district" label="Kecamatan" :required="true" :error="$errors->first('district')" value="{{ old('district') }}" />
                <x-input name="postal_code" label="Kode Pos" :required="true" :error="$errors->first('postal_code')" value="{{ old('postal_code') }}" />
            </div>
            <div>
                <label for="full_address" class="block text-sm font-medium text-primary mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                <textarea name="full_address" id="full_address" rows="3" required
                    class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-primary placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/10">{{ old('full_address') }}</textarea>
                @error('full_address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <x-button variant="primary" type="submit" fullWidth>Simpan Alamat</x-button>
        </form>
    </x-modal>
</x-layouts.app>
