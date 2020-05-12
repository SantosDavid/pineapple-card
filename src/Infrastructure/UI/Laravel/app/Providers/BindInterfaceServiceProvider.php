<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PineappleCard\Domain\Card\CardRepository;
use PineappleCard\Domain\Customer\CustomerRepository;
use PineappleCard\Domain\Invoice\InvoiceRepository;
use PineappleCard\Infrastructure\Persistence\Doctrine\Repository\DoctrineCardRepository;
use PineappleCard\Infrastructure\Persistence\Doctrine\Repository\DoctrineCustomerRepository;
use PineappleCard\Infrastructure\Persistence\Doctrine\Repository\DoctrineInvoiceRepository;

class BindInterfaceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(CustomerRepository::class, DoctrineCustomerRepository::class);

        $this->app->bind(CardRepository::class, DoctrineCardRepository::class);

        $this->app->bind(InvoiceRepository::class, DoctrineInvoiceRepository::class);
    }
}
