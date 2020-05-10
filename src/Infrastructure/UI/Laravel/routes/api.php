<?php

use Illuminate\Support\Facades\Route;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->post('sign-in', 'App\Http\Controllers\Api\V1\CustomerController@store');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', 'Api\V1\AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'Api\V1\AuthController@me');

});