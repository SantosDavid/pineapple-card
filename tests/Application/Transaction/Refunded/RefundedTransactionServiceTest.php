<?php

namespace Tests\Application\Transaction\Refunded;

use PHPUnit\Framework\TestCase;
use PineappleCard\Application\Transaction\Refunded\RefundTransactionRequest;
use PineappleCard\Application\Transaction\Refunded\RefundTransactionService;
use PineappleCard\Domain\Card\Card;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Transaction\Exception\TransactionNotFoundException;
use PineappleCard\Infrastructure\Persistence\InMemory\CardInMemoryRepository;
use PineappleCard\Infrastructure\Persistence\InMemory\TransactionInMemoryRepository;
use Tests\Application\Shared\CreateTransactionHelper;

class RefundedTransactionServiceTest extends TestCase
{
    use CreateTransactionHelper;

    private TransactionInMemoryRepository $transactionRepository;

    private CardInMemoryRepository $cardRepository;

    private RefundTransactionService $service;

    public function setUp(): void
    {
        $this->transactionRepository = new TransactionInMemoryRepository();
        $this->cardRepository = new CardInMemoryRepository();

        $this->service = new RefundTransactionService(
            $this->transactionRepository,
            $this->cardRepository
        );
    }

    public function testShouldRaiseExceptionWhenTransactionDoNotExists()
    {
        $this->expectException(TransactionNotFoundException::class);

        $request = (new RefundTransactionRequest())
            ->setCustomerId('123456')
            ->setTransactionId('654321');


        $this->service->execute($request);
    }

    public function testShouldRaiseExceptionWhenTransactionDontBelongsToCustomer()
    {
        $this->expectException(TransactionNotFoundException::class);

        $this->transactionRepository->create($transaction = $this->createTransaction());

        $this->cardRepository->create(new Card($transaction->cardId(), $customerId = new CustomerId()));

        $request = (new RefundTransactionRequest())
            ->setCustomerId('1234')
            ->setTransactionId($transaction->id());


        $this->service->execute($request);
    }

    public function testShouldMarkAsRefund()
    {
        $this->transactionRepository->create($transaction = $this->createTransaction());

        $this->cardRepository->create(new Card($transaction->cardId(), $customerId = new CustomerId()));

        $request = (new RefundTransactionRequest())
            ->setCustomerId($customerId->id())
            ->setTransactionId($transaction->id()->id());


        $this->service->execute($request);


        $this->assertTrue($transaction->isRefunded());
    }
}
