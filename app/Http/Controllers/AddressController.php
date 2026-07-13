<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Repositories\Interfaces\AddressRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function __construct(
        protected AddressRepositoryInterface $addressRepository
    ) {}

    public function index()
    {
        $addresses = $this->addressRepository->getByUser(Auth::id());

        return view('profile.addresses', [
            'addresses' => $addresses,
        ]);
    }

    public function store(StoreAddressRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        $this->addressRepository->create($validated);

        return back()->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function update(StoreAddressRequest $request, int $id)
    {
        $address = $this->addressRepository->findById($id);

        if (!$address || $address->user_id !== Auth::id()) {
            abort(403);
        }

        $this->addressRepository->update($address, $request->validated());

        return back()->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $address = $this->addressRepository->findById($id);

        if (!$address || $address->user_id !== Auth::id()) {
            abort(403);
        }

        $this->addressRepository->delete($address);

        return back()->with('success', 'Alamat berhasil dihapus.');
    }

    public function setDefault(int $id)
    {
        $this->addressRepository->setDefault(Auth::id(), $id);

        return back()->with('success', 'Alamat utama berhasil diubah.');
    }
}
