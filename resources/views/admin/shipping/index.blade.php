@extends('admin.layouts.app')
@section('title', 'Metode Pengiriman')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Metode Pengiriman</h1>
        <p class="text-sm text-gray-500">Kelola opsi kurir dan ongkos kirim (sementara tarif flat).</p>
    </div>
    <button x-data @click="$dispatch('open-modal-add-shipping')" class="px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg shadow hover:bg-black transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Kurir
    </button>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-4">Kurir</th>
                <th class="px-6 py-4">Tarif (Flat)</th>
                <th class="px-6 py-4">Estimasi</th>
                <th class="px-6 py-4 text-center">Status</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shippingMethods as $method)
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4">
                    <p class="font-bold text-gray-900">{{ $method->name }}</p>
                    <p class="text-xs text-gray-500">Kode: {{ strtoupper($method->code) }}</p>
                </td>
                <td class="px-6 py-4 font-medium text-gray-900">{{ $method->formatted_cost }}</td>
                <td class="px-6 py-4">{{ $method->estimated_days ?? '-' }}</td>
                <td class="px-6 py-4 text-center">
                    @if($method->is_active)
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Aktif</span>
                    @else
                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">Nonaktif</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button x-data @click="$dispatch('open-modal-edit-shipping', {{ json_encode($method) }})" class="text-blue-600 hover:text-blue-900 p-1">Edit</button>
                        <form action="{{ route('admin.shipping.destroy', $method) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 p-1">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modals -->
<x-modal name="add-shipping" title="Tambah Kurir">
    <form action="{{ route('admin.shipping.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <x-input name="name" label="Nama Kurir (Misal: JNE Reguler)" required />
            <x-input name="code" label="Kode Unik (Misal: jne_reg)" required />
            <x-input name="base_cost" type="number" label="Tarif Ongkir Flat (Rp)" required />
            <x-input name="estimated_days" label="Estimasi Sampai (Misal: 2-3 hari)" />
            <x-input name="sort_order" type="number" label="Urutan Tampil" value="0" />
            
            <label class="flex items-center gap-2 cursor-pointer pt-2">
                <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-primary">
                <span class="text-sm font-medium text-gray-700">Aktif</span>
            </label>
            
            <div class="flex justify-end pt-4">
                <x-button variant="primary" type="submit">Simpan</x-button>
            </div>
        </div>
    </form>
</x-modal>

<div x-data="{ form: {} }" @open-modal-edit-shipping.window="form = $event.detail; $dispatch('open-modal-edit-shipping-modal')">
    <x-modal name="edit-shipping-modal" title="Edit Kurir">
        <form :action="`/admin/shipping/${form.id}`" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div><label class="block text-sm">Nama</label><input type="text" name="name" x-model="form.name" required class="w-full border-gray-300 rounded-md"></div>
                <div><label class="block text-sm">Kode</label><input type="text" name="code" x-model="form.code" required class="w-full border-gray-300 rounded-md bg-gray-100"></div>
                <div><label class="block text-sm">Tarif Flat (Rp)</label><input type="number" name="base_cost" x-model="form.base_cost" required class="w-full border-gray-300 rounded-md"></div>
                <div><label class="block text-sm">Estimasi</label><input type="text" name="estimated_days" x-model="form.estimated_days" class="w-full border-gray-300 rounded-md"></div>
                <div><label class="block text-sm">Urutan</label><input type="number" name="sort_order" x-model="form.sort_order" class="w-full border-gray-300 rounded-md"></div>
                
                <label class="flex items-center gap-2 cursor-pointer pt-2">
                    <input type="checkbox" name="is_active" value="1" :checked="form.is_active" class="rounded border-gray-300 text-primary">
                    <span class="text-sm font-medium text-gray-700">Aktif</span>
                </label>
                
                <div class="flex justify-end pt-4">
                    <x-button variant="primary" type="submit">Perbarui</x-button>
                </div>
            </div>
        </form>
    </x-modal>
</div>
@endsection
