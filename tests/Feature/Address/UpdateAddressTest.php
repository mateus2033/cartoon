<?php

namespace Tests\Feature\Address;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class UpdateAddressTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute(array $payload)
    {   
        return $this->putJson(route('address.update'), $payload, ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('user')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function it_should_update_at_address_in_database()
    {
        /** @var Address $address */
        $address = $this->address()->setUserId($this->user->id)->create(5);

        /** @var Address $payload */
        $addressCurrent = $address->random();

        /** @var Address $addressUpdate */
        $payload = $this->address()->setId($addressCurrent->id)->setStreet('Rua Andorinha')->setUserId($this->user->id)->make();

        $this->execute($payload->toArray())->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('addresses', ['id' => $payload->id, 'street' => $payload->street]);
    }
}
