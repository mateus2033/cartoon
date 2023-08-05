<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class DestroyUserTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute(array $payload)
    {
        return $this->deleteJson(route('destroy.user'), $payload, ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('user')->setId(2)->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_destroy_user_in_database()
    {
        $payload = [
            'user_id' => $this->user->id
        ];

        $this->execute($payload)->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    }
}
