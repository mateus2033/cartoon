<?php 

namespace Tests\Feature\Product;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class IndexMoreSoldTest extends TestCase 
{
    private $rule;
    private $user;
    private string $token;

    public function execute()
    {   
        return $this->getJson(route('product.index.more.sold'), ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('admin')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_index_product_more_sold_of_database()
    {
        $this->execute()->assertStatus(Response::HTTP_OK);
    }
}