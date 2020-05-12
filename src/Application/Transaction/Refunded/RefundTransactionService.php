<?php

namespace PineappleCard\Application\Transaction\Refunded;

use PineappleCard\Domain\Card\Card;
use PineappleCard\Domain\Card\CardRepository;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Transaction\Exception\TransactionNotFoundException;
use PineappleCard\Domain\Transaction\Transaction;
use PineappleCard\Domain\Transaction\TransactionId;
use PineappleCard\Domain\Transaction\TransactionRepository;

class RefundTransactionService
{
    private TransactionRepository $repository;

    private CardRepository $cardRepository;

    public function __construct(TransactionRepository $repository, CardRepository $cardRepository)
    {
        $this->repository = $repository;
        $this->cardRepository = $cardRepository;
    }

    public function execute(RefundTransactionRequest $request)
    {
        $transaction = $this->findTransaction($request);

        $transaction->markAsRefunded();

        $this->repository->save($transaction);
    }

    private function findTransaction(RefundTransactionRequest $request): ?Transaction
    {
        $lookingFor = new TransactionId($request->getTransactionId());
        $transaction = $this->repository->byId($lookingFor);

        if (is_null($transaction)) {
            throw new TransactionNotFoundException($lookingFor);
        }

        $customerId = new CustomerId($request->getCustomerId());

        $card = $this->cardRepository
            ->byCustomerId($customerId)
            ->first(fn (Card $card) => $card->id()->equals($transaction->cardId()));

        if (is_null($card)) {
            throw new TransactionNotFoundException($lookingFor);
        }

        return $transaction;
    }
}
