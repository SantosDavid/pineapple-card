<?php

namespace PineappleCard\Infrastructure\Persistence\InMemory;

use PineappleCard\Domain\Transaction\Transaction;
use PineappleCard\Domain\Transaction\TransactionRepository;
use Tymon\JWTAuth\Claims\Collection;

class TransactionInMemoryRepository implements TransactionRepository
{
    private Collection $items;

    public function __construct()
    {
        $this->items = new Collection();
    }

    public function save(Transaction $transaction): Transaction
    {
        $this->items->push($transaction);

        return $transaction;
    }

    public function countItems(): int
    {
        return $this->items->count();
    }
}
