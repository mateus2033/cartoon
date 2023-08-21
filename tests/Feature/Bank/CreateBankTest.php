<?php

namespace Tests\Feature\Bank;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class CreateBankTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute(array $payload)
    {   
        return $this->postJson(route('storage.bank'), $payload, ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('admin')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_create_bank_in_database()
    {
        /** @var Bank $bank */
        $bank = $this->bank()->setName('Test')->setCode('777')->setActive('Y')->make();
    
        $this->execute($bank->toArray())->assertStatus(Response::HTTP_CREATED); 
        $this->assertDatabaseHas('banks',['code' => $bank->code, 'name' => $bank->name]); 
    }
}
