<?php

namespace App\Providers;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Illuminate\Support\ServiceProvider;
use Doctrine\ORM\EntityManager;

class DoctrineServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(
            EntityManagerInterface::class,
            fn () => EntityManager::create($this->connection(), $this->config())
        );
    }

    private function connection()
    {
        return DriverManager::getConnection(config('database.connections.mysql'));
    }

    private function config()
    {
        return Setup::createXMLMetadataConfiguration(
            [(__DIR__."/../../../../Persistence/Doctrine/Mapping")],
            config('app.env') === 'local'
        );
    }
}
