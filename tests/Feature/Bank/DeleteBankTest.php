<?php

namespace Tests\Feature\Bank;

use App\Models\BankData;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class DeleteBankTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute(array $payload)
    {   
        return $this->deleteJson(route('delete.bank'), $payload, ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('admin')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_delete_bank_in_database()
    {
        /** @var Collect $bank */
        $bank = $this->bank()->setActive('N')->create(3);

        /** @var Bank $bank_current */
        $bank_current = $bank->random();

        $payload = [
            'bank_id' => $bank_current->id
        ];

        $this->execute($payload)->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('banks', ['id' => $bank_current->id]);
    }


    /** @test*/
    public function must_not_delete_an_active_bank()
    {
        /** @var Collect $bank */
        $bank = $this->bank()->setActive('Y')->create(3);

        /** @var Bank $bank_current */
        $bank_current = $bank->random();

        $payload = [
            'bank_id' => $bank_current->id
        ];

        $response = $this->execute($payload);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonFragment(['error' => "active banks cannot be deleted"]);
    }

    /** @test*/
    public function must_not_delete_bank_with_active_relaship()
    {
        /** @var Collect $bank */
        $bank = $this->bank()->setActive('N')->create(3);

        /** @var Bank $bank_current */
        $bank_current = $bank->random();

        /** @var BankData $bank_data  */
        $bank_data = $this->bankData()->setBankId($bank_current->id)->create();

        $payload = [
            'bank_id' => $bank_current->id
        ];

        $response = $this->execute($payload);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonFragment(['error' => "Bank with active relaship"]);
    }
}
