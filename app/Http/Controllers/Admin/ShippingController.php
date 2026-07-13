<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        $shippingMethods = ShippingMethod::orderBy('sort_order')->get();
        return view('admin.shipping.index', compact('shippingMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:shipping_methods,code',
            'description' => 'nullable|string',
            'base_cost' => 'required|integer|min:0',
            'estimated_days' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'required|integer|min:0',
        ]);

        if (!isset($validated['is_active'])) $validated['is_active'] = false;

        ShippingMethod::create($validated);

        return redirect()->route('admin.shipping.index')->with('success', 'Metode pengiriman berhasil ditambahkan.');
    }

    public function update(Request $request, ShippingMethod $shipping)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:shipping_methods,code,' . $shipping->id,
            'description' => 'nullable|string',
            'base_cost' => 'required|integer|min:0',
            'estimated_days' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'required|integer|min:0',
        ]);

        if (!isset($validated['is_active'])) $validated['is_active'] = false;

        $shipping->update($validated);

        return redirect()->route('admin.shipping.index')->with('success', 'Metode pengiriman berhasil diperbarui.');
    }

    public function destroy(ShippingMethod $shipping)
    {
        $shipping->delete();
        return redirect()->route('admin.shipping.index')->with('success', 'Metode pengiriman berhasil dihapus.');
    }
}
