<?php

namespace App\Models;

use OpenApi\Annotations as OA;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * User
 * @package Mateus2033
 * @author  Mateus2033
 * @OA\Schema(
 *     title="User",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $fillable = [
        'id',
        'name',
        'lastName',
        'cpf',
        'dataBirth',
        'cellphone',
        'image',
        'email',
        'password',
        'rule_id',
        'email_verified_at'
    ];
  
    private int $id;
    private string $name;
    private string $lastName;
    private string $cpf;
    private string $dataBirth;
    private string $cellphone;
    private string $image;
    private string $email;
    private string $password;
    private $rule_id;
    private string $email_verified_at;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function setCpf($cpf): void
    {
        $this->cpf = $cpf;
    }

    public function getDataBirth(): string
    {
        return $this->dataBirth;
    }

    public function setDataBirth($dataBirth): void
    {
        $this->dataBirth = $dataBirth;
    }

    public function getCellphone(): string
    {
        return $this->cellphone;
    }

    public function setCellphone($cellphone): void
    {
        $this->cellphone = $cellphone;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getRule_id(): string
    {
        return $this->rule_id;
    }

    public function setRule_id($rule_id): void
    {
        $this->rule_id = $rule_id;
    }

    public function getEmail_verified_at(): string
    {
        return $this->email_verified_at;
    }

    public function setEmail_verified_at($email_verified_at): void
    {
        $this->email_verified_at = $email_verified_at;
    }

    public function rules()
    {
        return $this->belongsTo(Rules::class, 'rule_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'id'   => $this->getAttribute('id'),
            'rule'  =>  $this->getAttribute('rule_id'),
        ];
    }
}
