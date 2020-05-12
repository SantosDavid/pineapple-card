<?php

namespace PineappleCard\Domain\Transaction;

use PineappleCard\Domain\Shared\Uuid;

class TransactionId extends Uuid
{
    public function equals(TransactionId $transactionId): bool
    {
        return $this->id === $transactionId->id();
    }
}
