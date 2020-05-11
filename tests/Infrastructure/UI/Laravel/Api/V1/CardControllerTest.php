<?php

namespace Tests\Infrastructure\UI\Laravel\Api\V1;

use PineappleCard\Domain\Card\Card;
use PineappleCard\Domain\Customer\Customer;
use Tests\Infrastructure\UI\Laravel\TestCase;

class CardControllerTest extends TestCase
{
    private Customer $customer;

    public function setUp(): void
    {
        parent::setUp();

        $this->customer = $this->actingAsCustomer();
    }

    public function testShouldStoreCardInDatabase()
    {
        $response = $this->postJson("api/customers/{$this->customer->id()->id()}/cards");


        $response->assertCreated();
        $response->assertJsonStructure(['id']);
        $this->assertDatabaseHasId(Card::class, $response->json('id'));
    }
}
