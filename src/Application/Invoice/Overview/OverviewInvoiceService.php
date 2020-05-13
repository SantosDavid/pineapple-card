<?php

namespace PineappleCard\Application\Invoice\Overview;

use PineappleCard\Application\Customer\AvailableLimit\AvailableLimitRequest;
use PineappleCard\Application\Customer\AvailableLimit\AvailableLimitService;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceRepository;
use PineappleCard\Domain\Transaction\Transaction;
use PineappleCard\Domain\Transaction\TransactionRepository;
use Tightenco\Collect\Support\Collection;

class OverviewInvoiceService
{
    private InvoiceRepository $repository;

    private TransactionRepository $transactionRepository;

    private AvailableLimitService $availableLimitService;

    public function __construct(
        InvoiceRepository $repository,
        TransactionRepository $transactionRepository,
        AvailableLimitService $availableLimitService
    )
    {
        $this->repository = $repository;
        $this->transactionRepository = $transactionRepository;
        $this->availableLimitService = $availableLimitService;
    }

    public function execute(OverviewInvoiceRequest $request)
    {
        $customerId = new CustomerId($request->getCustomerId());

        $invoices = $this->repository->byCustomer($customerId);

        $response = new OverviewInvoiceResponse();

        $this->availableLimit($customerId, $response);
        $this->previousInvoice($invoices, $response);
        $this->currentInvoice($invoices, $response);

        return $response;
    }

    private function availableLimit(CustomerId $customerId, OverviewInvoiceResponse $response)
    {
        $request = (new AvailableLimitRequest())->setCustomerId($customerId->id());

        $limitResponse = $this->availableLimitService->execute($request);

        $response->setAvailableLimit($limitResponse->amount());
    }

    private function previousInvoice(Collection $invoices, OverviewInvoiceResponse $response): void
    {
        $invoice = $invoices
            ->sortBy(fn(Invoice $invoice) => $invoice->createdAt())
            ->first(fn(Invoice $invoice) => !$invoice->isOpened());

        if (is_null($invoice)) {
            return;
        }

        $this->fillInvoiceDTO($invoice, $response);
    }

    private function currentInvoice(Collection $invoices, OverviewInvoiceResponse $response): void
    {
        $invoice = $invoices->first(fn(Invoice $invoice) => $invoice->isOpened());

        if (is_null($invoice)) {
            return;
        }

        $this->fillInvoiceDTO($invoice, $response);
    }

    private function fillInvoiceDTO(Invoice $invoice, OverviewInvoiceResponse $response): void
    {
        $transactions = $this->transactionRepository->byInvoicesId(new Collection([$invoice->id()]));

        $responseTransactions = $transactions->map(function (Transaction $transaction) {
            return [
                'name' => $transaction->establishment()->name(),
                'status' => $transaction->status(),
                'amount' => $transaction->value()->amount(),
                'date' => $transaction->createdAt()
            ];
        });

        $response->addInvoice($invoice->status(), $invoice->dueDate(), $responseTransactions->toArray());
    }
}
