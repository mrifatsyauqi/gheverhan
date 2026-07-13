@extends('admin.layouts.app')
@section('title', 'Kelola Produk')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kelola Produk</h1>
        <p class="text-sm text-gray-500">Tambah, edit, atau hapus produk toko Anda.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg shadow hover:bg-black transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Produk
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Search & Filter -->
    <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex w-full max-w-md">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau SKU..." class="w-full border-gray-300 rounded-l-md shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
            <button type="submit" class="bg-gray-200 px-4 border border-l-0 border-gray-300 rounded-r-md hover:bg-gray-300 text-gray-700">Cari</button>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4">Produk</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4 text-center">Stok</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-3">
                        <img src="{{ $product->primary_image }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200" alt="{{ $product->name }}">
                        <div>
                            <p class="font-bold">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500">SKU: {{ $product->sku ?? '-' }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $product->category->name }}</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-900">{{ $product->formatted_price }}</p>
                        @if($product->compare_price)
                            <p class="text-xs text-gray-400 line-through">{{ $product->formatted_compare_price }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($product->is_active)
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Aktif</span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">Draft</span>
                        @endif
                        @if($product->is_featured)
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium ml-1">Featured</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900 p-1">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 p-1">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada produk ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="p-4 border-t border-gray-100">
        {{ $products->links() }}
    </div>
</div>
@endsection
