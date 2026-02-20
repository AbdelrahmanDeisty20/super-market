<?php

namespace App\Service;

use App\Models\UserAddress;
use App\Models\User;

class UserAddressService
{
    /**
     * Get all addresses for a user.
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserAddresses(User $user)
    {
        return UserAddress::where('user_id', $user->id)->latest()->get();
    }

    /**
     * Store a new address for a user.
     *
     * @param User $user
     * @param array $data
     * @return UserAddress
     */
    public function storeAddress(User $user, array $data)
    {
        if (isset($data['is_default']) && $data['is_default']) {
            $this->resetDefaultAddresses($user);
        }

        // If it's the first address, make it default automatically
        if (UserAddress::where('user_id', $user->id)->count() === 0) {
            $data['is_default'] = true;
        }

        return UserAddress::create(array_merge($data, ['user_id' => $user->id]));
    }

    /**
     * Update an address.
     *
     * @param UserAddress $address
     * @param array $data
     * @return UserAddress
     */
    public function updateAddress(UserAddress $address, array $data)
    {
        if (isset($data['is_default']) && $data['is_default']) {
            $this->resetDefaultAddresses($address->user);
        }

        $address->update([
            'label' => $data['label'] ?? $address->label,
            'address' => $data['address'] ?? $address->address,
            'is_default' => $data['is_default'] ?? $address->is_default,
        ]);
        return $address;
    }

    /**
     * Delete an address.
     *
     * @param UserAddress $address
     * @return bool|null
     */
    public function deleteAddress(UserAddress $address)
    {
        $wasDefault = $address->is_default;
        $deleted = $address->delete();

        if ($deleted && $wasDefault) {
            $nextAddress = UserAddress::where('user_id', $address->user_id)->first();
            if ($nextAddress) {
                $nextAddress->update(['is_default' => true]);
            }
        }

        return $deleted;
    }

    /**
     * Delete all addresses for a user.
     *
     * @param User $user
     * @return int
     */
    public function deleteAllAddresses(User $user)
    {
        return UserAddress::where('user_id', $user->id)->delete();
    }

    /**
     * Reset default status for all user addresses.
     *
     * @param User $user
     * @return void
     */
    protected function resetDefaultAddresses(User $user)
    {
        UserAddress::where('user_id', $user->id)->update(['is_default' => false]);
    }
}
