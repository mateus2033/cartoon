<?php

namespace App\Services\Address;

use App\Models\Address;
use App\Repository\User\UserRepository;
use App\Services\User\UserService;
use App\Services\User\UserValidationForSaveService;
use App\Services\User\UserValidationForUpdateService;
use App\Services\User\UserValidationPhotoPerfilForUpdate;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\GeneralValidation\ValidateCep;
use App\Utils\GeneralValidation\ValidateState;

class AddressValidationForSaveService extends Address
{
    private bool  $isValid;
    public  array $message;
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function validFormAddress(array $data)
    {
        $this->validateAddress($data);
        if ($this->isValid == true) {
            return $this->mountAddress();
        }
        return $this;
    }

    public function mountAddress(): array
    {
        return [
            'street' => $this->getState(),
            'number' => $this->getNumber(),
            'city'   => $this->getCity(),
            'state'  => $this->getState(),
            'postalCode' => $this->getPostalCode(),
            'user_id'    => $this->getUser_id(),
            'country'    => $this->getCountry()
        ];
    }

    public function validateAddress(array $data)
    {
        $count = 0;
        $array = [];
        $error = [];
        $data  = collect($data);

        $array['street'] = $this->_street($data->get('street'));
        $array['number'] = $this->_number($data->get('number'));
        $array['city']   = $this->_city($data->get('city'));
        $array['state']  = $this->_state($data->get('state'));
        $array['postalCode'] = $this->_postalCode($data->get('postalCode'));
        $array['user_id']    = $this->_user_id($data->get('user_id'));
        $array['country']    = $this->_country();

        foreach ($array as $key => $value) {
            if (!is_null($value)) {
                $error[$key] = $value;
                $count++;
            }
        }

        if ($count > 0) {
            $this->isValid = false;
            $this->message = $error;
        } else {
            $this->isValid = true;
            $this->message = $array;
        }
    }

    /**
     * @param string $street
     * @return string|null
     */
    private function _street($street)
    {
        if (!isset($street)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($street)) {
            return ConstantMessage::ONLY_STRING;
        }

        $this->setStreet($street);
        return null;
    }

    /**
     * @param string $number
     * @return string|null
     */
    private function _number($number)
    {
        if (!isset($number)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($number)) {
            return ConstantMessage::ONLY_STRING;
        }

        $this->setNumber($number);
        return null;
    }

    /**
     * @param string $city
     * @return string|null
     */
    private function _city($city)
    {
        if (!isset($city)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($city)) {
            return ConstantMessage::ONLY_STRING;
        }

        $this->setCity($city);
        return null;
    }

    /**
     * @param string $state
     * @return string|null
     */
    private function _state($state)
    {
        if (!isset($state)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($state)) {
            return ConstantMessage::ONLY_STRING;
        }

        $validate = (new ValidateState())->validAcronym($state);
        if (!is_bool($validate)) {
            return $validate;
        }

        $this->setState($state);
        return null;
    }

    /**
     * @param string $postalCode
     * @return string|null
     */
    private function _postalCode($postalCode)
    {
        if (!isset($postalCode)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($postalCode)) {
            return ConstantMessage::ONLY_STRING;
        }

        $cep = (new ValidateCep())->validateCEP($postalCode);
        if (!is_bool($cep)) {
            return $cep;
        }

        $this->setPostalCode($postalCode);
        return null;
    }

    /**
     * @param int $user_id
     * @return string|null
     */
    private function _user_id($user_id)
    {
        if (!isset($user_id)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_integer($user_id)) {
            return ConstantMessage::ONLY_INTEGER;
        }

        if(auth('api')->user()->id !== $user_id) {   
            return ConstantMessage::USERNOTFOUND;
        }

        $this->setUser_id($user_id);
        return null;
    }


    private function _country()
    {
        $this->setCountry('Brazil');
        return null;
    }
}
