<?php

namespace Tests\Feature\Administrator;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class UpdateAdministratorTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute(array $payload)
    {   
        return $this->putJson(route('update.administrator'), $payload, ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('admin')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_update_administrator_in_database()
    {
        /** @var User $administrator */
        $administrator = $this->administrator()->setCellphone('(27)9999-7777')->make();

        $payload = [
            'id'        => $this->user->id,
            'name'      => $administrator->name,
            'lastName'  => $administrator->lastName,
            'cpf'       => $administrator->cpf,
            'dataBirth' => $administrator->dataBirth,
            'cellphone' => $administrator->cellphone,
            'image'     => $administrator->image,
            'email'     => $administrator->email,
            'password'  => '13245678',
        ];
        
        $this->execute($payload)->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('users', ['id' => $payload['id'], 'name'=> $payload['name'], 'cpf' => $payload['cpf']]);
    }
}
