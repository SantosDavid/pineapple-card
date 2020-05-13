<?php

$api = app('Dingo\Api\Routing\Router');

$api->group(['namespace' => 'App\Http\Controllers\Api\V1', 'version' => 'v1'], function ($api) {
    $api->post('sign-up', 'CustomerController@store');

    $api->post('login', 'AuthController@login');

    $api->group(['middleware' => 'api.auth'], function ($api) {
        $api->post('me/cards', 'CardController@store');

        $api->get('me/points', 'CustomerController@points');

        $api->post('me/transactions', 'TransactionController@store');
        $api->post('me/transactions/{transactionId}/refunded', 'TransactionController@refunded');

        $api->post('me/invoices/{invoiceId}/pay', 'InvoiceController@pay');

        $api->get('me/invoices/overview', 'InvoiceController@overview');
    });
});
