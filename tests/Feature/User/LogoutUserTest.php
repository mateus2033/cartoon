<?php 

namespace Tests\Feature\User;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class LogoutUserTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute()
    {   
        return $this->getJson(route('logout.user'), ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('user')->setId(2)->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_logout_user_in_database()
    {
        $response = $this->execute()->assertStatus(Response::HTTP_OK);
        $response->assertExactJson(['message' => 'Successfully logged out']);
    }
}