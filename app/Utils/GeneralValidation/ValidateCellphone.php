<?php

namespace App\Utils\GeneralValidation;

class ValidateCellphone
{
    private bool $isValid = false;

    public function validateCellphoneAndPhone(string $value): bool
    {
        $response = preg_replace("/[^0-9]/", "", $value);
        $lenValor = strlen($response);

        if($lenValor == 10) 
        {
            return $this->validatePhone($response);
        }

        if($lenValor == 11) 
        {
            return $this->validateCellPhone($response);
        }

        return false;
    
    }

    private function validateCellPhone(string $cellphone) 
    {
        $arrayDDD   = $this->getBrazilianDDD();
        $currentDDD = $cellphone[0].$cellphone[1];
       
        if($cellphone[2] != 9) 
        {
            return false;
        }

        for($i=0; $i < count($arrayDDD); $i++)
        {
            if($arrayDDD[$i] == $currentDDD){
                $this->isValid = true;
            } 
        }

        return $this->isValid;
    }

    private function validatePhone(string $phone) 
    {   
        $arrayDDD   = $this->getBrazilianDDD();
        $currentDDD = $phone[0].$phone[1];
       
        for($i=0; $i < count($arrayDDD); $i++)
        {
            if($arrayDDD[$i] == $currentDDD){
                $this->isValid = true;
            } 
        }

        return $this->isValid;
    }

    private function getBrazilianDDD(): array
    {
        $array = [
            '11','12','13','14',
            '15','16','17','18',
            '19','21','22','24',
            '27','28','31','32',
            '33','34','35','37',
            '38','41','42','43',
            '44','45','46','47',
            '48','49','51','53',
            '54','55','61','62',
            '63','64','65','66',
            '67','68','69','71',
            '73','74','75','77',
            '79','81','82','83',
            '84','85','86','87',
            '88','89','91','92',
            '93','94','95','96',
            '97','98','99'
        ];

        return $array;
    }
}
