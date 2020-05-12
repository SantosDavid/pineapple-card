<?php

namespace Tests\Application\Invoice\FindOrCreate;

use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceRepository;
use Tightenco\Collect\Support\Collection;

class FakeInvoiceRepository implements InvoiceRepository
{
    public static bool $createdCalled =false;

    public static ?Collection $byCustomer = null;

    public function create(Invoice $invoice): Invoice
    {
        self::$createdCalled = true;

        return $invoice;
    }

    public function byCustomer(CustomerId $customerId): Collection
    {
        return self::$byCustomer ?? new Collection();
    }
}
