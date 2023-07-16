<?php 

namespace Tests\Feature\Address;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class StorageAddressTest extends TestCase 
{
    private $rule;
    private $user;
    private string $token;

    public function execute(array $payload)
    {   
        return $this->postJson(route('address.storage'), $payload, ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {   
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('user')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function it_should_create_at_address_in_database()
    {
        /** @var Address $address */
        $address = $this->address()->setUserId($this->user->id)->make(5);

        /** @var Address $payload */
        $payload = $address->random();

        $this->execute($payload->toArray())->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('addresses', ['id' => 1]);
    }
}