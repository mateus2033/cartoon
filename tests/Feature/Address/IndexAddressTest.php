<?php

namespace Tests\Feature\Address;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class IndexAddressTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute()
    {   
        return $this->getJson(route('address.index'), ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('user')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function it_should_get_all_address_in_database()
    {
        /** @var Address $address */
        $address = $this->address()->setUserId($this->user->id)->create(5);

        /** @var Address $payload */
        $payload = $address->random();

        $this->execute()->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('addresses', ['id' => $payload->id]);
    }
}
