<?php

namespace Tests\Feature\Administrator;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class SaveUserTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute(array $payload)
    {
        return $this->postJson(route('save.user'), $payload, ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('user')->setId(2)->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_create_user_in_database()
    {
        /** @var User $user */
        $user = $this->user()->setCellphone('(27)9999-7777')->make();

        $payload = [
            'name'      => $user->name,
            'lastName'  => $user->lastName,
            'cpf'       => $user->cpf,
            'dataBirth' => $user->dataBirth,
            'cellphone' => $user->cellphone,
            'image'     => $user->image,
            'email'     => $user->email,
            'password'  => '13245678',
        ];

        $this->execute($payload)->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('users', [
            'name'  => $payload['name'],
            'email' => $payload['email'],
            'cpf'   => $payload['cpf'],
            'cellphone' => $payload['cellphone']
        ]);
    }
}
