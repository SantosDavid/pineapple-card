<?php

namespace PineappleCard\Domain\Transaction;

interface TransactionRepository
{
    public function create(Transaction $transaction): Transaction;

    public function save(Transaction $transaction);

    public function byId(TransactionId $transactionId): ?Transaction;
}
