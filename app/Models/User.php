<?php

namespace App\Models;

use OpenApi\Annotations as OA;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * @OA\Property(
     *     title="Id",
     *     description="Id",
     *     format="int64",
     * )
     *
     * @var integer
     */
    private int    $id;


    /**
     * @OA\Property(
     *     title="Name",
     *     description="Name",
     *     format="string"
     * )
     *
     * @var integer
     */
    private string $name;

    /**
     * @OA\Property(
     *     title="Last Name",
     *     description="last Name",
     *     format="string"
     * )
     *
     * @var integer
     */
    private string $lastName;

    /**
     * @OA\Property(
     *     title="Cpf",
     *     description="Cpf",
     *     format="string"
     * )
     *
     * @var integer
     */
    private string $cpf;

    /**
     * @OA\Property(
     *     title="Cpf",
     *     description="Cpf",
     *     format="datetime",
     *     format="string"
     * )
     *
     * @var string
     */
    private string $dataBirth;

    /**
     * @OA\Property(
     *     title="Cellphone",
     *     description="Number of cellphone",
     *     format="string"
     * )
     *
     * @var string
     */
    private string $cellphone;

    /**
     * @OA\Property(
     *     title="Image",
     *     description="Photo Perfil",
     *     format="string"
     * )
     *
     * @var string
     */
    private string $image;

    /**
     * @OA\Property(
     *     title="Email",
     *     description="Your Email",
     *     format="file"
     * )
     *
     * @var string
     */
    private string $email;

    /**
     * @OA\Property(
     *     title="Password",
     *     description="Your Password",
     *     format="string"
     * )
     *
     * @var string
     */
    private string $password;


    private $rule_id;
    private string $email_verified_at;

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * Get the value of cpf
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     *
     * @return  self
     */
    public function setCpf($cpf): void
    {
        $this->cpf = $cpf;
    }

    /**
     * Get the value of dataBirth
     */
    public function getDataBirth(): string
    {
        return $this->dataBirth;
    }

    /**
     * Set the value of dataBirth
     *
     */
    public function setDataBirth($dataBirth): void
    {
        $this->dataBirth = $dataBirth;
    }

    /**
     * Get the value of cellphone
     */
    public function getCellphone(): string
    {
        return $this->cellphone;
    }

    /**
     * Set the value of cellphone
     *
     */
    public function setCellphone($cellphone): void
    {
        $this->cellphone = $cellphone;
    }

    /**
     * Get the value of image
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * Get the value of rule_id
     */
    public function getRule_id(): string
    {
        return $this->rule_id;
    }

    /**
     * Set the value of rule_id
     */
    public function setRule_id($rule_id): void
    {
        $this->rule_id = $rule_id;
    }

    /**
     * Get the value of email_verified_at
     */
    public function getEmail_verified_at(): string
    {
        return $this->email_verified_at;
    }

    /**
     * Set the value of email_verified_at
     */
    public function setEmail_verified_at($email_verified_at): void
    {
        $this->email_verified_at = $email_verified_at;
    }

    public function address()
    {
        return $this->hasMany(Address::class, 'user_id');
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
