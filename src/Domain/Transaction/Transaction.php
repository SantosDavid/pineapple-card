<?php

namespace PineappleCard\Domain\Transaction;

use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Shared\ValueObject\Money;
use PineappleCard\Domain\Transaction\ValueObject\Establishment;

class Transaction
{
    private TransactionId $transactionId;

    private CardId $cardId;

    private Establishment $establishment;

    private Money $value;

    public function __construct(
        TransactionId $transactionId,
        CardId $cardId,
        Establishment $establishment,
        Money $value
    )
    {
        $this->transactionId = $transactionId;
        $this->cardId = $cardId;
        $this->establishment = $establishment;
        $this->value = $value;
    }

    public function id(): TransactionId
    {
        return $this->transactionId;
    }
}
