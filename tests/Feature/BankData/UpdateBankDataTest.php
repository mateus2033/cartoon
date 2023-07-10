<?php

namespace Tests\Feature\BankData;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;


class UpdateBankDataTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute(array $payload)
    {
        return $this->putJson(route('bank.data.update'), $payload, ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('user')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_update_bank_data_in_database()
    {
        /** @var bank $bank */
        $bank = $this->bank()->setActive('Y')->setName('Sicoob')->setCode('337')->create();

        /** @var BankData $bankData */
        $bankData = $this->bankData()->setUserId($this->user->id)->setBankId($bank->id)->create();

        $payload = array_merge(
            $bankData->toArray(),
            $bank->toArray()
        );

        $this->execute($payload)->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('bank_data', [
            'id'              => $bankData->id, 
            'number_card'     => $bankData->number_card, 
            'number_agency'   => $bankData->number_agency, 
            'number_security' => $bankData->number_security, 
            'user_id' => $bankData->user_id, 
            'bank_id' => $bankData->bank_id, 
        ]);
    }
}
