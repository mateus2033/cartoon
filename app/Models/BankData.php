<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankData extends Model
{
    use HasFactory;
    protected $table = 'bank_data';
    protected $fillable = [
        'number_card',
        'number_agency',
        'number_security',
        'user_id'
    ];

    private int $number_card;
    private int $number_agency;
    private int $number_security;
    private int $user_id;


    /**
     * Get the value of number_card
     */ 
    public function getNumber_card(): int
    {
        return $this->number_card;
    }

    /**
     * Set the value of number_card
     *
     */ 
    public function setNumber_card($number_card): void
    {
        $this->number_card = $number_card;
    }

    /**
     * Get the value of number_agency
     */ 
    public function getNumber_agency(): int
    {
        return $this->number_agency;
    }

    /**
     * Set the value of number_agency
     */ 
    public function setNumber_agency($number_agency): void
    {
        $this->number_agency = $number_agency;
    }

    /**
     * Get the value of number_security
     */ 
    public function getNumber_security(): int
    {
        return $this->number_security;
    }

    /**
     * Set the value of number_security
     */ 
    public function setNumber_security($number_security): void
    {
        $this->number_security = $number_security;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUser_id(): int
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     */ 
    public function setUser_id($user_id): void
    {
        $this->user_id = $user_id;
    }
}
