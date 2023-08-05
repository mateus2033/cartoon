<?php

namespace Tests\Feature\Administrator;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class LogoutAdministratorTest extends TestCase
{
    private $rule;
    private $administrator;
    private string $token;

    public function execute()
    {   
        return $this->getJson(route('logout.administrator'), ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('admin')->create();
        $this->administrator  = $this->administrator()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->administrator);
    }

    /** @test*/
    public function is_should_logout_administrator_in_database()
    {  
        $response = $this->execute()->assertStatus(Response::HTTP_OK);
        $response->assertExactJson(['message' => 'Successfully logged out']);
    }
}
