<?php

namespace Tests\Feature\Product;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class DestroyProductTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute(array $payload)
    {   
        return $this->deleteJson(route('product.destroy'), $payload, ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('admin')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_destroy_product_of_database()
    {
        /** @var Collect $products */
        $products = $this->product()->create(10);

        /** @var Product $product */
        $product = $products->random();

        $payload = [
            'id' => $product->id
        ];

        $this->execute($payload)->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test*/
    public function is_should_return_product_not_found_when_destroy()
    {
        /** @var Collect $products */
        $products = $this->product()->create(10);

        $payload = [
            'id' => 9999
        ];

        $this->execute($payload)->assertStatus(Response::HTTP_BAD_REQUEST);
        $this->assertDatabaseMissing('products', ['id' => $payload['id']]);
    }
}
