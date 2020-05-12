<?php

namespace PineappleCard\Infrastructure\Persistence\InMemory;

use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceRepository;
use Tightenco\Collect\Support\Collection;

class InvoiceInMemoryRepository implements InvoiceRepository
{
    private Collection $items;

    public function __construct()
    {
        $this->items = new Collection();
    }

    public function create(Invoice $invoice): Invoice
    {
        $this->items->push($invoice);

        return $invoice;
    }

    public function byCustomer(CustomerId $customerId): Collection
    {
        return $this->items->filter(fn (Invoice $invoice) => $invoice->customerId()->equals($customerId));
    }

    public function save(Invoice $invoice)
    {

    }
}
