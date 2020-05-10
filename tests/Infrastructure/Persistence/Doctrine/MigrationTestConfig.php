<?php

$dotenv = Dotenv\Dotenv::createImmutable('/app/src/Infrastructure/UI/Laravel');
$dotenv->load();

return [
    'path' => env('SQLITE_PATH'),
    'driver' => 'pdo_sqlite',
];
