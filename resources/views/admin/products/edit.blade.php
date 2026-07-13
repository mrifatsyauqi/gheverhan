@extends('admin.layouts.app')
@section('title', 'Edit Produk')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-gray-500 hover:text-primary mb-2 inline-flex items-center gap-1">
        &larr; Kembali ke Daftar Produk
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Edit Produk: {{ $product->name }}</h1>
</div>

<form action="{{ route('admin.products.update', $product) }}" method="POST">
    @csrf
    @method('PUT')
    
    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Informasi Dasar</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="5" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Harga & Inventaris</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Coret (Opsional)</label>
                        <input type="number" name="compare_price" value="{{ old('compare_price', $product->compare_price) }}" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Berat (gram) <span class="text-red-500">*</span></label>
                        <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" required min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Organisasi</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="text-sm font-medium text-gray-700">Tampilkan Produk (Aktif)</span>
                        </label>
                    </div>
                    
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="text-sm font-medium text-gray-700">Jadikan Produk Unggulan</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" x-data="{ images: {{ json_encode(old('images', $product->images ?? [''])) }} }">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Gambar Produk</h2>
                
                <p class="text-xs text-gray-500 mb-4">Masukkan URL gambar.</p>
                
                <template x-for="(img, index) in images" :key="index">
                    <div class="flex gap-2 mb-2">
                        <input type="text" :name="`images[${index}]`" x-model="images[index]" required placeholder="https://..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary text-sm">
                        <button type="button" @click="images.splice(index, 1)" x-show="images.length > 1" class="px-3 bg-red-100 text-red-600 rounded-md hover:bg-red-200">X</button>
                    </div>
                </template>
                
                <button type="button" @click="images.push('')" class="mt-2 text-sm text-primary font-medium hover:underline">+ Tambah URL Gambar</button>
            </div>
            
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                <button type="submit" class="w-full bg-primary text-white font-bold py-3 px-4 rounded-lg shadow-md hover:bg-black transition-colors">
                    Perbarui Produk
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
