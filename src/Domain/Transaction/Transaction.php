<?php

namespace PineappleCard\Domain\Transaction;

use DateTime;
use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Invoice\InvoiceId;
use PineappleCard\Domain\Shared\ValueObject\Money;
use PineappleCard\Domain\Transaction\ValueObject\Establishment;

class Transaction
{
    private TransactionId $transactionId;

    private InvoiceId $invoiceId;

    private CardId $cardId;

    private Establishment $establishment;

    private Money $value;

    private DateTime $createdAt;

    public function __construct(
        TransactionId $transactionId,
        InvoiceId $invoiceId,
        CardId $cardId,
        Establishment $establishment,
        Money $value
    ) {
        $this->transactionId = $transactionId;
        $this->invoiceId = $invoiceId;
        $this->cardId = $cardId;
        $this->establishment = $establishment;
        $this->value = $value;
        $this->createdAt = new DateTime();
    }

    public function id(): TransactionId
    {
        return $this->transactionId;
    }
}
