<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::orderBy('sort_order')->get();
        return view('admin.payments.index', compact('paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code',
            'type' => 'required|in:bank_transfer,e_wallet,cod',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'account_number' => 'nullable|string|max:100',
            'account_name' => 'nullable|string|max:255',
            'logo' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'required|integer|min:0',
        ]);

        if (!isset($validated['is_active'])) $validated['is_active'] = false;

        PaymentMethod::create($validated);

        return redirect()->route('admin.payments.index')->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function update(Request $request, PaymentMethod $payment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code,' . $payment->id,
            'type' => 'required|in:bank_transfer,e_wallet,cod',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'account_number' => 'nullable|string|max:100',
            'account_name' => 'nullable|string|max:255',
            'logo' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'required|integer|min:0',
        ]);

        if (!isset($validated['is_active'])) $validated['is_active'] = false;

        $payment->update($validated);

        return redirect()->route('admin.payments.index')->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    public function destroy(PaymentMethod $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index')->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}
