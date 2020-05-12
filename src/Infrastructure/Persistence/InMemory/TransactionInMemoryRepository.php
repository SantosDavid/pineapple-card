<?php

namespace PineappleCard\Infrastructure\Persistence\InMemory;

use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Transaction\Transaction;
use PineappleCard\Domain\Transaction\TransactionId;
use PineappleCard\Domain\Transaction\TransactionRepository;
use Tymon\JWTAuth\Claims\Collection;

class TransactionInMemoryRepository implements TransactionRepository
{
    private Collection $items;

    public function __construct()
    {
        $this->items = new Collection();
    }

    public function create(Transaction $transaction): Transaction
    {
        $this->items->push($transaction);

        return $transaction;
    }

    public function countItems(): int
    {
        return $this->items->count();
    }

    public function save(Transaction $transaction)
    {
        // TODO: Implement create() method.
    }

    public function byId(TransactionId $transactionId): ?Transaction
    {
        return $this->items->first(fn (Transaction $transaction) => $transaction->id()->equals($transactionId));
    }
}
