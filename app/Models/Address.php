<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Address
 * @package Mateus2033
 * @author  Mateus2033
 * @OA\Schema(
 *     title="Pets Address",
 *     @OA\Xml(
 *         name="Address"
 *     )
 * )
 */
class Address extends Model
{
    use HasFactory;
    protected $table = 'addresses';
    protected $fillable = [
        'id',
        'street',
        'number',
        'city',
        'state',
        'country',
        'postalCode'
    ];

    private int $id;
    private string $street;
    private string $number;
    private string $city;
    private string $state;
    private string $country;
    private string $postalCode;

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * Get the value of street
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * Set the value of street
     *
     */
    public function setStreet($street): void
    {
        $this->street = $street;
    }

    /**
     * Get the value of number
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * Set the value of number
     *
     */
    public function setNumber($number): void
    {
        $this->number = $number;
    }

    /**
     * Get the value of city
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * Get the value of state
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * Set the value of state
     *
     */
    public function setState($state): void
    {
        $this->state = $state;
    }

    /**
     * Get the value of country
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Set the value of country
     *
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * Get the value of postalCode
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * Set the value of postalCode
     *
     */
    public function setPostalCode($postalCode): void
    {
        $this->postalCode = $postalCode;
    }
}
