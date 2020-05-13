<?php

namespace PineappleCard\Infrastructure\Persistence\InMemory;

use PineappleCard\Domain\Invoice\InvoiceId;
use PineappleCard\Domain\Transaction\Transaction;
use PineappleCard\Domain\Transaction\TransactionId;
use PineappleCard\Domain\Transaction\TransactionRepository;
use Tightenco\Collect\Support\Collection;

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

    public function byInvoicesId(Collection $invoicesId): Collection
    {
        return $this->items->filter(function (Transaction $transaction) use ($invoicesId) {
            return $invoicesId->first(function (InvoiceId $invoiceId) use ($transaction) {
                return $invoiceId->equals($transaction->invoiceId());
            });
        });
    }
}
