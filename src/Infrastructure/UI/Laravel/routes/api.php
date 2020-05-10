<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->post('sign-in', 'App\Http\Controllers\Api\V1\CustomerController@store');
});
