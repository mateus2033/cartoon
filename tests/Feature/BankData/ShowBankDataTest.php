<?php

namespace Tests\Feature\BankData;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class ShowBankDataTest extends TestCase
{
    protected $rule;
    protected $user;
    protected string $token;

    public function execute($id)
    {
        return $this->getJson(route('bank.data.show', $id), ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('user')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_show_bank_data_in_database()
    {
        /** @var BankData $bankData */
        $bankData = $this->bankData()->setUserId($this->user->id)->create();

        $this->execute($bankData->id)->assertStatus(Response::HTTP_OK);
    }
}
