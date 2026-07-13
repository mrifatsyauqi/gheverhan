@extends('admin.layouts.app')
@section('title', 'Metode Pembayaran')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Metode Pembayaran</h1>
        <p class="text-sm text-gray-500">Kelola rekening bank atau dompet digital untuk transfer manual.</p>
    </div>
    <button x-data @click="$dispatch('open-modal-add-payment')" class="px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg shadow hover:bg-black transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Metode
    </button>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-4">Metode</th>
                <th class="px-6 py-4">Tipe</th>
                <th class="px-6 py-4">Rekening</th>
                <th class="px-6 py-4 text-center">Status</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paymentMethods as $method)
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4 flex items-center gap-3">
                    @if($method->logo)
                        <img src="{{ $method->logo }}" class="h-8 object-contain" alt="Logo">
                    @endif
                    <div>
                        <p class="font-bold text-gray-900">{{ $method->name }}</p>
                    </div>
                </td>
                <td class="px-6 py-4 uppercase text-xs font-medium">{{ str_replace('_', ' ', $method->type) }}</td>
                <td class="px-6 py-4">
                    @if($method->type != 'cod')
                        <p class="font-mono text-gray-900 font-bold">{{ $method->account_number }}</p>
                        <p class="text-xs text-gray-500">a.n {{ $method->account_name }}</p>
                    @else
                        <p class="text-xs italic">Bayar di tempat</p>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    @if($method->is_active)
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Aktif</span>
                    @else
                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">Nonaktif</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button x-data @click="$dispatch('open-modal-edit-payment', {{ json_encode($method) }})" class="text-blue-600 hover:text-blue-900 p-1">Edit</button>
                        <form action="{{ route('admin.payments.destroy', $method) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
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
<x-modal name="add-payment" title="Tambah Metode Pembayaran">
    <form action="{{ route('admin.payments.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <x-input name="name" label="Nama Bank / E-Wallet (Misal: Bank BCA)" required />
            <div class="grid grid-cols-2 gap-4">
                <x-input name="code" label="Kode Unik (Misal: bca)" required />
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                    <select name="type" class="w-full border-gray-300 rounded-md">
                        <option value="bank_transfer">Transfer Bank</option>
                        <option value="e_wallet">E-Wallet</option>
                        <option value="cod">Cash on Delivery (COD)</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <x-input name="account_number" label="Nomor Rekening" />
                <x-input name="account_name" label="Atas Nama" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Instruksi Pembayaran</label>
                <textarea name="instructions" rows="2" placeholder="Cara bayar..." class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>
            
            <x-input name="logo" label="URL Logo Bank (Opsional)" />
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

<div x-data="{ form: {} }" @open-modal-edit-payment.window="form = $event.detail; $dispatch('open-modal-edit-payment-modal')">
    <x-modal name="edit-payment-modal" title="Edit Metode Pembayaran">
        <form :action="`/admin/payments/${form.id}`" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <x-input name="name" label="Nama" x-model="form.name" required />
                <div class="grid grid-cols-2 gap-4">
                    <x-input name="code" label="Kode" x-model="form.code" required />
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                        <select name="type" x-model="form.type" class="w-full border-gray-300 rounded-md">
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="e_wallet">E-Wallet</option>
                            <option value="cod">COD</option>
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <x-input name="account_number" label="Nomor Rekening" x-model="form.account_number" />
                    <x-input name="account_name" label="Atas Nama" x-model="form.account_name" />
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instruksi Pembayaran</label>
                    <textarea name="instructions" x-model="form.instructions" rows="2" class="w-full border-gray-300 rounded-md"></textarea>
                </div>
                
                <x-input name="logo" label="URL Logo Bank" x-model="form.logo" />
                <x-input name="sort_order" type="number" label="Urutan" x-model="form.sort_order" />
                
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
