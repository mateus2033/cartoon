<?php

namespace App\Services\Administrator;

use App\Models\User;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\GeneralValidation\ValidateCpf;
use App\Utils\GeneralValidation\ValidateDateTime;
use App\Utils\GeneralValidation\ValidateCellphone;

class AdministratorValidationForUpdateService extends User
{

    private ValidateCpf       $validateCpf;
    private ValidateDateTime  $validateDateTime;
    private ValidateCellphone $validateCellphone;
    protected bool $isValid;
    public string $fileName;
    public array $message;

    public function __construct(
        ValidateCpf $validateCpf,
        ValidateDateTime $validateDateTime,
        ValidateCellphone $validateCellphone
    ) {
        $this->validateCpf   = $validateCpf;
        $this->validateDateTime  = $validateDateTime;
        $this->validateCellphone = $validateCellphone;
    }

    public function validateFormAdministrator(array $data)
    {
        $this->validateUser($data);
        if ($this->isValid == true) {
            return $this->mountUser();
        }
        return $this;
    }

    private function mountUser(): array
    {
        return [
            'id'        => $this->getId(),
            'name'      => $this->getName(),
            'lastName'  => $this->getLastName(),
            'cpf'       => $this->getCpf(),
            'dataBirth' => $this->getDataBirth(),
            'cellphone' => $this->getCellphone(),
        ];
    }

    private function validateUser(array $data)
    {
        $count = 0;
        $array = [];
        $error = [];

        $array['id']        = $this->_id($data);
        $array['name']      = $this->_name($data);
        $array['lastName']  = $this->_lastName($data);
        $array['cpf']       = $this->_cpf($data);
        $array['dataBirth'] = $this->_dataBirth($data);
        $array['cellphone'] = $this->_cellphone($data);

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
     * @param array $data
     * @return string|null
     */
    private function _id(array $data)
    {
        if (!isset($data['id'])) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_integer($data['id'])) {
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
        if (!isset($data['name'])) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($data['name'])) {
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
        if (!isset($data['lastName'])) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($data['lastName'])) {
            return ConstantMessage::ONLY_STRING;
        }

        $this->setLastName($data['lastName']);
        return null;
    }

    /**
     * @param array $data
     * @return string|null
     */
    private function _cpf(array $data)
    {
        if (!isset($data['cpf'])) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($data['cpf'])) {
            return ConstantMessage::ONLY_STRING;
        }

        $cpf = $this->validateCpf->validarCPF($data['cpf']);

        if (!is_null($cpf)) {
            return $cpf;
        }

        $this->setCpf($data['cpf']);
        return null;
    }

    /**
     * @param array $data
     * @return string|null
     */
    private function _dataBirth(array $data)
    {
        if (!isset($data['dataBirth'])) {
            return ConstantMessage::REQUIRED;
        }

        $dataBirth = $this->validateDateTime->validaData($data['dataBirth']);
        if (is_bool($dataBirth)) {
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
        if (!isset($data['cellphone'])) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($data['cellphone'])) {
            return ConstantMessage::ONLY_STRING;
        }

        $cellphone = $this->validateCellphone->validateCellphoneAndPhone($data['cellphone']);
        if (!$cellphone) {
            return ConstantMessage::INVALID_CELLPHONE;
        }

        $this->setCellphone($data['cellphone']);
        return null;
    }
}
