@extends('admin.layouts.app')
@section('title', 'Profil Pelanggan')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.customers.index') }}" class="text-sm font-medium text-gray-500 hover:text-primary mb-2 inline-flex items-center gap-1">
        &larr; Kembali ke Daftar Pelanggan
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Profil Pelanggan</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Info -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
            <div class="w-24 h-24 mx-auto rounded-full bg-primary flex items-center justify-center font-bold text-3xl text-white mb-4 shadow-lg">
                {{ substr($customer->name, 0, 1) }}
            </div>
            <h2 class="text-xl font-bold text-gray-900">{{ $customer->name }}</h2>
            <p class="text-sm text-gray-500 mb-4">Bergabung sejak {{ $customer->created_at->format('M Y') }}</p>
            
            <div class="space-y-3 text-sm text-left border-t border-gray-100 pt-4 mt-4">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <a href="mailto:{{ $customer->email }}" class="text-primary hover:underline">{{ $customer->email }}</a>
                </div>
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <span class="text-gray-700">{{ $customer->phone ?? 'Belum ada nomor HP' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Pesanan -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Riwayat Pesanan ({{ $customer->orders->count() }})</h3>
            
            <div class="space-y-4">
                @forelse($customer->orders as $order)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-lg border border-gray-100 hover:bg-gray-50 transition gap-4">
                    <div>
                        <a href="{{ route('admin.orders.show', $order) }}" class="font-bold text-primary hover:underline block">{{ $order->order_number }}</a>
                        <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="font-bold text-gray-900 mb-1">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $order->status_color }}">
                            {{ $order->status_label }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-sm italic text-center py-4">Belum ada riwayat pesanan.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
