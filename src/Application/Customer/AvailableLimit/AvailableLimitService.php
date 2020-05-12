<?php

namespace PineappleCard\Application\Customer\AvailableLimit;

use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\CustomerRepository;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceRepository;
use PineappleCard\Domain\Shared\ValueObject\Money;
use PineappleCard\Domain\Transaction\Transaction;
use PineappleCard\Domain\Transaction\TransactionRepository;
use Tightenco\Collect\Support\Collection;

class AvailableLimitService
{
    private CustomerRepository $customerRepository;

    private InvoiceRepository $invoiceRepository;

    private TransactionRepository $transactionRepository;

    public function __construct(
        CustomerRepository $customerRepository,
        InvoiceRepository $invoiceRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->customerRepository = $customerRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function execute(AvailableLimitRequest $request)
    {
        $customerId = new CustomerId($request->getCustomerId());

        $customerLimit = $this->customerLimit($customerId);
        $notPaidAmount = $this->notPaidAmount($customerId);

        $availableLimit = $customerLimit->sub($notPaidAmount);


        return new AvailableLimitResponse($availableLimit->amount(), $availableLimit->currency());
    }

    private function customerLimit(CustomerId $customerId): Money
    {
        $customer = $this->customerRepository->byId($customerId);

        return $customer->limit();
    }

    public function notPaidAmount(CustomerId $customerId): Money
    {
        $notPaidInvoicesId = $this->notPaidInvoicesId($customerId);

        return $this->transactionRepository->byInvoicesId($notPaidInvoicesId)
            ->filter(function (Transaction $transaction) {
                return !$transaction->isRefunded();
            })
            ->reduce(function (Money $money, Transaction $transaction) {
                return $money->add($transaction->value());
            }, new Money(0));
    }

    private function notPaidInvoicesId(CustomerId $customerId): Collection
    {
        return $this->invoiceRepository
            ->byCustomer($customerId)
            ->filter(fn (Invoice $invoice) => !$invoice->isPaid())
            ->map(fn (Invoice $invoice) => $invoice->id());
    }
}
