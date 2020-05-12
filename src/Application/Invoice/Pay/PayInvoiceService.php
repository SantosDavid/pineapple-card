<?php

namespace PineappleCard\Application\Invoice\Pay;

use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Invoice\Exception\InvoiceNotFoundException;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceId;
use PineappleCard\Domain\Invoice\InvoiceRepository;

class PayInvoiceService
{
    private InvoiceRepository $repository;

    public function __construct(InvoiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(PayInvoiceRequest $request)
    {
        $invoice = $this->findInvoice($request);

        $invoice->markAsPayed();

        $this->repository->save($invoice);
    }

    private function findInvoice(PayInvoiceRequest $request): Invoice
    {
        $invoices = $this->repository->byCustomer(new CustomerId($request->getCustomerId()));

        $lookingForInvoiceId = new InvoiceId($request->getInvoiceId());

        $invoice = $invoices->first(fn (Invoice $invoice) => $invoice->id()->equals($lookingForInvoiceId));

        if (is_null($invoice)) {
            throw new InvoiceNotFoundException($lookingForInvoiceId);
        }

        return $invoice;
    }
}
