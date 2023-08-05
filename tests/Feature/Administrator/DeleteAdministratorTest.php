<?php

namespace Tests\Feature\Administrator;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class DeleteAdministratorTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute(array $payload)
    {
        return $this->deleteJson(route('delete.administrator'), $payload, ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('user')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_delete_administrator_in_database()
    {
        /** @var User $administrator */
        $administrator = $this->administrator()->create(10);

        $payload = [
            'adm_id' => $administrator->random()->id
        ];

        $this->execute($payload)->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('users', ['adm_id' => $administrator->random()->id]);
    }
}
