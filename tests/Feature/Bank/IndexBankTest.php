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

    public function execute($data)
    {   
        return $this->getJson(route('index.bank',$data),['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
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
        $payload = [
            "page" => 1,
            "perpage" => 10,
            "paginate" => true
        ];

        /** @var Bank $bank */
        $bank = $this->bank()->create(3);

        $current = $bank->random();

        $this->execute($payload)->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('banks', ['id' => $current->id]);
    }
}
