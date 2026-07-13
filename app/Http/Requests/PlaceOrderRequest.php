<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address_id' => ['required', 'integer', 'exists:addresses,id'],
            'shipping_method' => ['required', 'string', 'in:jne,jnt,sicepat'],
            'payment_method' => ['required', 'string', 'in:bank_transfer,ewallet,cod'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'address_id.required' => 'Alamat pengiriman harus dipilih.',
            'address_id.exists' => 'Alamat tidak ditemukan.',
            'shipping_method.required' => 'Metode pengiriman harus dipilih.',
            'shipping_method.in' => 'Metode pengiriman tidak valid.',
            'payment_method.required' => 'Metode pembayaran harus dipilih.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',
        ];
    }
}
