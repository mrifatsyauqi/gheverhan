<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Address;

interface AddressRepositoryInterface
{
    public function getByUser(int $userId): Collection;

    public function findById(int $id): ?Address;

    public function create(array $data): Address;

    public function update(Address $address, array $data): Address;

    public function delete(Address $address): void;

    public function setDefault(int $userId, int $addressId): void;
}
