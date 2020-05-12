<?php

namespace PineappleCard\Application\Invoice\FindOrCreate;

use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\CustomerRepository;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceId;
use PineappleCard\Domain\Invoice\InvoiceRepository;

class FindOrCreateInvoiceService
{
    private CustomerRepository $customerRepository;

    private InvoiceRepository $repository;

    public function __construct(CustomerRepository $customerRepository, InvoiceRepository $repository)
    {
        $this->repository = $repository;
        $this->customerRepository = $customerRepository;
    }

    public function execute(FindOrCreateInvoiceRequest $request)
    {
        $customerId = new CustomerId($request->getCustomerId());
        $customer = $this->customerRepository->byId($customerId);

        $invoice = $this->findOpenedInvoice($customerId);

        if (is_null($invoice)) {
            $invoice = $this->repository->create(
                new Invoice(new InvoiceId(), $customerId, $customer->payDay())
            );
        }

        return new FindOrCreateInvoiceResponse($invoice->id());
    }

    private function findOpenedInvoice(CustomerId $customerId): ?Invoice
    {
        return $this->repository->byCustomer($customerId)->first(function (Invoice $invoice) {
            return $invoice->isOpened();
        });
    }
}
