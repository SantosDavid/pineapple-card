<?php

namespace Tests\Infrastructure\UI\Laravel\Api\V1;

use PineappleCard\Domain\Customer\Customer;
use Tests\Infrastructure\UI\Laravel\TestCase;

class CustomerControllerTest extends TestCase
{
    public function testShouldCreateCustomer()
    {
        $data = ['limit' => 500, 'pay_day' => 10];


        $response = $this->postJson('api/sign-in', $data);


        $response->assertCreated();
        $response->assertJsonStructure(['id']);
        $this->assertDatabaseHasId(Customer::class, $response->json('id'));
    }

    public function testShouldReturnStatusCode400WhenRequestHasDayNotValid()
    {
        $data = ['limit' => 500, 'pay_day' => 11];


        $response = $this->postJson('api/sign-in', $data);


        $response->assertStatus(400);
        $response->assertJsonMissing(['id']);
    }
}
