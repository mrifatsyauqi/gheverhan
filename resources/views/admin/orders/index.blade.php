@extends('admin.layouts.app')
@section('title', 'Kelola Pesanan')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pesanan</h1>
        <p class="text-sm text-gray-500">Kelola dan pantau pesanan pelanggan.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Filter -->
    <div class="p-4 border-b border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-between gap-4">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-1 max-w-md">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Pesanan atau Nama..." class="w-full border-gray-300 rounded-l-md shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
            <button type="submit" class="bg-gray-200 px-4 border border-l-0 border-gray-300 rounded-r-md hover:bg-gray-300 text-gray-700">Cari</button>
        </form>

        <div class="flex gap-2 overflow-x-auto pb-2 sm:pb-0">
            <a href="{{ route('admin.orders.index') }}" class="px-3 py-1.5 rounded-full text-xs font-medium whitespace-nowrap {{ !request('status') ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Semua</a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-3 py-1.5 rounded-full text-xs font-medium whitespace-nowrap {{ request('status') == 'pending' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Baru</a>
            <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="px-3 py-1.5 rounded-full text-xs font-medium whitespace-nowrap {{ request('status') == 'processing' ? 'bg-yellow-500 text-white' : 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100' }}">Diproses</a>
            <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="px-3 py-1.5 rounded-full text-xs font-medium whitespace-nowrap {{ request('status') == 'shipped' ? 'bg-blue-500 text-white' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }}">Dikirim</a>
            <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="px-3 py-1.5 rounded-full text-xs font-medium whitespace-nowrap {{ request('status') == 'delivered' ? 'bg-green-500 text-white' : 'bg-green-50 text-green-700 hover:bg-green-100' }}">Selesai</a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4">Pesanan</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4 text-center">Tanggal</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-bold text-gray-900">
                        {{ $order->order_number }}
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                    </td>
                    <td class="px-6 py-4 text-center text-xs">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $order->status_color }}">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-primary font-medium hover:underline">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada pesanan ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="p-4 border-t border-gray-100">
        {{ $orders->links() }}
    </div>
</div>
@endsection
