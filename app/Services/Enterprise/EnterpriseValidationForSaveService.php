<?php

namespace App\Services\Enterprise;

use App\Exceptions\CustomException;
use Exception;
use App\Models\Enterprise;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ConstantMessage\enterprise\EnterpriseMessage;
use App\Utils\GeneralValidation\ValidateCPNJ;
use App\Utils\GeneralValidation\ValidateDateTime;
use Illuminate\Http\Response;

class EnterpriseValidationForSaveService extends Enterprise
{
    private ValidateCPNJ $validateCPNJ;
    private ValidateDateTime $validateDateTime;

    public function __construct(
        ValidateCPNJ $validateCPNJ,
        ValidateDateTime $validateDateTime
    ){
        $this->validateCPNJ = $validateCPNJ;
        $this->validateDateTime = $validateDateTime;
    }

    public function validFormEnterprise(array $data)
    {  
        $this->validateEnterprise($data);
        return $this->mountEnterprise();
    }

    private function mountEnterprise(): array
    {
        return [
            'name'=> $this->getName(),
            'cnpj'=> $this->getCnpj(),
            'responsible' => $this->getResponsible(),
            'foundation' => $this->getFoundation(),
            'fantasy_name' => $this->getFantasyName(),
            'corporate_reason' => $this->getCorporateReason(),
            'state_registration' => $this->getStateRegistration(),
            'municipal_registration' => $this->getMunicipalRegistration(),
        ];
    }

    private function validateEnterprise(array $data)
    {
        $array = [];
        $error = [];
        $numberError = 0;
        $data = collect($data);

        $array['name']                    = $this->_name($data->get('name')); 
        $array['cnpj']                    = $this->_cnpj($data->get('cnpj'));
        $array['responsible']             = $this->_responsible($data->get('responsible'));
        $array['foundation']              = $this->_foundation($data->get('foundation')); 
        $array['fantasy_name']            = $this->_fantasy_name($data->get('fantasy_name'));  
        $array['corporate_reason']        = $this->_corporate_reason($data->get('corporate_reason')); 
        $array['state_registration']      = $this->_state_registration($data->get('state_registration'));
        $array['municipal_registration']  = $this->_municipal_registration($data->get('municipal_registration')); 

        foreach ($array as $key => $value) {
            if (!is_null($value)) {
                $error[$key] = $value;
                $numberError++;
            }
        }

        if($numberError > 0) {
            CustomException::exception($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }    

        return true;
    }

    /**
     * @param string $name
     * @return string|null
     */
    private function _name(?string $name)
    {
        if (!isset($name)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($name)) {
            return ConstantMessage::ONLY_STRING;
        }

        $this->setName($name);
        return null;
    }

    /**
     * @param string $cnpj
     * @return string|null
     */
    private function _cnpj(?string $cnpj)
    {
        if (!isset($cnpj)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($cnpj)) {
            return ConstantMessage::ONLY_STRING;
        }

        if(!$this->validateCPNJ->validateCPNJ($cnpj)) {
            return EnterpriseMessage::INVALID_CNPJ;
        }
        
        $this->setCnpj($cnpj);
        return null;
    }

    /**
     * @param string $responsible
     * @return string|null
     */
    private function _responsible(?string $responsible)
    {
        if (!isset($responsible)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($responsible)) {
            return ConstantMessage::ONLY_STRING;
        }

        $this->setResponsible($responsible);
        return null;
    }

    /**
     * @param string $foundation
     * @return string|null
     */
    private function _foundation(?string $foundation)
    {
        if (!isset($foundation)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($foundation)) {
            return ConstantMessage::ONLY_STRING;
        }

        $foundation = $this->validateDateTime->validaData($foundation);
        if(!$foundation) {
            return ConstantMessage::INVALID_DATE;
        }

        $this->setFoundation($foundation);
        return null;
    }

    /**
     * @param string $fantasy_name
     * @return string|null
     */
    private function _fantasy_name(?string $fantasy_name)
    {
        if (!isset($fantasy_name)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($fantasy_name)) {
            return ConstantMessage::ONLY_STRING;
        }

        $this->setFantasyName($fantasy_name);
        return null;
    }

    /**
     * @param string $corporate_reason
     * @return string|null
     */
    private function _corporate_reason(?string $corporate_reason)
    {
        if (!isset($corporate_reason)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($corporate_reason)) {
            return ConstantMessage::ONLY_STRING;
        }

        $this->setCorporateReason($corporate_reason);
        return null;
    }

    /**
     * @param string $state_registration
     * @return string|null
     */
    private function _state_registration(?string $state_registration)
    {
        if (!isset($state_registration)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($state_registration)) {
            return ConstantMessage::ONLY_STRING;
        }

        $this->setStateRegistration($state_registration);
        return null;
    }

    /**
     * @param string $municipal_registration
     * @return string|null
     */
    private function _municipal_registration(?string $municipal_registration)
    {
        if (!isset($municipal_registration)) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($municipal_registration)) {
            return ConstantMessage::ONLY_STRING;
        }

        $this->setMunicipalRegistration($municipal_registration);
        return null;
    }
}