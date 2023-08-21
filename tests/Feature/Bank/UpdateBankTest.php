<?php

namespace Tests\Feature\Bank;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class UpdateBankTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute(array $payload)
    {
        return $this->putJson(route('update.bank'), $payload, ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('admin')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_update_bank_in_database()
    {
        /** @var Collect $bank */
        $bank = $this->bank()->create(3);

        /** @var Bank $current */
        $current = $bank->random();

        /** @var Bank $bank_fake */
        $bank_update = $this->bank()->setId($current->id)->setName('Sombreiro')->setCode('465')->setActive('Y')->make();

        $this->execute($bank_update->toArray())->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('banks', [
            'id'   => $bank_update->id,
            'name' => $bank_update->name,
            'code' => $bank_update->code
        ]);
    }

    /** @test*/
    public function must_not_update_when_bank_not_found()
    {
        /** @var Collect $bank */
        $bank = $this->bank()->create(3);

        /** @var Bank $current */
        $current = $bank->random();

        /** @var Bank $bank_fake */
        $bank_update = $this->bank()->setId(1000)->setName('Sombreiro')->setCode('465')->setActive('Y')->make();

        $response = $this->execute($bank_update->toArray());
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonFragment(['error' => "Bank not found"]);
    }
}
