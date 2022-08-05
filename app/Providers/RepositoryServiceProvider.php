<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\{
ProductRepository,
UserRepository,
CategoryRepository,
BrandRepository,
OrderStatusRepository
};

use App\Interfaces\{
ProductRepositoryInterface,
UserRepositoryInterface,
CategoryRepositoryInterface,
BrandRepositoryInterface,
OrderStatusRepositoryInterface
};


class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(OrderStatusRepositoryInterface::class, OrderStatusRepository::class);
    }
    

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
