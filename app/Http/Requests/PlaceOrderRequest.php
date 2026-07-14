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
            'address_id' => [
                'required', 
                'integer', 
                \Illuminate\Validation\Rule::exists('addresses', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                })
            ],
            'shipping_method' => ['required', 'string', \Illuminate\Validation\Rule::exists('shipping_methods', 'code')],
            'payment_method' => ['required', 'string', \Illuminate\Validation\Rule::exists('payment_methods', 'code')],
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
