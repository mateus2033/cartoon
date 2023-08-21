<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $table = 'banks';

    protected $fillable = [
        'id',
        'code',
        'name',
        'active'
    ];

    private int $id;
    private string $code;
    private string $name;
    private string $active;

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getActive(): string
    {
        return $this->active;
    }

    public function setActive(string $active): void
    {
        $this->active = $active;
    }

    public function bankData()
    {
        return $this->hasMany(BankData::class, 'bank_id');
    }
}
