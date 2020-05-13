<?php

namespace Tests\Application\Customer\Points;

use PHPUnit\Framework\TestCase;
use PineappleCard\Application\Customer\Points\CustomerPointsRequest;
use PineappleCard\Application\Customer\Points\CustomerPointsService;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Infrastructure\Persistence\InMemory\InvoiceInMemoryRepository;
use PineappleCard\Infrastructure\Persistence\InMemory\TransactionInMemoryRepository;
use Tests\Application\Shared\CreateInvoiceHelper;
use Tests\Application\Shared\CreateTransactionHelper;

class CustomerPointsServiceTest extends TestCase
{
    use CreateTransactionHelper;
    use CreateInvoiceHelper;

    private InvoiceInMemoryRepository $invoiceRepository;

    private TransactionInMemoryRepository $transactionRepository;

    private CustomerPointsService $service;

    public function setUp(): void
    {
        $this->invoiceRepository = new InvoiceInMemoryRepository();
        $this->transactionRepository = new TransactionInMemoryRepository();

        $this->service = new CustomerPointsService(
            $this->invoiceRepository,
            $this->transactionRepository
        );
    }

    public function testShouldReturnZeroPointsWhenCustomerDontHasTransactions()
    {
        $request = (new CustomerPointsRequest())
            ->setCustomerId('1');


        $response = $this->service->execute($request);


        $this->assertEquals(0, $response->getPoints());
    }

    public function testShouldReturnZeroPointsWhenCustomerOnlyHasRefundedTransactions()
    {
        $customerId = new CustomerId();

        $request = (new CustomerPointsRequest())
            ->setCustomerId($customerId->id());

        $this->invoiceRepository->create($invoice = $this->createInvoice(false, $customerId));
        $this->transactionRepository->create($this->createTransaction(100, true, $invoice->id()));
        $this->transactionRepository->create($this->createTransaction(100, true, $invoice->id()));


        $response = $this->service->execute($request);


        $this->assertEquals(0, $response->getPoints());
    }

    public function testShouldReturnCorrectPoints()
    {
        $customerId = new CustomerId();

        $request = (new CustomerPointsRequest())
            ->setCustomerId($customerId->id());

        $this->invoiceRepository->create($invoice = $this->createInvoice(false, $customerId));
        $this->transactionRepository->create($this->createTransaction(1, false, $invoice->id()));
        $this->transactionRepository->create($this->createTransaction(1, false, $invoice->id()));
        $this->transactionRepository->create($this->createTransaction(1, true, $invoice->id()));


        $response = $this->service->execute($request);


        $this->assertEquals(1.6, $response->getPoints());
    }
}
