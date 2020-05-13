<?php

namespace PineappleCard\Application\Customer\Points;

use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceRepository;
use PineappleCard\Domain\Transaction\Transaction;
use PineappleCard\Domain\Transaction\TransactionRepository;
use Tightenco\Collect\Support\Collection;

class CustomerPointsService
{
    private InvoiceRepository $invoiceRepository;

    private TransactionRepository $transactionRepository;

    public function __construct(InvoiceRepository $invoiceRepository, TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->invoiceRepository = $invoiceRepository;
    }

    public function execute(CustomerPointsRequest $request)
    {
        $invoices = $this->invoiceRepository->byCustomer(new CustomerId($request->getCustomerId()));
        $invoicesId = $invoices->map(fn(Invoice $invoice) => $invoice->id());

        $transactions = $this->transactionRepository->byInvoicesId($invoicesId);

        $points = $this->calculatePoints($transactions);

        return new CustomerPointsResponse($points);
    }

    private function calculatePoints(Collection $transactions): float
    {
        return $transactions->reduce(function (float $points, Transaction $transaction) {
            if (!$transaction->isRefunded()) {
                $points += $transaction->establishment()->scoreRate();
            }

            return $points;
        }, 0.00);
    }
}
