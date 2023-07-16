<?php

namespace Tests\Feature\Address;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class DestroyAddressTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute($payload)
    {   
        return $this->deleteJson(route('address.destroy'),$payload, ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('user')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function it_should_delete_address_in_database()
    {
        /** @var Address $address */
        $address = $this->address()->setUserId($this->user->id)->create(5);

        /** @var Address $payload */
        $address_current = $address->random();

        $payload = [
            'id' => $address_current->id
        ];

        $this->execute($payload)->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('addresses', ['id' => $payload['id']]);
    }
}
