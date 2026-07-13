<x-profile.layout title="Alamat Saya">
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-primary">Alamat Saya</h2>
            <x-button variant="primary" size="sm" x-data @click="$dispatch('open-modal-add-address')">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Tambah
            </x-button>
        </div>

        @if($addresses->isEmpty())
            <div class="text-center py-12 bg-surface rounded-xl">
                <p class="text-gray-500">Belum ada alamat tersimpan.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($addresses as $address)
                    <div class="p-4 border border-gray-100 rounded-xl hover:shadow-card transition-all duration-200">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-primary">{{ $address->label }}</span>
                                @if($address->is_default)
                                    <x-badge variant="primary" text="Utama" />
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                @unless($address->is_default)
                                    <form action="{{ route('addresses.setDefault', $address->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-xs text-primary hover:underline">Jadikan Utama</button>
                                    </form>
                                @endunless
                                <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Hapus alamat ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-primary">{{ $address->recipient_name }}</p>
                        <p class="text-sm text-gray-500">{{ $address->phone }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $address->formatted_address }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Add Address Modal --}}
    <x-modal name="add-address" title="Tambah Alamat Baru" maxWidth="lg">
        <form action="{{ route('addresses.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <x-input name="label" label="Label" placeholder="Rumah, Kantor..." :required="true" value="{{ old('label') }}" />
                <x-input name="recipient_name" label="Nama Penerima" :required="true" value="{{ old('recipient_name') }}" />
            </div>
            <x-input name="phone" label="No. Telepon" type="tel" placeholder="08xxxxxxxxxx" :required="true" value="{{ old('phone') }}" />
            <div class="grid grid-cols-2 gap-4">
                <x-input name="province" label="Provinsi" :required="true" value="{{ old('province') }}" />
                <x-input name="city" label="Kota/Kabupaten" :required="true" value="{{ old('city') }}" />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <x-input name="district" label="Kecamatan" :required="true" value="{{ old('district') }}" />
                <x-input name="postal_code" label="Kode Pos" :required="true" value="{{ old('postal_code') }}" />
            </div>
            <div>
                <label for="full_address" class="block text-sm font-medium text-primary mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                <textarea name="full_address" id="full_address" rows="3" required
                    class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-primary placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/10">{{ old('full_address') }}</textarea>
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_default" value="1" class="rounded border-gray-300 text-primary focus:ring-primary">
                <span class="text-sm text-gray-600">Jadikan alamat utama</span>
            </label>
            <x-button variant="primary" type="submit" fullWidth>Simpan Alamat</x-button>
        </form>
    </x-modal>
</x-profile.layout>
