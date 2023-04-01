<?php

namespace App\Services\Administrator;

use App\Models\User;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ConstantMessage\ConstantPath;
use App\Utils\GeneralValidation\ValidateCpf;
use App\Utils\GeneralValidation\ValidateEmail;
use App\Utils\GeneralValidation\ValidateDateTime;
use App\Utils\GeneralValidation\ValidateCellphone;
use App\Utils\PermissionValue\PermissionValue;
use Illuminate\Support\Facades\Hash;

class AdministratorValidationForSaveService extends User {

    private ValidateCpf       $validateCpf;
    private ValidateEmail     $validateEmail;
    private ValidateDateTime  $validateDateTime;
    private ValidateCellphone $validateCellphone;
    protected bool $isValid;
    public string $fileName;
    public array $message;

    public function __construct(
        ValidateCpf $validateCpf,
        ValidateEmail $validateEmail,
        ValidateDateTime $validateDateTime,
        ValidateCellphone $validateCellphone
    ) {
        $this->validateCpf   = $validateCpf;
        $this->validateEmail = $validateEmail;
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
            'name'      => $this->getName(),
            'lastName'  => $this->getLastName(),
            'cpf'       => $this->getCpf(),
            'dataBirth' => $this->getDataBirth(),
            'cellphone' => $this->getCellphone(),
            'image'    => $this->getImage(),
            'email'    => $this->getEmail(),
            'password' => $this->getPassword(),
            'rule_id'  => $this->getRule_id(),
            'email_verified_at' => $this->getEmail_verified_at()
        ];
    }

    private function validateUser(array $data)
    {
        $count = 0;
        $array = [];
        $error = [];

        $array['name']      = $this->_name($data);
        $array['lastName']  = $this->_lastName($data);
        $array['cpf']       = $this->_cpf($data);
        $array['dataBirth'] = $this->_dataBirth($data);
        $array['cellphone'] = $this->_cellphone($data);
        $array['image']     = $this->_image($data);
        $array['email']     = $this->_email($data);
        $array['password']  = $this->_password($data);
        $array['rule_id']   = $this->_rule_id();
        $array['email_verified_at'] = $this->_email_verified_at($data);

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

    /**
     * @param array $data
     * @return string|null
     */
    private function _image(array $data)
    {
        if (!isset($data['image'])) {
            return ConstantMessage::REQUIRED;
        }

        if (!$data['image']->isValid()) {
            return ConstantMessage::INVALID_IMAGE_PERFIL;
        }

        $imageName = md5($data['image']->getClientOriginalName() . strtotime("now")) . "." . $data['image']->extension();
        $data['image']->move(public_path(ConstantPath::PERFIL_PATH_ADM), $imageName);

        $this->fileName = $imageName;
        $this->setImage($imageName);
        return null;
    }

    /**
     * @param array $data
     * @return string|null
     */
    private function _email(array $data)
    {
        if (!isset($data['email'])) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($data['email'])) {
            return ConstantMessage::ONLY_STRING;
        }

        $email = $this->validateEmail->validMyEmail($data['email']);
        if ($email) {
            return $email;
        }

        $this->setEmail($data['email']);
        return null;
    }

    /**
     * @param array $data
     * @return string|null
     */
    private function _password(array $data)
    {
        if (!isset($data['password'])) {
            return ConstantMessage::REQUIRED;
        }

        if (!is_string($data['password'])) {
            return ConstantMessage::ONLY_STRING;
        }

        if (strlen($data['password']) < 8) {
            return ConstantMessage::MIN_REQUIRED;
        }

        $this->setPassword(Hash::make($data['password']));
        return null;
    }

    private function _rule_id()
    {
        $this->setRule_id(PermissionValue::ADMIN_PERMISSION);
    }

    private function _email_verified_at(array $data)
    {
        $today = date("Y-m-d H:i:s");
        $this->setEmail_verified_at($today);
        return null;
    }
}