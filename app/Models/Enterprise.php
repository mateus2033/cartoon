<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    use HasFactory;
    protected $table = 'enterprises';
    protected $fillable = [
        'id',
        'name',
        'fantasy_name',
        'corporate_reason',
        'state_registration',
        'cnpj',
        'municipal_registration',
        'responsible',
        'foundation',
        'address_id'
    ];

    private int $id;
    private string $name;
    private string $fantasy_name;
    private string $corporate_reason;
    private string $state_registration;
    private string $cnpj;
    private string $municipal_registration;
    private string $responsible;
    private string $foundation;
    private int $address_id;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFantasyName(): string
    {
        return $this->fantasy_name;
    }

    public function getCorporateReason(): string
    {
        return $this->corporate_reason;
    }

    public function getStateRegistration(): string
    {
        return $this->state_registration;
    }

    public function getCnpj(): string
    {
        return $this->cnpj;
    }

    public function getMunicipalRegistration(): string
    {
        return $this->municipal_registration;
    }

    public function getResponsible(): string
    {
        return $this->responsible;
    }

    public function getFoundation(): string
    {
        return $this->foundation;
    }

    public function getAddressId(): int
    {
        return $this->address_id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setFantasyName(string $fantasy_name): void
    {
        $this->fantasy_name = $fantasy_name;
    }

    public function setCorporateReason(string $corporate_reason): void
    {
        $this->corporate_reason = $corporate_reason;
    }

    public function setStateRegistration(string $state_registration): void
    {
        $this->state_registration = $state_registration;
    }

    public function setCnpj(string $cnpj): void
    {
        $this->cnpj = $cnpj;
    }

    public function setMunicipalRegistration(string $municipal_registration): void
    {
        $this->municipal_registration = $municipal_registration;
    }

    public function setResponsible(string $responsible): void
    {
        $this->responsible = $responsible;
    }

    public function setFoundation(string $foundation): void
    {
        $this->foundation = $foundation;
    }

    public function setAddressId(string $address_id): void
    {
        $this->address_id = $address_id;
    }
}
