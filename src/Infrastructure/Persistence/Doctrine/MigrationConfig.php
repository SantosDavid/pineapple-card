<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../UI/Laravel');
$dotenv->load();

return [
    'dbname' => env('DB_DATABASE'),
    'user' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    'host' => env('DB_HOST'),
    'driver' => env('DB_DRIVER'),
];
