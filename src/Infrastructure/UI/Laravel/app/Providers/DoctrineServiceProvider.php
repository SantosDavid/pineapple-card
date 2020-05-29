<?php

namespace App\Providers;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Illuminate\Support\ServiceProvider;
use PineappleCard\Domain\Card\CardRepository;
use PineappleCard\Domain\Customer\CustomerRepository;
use PineappleCard\Domain\Invoice\InvoiceRepository;
use PineappleCard\Domain\Transaction\TransactionRepository;
use PineappleCard\Infrastructure\Persistence\Doctrine\Repository\DoctrineCardRepository;
use PineappleCard\Infrastructure\Persistence\Doctrine\Repository\DoctrineCustomerRepository;
use PineappleCard\Infrastructure\Persistence\Doctrine\Repository\DoctrineInvoiceRepository;
use PineappleCard\Infrastructure\Persistence\Doctrine\Repository\DoctrineTransactionRepository;
use PineappleCard\Infrastructure\Persistence\Doctrine\Types\CardTypeId;
use PineappleCard\Infrastructure\Persistence\Doctrine\Types\CustomerTypeId;
use PineappleCard\Infrastructure\Persistence\Doctrine\Types\InvoiceTypeId;
use PineappleCard\Infrastructure\Persistence\Doctrine\Types\TransactionTypeId;

class DoctrineServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(
            EntityManagerInterface::class,
            fn () => EntityManager::create($this->connection(), $this->config())
        );

        $this->types();

        $this->app->bind(CustomerRepository::class, DoctrineCustomerRepository::class);

        $this->app->bind(CardRepository::class, DoctrineCardRepository::class);

        $this->app->bind(InvoiceRepository::class, DoctrineInvoiceRepository::class);

        $this->app->bind(TransactionRepository::class, DoctrineTransactionRepository::class);
    }

    private function connection()
    {
        return DriverManager::getConnection(config('database.connections.mysql'));
    }

    private function config()
    {
        return Setup::createXMLMetadataConfiguration(
            [(__DIR__."/../../../../Persistence/Doctrine/Mapping")],
            ('app.env') === 'local'
        );
    }

    private function types()
    {
        if (!Type::hasType(CustomerTypeId::MYTYPE)) {
            Type::addType(CustomerTypeId::MYTYPE, CustomerTypeId::class);
        }

        if (!Type::hasType(CardTypeId::MYTYPE)) {
            Type::addType(CardTypeId::MYTYPE, CardTypeId::class);
        }

        if (!Type::hasType(InvoiceTypeId::MYTYPE)) {
            Type::addType(InvoiceTypeId::MYTYPE, InvoiceTypeId::class);
        }

        if (!Type::hasType(TransactionTypeId::MYTYPE)) {
            Type::addType(TransactionTypeId::MYTYPE, TransactionTypeId::class);
        }
    }
}
