<?php 

namespace Tests\Feature\User;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class ShowUserTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute()
    {   
        return $this->getJson(route('show.user'), ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('user')->setId(2)->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_show_user_in_database()
    {
        $this->execute()->assertStatus(Response::HTTP_OK);  
        $this->assertDatabaseHas('users',['id' => $this->user->id]);
    }
}