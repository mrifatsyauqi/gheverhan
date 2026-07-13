@extends('admin.layouts.app')
@section('title', 'Visual Toko / Banner')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Visual Toko (Banner)</h1>
        <p class="text-sm text-gray-500">Atur banner di halaman depan, promo, dan lainnya.</p>
    </div>
    <button x-data @click="$dispatch('open-modal-add-banner')" class="px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg shadow hover:bg-black transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Banner
    </button>
</div>

<!-- Hero Banners -->
<h2 class="text-lg font-bold text-gray-900 mb-4 mt-8">Hero Banners (Halaman Depan Utama)</h2>
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @foreach($banners->where('position', 'hero') as $banner)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group">
        <div class="relative h-48 w-full bg-gray-200">
            <img src="{{ $banner->image }}" class="w-full h-full object-cover" alt="Banner">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity gap-2">
                <button x-data @click="$dispatch('open-modal-edit-banner', {{ json_encode($banner) }})" class="px-3 py-1.5 bg-white text-gray-900 rounded shadow text-sm font-medium hover:bg-gray-100">Edit</button>
                <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 bg-red-600 text-white rounded shadow text-sm font-medium hover:bg-red-700">Hapus</button>
                </form>
            </div>
            @if(!$banner->is_active)
                <div class="absolute top-2 right-2 px-2 py-1 bg-red-600 text-white text-xs font-bold rounded">TIDAK AKTIF</div>
            @endif
            <div class="absolute top-2 left-2 px-2 py-1 bg-primary text-white text-xs font-bold rounded">Urutan: {{ $banner->sort_order }}</div>
        </div>
        <div class="p-4">
            <h3 class="font-bold text-gray-900 truncate">{{ $banner->title ?? '(Tanpa Judul)' }}</h3>
            <p class="text-sm text-gray-500 truncate">{{ $banner->subtitle ?? '-' }}</p>
            @if($banner->link_url)
                <a href="{{ $banner->link_url }}" target="_blank" class="text-xs text-primary hover:underline mt-2 inline-block">Lihat Tautan &rarr;</a>
            @endif
        </div>
    </div>
    @endforeach
</div>

<!-- Promo Banners -->
<h2 class="text-lg font-bold text-gray-900 mb-4 mt-12">Promo Banners</h2>
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
    @foreach($banners->where('position', 'promo') as $banner)
    <!-- (struktur card sama dengan hero) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group">
        <div class="relative h-32 w-full bg-gray-200">
            <img src="{{ $banner->image }}" class="w-full h-full object-cover" alt="Banner">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity gap-2">
                <button x-data @click="$dispatch('open-modal-edit-banner', {{ json_encode($banner) }})" class="px-3 py-1.5 bg-white text-gray-900 rounded shadow text-sm font-medium">Edit</button>
                <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 bg-red-600 text-white rounded shadow text-sm font-medium">Hapus</button>
                </form>
            </div>
            @if(!$banner->is_active)
                <div class="absolute top-2 right-2 px-2 py-1 bg-red-600 text-white text-xs font-bold rounded">TIDAK AKTIF</div>
            @endif
        </div>
        <div class="p-4">
            <h3 class="font-bold text-gray-900 truncate text-sm">{{ $banner->title ?? '(Tanpa Judul)' }}</h3>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal Tambah -->
<x-modal name="add-banner" title="Tambah Banner">
    <form action="{{ route('admin.banners.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <x-input name="title" label="Judul Utama" />
            <x-input name="subtitle" label="Sub Judul" />
            <x-input name="image" label="URL Gambar (Penting)" required />
            <x-input name="link_url" label="Tautan / Link (Opsional)" />
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Posisi</label>
                    <select name="position" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                        <option value="hero">Hero (Utama)</option>
                        <option value="promo">Promo</option>
                        <option value="footer">Footer</option>
                    </select>
                </div>
                <x-input name="sort_order" type="number" label="Urutan" value="0" />
            </div>

            <label class="flex items-center gap-2 cursor-pointer pt-2">
                <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-primary focus:ring-primary">
                <span class="text-sm font-medium text-gray-700">Tampilkan Banner (Aktif)</span>
            </label>
            
            <div class="flex justify-end pt-4">
                <x-button variant="primary" type="submit">Simpan Banner</x-button>
            </div>
        </div>
    </form>
</x-modal>

<!-- Modal Edit (simplified alpinejs binding) -->
<div x-data="{ 
    banner: { id:'', title:'', subtitle:'', image:'', link_url:'', position:'hero', sort_order:0, is_active:1 } 
}" @open-modal-edit-banner.window="banner = $event.detail; $dispatch('open-modal-edit-banner-modal')">
    <x-modal name="edit-banner-modal" title="Edit Banner">
        <form :action="`/admin/banners/${banner.id}`" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div><label class="block text-sm">Judul</label><input type="text" name="title" x-model="banner.title" class="w-full border-gray-300 rounded-md"></div>
                <div><label class="block text-sm">Sub Judul</label><input type="text" name="subtitle" x-model="banner.subtitle" class="w-full border-gray-300 rounded-md"></div>
                <div><label class="block text-sm">URL Gambar</label><input type="text" name="image" x-model="banner.image" required class="w-full border-gray-300 rounded-md"></div>
                <div><label class="block text-sm">Tautan</label><input type="text" name="link_url" x-model="banner.link_url" class="w-full border-gray-300 rounded-md"></div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm">Posisi</label>
                        <select name="position" x-model="banner.position" class="w-full border-gray-300 rounded-md">
                            <option value="hero">Hero (Utama)</option>
                            <option value="promo">Promo</option>
                            <option value="footer">Footer</option>
                        </select>
                    </div>
                    <div><label class="block text-sm">Urutan</label><input type="number" name="sort_order" x-model="banner.sort_order" class="w-full border-gray-300 rounded-md"></div>
                </div>

                <label class="flex items-center gap-2 cursor-pointer pt-2">
                    <input type="checkbox" name="is_active" value="1" :checked="banner.is_active" class="rounded border-gray-300 text-primary">
                    <span class="text-sm font-medium text-gray-700">Aktif</span>
                </label>
                
                <div class="flex justify-end pt-4">
                    <x-button variant="primary" type="submit">Perbarui Banner</x-button>
                </div>
            </div>
        </form>
    </x-modal>
</div>
@endsection
