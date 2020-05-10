<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->post('sign-up', 'App\Http\Controllers\Api\V1\CustomerController@store');

    $api->post('login', 'App\Http\Controllers\Api\V1\AuthController@login');

    $api->group(['middleware' => 'api.auth'], function ($api) {
        // authenticated routes
    });
});
