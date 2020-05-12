<?php

namespace Tests\Application\Transaction\Create;

use PHPUnit\Framework\TestCase;
use PineappleCard\Application\Invoice\FindOrCreate\FindOrCreateInvoiceService;
use PineappleCard\Application\Transaction\Create\CreateTransactionRequest;
use PineappleCard\Application\Transaction\Create\CreateTransactionService;
use PineappleCard\Domain\Shared\Exception\CardIdNotExistsException;
use PineappleCard\Infrastructure\Persistence\InMemory\CardInMemoryRepository;
use PineappleCard\Infrastructure\Persistence\InMemory\TransactionInMemoryRepository;

class CreateTransactionServiceTest extends TestCase
{
    private CardInMemoryRepository $cardRepository;

    private TransactionInMemoryRepository $transactionRepository;

    private CreateTransactionService $service;

    private FindOrCreateInvoiceService $findOrCreateInvoiceService;

    public function setUp(): void
    {
        $this->transactionRepository = new TransactionInMemoryRepository();
        $this->cardRepository = new CardInMemoryRepository();
        $this->findOrCreateInvoiceService = new FindOrCreateInvoiceServiceFake();

        $this->service = new CreateTransactionService(
            $this->transactionRepository,
            $this->cardRepository,
            $this->findOrCreateInvoiceService
        );
    }

    public function testShouldRaiseExceptionWhenCardIdDoNotExists()
    {
        $this->expectException(CardIdNotExistsException::class);

        $request = (new CreateTransactionRequest())->setCardId('1');


        $this->service->execute($request);
    }
}
