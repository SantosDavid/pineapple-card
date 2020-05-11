<?php

$api = app('Dingo\Api\Routing\Router');

$api->group(['namespace' => 'App\Http\Controllers\Api\V1', 'version' => 'v1'], function ($api) {
    $api->post('sign-up', 'CustomerController@store');

    $api->post('login', 'AuthController@login');

    $api->group(['middleware' => 'api.auth'], function ($api) {
        $api->post('customers/{customer_id}/cards', 'CardController@store');
    });
});
