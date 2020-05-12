<?php

namespace PineappleCard\Domain\Invoice;

use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Invoice\ValueObject\Period;

interface InvoiceRepository
{
    public function create(Invoice $invoice): Invoice;

    public function byPeriod(CardId $cardId, Period $period): ?Invoice;
}
