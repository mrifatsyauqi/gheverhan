@extends('admin.layouts.app')
@section('title', 'Kelola Kategori')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kelola Kategori</h1>
        <p class="text-sm text-gray-500">Kategori produk toko Anda.</p>
    </div>
    <button x-data @click="$dispatch('open-modal-add-category')" class="px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg shadow hover:bg-black transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Kategori
    </button>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Jumlah Produk</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-3">
                        @if($category->image)
                            <img src="{{ $category->image }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200" alt="{{ $category->name }}">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div>
                            <p class="font-bold">{{ $category->name }}</p>
                            <p class="text-xs text-gray-500">/category/{{ $category->slug }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">{{ $category->products_count }} produk</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button 
                                x-data 
                                @click="$dispatch('open-modal-edit-category', { 
                                    id: {{ $category->id }}, 
                                    name: '{{ addslashes($category->name) }}', 
                                    description: '{{ addslashes($category->description) }}', 
                                    image: '{{ addslashes($category->image) }}' 
                                })" 
                                class="text-blue-600 hover:text-blue-900 p-1">Edit</button>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 p-1" {{ $category->products_count > 0 ? 'disabled class=opacity-50 cursor-not-allowed' : '' }}>Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<x-modal name="add-category" title="Tambah Kategori">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <x-input name="name" label="Nama Kategori" required />
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"></textarea>
            </div>
            <x-input name="image" label="URL Gambar (Opsional)" />
            
            <div class="flex justify-end pt-4">
                <x-button variant="primary" type="submit">Simpan Kategori</x-button>
            </div>
        </div>
    </form>
</x-modal>

<!-- Modal Edit -->
<div x-data="{ id: '', name: '', description: '', image: '' }" @open-modal-edit-category.window="id = $event.detail.id; name = $event.detail.name; description = $event.detail.description; image = $event.detail.image; $dispatch('open-modal-edit-category-modal')">
    <x-modal name="edit-category-modal" title="Edit Kategori">
        <form :action="`/admin/categories/${id}`" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" name="name" x-model="name" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" x-model="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL Gambar</label>
                    <input type="text" name="image" x-model="image" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                </div>
                
                <div class="flex justify-end pt-4">
                    <x-button variant="primary" type="submit">Perbarui Kategori</x-button>
                </div>
            </div>
        </form>
    </x-modal>
</div>
@endsection
