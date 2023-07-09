<?php

namespace Tests\Feature\BankData;

use Tests\TestCase;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class DestroyBankDataTest extends TestCase
{
    protected $rule;
    protected $user;
    protected string $token;

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
    }
}
