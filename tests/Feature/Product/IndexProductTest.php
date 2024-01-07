<?php

namespace Tests\Feature\Product;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;


class IndexProductTest extends TestCase
{

    private $rule;
    private $user;
    private string $token;

    public function execute($payload)
    {   //dd( $this->getJson(route('product.index', $payload), ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']));
        return $this->getJson(route('product.index', $payload), ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('admin')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_index_product_of_database()
    {
        $payload = [
            "page"=>1,
            "perpage"=>10,
            "paginate"=>true
        ];
        
        /** @var Collect $products */
        $products = $this->product()->create(10);

        /** @var Product $product */
        $product = $products->random();

        $this->execute($payload)->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }
}
