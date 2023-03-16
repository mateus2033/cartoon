<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'type',
        'method',
        'value',
        'date_payment',
        'cart_id'
    ];

    private string $type;
    private string $method;
    private float  $value;
    private string $date_payment;
    private int    $cart_id;

    /**
     * Get the value of type
     */ 
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     */ 
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * Get the value of method
     */ 
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Set the value of method
     *
     */ 
    public function setMethod($method): void
    {
        $this->method = $method;
    }

    /**
     * Get the value of value
     */ 
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     */ 
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * Get the value of date_payment
     */ 
    public function getDate_payment(): string
    {
        return $this->date_payment;
    }

    /**
     * Set the value of date_payment
     *
     */ 
    public function setDate_payment($date_payment): void
    {
        $this->date_payment = $date_payment;
    }

    /**
     * Get the value of cart_id
     */ 
    public function getCart_id()
    {
        return $this->cart_id;
    }

    /**
     * Set the value of cart_id
     */ 
    public function setCart_id($cart_id): void
    {
        $this->cart_id = $cart_id;
    }
}
