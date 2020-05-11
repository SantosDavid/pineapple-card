<?php

namespace PineappleCard\Domain\Transaction;

interface TransactionRepository
{
    public function save(Transaction $transaction): Transaction;
}
