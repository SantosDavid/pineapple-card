<?php

namespace Tests\Infrastructure\UI\Laravel\Api\V1;

use PineappleCard\Domain\Card\Card;
use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Card\CardRepository;
use PineappleCard\Domain\Customer\Customer;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Shared\ValueObject\Auth;
use PineappleCard\Domain\Shared\ValueObject\Money;
use PineappleCard\Domain\Transaction\Transaction;
use Tests\Infrastructure\UI\Laravel\TestCase;

class TransactionControllerTest extends TestCase
{
    private Customer $customer;

    private CardId $cardId;

    public function setUp(): void
    {
        parent::setUp();

        $this->customer = $this->actingAsCustomer();

        $cardRepository = app(CardRepository::class);

        $this->cardId = $cardRepository->create((new Card(
            new CardId(),
            $this->customer->id(),
        )))->id();
    }

    public function testShouldCreateTransaction()
    {
        $data = [
            'value' => 99.99,
            'latitude' => "40.7143528",
            'longitude' => '-74.0059731',
            'category' => 1,
            'card_id' => $this->cardId->id(),
        ];


        $response = $this->postJson('api/me/transactions', $data);


        $response->assertCreated();
        $response->assertJsonStructure(['id']);
        $this->assertDatabaseHasId(Transaction::class, $response->json('id'));
    }
}
