<?php 

namespace Tests\Feature\Administrator;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class ShowAdministratorTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute()
    {  
        return $this->getJson(route('show.administrator'), ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('admin')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_show_administrator_in_database()
    {
        $this->execute()->assertStatus(Response::HTTP_OK);  
        $this->assertDatabaseHas('users',['id' => $this->user->id]);
    }
}