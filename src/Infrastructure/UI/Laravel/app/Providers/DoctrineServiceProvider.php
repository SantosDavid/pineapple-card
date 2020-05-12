<?php

namespace App\Providers;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Illuminate\Support\ServiceProvider;
use Doctrine\ORM\EntityManager;
use PineappleCard\Domain\Invoice\InvoiceId;
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
