<?php

namespace App\Utils\GeneralValidation;

use App\Utils\ConstantMessage\ConstantMessage;

class ValidateState {

    private bool $isValid = false;

    /**
     * @param string $acronym
     * @return string|bool
     */
    public function validAcronym(string $acronym)
    {
        $states = $this->getStates();
        for($i=0; $i < count($states); $i++)
        {
            if($states[$i] == $acronym){
                $this->isValid = true;
            } 
        }

        if(!$this->isValid)
        {
            return ConstantMessage::INVALID_STATE;
        }
        return $this->isValid;
    }

    public function getStates(): array
    {
        return [
            0 =>'AC',
            1 =>'AL',
            2 =>'AP',
            3 =>'AM',
            4 =>'BA',
            5 =>'CE',
            6 =>'DF',
            7 =>'ES',
            8 =>'GO',
            9 =>'MA',
            10 =>'MT',
            11 =>'MS',
            12 =>'MG',
            13 =>'PA',
            14 =>'PB',
            15 =>'PR',
            16 =>'PE',
            17 =>'PI',
            18 =>'RJ',
            19 =>'RN',
            20 =>'RS',
            21 =>'RO',
            22 =>'RR',
            23 =>'SC',
            24 =>'SP',
            25 =>'SE',
            26 =>'TO',
        ];
    }
}
