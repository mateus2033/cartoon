<?php 

namespace Tests\Feature\BankData;

use Tests\TestCase;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class IndexBankDataTest extends TestCase 
{
    protected $rule;
    protected $user;
    protected string $token;

    public function execute($page)
    {   
        return $this->getJson(route('bank.data.index', $page), ['authorization' => 'Bearer ' . $this->token, 'Accept' => 'application/json']);
    }

    public function setUp(): void
    {   
        parent::setUp();
        $this->rule  = $this->rules()->setPermission('user')->create();
        $this->user  = $this->user()->setRuleId($this->rule->id)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test*/
    public function is_should_get_all_bank_data_in_database()
    {   
        /** @var bank $bank */
        $bank = $this->bank()->create();

        /** @var BankData $bankData */
        $bankData = $this->bankData()->setUserId($this->user->id)->setBankId($bank->id)->create(3);

        $page = 1;       
        $this->execute($page)->assertStatus(Response::HTTP_OK); 
    }
}