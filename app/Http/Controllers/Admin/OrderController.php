<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        $orders = $query->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'address', 'statusHistories']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,refunded',
            'notes' => 'nullable|string',
            'tracking_number' => 'nullable|string|required_if:status,shipped',
        ]);

        $order->status = $validated['status'];
        
        if ($validated['status'] === 'shipped') {
            $order->tracking_number = $validated['tracking_number'];
            $order->shipped_at = now();
        } elseif ($validated['status'] === 'delivered') {
            $order->delivered_at = now();
        }

        $order->save();

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'status' => $validated['status'],
            'description' => $validated['notes'] ?? 'Status diupdate oleh Admin',
            'changed_at' => now(),
        ]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
