<?php

namespace Tests\Builders\Administrator;

use App\Models\User;

class AdministratorBuilder 
{
    protected $attributes = [];

    public function setId($id = null): self
    {
        $this->attributes['id'] = $id;
        return $this;
    }

    public function setName($name = null): self
    {
        $this->attributes['name'] = $name;
        return $this;
    }

    public function setLastName($lastName = null): self
    {
        $this->attributes['lastName'] = $lastName;
        return $this;
    }

    public function setCpf($cpf = null): self
    {
        $this->attributes['cpf'] = $cpf;
        return $this;
    }

    public function setDataBirth($dataBirth = null): self
    {
        $this->attributes['dataBirth'] = $dataBirth;
        return $this;
    }

    public function setCellphone($cellphone = null): self
    {
        $this->attributes['cellphone'] = $cellphone;
        return $this;
    }

    public function setImage($image = null): self
    {
        $this->attributes['image'] = $image;
        return $this;
    }

    public function setEmail($email = null): self
    {
        $this->attributes['email'] = $email;
        return $this;
    }

    public function setPassword($password = null): self
    {
        $this->attributes['password'] = $password;
        return $this;
    }

    public function setRuleId($rule_id = null): self
    {  
        $this->attributes['rule_id'] = $rule_id;
        return $this;
    }

    public function create($quantity = null)
    {   
        return User::factory($quantity)->create($this->attributes);
    }

    public function make($quantity = null)
    {  
        return User::factory($quantity)->make($this->attributes);
    }
}

