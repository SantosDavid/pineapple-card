<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MongoDB\Client;
use PineappleCard\Domain\Card\CardRepository;
use PineappleCard\Domain\Customer\CustomerRepository;
use PineappleCard\Domain\Invoice\InvoiceRepository;
use PineappleCard\Domain\Transaction\TransactionRepository;
use PineappleCard\Infrastructure\Persistence\MongoDB\MongoDBCardRepository;
use PineappleCard\Infrastructure\Persistence\MongoDB\MongoDBCustomerRepository;
use PineappleCard\Infrastructure\Persistence\MongoDB\MongoDBInvoiceRepository;
use PineappleCard\Infrastructure\Persistence\MongoDB\MongoDBTransactionRepository;

class MongoDBServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(Client::class, function () {
            return new Client(
                config('database.connections.mongo.url'),
                config('database.connections.mongo.options')
            );
        });


        $this->app->bind(CustomerRepository::class, MongoDBCustomerRepository::class);

        $this->app->bind(CardRepository::class, MongoDBCardRepository::class);

        $this->app->bind(InvoiceRepository::class, MongoDBInvoiceRepository::class);

        $this->app->bind(TransactionRepository::class, MongoDBTransactionRepository::class);
    }
}
