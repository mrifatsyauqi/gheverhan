@extends('admin.layouts.app')
@section('title', 'Detail Pesanan')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-gray-500 hover:text-primary mb-2 inline-flex items-center gap-1">
        &larr; Kembali ke Daftar Pesanan
    </a>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pesanan {{ $order->order_number }}</h1>
            <p class="text-sm text-gray-500">{{ $order->created_at->format('d F Y, H:i') }}</p>
        </div>
        <div>
            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $order->status_color }}">
                Status: {{ $order->status_label }}
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Items & Timeline -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Order Items -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Item Pesanan</h2>
            
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex gap-4 items-center pb-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                    <img src="{{ $item->product->primary_image }}" alt="{{ $item->product_name }}" class="w-16 h-16 object-cover rounded-md border border-gray-200">
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900">{{ $item->product_name }}</h3>
                        @if($item->variant_attributes)
                            <p class="text-xs text-gray-500 mt-1">
                                @foreach(json_decode($item->variant_attributes, true) as $key => $val)
                                    {{ ucfirst($key) }}: {{ $val }}
                                @endforeach
                            </p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">{{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        <p class="font-bold text-gray-900 mt-1">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-6 border-t border-gray-100 pt-4 space-y-2 text-sm">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span>{{ $order->formatted_subtotal }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Ongkos Kirim ({{ $order->shipping_method }})</span>
                    <span>{{ $order->formatted_shipping_cost }}</span>
                </div>
                @if($order->discount > 0)
                <div class="flex justify-between text-green-600">
                    <span>Diskon</span>
                    <span>- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t border-gray-100 mt-2">
                    <span>Total</span>
                    <span>{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>
        
        <!-- Status Update -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Update Status Pesanan</h2>
            
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ubah Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" onchange="document.getElementById('resi-container').style.display = (this.value == 'shipped') ? 'block' : 'none'">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses/Dikemas</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Selesai / Diterima</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Refund</option>
                        </select>
                    </div>
                    <div id="resi-container" style="display: {{ $order->status == 'shipped' ? 'block' : 'none' }}">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Resi (Jika Dikirim)</label>
                        <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Internal (Opsional)</label>
                    <textarea name="notes" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"></textarea>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-primary text-white font-medium rounded-lg hover:bg-black">Simpan Perubahan</button>
                </div>
            </form>
        </div>

    </div>

    <!-- Right Column: Customer & Shipping Info -->
    <div class="space-y-6">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">Pelanggan</h2>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-500">
                    {{ substr($order->user->name, 0, 1) }}
                </div>
                <div>
                    <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                    <a href="mailto:{{ $order->user->email }}" class="text-sm text-primary hover:underline">{{ $order->user->email }}</a>
                </div>
            </div>
            <a href="{{ route('admin.customers.show', $order->user) }}" class="text-sm font-medium text-gray-500 hover:text-primary">Lihat Profil Pelanggan &rarr;</a>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">Alamat Pengiriman</h2>
            @php
                $address = json_decode($order->shipping_address_snapshot);
            @endphp
            <p class="font-medium text-gray-900 mb-1">{{ $address->recipient_name }}</p>
            <p class="text-sm text-gray-600 mb-2">{{ $address->phone }}</p>
            <p class="text-sm text-gray-600 leading-relaxed">
                {{ $address->street_address }}<br>
                {{ $address->district }}, {{ $address->city }}<br>
                {{ $address->province }} {{ $address->postal_code }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">Pembayaran</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Metode</span>
                    <span class="font-medium text-gray-900 uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="font-medium {{ $order->payment_status == 'paid' ? 'text-green-600' : 'text-yellow-600' }} uppercase">{{ $order->payment_status }}</span>
                </div>
                @if($order->paid_at)
                <div class="flex justify-between">
                    <span class="text-gray-500">Dibayar Pada</span>
                    <span class="text-gray-900">{{ $order->paid_at->format('d M Y, H:i') }}</span>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
