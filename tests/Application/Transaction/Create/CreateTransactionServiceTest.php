<?php

namespace Tests\Application\Transaction\Create;

use PHPUnit\Framework\TestCase;
use PineappleCard\Application\Transaction\Create\CreateTransactionRequest;
use PineappleCard\Application\Transaction\Create\CreateTransactionService;
use PineappleCard\Domain\Card\Card;
use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Invoice\InvoiceId;
use PineappleCard\Domain\Shared\Exception\CardIdNotExistsException;
use PineappleCard\Infrastructure\Persistence\InMemory\CardInMemoryRepository;
use PineappleCard\Infrastructure\Persistence\InMemory\TransactionInMemoryRepository;

class CreateTransactionServiceTest extends TestCase
{
    private CardInMemoryRepository $cardRepository;

    private TransactionInMemoryRepository $transactionRepository;

    private CreateTransactionService $service;

    public function setUp(): void
    {
        $this->transactionRepository = new TransactionInMemoryRepository();
        $this->cardRepository = new CardInMemoryRepository();

        $this->service = new CreateTransactionService(
            $this->transactionRepository,
            $this->cardRepository
        );
    }

    public function testShouldRaiseExceptionWhenCardIdDoNotExists()
    {
        $this->expectException(CardIdNotExistsException::class);

        $request = (new CreateTransactionRequest())->setCardId('1');


        $this->service->execute($request);
    }

    public function testShouldCreateTransaction()
    {
        $cardId = new CardId('1');

        $request = (new CreateTransactionRequest())
            ->setValue(100)
            ->setLatitude(1)
            ->setLongitude(2)
            ->setCategory(1)
            ->setCardId($cardId->id())
            ->setInvoiceId(new InvoiceId());

        $this->cardRepository->create(new Card($cardId, new CustomerId()));


        $this->service->execute($request);


        $this->assertEquals(1, $this->transactionRepository->countItems());
    }
}
