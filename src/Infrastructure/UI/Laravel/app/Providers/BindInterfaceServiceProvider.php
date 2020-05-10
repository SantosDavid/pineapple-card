<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PineappleCard\Domain\Customer\CustomerRepository;
use PineappleCard\Infrastructure\Persistence\Doctrine\Repository\DoctrineCustomerRepository;

class BindInterfaceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(CustomerRepository::class, DoctrineCustomerRepository::class);
    }
}
