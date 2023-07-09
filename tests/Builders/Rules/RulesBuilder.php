<?php 

namespace Tests\Builders\Rules;

use App\Models\Rules;

class RulesBuilder 
{
    protected $attributes = [];

    public function setId($id = null): self
    {
        $this->attributes['id'] = $id;
        return $this;
    }

    public function setPermission($permission = null): self
    {
        $this->attributes['permission'] = $permission;
        return $this;
    }

    public function create($quantity = null)
    {  
        return Rules::factory($quantity)->create($this->attributes);
    }

    public function make($quantity = null)
    {
        return Rules::factory($quantity)->make($this->attributes);
    }
}