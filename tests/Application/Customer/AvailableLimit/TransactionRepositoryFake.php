<?php

namespace Tests\Application\Customer\AvailableLimit;

use PineappleCard\Domain\Transaction\Transaction;
use PineappleCard\Domain\Transaction\TransactionId;
use PineappleCard\Domain\Transaction\TransactionRepository;
use Tightenco\Collect\Support\Collection;

class TransactionRepositoryFake implements TransactionRepository
{
    public Collection $transactions;

    public Collection $invoicesId;

    public function __construct()
    {
        $this->transactions= new Collection();
    }

    public function create(Transaction $transaction): Transaction
    {
        // TODO: Implement create() method.
    }

    public function save(Transaction $transaction)
    {
        // TODO: Implement save() method.
    }

    public function byId(TransactionId $transactionId): ?Transaction
    {
        // TODO: Implement byId() method.
    }

    public function byInvoicesId(Collection $invoicesId): Collection
    {
        $this->invoicesId = $invoicesId;

        return $this->transactions;
    }
}
