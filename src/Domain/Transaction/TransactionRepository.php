<?php

namespace PineappleCard\Domain\Transaction;

use Tightenco\Collect\Support\Collection;

interface TransactionRepository
{
    public function create(Transaction $transaction): Transaction;

    public function save(Transaction $transaction);

    public function byId(TransactionId $transactionId): ?Transaction;

    public function byInvoicesId(Collection $invoicesId): Collection;
}
