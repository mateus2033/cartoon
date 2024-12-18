<?php

namespace Tests\Feature\BankData;

use Tests\TestCase;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class DestroyBankDataTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute($payload)
    {
        return $this->deleteJson(route('bank.data.delete'), $payload, ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('user')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_delete_bank_data_in_database()
    {
        /** @var BankData $bankData */
        $bankData = $this->bankData()->setUserId($this->user->id)->create();

        $payload = [
            'user_id'     => $this->user->id,
            'bankdata_id' => $bankData->id   
        ];

        $this->execute($payload)->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('bank_data', [
            'id'              => $bankData->id, 
            'number_card'     => $bankData->number_card, 
            'number_agency'   => $bankData->number_agency, 
            'number_security' => $bankData->number_security, 
            'user_id' => $bankData->user_id, 
            'bank_id' => $bankData->bank_id, 
        ]);
    }
}
