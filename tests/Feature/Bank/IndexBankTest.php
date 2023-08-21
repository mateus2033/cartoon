<?php

namespace Tests\Feature\Bank;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class IndexBankTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute(int $page)
    {   
        return $this->getJson(route('index.bank',$page),['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('admin')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_index_bank_in_database()
    {
        /** @var int $page */
        $page = 1;

        /** @var Bank $bank */
        $bank = $this->bank()->create(3);

        $current = $bank->random();

        $this->execute($page)->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('banks', ['id' => $current->id]);
    }
}
