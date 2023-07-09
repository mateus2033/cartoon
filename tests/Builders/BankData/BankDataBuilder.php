<?php

namespace Tests\Builders\BankData;

use App\Models\BankData;

class BankDataBuilder
{

    protected $attributes = [];

    public function setId($id = null): self
    {
        $this->attributes['id'] = $id;
        return $this;
    }

    public function setNumberCard($number_card = null): self
    {
        $this->attributes['number_card'] = $number_card;
        return $this;
    }

    public function setNumberAgency($number_agency = null): self
    {
        $this->attributes['number_agency'] = $number_agency;
        return $this;
    }

    public function setNumberSecurity($number_security = null): self
    {
        $this->attributes['number_security'] = $number_security;
        return $this;
    }

    public function setUserId($user_id = null): self
    {
        $this->attributes['user_id'] = $user_id;
        return $this;
    }

    public function setBankId($bank_id = null): self
    {
        $this->attributes['bank_id'] = $bank_id;
        return $this;
    }

    public function create($quantity = null)
    {
        return BankData::factory($quantity)->create($this->attributes);
    }

    public function make($quantity = null)
    {
        return BankData::factory($quantity)->make($this->attributes);
    }
}
