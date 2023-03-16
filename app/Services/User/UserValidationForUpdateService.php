<?php

namespace App\Services\User;

use App\Models\User;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\GeneralValidation\ValidateDateTime;
use App\Utils\GeneralValidation\ValidateCellphone;

class UserValidationForUpdateService extends User {
    
    protected bool $isValid;
    public array $message;

    public function validateFormUser(array $data) 
    {
        $this->validateUser($data);
        if($this->isValid == true)
        {
            return $this->mountUser();
        }
        return $this;
    }

    public function mountUser(): array
    {
        return [
            'id'        => $this->getId(),
            'name'      => $this->getName(),
            'lastName'  => $this->getLastName(),  
            'dataBirth' => $this->getDataBirth(),  
            'cellphone' => $this->getCellphone()
        ];
    }

    public function validateUser(array $data) 
    {
        $count = 0;
        $array = [];
        $error = [];

        $array['id']        = $this->_id($data);
        $array['name']      = $this->_name($data);
        $array['lastName']  = $this->_lastName($data);
        $array['dataBirth'] = $this->_dataBirth($data);
        $array['cellphone'] = $this->_cellphone($data); 
         
        foreach($array as $key => $value)
        {
            if(!is_null($value)){
                $error[$key] = $value;
                $count++;
            }
        }
              
        if($count > 0)
        {
            $this->isValid = false;
            $this->message = $error;
        } else {
            $this->isValid = true;
            $this->message = $array;
        }   
    }

    /**
     * @param array $data
     * @return string|null
     */
    private function _id(array $data)
    {
        if(!isset($data['id']))
        {
            return ConstantMessage::REQUIRED;
        }

        if(!is_integer($data['id']))
        {
            return ConstantMessage::ONLY_INTEGER;
        }

        $this->setId($data['id']);
        return null;
    }

    /**
     * @param array $data
     * @return string|null
     */
    private function _name(array $data)
    {
        if(!isset($data['name']))
        {
            return ConstantMessage::REQUIRED;
        }

        if(!is_string($data['name']))
        {
            return ConstantMessage::ONLY_STRING;
        }

        $this->setName($data['name']);
        return null;
    }

    /**
     * @param array $data
     * @return string|null
     */
    private function _lastName(array $data)
    {
        if(!isset($data['lastName']))
        {
            return ConstantMessage::REQUIRED;
        }

        if(!is_string($data['lastName']))
        {
            return ConstantMessage::ONLY_STRING;
        }

        $this->setLastName($data['lastName']);
        return null;
    }

    /**
     * @param array $data
     * @return string|null
     */
    private function _dataBirth(array $data)
    {
        if(!isset($data['dataBirth']))
        {
            return ConstantMessage::REQUIRED;
        }

        $dataBirth = (new ValidateDateTime())->validaData($data['dataBirth']);
        if(is_bool($dataBirth)) 
        {
            return ConstantMessage::INVALID_DATE;
        }

        $this->setDataBirth($dataBirth);
        return null;
    }

    /**
     * @param array $data
     * @return string|null
     */
    private function _cellphone(array $data)
    {
        if(!isset($data['cellphone']))
        {
            return ConstantMessage::REQUIRED;
        }

        if(!is_string($data['cellphone']))
        {
            return ConstantMessage::ONLY_STRING;
        }

        $cellphone = (new ValidateCellphone())->validateCellphoneAndPhone($data['cellphone']);
        if(!$cellphone) 
        {
            return ConstantMessage::INVALID_CELLPHONE;
        }

        $this->setCellphone($data['cellphone']);
        return null;
    }
}