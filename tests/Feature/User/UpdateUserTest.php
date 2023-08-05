<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;


class UpdateUserTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute(array $payload)
    {   //dd($this->putJson(route('update.user'), $payload, ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']));
        return $this->putJson(route('update.user'), $payload, ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('user')->setId(2)->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_update_photo_user_in_database()
    {
        /** @var User $administrator */
        $user = $this->user()->setCellphone('(27)9999-7777')->make();

        $payload = [
            'id'        => $this->user->id,
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
        $this->assertDatabaseHas('users', ['id' => $payload['id'], 'name' => $payload['name'], 'cpf' => $payload['cpf']]);
    }
}
