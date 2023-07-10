<?php

namespace App\Services\BankData;

use App\Models\BankData;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ConstantMessage\ConstantPermissionMessage;

class BankDataValidationForUpdateService extends BankData
{
    private bool  $isValid;
    public  array $message;


    public function validFormBankData(array $data)
    {
        $this->validateBankData($data);
        if ($this->isValid == true) {
            return $this->mountBankData();
        }
        return $this;
    }

    private function mountBankData(): array
    {
        return [
            'id'  => $this->getId(),
            'number_card' => $this->getNumber_card(),
            'number_agency' => $this->getNumber_agency(),
            'number_security' => $this->getNumber_security(),
            'user_id' => $this->getUser_id()
        ];
    }

    private function validateBankData(array $data)
    {
        $array = [];
        $error = [];
        $numberError = 0;
        $data  = collect($data);

        $array['id']  = $this->_id($data->get('id'));
        $array['number_card']  = $this->_number_card($data->get('number_card'));
        $array['number_agency'] = $this->_number_agency($data->get('number_agency'));
        $array['number_security'] = $this->_number_security($data->get('number_security'));
        $array['user_id'] = $this->_user_id((int) $data->get('user_id'));

        foreach ($array as $key => $value) {
            if (!is_null($value)) {
                $error[$key] = $value;
                $numberError++;
            }
        }

        if ($numberError > 0) {
            $this->isValid = false;
            $this->message = $error;
        } else {
            $this->isValid = true;
            $this->message = $array;
        }
    }

    /**
     * @param int $number_card
     * @return string|null
     */
    private function _id($id)
    {
        if (!isset($id)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_integer($id) || $id <= 0) {
            return ConstantMessage::ONLY_INTEGER_POSITIVE;
        }

        $this->setId($id);
        return null;
    }

    /**
     * @param int $number_card
     * @return string|null
     */
    private function _number_card($number_card)
    {
        if (!isset($number_card)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_integer($number_card) || $number_card <= 0) {
            return ConstantMessage::ONLY_INTEGER_POSITIVE;
        }

        $this->setNumber_card($number_card);
        return null;
    }

    /**
     * @param int $number_agency
     * @return string|null
     */
    private function _number_agency($number_agency)
    {
        if (!isset($number_agency)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_integer($number_agency) || $number_agency <= 0) {
            return ConstantMessage::ONLY_INTEGER_POSITIVE;
        }

        $this->setNumber_agency($number_agency);
        return null;
    }

    /**
     * @param int $number_security
     * @return string|null
     */
    private function _number_security($number_security)
    {
        if (!isset($number_security)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_integer($number_security) || $number_security <= 0) {
            return ConstantMessage::ONLY_INTEGER_POSITIVE;
        }

        $this->setNumber_security($number_security);
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

        if (!is_integer($user_id) || $user_id <= 0) {
            return ConstantMessage::ONLY_INTEGER_POSITIVE;
        }

        if (auth('api')->user()->id !== $user_id) {
            return ConstantPermissionMessage::INVALID_OPERATION;
        }

        $this->setUser_id($user_id);
        return null;
    }
}
