<?php

namespace App\Services\Address;

use App\Models\Address;
use App\Interfaces\Address\AddressRepositoryInterface;
use App\Interfaces\Address\AddressServiceInterface;
use App\Services\Address\AddressValidationForSaveService;
use App\Services\Address\AddressValidationForUpdateService;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ErroMensage\ErroMensage;
use App\Utils\SuccessMessage\SuccessMessage;

class AddressService implements AddressServiceInterface
{
    private AddressRepositoryInterface $addressRepository;
    private AddressValidationForSaveService $addressValidationForSaveService;
    private AddressValidationForUpdateService $addressValidationForUpdateService;

    public function __construct(
        AddressRepositoryInterface $addressRepository,
        AddressValidationForSaveService $addressValidationForSaveService,
        AddressValidationForUpdateService $addressValidationForUpdateService
    ) {
        $this->addressRepository = $addressRepository;
        $this->addressValidationForSaveService = $addressValidationForSaveService;
        $this->addressValidationForUpdateService = $addressValidationForUpdateService;
    }

    public function listAddress(int $user_id)
    {
        $address = $this->addressRepository->findByRelations($user_id);
        if ($address->isNotEmpty()) return $address;
        else
        return ErroMensage::errorMessage(ConstantMessage::ADDRESSNOTFOUND);
    }

    public function manageStorageAddress(array $data)
    {
        $address = $this->addressValidationForSaveService->validFormAddress($data);
        if (is_array($address)) {
            $response = $this->addressRepository->create($address);
            return $response;
        }
        return $address->message;
    }

    public function showAddressById(int $address_id)
    {
        $address = $this->addressRepository->findById($address_id);
        if (!is_null($address)) {
            return $address;
        }
        return ConstantMessage::ADDRESSNOTFOUND;
    }

    public function validateAddressRelationWithUser(array $addressValid)
    {
        $valid = false;
        $userAddresses = $addressValid['user_id']->address;
        foreach ($userAddresses as  $userAddresse) {
            if ($userAddresse->id == $addressValid['id']) {
                return $userAddresse;
            }
        }

        if (!$valid) {
            return ConstantMessage::INVALID_ADDRESS;
        }
        return $valid;
    }

    public function manageUpdateAddress(array $data)
    {
        $addressValid = $this->addressValidationForUpdateService->validFormAddress($data);
        if (!is_array($addressValid)) {
            $error = $addressValid->message;
            return $error;
        }

        $userAddress = $this->validateAddressRelationWithUser($addressValid);
        if ($userAddress instanceof Address) {
            $addressValid['user_id'] = $addressValid['user_id']->id;
            $this->addressRepository->update($userAddress, $addressValid);
            return $this->showAddressById($addressValid['id']);
        }
        return ErroMensage::errorMessage($userAddress);
    }

    public function showAddress(int $address_id)
    {
        $address = $this->addressRepository->findById($address_id);
        if (!is_null($address)) {
            return $address;
        }
        return ConstantMessage::ADDRESSNOTFOUND;
    }

    public function manageDeleteAddress(int $address_id, int $user_id)
    {
        $address = $this->showAddress($address_id);
        if (is_string($address)) {
            return ErroMensage::errorMessage($address);
        }

        if ($address['user_id'] == $user_id) {
            $this->addressRepository->destroy($address->id);
            return SuccessMessage::sucessMessage(ConstantMessage::ADDRESS_DELETED);
        }

        return ErroMensage::errorMessage(ConstantMessage::INVALID_ADDRESS);
    }
}
