<?php

namespace Tests\Application\Invoice\FindOrCreate;

use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceRepository;
use PineappleCard\Domain\Invoice\ValueObject\Period;

class FakeInvoiceRepository implements InvoiceRepository
{
    public static bool $createdCalled =false;

    public static ?Invoice $byPeriod = null;

    public function create(Invoice $invoice): Invoice
    {
        self::$createdCalled = true;

        return $invoice;
    }

    public function byPeriod(CardId $cardId, Period $period): ?Invoice
    {
        return self::$byPeriod;
    }
}
