<?php

namespace App\Services\Bank;

use App\Models\Bank;
use App\Utils\ConstantMessage\ConstantMessage;

class BankValidationForSaveService extends Bank
{

    private bool  $isValid;
    public  array $message;

    public function validFormBank(array $data)
    {
        $this->validateBank($data);
        if ($this->isValid == true) {
            return $this->mountBank();
        }
        return $this;
    }

    private function mountBank(): array
    {
        return [
            'code'   =>$this->getCode(),
            'name'   =>$this->getName(),
            'active' =>$this->getActive()
        ];
    }

    private function validateBank(array $data)
    {
        $array = [];
        $error = [];
        $numberError = 0;
        $data = collect($data);

        $array['code']   = $this->_code($data->get('code'));
        $array['name']   = $this->_name($data->get('name'));
        $array['active'] = $this->_active();

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
     * @param string $code
     * @return string|null
     */
    private function _code($code)
    {
        if(!isset($code))
        {
            return ConstantMessage::REQUIRED;
        }
        
        if(!is_string($code))
        {  
            return ConstantMessage::ONLY_STRING;
        }

        $this->setCode($code);
        return null;
    }

    /**
     * @param string $name
     * @return string|null
     */
    private function _name($name)
    {
        if(!isset($name))
        {
            return ConstantMessage::REQUIRED;
        }
        
        if(!is_string($name))
        {  
            return ConstantMessage::ONLY_STRING;
        }

        $this->setName($name);
        return null;
    }

    /**
     * @return string|null
     */
    private function _active()
    {
        $this->setActive('Y');
        return null;
    }
}
