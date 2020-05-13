<?php

namespace Tests\Application\Invoice\Overview;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use PineappleCard\Application\Customer\AvailableLimit\AvailableLimitResponse;
use PineappleCard\Application\Customer\AvailableLimit\AvailableLimitService;
use PineappleCard\Application\Invoice\Overview\OverviewInvoiceRequest;
use PineappleCard\Application\Invoice\Overview\OverviewInvoiceService;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Infrastructure\Persistence\InMemory\InvoiceInMemoryRepository;
use PineappleCard\Infrastructure\Persistence\InMemory\TransactionInMemoryRepository;
use Tests\Application\Shared\CreateInvoiceHelper;
use Tests\Application\Shared\CreateTransactionHelper;
use Tightenco\Collect\Support\Collection;

class OverviewInvoiceServiceTest extends TestCase
{
    use CreateTransactionHelper;
    use CreateInvoiceHelper;

    private InvoiceInMemoryRepository $invoiceRepository;

    private TransactionInMemoryRepository $transactionRepository;

    private $availableLimitService;

    private OverviewInvoiceService $service;

    public function setUp(): void
    {
        $this->invoiceRepository = new InvoiceInMemoryRepository();
        $this->transactionRepository = new TransactionInMemoryRepository();
        $this->availableLimitService = $this->createMock(AvailableLimitService::class);

        $this->service = new OverviewInvoiceService(
            $this->invoiceRepository,
            $this->transactionRepository,
            $this->availableLimitService
        );
    }

    private function configureStub()
    {
        $this->availableLimitService
            ->method('execute')
            ->willReturn((new AvailableLimitResponse(0)));
    }

    private function addInvoices(Collection $invoices)
    {
        $invoices->each(function (Invoice $invoice) {
            $this->invoiceRepository->create($invoice);
        });
    }

    public function testShouldReturnCorrectAvailableLimit()
    {
        $request = (new OverviewInvoiceRequest())->setCustomerId('1');

        $this->availableLimitService
            ->method('execute')
            ->willReturn((new AvailableLimitResponse($amount = 100)));


        $response = $this->service->execute($request);


        $this->assertEquals(100, $response->getAvailableLimit());
    }

    public function testShouldReturnNullWhenCustomerHasZeroInvoices()
    {
        $this->configureStub();
        $customerId = new CustomerId();

        $request = (new OverviewInvoiceRequest())->setCustomerId($customerId->id());


        $response = $this->service->execute($request);


        $this->assertEquals(0, count($response->getInvoices()));
    }

    public function testShouldReturnCorrectPreviousInvoice()
    {
        $this->configureStub();
        $customerId = new CustomerId();
        $request = (new OverviewInvoiceRequest())->setCustomerId($customerId->id());

        $this->addInvoices(new Collection([
            $this->createInvoice(true, $customerId, Carbon::now()->subYears(3)),
            $invoice = $this->createInvoice(true, $customerId, Carbon::now()->subYears(2)),
        ]));


        $response = $this->service->execute($request);


        $this->assertEquals(1, count($response->getInvoices()));
        $this->assertEquals($invoice->id()->id(), $response->getInvoices()[0]['id']);
    }

    public function testShouldReturnCorrectCurrentInvoice()
    {
        $this->configureStub();
        $customerId = new CustomerId();
        $invoice = $this->invoiceRepository->create($this->createInvoice(false, $customerId, Carbon::now()));

        $request = (new OverviewInvoiceRequest())->setCustomerId($customerId->id());


        $response = $this->service->execute($request);


        $this->assertEquals(1, count($response->getInvoices()));
        $this->assertEquals($invoice->id()->id(), $response->getInvoices()[0]['id']);
    }

    public function testShouldReturnCorrectTransactions()
    {
        $this->configureStub();
        $customerId = new CustomerId();

        $this->transactionRepository->create($transaction = $this->createTransaction());
        $this->invoiceRepository->create($this->createChoosingId($transaction->invoiceId(), $customerId));

        $request = (new OverviewInvoiceRequest())->setCustomerId($customerId->id());


        $response = $this->service->execute($request);


        $this->assertEquals(1, count($response->getInvoices()[0]['transactions']));
        $transactionResponse = $response->getInvoices()[0]['transactions'][0];
        $this->assertEquals($transaction->status(), $transactionResponse['status']);
        $this->assertEquals($transaction->value()->amount(), $transactionResponse['amount']);
        $this->assertEquals($transaction->createdAt()->format('c'), $transactionResponse['date']);
    }
}
