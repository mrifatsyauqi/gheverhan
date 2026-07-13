<?php

namespace App\Repositories\Eloquent;

use App\Models\Address;
use App\Repositories\Interfaces\AddressRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AddressRepository implements AddressRepositoryInterface
{
    public function __construct(
        protected Address $model
    ) {}

    public function getByUser(int $userId): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->orderByDesc('is_default')
            ->orderByDesc('created_at')
            ->get();
    }

    public function findById(int $id): ?Address
    {
        return $this->model->find($id);
    }

    public function create(array $data): Address
    {
        // If this is the first address or is_default, reset others
        if (!empty($data['is_default'])) {
            $this->model->where('user_id', $data['user_id'])->update(['is_default' => false]);
        }

        // If user has no addresses, make this the default
        $hasAddresses = $this->model->where('user_id', $data['user_id'])->exists();
        if (!$hasAddresses) {
            $data['is_default'] = true;
        }

        return $this->model->create($data);
    }

    public function update(Address $address, array $data): Address
    {
        if (!empty($data['is_default'])) {
            $this->model->where('user_id', $address->user_id)
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        $address->update($data);
        return $address->fresh();
    }

    public function delete(Address $address): void
    {
        $wasDefault = $address->is_default;
        $userId = $address->user_id;

        $address->delete();

        // If deleted address was default, set the most recent as default
        if ($wasDefault) {
            $nextDefault = $this->model
                ->where('user_id', $userId)
                ->latest()
                ->first();

            if ($nextDefault) {
                $nextDefault->update(['is_default' => true]);
            }
        }
    }

    public function setDefault(int $userId, int $addressId): void
    {
        $this->model->where('user_id', $userId)->update(['is_default' => false]);
        $this->model->where('id', $addressId)->where('user_id', $userId)->update(['is_default' => true]);
    }
}
