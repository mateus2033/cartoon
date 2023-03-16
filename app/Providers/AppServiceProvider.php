<?php

namespace App\Providers;

use App\Interfaces\Acquisitions\AcquisitionsRepositoryInterface;
use App\Interfaces\Address\AddressRepositoryInterface;
use App\Interfaces\BankData\BankDataRepositoryInterface;
use App\Interfaces\Carts\CartsRepositoryInterface;
use App\Interfaces\Category\CategoryRepositoryInterface;
use App\Interfaces\Payment\PaymentRepositoryInterface;
use App\Interfaces\Product\ProductRepositoryInterface;
use App\Interfaces\Stock\StockRepositoryInterface;
use App\Interfaces\User\UserRepositoryInterface;
use App\Repository\Acquisitions\AcquisitionsRespository;
use App\Repository\Address\AddressRepository;
use App\Repository\BankData\BankDataRepository;
use App\Repository\Carts\CartRepository;
use App\Repository\Category\CategoryRepository;
use App\Repository\Payment\PaymentRepository;
use App\Repository\Product\ProductRepository;
use App\Repository\Stock\StockRepository;
use App\Repository\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AcquisitionsRepositoryInterface::class, AcquisitionsRespository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        $this->app->bind(BankDataRepositoryInterface::class, BankDataRepository::class);
        $this->app->bind(CartsRepositoryInterface::class, CartRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(StockRepositoryInterface::class, StockRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
