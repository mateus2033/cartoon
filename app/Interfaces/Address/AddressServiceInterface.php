<?php
namespace App\Interfaces\Address;

interface AddressServiceInterface {
    public function listAddress(int $user_id);
    public function manageStorageAddress(array $data);
    public function showAddressById(int $address_id);
    public function validateAddressRelationWithUser(array $addressValid);
    public function manageUpdateAddress(array $data);
    public function showAddress(int $address_id);
    public function manageDeleteAddress(int $address_id, int $user_id);
}