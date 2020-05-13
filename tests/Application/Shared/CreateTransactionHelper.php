<?php

namespace Tests\Application\Shared;

use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Invoice\InvoiceId;
use PineappleCard\Domain\Shared\ValueObject\Geolocation;
use PineappleCard\Domain\Shared\ValueObject\Money;
use PineappleCard\Domain\Transaction\Transaction;
use PineappleCard\Domain\Transaction\TransactionId;
use PineappleCard\Domain\Transaction\ValueObject\Establishment;

trait CreateTransactionHelper
{
    public function createTransaction($value = 1, $refunded = false): Transaction
    {
        $establishment = new Establishment('Place',1, new Geolocation(1, 1));

        $transaction = new Transaction(
            $transactionId = new TransactionId(),
            new InvoiceId(),
            $cardId = new CardId(),
            $establishment,
            new Money($value)
        );

        if ($refunded) {
            $transaction->markAsRefunded();
        }

        return $transaction;
    }
}
