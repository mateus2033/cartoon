<?php

namespace Tests\Feature\Product;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class ShowProductTest extends TestCase
{
    private $rule;
    private $user;
    private string $token;

    public function execute(int $product_id)
    {
        return $this->getJson(route('product.show', $product_id), ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('admin')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_show_product_of_database()
    {
        /** @var Collect $products */
        $products = $this->product()->create(10);

        /** @var Product $product */
        $product = $products->random();

        $product_id = $product->id;

        $this->execute($product_id)->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    /** @test*/
    public function is_should_return_product_not_found()
    {
        /** @var Collect $products */
        $products = $this->product()->create(10);

        /** @var int $product_id */
        $product_id = 9999;

        $this->execute($product_id)->assertStatus(Response::HTTP_NOT_FOUND);
        $this->assertDatabaseMissing('products', ['id' => $product_id]);
    }
}
