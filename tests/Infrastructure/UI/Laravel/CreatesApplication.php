<?php

namespace Tests\Infrastructure\UI\Laravel;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Config;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require '/app/src/Infrastructure/UI/Laravel/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        Config::set('database.connections.mysql', [
            'driver' => 'pdo_sqlite',
            'path' => env('SQLITE_PATH'),
        ]);

        $this->refreshDatabase();

        return $app;
    }

    public function refreshDatabase()
    {
        try {
            unlink(env('SQLITE_PATH'));
        } catch (\Throwable $e) {

        }

        exec('./vendor/bin/doctrine-migrations migrations:migrate --db-configuration=tests/Infrastructure/Persistence/Doctrine/MigrationTestConfig.php --no-interaction');
    }
}
