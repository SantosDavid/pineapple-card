<?php

namespace Tests\Application\Transaction\Create;

use PHPUnit\Framework\TestCase;
use PineappleCard\Application\Customer\AvailableLimit\AvailableLimitResponse;
use PineappleCard\Application\Customer\AvailableLimit\AvailableLimitService;
use PineappleCard\Application\Invoice\FindOrCreate\FindOrCreateInvoiceService;
use PineappleCard\Application\Transaction\Create\CreateTransactionRequest;
use PineappleCard\Application\Transaction\Create\CreateTransactionService;
use PineappleCard\Domain\Card\Card;
use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\Exception\InsufficientLimitException;
use PineappleCard\Domain\Shared\Exception\CardIdNotExistsException;
use PineappleCard\Infrastructure\Persistence\InMemory\CardInMemoryRepository;
use PineappleCard\Infrastructure\Persistence\InMemory\TransactionInMemoryRepository;

class CreateTransactionServiceTest extends TestCase
{
    private CardInMemoryRepository $cardRepository;

    private TransactionInMemoryRepository $transactionRepository;

    private CreateTransactionService $service;

    private FindOrCreateInvoiceService $findOrCreateInvoiceService;

    private $availableLimitServiceMock;

    public function setUp(): void
    {
        $this->transactionRepository = new TransactionInMemoryRepository();
        $this->cardRepository = new CardInMemoryRepository();
        $this->findOrCreateInvoiceService = new FindOrCreateInvoiceServiceFake();
        $this->availableLimitServiceMock = $this->createMock(AvailableLimitService::class);

        $this->service = new CreateTransactionService(
            $this->transactionRepository,
            $this->cardRepository,
            $this->findOrCreateInvoiceService,
            $this->availableLimitServiceMock
        );
    }

    public function testShouldRaiseExceptionWhenCardIdDoNotExists()
    {
        $this->expectException(CardIdNotExistsException::class);

        $request = (new CreateTransactionRequest())->setCardId('1')->setCustomerId(1);


        $this->service->execute($request);
    }

    public function testShouldRaiseExceptionWhenCustomerHasInsufficientLimit()
    {
        $this->expectException(InsufficientLimitException::class);

        $this->cardRepository->create(new Card($cardId = new CardId, $customerId = new CustomerId()));

        $request = (new CreateTransactionRequest())
            ->setValue(100)
            ->setCardId($cardId->id())
            ->setCustomerId($customerId->id());

        $this->availableLimitServiceMock
            ->method('execute')
            ->willReturn(new AvailableLimitResponse(0));


        $this->service->execute($request);
    }
}
