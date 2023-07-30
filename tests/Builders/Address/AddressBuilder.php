<?php

namespace Tests\Builders\Address;

use App\Models\Address;

class AddressBuilder
{
    protected $attributes = [];

    public function setId($id = null): self
    {
        $this->attributes['id'] = $id;
        return $this;
    }

    public function setStreet($street = null)
    {
        $this->attributes['street'] = $street;
        return $this;
    }

    public function setNumber($number = null)
    {
        $this->attributes['number'] = $number;
        return $this;
    }

    public function setCity($city = null)
    {
        $this->attributes['city'] = $city;
        return $this;
    }

    public function setState($state = null)
    {
        $this->attributes['state'] = $state;
        return $this;
    }

    public function setCountry($country = null)
    {
        $this->attributes['country'] = $country;
        return $this;
    }

    public function setPostalCode($postalCode = null)
    {
        $this->attributes['postalCode'] = $postalCode;
        return $this;
    }

    public function setUserId($user_id = null)
    {
        $this->attributes['user_id'] = $user_id;
        return $this;
    }

    public function create($quantity = null)
    {
        return Address::factory($quantity)->create($this->attributes);
    }

    public function make($quantity = null)
    {
        return Address::factory($quantity)->make($this->attributes);
    }
}
