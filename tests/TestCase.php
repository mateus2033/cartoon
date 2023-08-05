<?php

namespace Tests;

use Tests\CreatesApplication;
use Tests\Builders\Users\UserBuilder;
use Tests\Builders\BankData\BankDataBuilder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Builders\Address\AddressBuilder;
use Tests\Builders\Administrator\AdministratorBuilder;
use Tests\Builders\Bank\BankBuilder;
use Tests\Builders\Rules\RulesBuilder;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions, DatabaseMigrations;

    public function user(): UserBuilder 
    {
        return new UserBuilder;
    }

    public function bankData(): BankDataBuilder
    {
        return new BankDataBuilder;
    }

    public function bank(): BankBuilder
    {
        return new BankBuilder;
    }

    public function rules(): RulesBuilder
    {
        return new RulesBuilder;
    }

    public function address(): AddressBuilder 
    {
        return new AddressBuilder;
    }

    public function administrator(): AdministratorBuilder
    {
        return new AdministratorBuilder;
    }
}
