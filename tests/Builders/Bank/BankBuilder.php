<?php 

namespace Tests\Builders\Bank;

use App\Models\Bank;

class BankBuilder 
{
    protected $attributes = [];

    public function setId($id = null): self
    {
        $this->attributes['id'] = $id;
        return $this;
    }

    public function setCode($code = null): self 
    {
        $this->attributes['code'] = $code;
        return $this;
    }

    public function setName($name = null): self 
    {
        $this->attributes['name'] = $name;
        return $this;
    }

    public function setActive($active = null): self 
    {
        $this->attributes['active'] = $active;
        return $this;
    }   

    public function create($quantity = null)
    {
        return Bank::factory($quantity)->create($this->attributes);
    }

    public function make($quantity = null)
    {
        return Bank::factory($quantity)->make($this->attributes);
    }
}