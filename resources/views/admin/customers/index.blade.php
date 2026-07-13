@extends('admin.layouts.app')
@section('title', 'Kelola Pelanggan')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pelanggan</h1>
        <p class="text-sm text-gray-500">Daftar semua pelanggan terdaftar.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Search -->
    <div class="p-4 border-b border-gray-100 bg-gray-50">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex w-full max-w-md">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau telepon..." class="w-full border-gray-300 rounded-l-md shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
            <button type="submit" class="bg-gray-200 px-4 border border-l-0 border-gray-300 rounded-r-md hover:bg-gray-300 text-gray-700">Cari</button>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4">Nama Pelanggan</th>
                    <th class="px-6 py-4">Kontak</th>
                    <th class="px-6 py-4 text-center">Bergabung</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-500">
                            {{ substr($customer->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold">{{ $customer->name }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p>{{ $customer->email }}</p>
                        <p class="text-xs text-gray-400">{{ $customer->phone ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{ $customer->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.customers.show', $customer) }}" class="text-primary font-medium hover:underline">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada pelanggan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-gray-100">
        {{ $customers->links() }}
    </div>
</div>
@endsection
