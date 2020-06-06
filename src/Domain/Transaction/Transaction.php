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

    private bool $refunded = false;

    public function __construct(
        TransactionId $transactionId,
        InvoiceId $invoiceId,
        CardId $cardId,
        Establishment $establishment,
        Money $value,
        $createdAt = null
    ) {
        $this->transactionId = $transactionId;
        $this->invoiceId = $invoiceId;
        $this->cardId = $cardId;
        $this->establishment = $establishment;
        $this->value = $value;
        $this->createdAt = $createdAt ?? new DateTime();
    }

    public function id(): TransactionId
    {
        return $this->transactionId;
    }

    public function markAsRefunded()
    {
        $this->refunded = true;
    }

    public function cardId(): CardId
    {
        return $this->cardId;
    }

    public function isRefunded(): bool
    {
        return $this->refunded;
    }

    public function status(): string
    {
        if ($this->isRefunded()) {
            return 'refunded';
        }

        return 'charged';
    }

    public function value(): Money
    {
        return $this->value;
    }

    public function invoiceId(): InvoiceId
    {
        return $this->invoiceId;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function establishment(): Establishment
    {
        return $this->establishment;
    }
}
