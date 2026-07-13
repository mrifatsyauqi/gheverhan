<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'label' => ['required', 'string', 'max:50'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^(\+62|62|0)[0-9]{8,13}$/'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'full_address' => ['required', 'string', 'max:500'],
            'is_default' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'label.required' => 'Label alamat harus diisi.',
            'recipient_name.required' => 'Nama penerima harus diisi.',
            'phone.required' => 'Nomor telepon harus diisi.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
            'province.required' => 'Provinsi harus diisi.',
            'city.required' => 'Kota harus diisi.',
            'district.required' => 'Kecamatan harus diisi.',
            'postal_code.required' => 'Kode pos harus diisi.',
            'full_address.required' => 'Alamat lengkap harus diisi.',
        ];
    }
}
